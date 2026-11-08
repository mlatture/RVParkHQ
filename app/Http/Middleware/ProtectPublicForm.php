<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Contracts\Cache\Repository as Cache;
use Illuminate\Contracts\Encryption\DecryptException;
use Illuminate\Contracts\Encryption\Encrypter;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpFoundation\Response;

class ProtectPublicForm
{
    public function __construct(
        private readonly Encrypter $encrypter,
        private readonly Cache $cache,
    ) {}

    public function handle(Request $request, Closure $next): Response
    {
        $route = $request->route()?->getName() ?? $request->path();

        if (filled($request->input('_form_website'))) {
            $this->reject($request, $route, 'honeypot', '_form_website');
        }

        $issuedAt = $this->issuedAt($request, $route);
        $age = now()->timestamp - $issuedAt;

        if ($age < (int) config('anti_abuse.minimum_seconds', 2)) {
            $this->reject($request, $route, 'completed_too_quickly', '_form_started_at');
        }

        if ($age > (int) config('anti_abuse.maximum_age_seconds', 7200)) {
            $this->reject($request, $route, 'token_expired', '_form_started_at');
        }

        $ipKey = 'form-abuse:ip:'.$this->keyedHash($route.'|'.$request->ip());
        $this->enforceRateLimit(
            $request,
            $route,
            $ipKey,
            (int) config('anti_abuse.ip.max_attempts', 10),
            (int) config('anti_abuse.ip.decay_seconds', 60),
            'ip_rate_limit'
        );

        if ($email = $this->normalizedEmail($request)) {
            $emailKey = 'form-abuse:email:'.$this->keyedHash($route.'|'.$email);
            $this->enforceRateLimit(
                $request,
                $route,
                $emailKey,
                (int) config('anti_abuse.email.max_attempts', 5),
                (int) config('anti_abuse.email.decay_seconds', 3600),
                'email_rate_limit'
            );
        }

        $duplicateKey = 'form-abuse:duplicate:'.$this->payloadHash($request, $route);

        // Keep this atomic reservation immediately adjacent to controller dispatch.
        if (! $this->cache->add($duplicateKey, true, (int) config('anti_abuse.duplicate_seconds', 120))) {
            $this->reject($request, $route, 'duplicate_payload', '_form');
        }

        return $next($request);
    }

    private function issuedAt(Request $request, string $route): int
    {
        $token = $request->input('_form_started_at');

        if (! is_string($token) || $token === '') {
            $this->reject($request, $route, 'missing_token', '_form_started_at');
        }

        try {
            $data = json_decode($this->encrypter->decryptString($token), true, flags: JSON_THROW_ON_ERROR);
        } catch (DecryptException|\JsonException) {
            $this->reject($request, $route, 'invalid_token', '_form_started_at');
        }

        if (! is_array($data)
            || ! is_int($data['issued_at'] ?? null)
            || ! is_string($data['nonce'] ?? null)
            || $data['nonce'] === '') {
            $this->reject($request, $route, 'invalid_token', '_form_started_at');
        }

        return $data['issued_at'];
    }

    private function enforceRateLimit(
        Request $request,
        string $route,
        string $key,
        int $maxAttempts,
        int $decaySeconds,
        string $reason,
    ): void {
        if (RateLimiter::tooManyAttempts($key, $maxAttempts)) {
            $this->reject($request, $route, $reason, '_form');
        }

        RateLimiter::hit($key, $decaySeconds);
    }

    private function normalizedEmail(Request $request): ?string
    {
        foreach (['email', 'user_email'] as $field) {
            $value = $request->input($field);

            if (is_string($value) && trim($value) !== '') {
                return mb_strtolower(trim($value));
            }
        }

        return null;
    }

    private function payloadHash(Request $request, string $route): string
    {
        $payload = Arr::except($request->all(), [
            '_token',
            '_form_started_at',
            '_form_website',
        ]);

        $payload = $this->sortRecursively($payload);

        return $this->keyedHash($route.'|'.json_encode($payload, JSON_THROW_ON_ERROR));
    }

    private function sortRecursively(array $values): array
    {
        foreach ($values as &$value) {
            if (is_array($value)) {
                $value = $this->sortRecursively($value);
            }
        }
        unset($value);

        if (! array_is_list($values)) {
            ksort($values);
        }

        return $values;
    }

    private function reject(Request $request, string $route, string $reason, string $field): never
    {
        Log::warning('Public form submission rejected', [
            'reason' => $reason,
            'route' => $route,
            'ip_hash' => $this->keyedHash((string) $request->ip()),
        ]);

        $message = $field === '_form_started_at'
            ? 'This form could not be verified. Please refresh the page and try again.'
            : 'Unable to submit this form. Please wait and try again.';

        throw ValidationException::withMessages([$field => $message]);
    }

    private function keyedHash(string $value): string
    {
        return hash_hmac('sha256', $value, (string) config('app.key'));
    }
}
