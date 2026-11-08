<?php

namespace Tests\Feature;

use App\Http\Middleware\VerifyCsrfToken;
use PHPUnit\Framework\Attributes\DataProvider;
use Tests\TestCase;

class TurnstileRoutesTest extends TestCase
{
    #[DataProvider('publicSubmissionRoutes')]
    public function test_public_submission_routes_require_turnstile(string $routeName): void
    {
        $route = app('router')->getRoutes()->getByName($routeName);

        $this->assertNotNull($route, "Route [{$routeName}] was not found.");
        $this->assertContains('turnstile', $route->gatherMiddleware(), "Route [{$routeName}] is not Turnstile protected.");
    }

    public static function publicSubmissionRoutes(): array
    {
        return [
            'review submission' => ['rv-park.pending-review'],
            'newsletter subscription' => ['rv-park.email.subscribe'],
            'park suggestion' => ['rv-park.suggest.park.store'],
            'advertising inquiry' => ['rv-park.advertise.store'],
            'park claim' => ['rv-park.claim-park.store'],
            'frontend login' => ['modal.login'],
            'frontend registration' => ['modal.register'],
            'admin login' => ['admin.login.submit'],
            'admin registration' => ['admin.register.submit'],
            'admin password reset request' => ['admin.password.update'],
            'legacy password reset request' => ['password.email'],
        ];
    }

    #[DataProvider('legacyAuthEndpoints')]
    public function test_legacy_auth_posts_require_turnstile(string $uri, array $payload): void
    {
        config(['app.key' => 'base64:AAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAA=']);
        $this->withoutMiddleware(VerifyCsrfToken::class);

        $this->postJson($uri, $payload)
            ->assertUnprocessable()
            ->assertJsonValidationErrors('cf-turnstile-response');
    }

    public static function legacyAuthEndpoints(): array
    {
        return [
            'login' => ['/login', ['email' => 'person@example.com', 'password' => 'password']],
            'registration' => ['/register', [
                'name' => 'Test Person',
                'email' => 'person@example.com',
                'password' => 'Password1!',
                'password_confirmation' => 'Password1!',
            ]],
        ];
    }
}
