<?php

namespace Tests\Feature;

use Tests\TestCase;

class TurnstileComponentTest extends TestCase
{
    public function test_turnstile_component_renders_configured_site_key_and_error(): void
    {
        config(['services.turnstile.site_key' => 'test-site-key']);

        $view = $this->withViewErrors([
            'cf-turnstile-response' => 'Please confirm you are human and try again.',
        ])->blade('<x-turnstile />');

        $view->assertSee('class="cf-turnstile"', false);
        $view->assertSee('data-sitekey="test-site-key"', false);
        $view->assertSee('Please confirm you are human and try again.');
    }
}
