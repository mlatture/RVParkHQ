<?php

namespace Tests\Feature;

use PHPUnit\Framework\Attributes\DataProvider;
use Tests\TestCase;

class FormAbuseRouteCoverageTest extends TestCase
{
    #[DataProvider('protectedSubmissionRoutes')]
    public function test_public_submission_route_uses_form_abuse_middleware(string $routeName): void
    {
        $route = $this->postRoute($routeName);

        $this->assertNotNull($route, "Route [{$routeName}] was not found.");
        $this->assertContains('form.abuse', $route->gatherMiddleware(), "Route [{$routeName}] lacks form abuse protection.");
    }

    public static function protectedSubmissionRoutes(): array
    {
        return [
            'review' => ['rv-park.pending-review'],
            'newsletter' => ['rv-park.email.subscribe'],
            'park suggestion' => ['rv-park.suggest.park.store'],
            'advertising inquiry' => ['rv-park.advertise.store'],
            'park claim' => ['rv-park.claim-park.store'],
            'frontend modal registration' => ['modal.register'],
            'legacy frontend registration' => ['register'],
            'admin registration' => ['admin.register.submit'],
            'admin password reset request' => ['admin.password.update'],
            'legacy password reset request' => ['password.email'],
        ];
    }

    #[DataProvider('loginRoutes')]
    public function test_login_route_is_rate_limited_without_form_timing_requirement(string $routeName): void
    {
        $route = $this->postRoute($routeName);
        $middleware = $route?->gatherMiddleware() ?? [];

        $this->assertNotNull($route, "Route [{$routeName}] was not found.");
        $this->assertTrue(
            collect($middleware)->contains(fn (string $item) => str_starts_with($item, 'throttle:')),
            "Route [{$routeName}] is not rate limited."
        );
        $this->assertNotContains('form.abuse', $middleware, "Route [{$routeName}] should not require minimum fill time.");
    }

    public static function loginRoutes(): array
    {
        return [
            'frontend modal login' => ['modal.login'],
            'legacy frontend login' => ['login'],
            'admin login' => ['admin.login.submit'],
        ];
    }

    #[DataProvider('excludedRoutes')]
    public function test_payment_and_authenticated_profile_routes_are_not_protected(string $routeName): void
    {
        $route = $this->postRoute($routeName);

        $this->assertNotNull($route, "Route [{$routeName}] was not found.");
        $this->assertNotContains('form.abuse', $route->gatherMiddleware());
    }

    public static function excludedRoutes(): array
    {
        return [
            'payment' => ['rv-park.pay-bill.process'],
            'stored-card payment' => ['rv-park.pay-bill.card.process'],
            'profile update' => ['rv-park.profile.update'],
        ];
    }

    private function postRoute(string $name): ?\Illuminate\Routing\Route
    {
        $legacyUris = ['register' => 'register', 'login' => 'login'];

        return collect(app('router')->getRoutes()->getRoutes())
            ->first(fn (\Illuminate\Routing\Route $route) => in_array('POST', $route->methods(), true)
                && ($route->getName() === $name || $route->uri() === ($legacyUris[$name] ?? null)));
    }
}
