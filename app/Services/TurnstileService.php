<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class TurnstileService
{
    public function verify(string $token, ?string $ipAddress = null): bool
    {
        $secretKey = config('services.turnstile.secret_key');

        if (! is_string($secretKey) || $secretKey === '' || $token === '') {
            return false;
        }

        try {
            $response = Http::asForm()
                ->timeout(5)
                ->post(config('services.turnstile.verify_url'), array_filter([
                    'secret' => $secretKey,
                    'response' => $token,
                    'remoteip' => $ipAddress,
                ]));
        } catch (\Throwable) {
            return false;
        }

        return $response->successful() && $response->json('success') === true;
    }
}
