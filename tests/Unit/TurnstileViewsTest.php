<?php

namespace Tests\Unit;

use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

class TurnstileViewsTest extends TestCase
{
    #[DataProvider('protectedFormViews')]
    public function test_protected_form_renders_turnstile_widget(string $relativePath): void
    {
        $contents = file_get_contents(dirname(__DIR__, 2).'/'.$relativePath);

        $this->assertStringContainsString('<x-turnstile', $contents, "Missing Turnstile widget in {$relativePath}.");
    }

    public static function protectedFormViews(): array
    {
        return [
            ['resources/views/frontend/pages/advertise/index.blade.php'],
            ['resources/views/frontend/pages/suggest/index.blade.php'],
            ['resources/views/frontend/pages/layouts/partials/footer.blade.php'],
            ['resources/views/frontend/pages/park/show.blade.php'],
            ['resources/views/frontend/pages/park/partials/claim-park-modal.blade.php'],
            ['resources/views/frontend/auth/login.blade.php'],
            ['resources/views/frontend/auth/register.blade.php'],
            ['resources/views/auth/login.blade.php'],
            ['resources/views/auth/register.blade.php'],
            ['resources/views/auth/passwords/email.blade.php'],
            ['resources/views/backend/auth/login.blade.php'],
            ['resources/views/backend/auth/register.blade.php'],
            ['resources/views/backend/auth/passwords/email.blade.php'],
        ];
    }

    public function test_ajax_review_form_resets_explicit_widget_after_submission(): void
    {
        $contents = file_get_contents(dirname(__DIR__, 2).'/resources/views/frontend/pages/park/show.blade.php');

        $this->assertStringContainsString('reviewTurnstileWidgetId = window.turnstile.render', $contents);
        $this->assertStringContainsString('window.turnstile.reset(reviewTurnstileWidgetId)', $contents);
        $this->assertStringNotContainsString("window.turnstile.reset(form.find('.cf-turnstile')[0])", $contents);
    }

    #[DataProvider('turnstileLayouts')]
    public function test_form_layout_loads_turnstile_script(string $relativePath): void
    {
        $contents = file_get_contents(dirname(__DIR__, 2).'/'.$relativePath);

        $this->assertStringContainsString('https://challenges.cloudflare.com/turnstile/v0/api.js', $contents);
    }

    public static function turnstileLayouts(): array
    {
        return [
            ['resources/views/frontend/pages/layouts/app.blade.php'],
            ['resources/views/layouts/app.blade.php'],
            ['resources/views/backend/auth/layouts/app.blade.php'],
        ];
    }
}
