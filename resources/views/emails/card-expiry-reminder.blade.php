<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Card Expiry Notification</title>
</head>
<body style="font-family: Arial, sans-serif; background-color: #f4f4f4; margin: 0; padding: 20px;">
<table width="100%" cellpadding="0" cellspacing="0">
    <tr>
        <td align="center">
            <table width="600" cellpadding="0" cellspacing="0" style="background-color: #ffffff; border-radius: 6px; overflow: hidden;">
                <tr>
                    <td style="background-color: #007bff; padding: 20px; color: #ffffff; text-align: center;">
                        <h2 style="margin: 0;">{{ config('app.name') }}</h2>
                    </td>
                </tr>
                <tr>
                    <td style="padding: 30px;">
                        <p style="font-size: 16px;">Dear {{ $card->user->name }},</p>
                        <p style="font-size: 16px;">
                            Your card ending with <strong>{{ substr($card->card_number, -4) }}</strong> is about to expire on
                            <strong>{{ $card->expiry }}</strong>.
                        </p>
                        <p style="font-size: 16px;">Please update your card information to avoid payment failures.</p>
                        <p style="font-size: 16px;">Regards,<br>{{ config('app.name') }} Team</p>
                    </td>
                </tr>
                <tr>
                    <td style="background-color: #f4f4f4; padding: 20px; text-align: center; font-size: 12px; color: #888888;">
                        &copy; {{ date('Y') }} {{ config('app.name') }}. All rights reserved.
                    </td>
                </tr>
            </table>
        </td>
    </tr>
</table>
</body>
</html>
