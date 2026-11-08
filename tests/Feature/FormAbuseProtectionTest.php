<?php

namespace Tests\Feature;

use App\Http\Middleware\VerifyCsrfToken;
use Carbon\Carbon;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Route;
use Tests\TestCase;

class FormAbuseProtectionTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        config([
            'app.key' => 'base64:AAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAA=',
            'anti_abuse.minimum_seconds' => 2,
            'anti_abuse.maximum_age_seconds' => 7200,
            'anti_abuse.ip.max_attempts' => 10,
            'anti_abuse.ip.decay_seconds' => 60,
            'anti_abuse.email.max_attempts' => 5,
            'anti_abuse.email.decay_seconds' => 3600,
            'anti_abuse.duplicate_seconds' => 120,
        ]);

        Carbon::setTestNow('2026-01-01 12:00:00');
        Cache::flush();
        $this->withoutMiddleware(VerifyCsrfToken::class);

        Route::post('/_test/abuse-protected', fn () => response()->json(['passed' => true]))
            ->middleware('form.abuse')
            ->name('test.abuse-protected');
    }

    protected function tearDown(): void
    {
        Carbon::setTestNow();
        parent::tearDown();
    }

    public function test_missing_form_start_token_fails_closed_for_json(): void
    {
        $this->postJson('/_test/abuse-protected', ['email' => 'person@example.com'])
            ->assertUnprocessable()
            ->assertJsonValidationErrors('_form_started_at');
    }

    public function test_invalid_form_start_token_fails_closed(): void
    {
        $this->postJson('/_test/abuse-protected', [
            '_form_started_at' => 'not-an-encrypted-token',
            'email' => 'person@example.com',
        ])->assertUnprocessable()->assertJsonValidationErrors('_form_started_at');
    }

    public function test_submission_completed_under_two_seconds_is_rejected(): void
    {
        $this->postJson('/_test/abuse-protected', $this->payload(1))
            ->assertUnprocessable()
            ->assertJsonValidationErrors('_form_started_at');
    }

    public function test_token_older_than_two_hours_is_rejected(): void
    {
        $this->postJson('/_test/abuse-protected', $this->payload(7201))
            ->assertUnprocessable()
            ->assertJsonValidationErrors('_form_started_at');
    }

    public function test_honeypot_must_be_empty(): void
    {
        $this->postJson('/_test/abuse-protected', $this->payload(3, [
            '_form_website' => 'https://spam.example',
        ]))->assertUnprocessable()->assertJsonValidationErrors('_form_website');
    }

    public function test_valid_submission_reaches_the_controller(): void
    {
        $this->postJson('/_test/abuse-protected', $this->payload())
            ->assertOk()
            ->assertJson(['passed' => true]);
    }

    public function test_route_and_ip_limit_is_enforced(): void
    {
        config(['anti_abuse.ip.max_attempts' => 2]);

        $this->postJson('/_test/abuse-protected', $this->payload(3, ['message' => 'one']))->assertOk();
        $this->postJson('/_test/abuse-protected', $this->payload(3, ['message' => 'two']))->assertOk();
        $this->postJson('/_test/abuse-protected', $this->payload(3, ['message' => 'three']))
            ->assertUnprocessable()
            ->assertJsonValidationErrors('_form');
    }

    public function test_normalized_email_limit_is_enforced_across_ip_addresses(): void
    {
        config(['anti_abuse.email.max_attempts' => 2]);

        $this->withServerVariables(['REMOTE_ADDR' => '192.0.2.1'])
            ->postJson('/_test/abuse-protected', $this->payload(3, ['message' => 'one', 'email' => ' Person@Example.COM ']))
            ->assertOk();
        $this->withServerVariables(['REMOTE_ADDR' => '192.0.2.2'])
            ->postJson('/_test/abuse-protected', $this->payload(3, ['message' => 'two', 'email' => 'person@example.com']))
            ->assertOk();
        $this->withServerVariables(['REMOTE_ADDR' => '192.0.2.3'])
            ->postJson('/_test/abuse-protected', $this->payload(3, ['message' => 'three', 'email' => 'PERSON@example.com']))
            ->assertUnprocessable()
            ->assertJsonValidationErrors('_form');
    }

    public function test_identical_payload_is_suppressed_for_a_short_window(): void
    {
        $payload = $this->payload(3, ['message' => 'same']);

        $this->postJson('/_test/abuse-protected', $payload)->assertOk();
        $payload['_form_started_at'] = $this->token(3);
        $this->postJson('/_test/abuse-protected', $payload)
            ->assertUnprocessable()
            ->assertJsonValidationErrors('_form');
    }

    public function test_middleware_validation_failure_does_not_consume_duplicate_slot(): void
    {
        $payload = $this->payload(1, ['message' => 'retry me']);

        $this->postJson('/_test/abuse-protected', $payload)
            ->assertUnprocessable()
            ->assertJsonValidationErrors('_form_started_at');

        $payload['_form_started_at'] = $this->token(3);
        $this->postJson('/_test/abuse-protected', $payload)->assertOk();
    }

    public function test_html_rejection_uses_normal_validation_redirect(): void
    {
        $this->from('/form')->post('/_test/abuse-protected', ['email' => 'person@example.com'])
            ->assertRedirect('/form')
            ->assertSessionHasErrors('_form_started_at');
    }

    public function test_rejection_log_does_not_contain_raw_pii_or_token(): void
    {
        Log::shouldReceive('warning')->once()->withArgs(function (string $message, array $context): bool {
            $encoded = json_encode([$message, $context]);

            return $message === 'Public form submission rejected'
                && ! str_contains($encoded, 'private@example.com')
                && ! str_contains($encoded, 'super-secret-token')
                && array_keys($context) === ['reason', 'route', 'ip_hash'];
        });

        $this->postJson('/_test/abuse-protected', [
            '_form_started_at' => 'super-secret-token',
            'email' => 'private@example.com',
        ])->assertUnprocessable();
    }

    private function payload(int $age = 3, array $overrides = []): array
    {
        return array_merge([
            '_form_started_at' => $this->token($age),
            '_form_website' => '',
            'email' => 'person@example.com',
            'message' => 'hello',
        ], $overrides);
    }

    private function token(int $age): string
    {
        return Crypt::encryptString(json_encode([
            'issued_at' => now()->subSeconds($age)->timestamp,
            'nonce' => bin2hex(random_bytes(8)),
        ], JSON_THROW_ON_ERROR));
    }
}
