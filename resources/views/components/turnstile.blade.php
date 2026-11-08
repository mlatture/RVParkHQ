@props([
    'size' => 'normal',
    'theme' => 'auto',
    'explicit' => false,
])

<div class="turnstile-field">
    <div
        {{ $attributes->class(['cf-turnstile' => ! $explicit]) }}
        data-sitekey="{{ config('services.turnstile.site_key') }}"
        data-size="{{ $size }}"
        data-theme="{{ $theme }}"
    ></div>

    @error('cf-turnstile-response')
        <div role="alert" style="color: #dc2626; font-size: 0.875rem; margin-top: 0.5rem;">
            {{ $message }}
        </div>
    @enderror
</div>
