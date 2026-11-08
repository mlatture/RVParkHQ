<?php

namespace App\Http\Middleware;

use App\Services\TurnstileService;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpFoundation\Response;

class VerifyTurnstile
{
    public function __construct(private readonly TurnstileService $turnstile) {}

    public function handle(Request $request, Closure $next): Response
    {
        $token = $request->string('cf-turnstile-response')->trim()->toString();

        if ($token === '' || ! $this->turnstile->verify($token, $request->ip())) {
            throw ValidationException::withMessages([
                'cf-turnstile-response' => 'Please confirm you are human and try again.',
            ]);
        }

        return $next($request);
    }
}
