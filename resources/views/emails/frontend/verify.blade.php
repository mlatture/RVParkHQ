<x-mail::message>
# Email Verification Required

Hello {{ $user->name }},

Thank you for registering! Please verify your email address by clicking the button below:

<x-mail::button :url="$verificationUrl">
Verify Email
</x-mail::button>

If you did not create an account, no further action is required.

Thanks,<br>
{{ config('app.name') }}
</x-mail::message>