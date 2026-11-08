<?php

namespace Tests\Feature;

use App\Services\TurnstileService;
use Illuminate\Support\Facades\Http;
use Tests\TestCase;

class TurnstileServiceTest extends TestCase
{
    public function test_valid_turnstile_token_is_accepted(): void
    {
        config([
            'services.turnstile.secret_key' => 'test-secret',
            'services.turnstile.verify_url' => 'https://challenges.cloudflare.com/turnstile/v0/siteverify',
        ]);

        Http::fake([
            'https://challenges.cloudflare.com/turnstile/v0/siteverify' => Http::response([
                'success' => true,
            ]),
        ]);

        $verified = app(TurnstileService::class)->verify('valid-token', '203.0.113.10');

        $this->assertTrue($verified);
        Http::assertSent(fn ($request) => $request->url() === 'https://challenges.cloudflare.com/turnstile/v0/siteverify'
            && $request['secret'] === 'test-secret'
            && $request['response'] === 'valid-token'
            && $request['remoteip'] === '203.0.113.10'
        );
    }

    public function test_turnstile_verification_fails_closed_when_cloudflare_is_unavailable(): void
    {
        config([
            'services.turnstile.secret_key' => 'test-secret',
            'services.turnstile.verify_url' => 'https://challenges.cloudflare.com/turnstile/v0/siteverify',
        ]);

        Http::fake(fn () => throw new \RuntimeException('network unavailable'));

        $this->assertFalse(
            app(TurnstileService::class)->verify('valid-token', '203.0.113.10')
        );
    }
}
