<?php

namespace Tests\Feature;

use Illuminate\Support\Facades\Crypt;
use Tests\TestCase;

class FormAbuseComponentTest extends TestCase
{
    public function test_component_renders_encrypted_start_token_and_honeypot(): void
    {
        config(['app.key' => 'base64:AAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAA=']);

        $html = $this->blade('<x-form-abuse-protection />');

        $html->assertSee('name="_form_started_at"', false)
            ->assertSee('name="_form_website"', false)
            ->assertSee('tabindex="-1"', false)
            ->assertSee('aria-hidden="true"', false);

        preg_match('/name="_form_started_at" value="([^"]+)"/', (string) $html, $matches);
        $this->assertNotEmpty($matches[1] ?? null);

        $data = json_decode(Crypt::decryptString(html_entity_decode($matches[1], ENT_QUOTES)), true, flags: JSON_THROW_ON_ERROR);
        $this->assertIsInt($data['issued_at'] ?? null);
        $this->assertIsString($data['nonce'] ?? null);
        $this->assertNotSame('', $data['nonce']);
    }
}
