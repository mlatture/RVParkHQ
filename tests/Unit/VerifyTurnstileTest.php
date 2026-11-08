<?php

namespace Tests\Unit;

use App\Http\Middleware\VerifyTurnstile;
use App\Services\TurnstileService;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Mockery;
use Symfony\Component\HttpFoundation\Response;
use Tests\TestCase;

class VerifyTurnstileTest extends TestCase
{
    protected function tearDown(): void
    {
        Mockery::close();
        parent::tearDown();
    }

    public function test_request_continues_after_successful_turnstile_verification(): void
    {
        $service = Mockery::mock(TurnstileService::class);
        $service->shouldReceive('verify')
            ->once()
            ->with('valid-token', '203.0.113.10')
            ->andReturnTrue();

        $request = Request::create('/form', 'POST', [
            'cf-turnstile-response' => 'valid-token',
        ], [], [], ['REMOTE_ADDR' => '203.0.113.10']);

        $response = (new VerifyTurnstile($service))->handle(
            $request,
            fn () => new Response('accepted', 200)
        );

        $this->assertSame(200, $response->getStatusCode());
        $this->assertSame('accepted', $response->getContent());
    }

    public function test_request_is_rejected_when_turnstile_token_is_missing(): void
    {
        $service = Mockery::mock(TurnstileService::class);
        $service->shouldNotReceive('verify');

        $request = Request::create('/form', 'POST', [], [], [], [
            'REMOTE_ADDR' => '203.0.113.10',
        ]);

        $this->expectException(ValidationException::class);

        (new VerifyTurnstile($service))->handle(
            $request,
            fn () => new Response('accepted', 200)
        );
    }

    public function test_request_is_rejected_when_cloudflare_rejects_token(): void
    {
        $service = Mockery::mock(TurnstileService::class);
        $service->shouldReceive('verify')->once()->andReturnFalse();

        $request = Request::create('/form', 'POST', [
            'cf-turnstile-response' => 'invalid-token',
        ], [], [], ['REMOTE_ADDR' => '203.0.113.10']);

        $this->expectException(ValidationException::class);

        (new VerifyTurnstile($service))->handle(
            $request,
            fn () => new Response('accepted', 200)
        );
    }
}
