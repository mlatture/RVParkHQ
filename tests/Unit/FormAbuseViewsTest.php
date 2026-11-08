<?php

namespace Tests\Unit;

use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

class FormAbuseViewsTest extends TestCase
{
    #[DataProvider('protectedFormViews')]
    public function test_protected_form_includes_reusable_component(string $relativePath): void
    {
        $contents = file_get_contents(dirname(__DIR__, 2).'/'.$relativePath);

        $this->assertStringContainsString('<x-form-abuse-protection', $contents, "Missing form abuse component in {$relativePath}.");
    }

    public static function protectedFormViews(): array
    {
        return [
            ['resources/views/frontend/pages/park/show.blade.php'],
            ['resources/views/frontend/pages/layouts/partials/footer.blade.php'],
            ['resources/views/frontend/pages/suggest/index.blade.php'],
            ['resources/views/frontend/pages/advertise/index.blade.php'],
            ['resources/views/frontend/pages/park/partials/claim-park-modal.blade.php'],
            ['resources/views/frontend/auth/register.blade.php'],
            ['resources/views/auth/register.blade.php'],
            ['resources/views/backend/auth/register.blade.php'],
            ['resources/views/backend/auth/passwords/email.blade.php'],
            ['resources/views/auth/passwords/email.blade.php'],
        ];
    }

    #[DataProvider('loginViews')]
    public function test_login_form_does_not_require_form_timing_component(string $relativePath): void
    {
        $contents = file_get_contents(dirname(__DIR__, 2).'/'.$relativePath);

        $this->assertStringNotContainsString('<x-form-abuse-protection', $contents);
    }

    public static function loginViews(): array
    {
        return [
            ['resources/views/frontend/auth/login.blade.php'],
            ['resources/views/auth/login.blade.php'],
            ['resources/views/backend/auth/login.blade.php'],
        ];
    }
}
