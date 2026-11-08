<?php

namespace App\View\Components;

use Illuminate\Contracts\Encryption\Encrypter;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Str;
use Illuminate\View\Component;

class FormAbuseProtection extends Component
{
    public readonly string $token;

    public function __construct(Encrypter $encrypter)
    {
        $this->token = $encrypter->encryptString(json_encode([
            'issued_at' => now()->timestamp,
            'nonce' => Str::random(32),
        ], JSON_THROW_ON_ERROR));
    }

    public function render(): View
    {
        return view('components.form-abuse-protection');
    }
}
