<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Email Verification</title>
</head>
<body style="margin: 0; padding: 0; background-color: #f4f4f4;">
<table width="100%" bgcolor="#f4f4f4" cellpadding="0" cellspacing="0" style="padding: 20px;">
    <tr>
        <td align="center">
            <table width="600" cellpadding="0" cellspacing="0" bgcolor="#ffffff" style="border-radius: 8px; overflow: hidden; box-shadow: 0 2px 6px rgba(0, 0, 0, 0.1); font-family: Arial, sans-serif;">
                <tr>
                    <td bgcolor="#007BFF" style="padding: 20px; color: #ffffff; font-size: 20px; font-weight: bold;">
                        {{ config('app.name') }}
                    </td>
                </tr>
                <tr>
                    <td style="padding: 30px; color: #333;">
                        <p style="font-size: 16px;">Hi {{ $user->name }},</p>
                        <p style="font-size: 16px;">Please verify your email address by clicking the link below:</p>
                        <p style="text-align: center; margin: 30px 0;">
                            <a href="{{ $verificationUrl }}" style="display: inline-block; padding: 12px 24px; background-color: #007BFF; color: #fff; text-decoration: none; border-radius: 4px; font-size: 16px;">
                                Verify Email
                            </a>
                        </p>
                        <p style="font-size: 14px;">If you did not create an account, no further action is required.</p>
                        <p style="font-size: 14px;">Regards,<br><strong>{{ config('app.name') }} Team</strong></p>
                    </td>
                </tr>
                <tr>
                    <td bgcolor="#f1f1f1" style="padding: 15px; text-align: center; font-size: 12px; color: #888;">
                        &copy; {{ now()->year }} {{ config('app.name') }}. All rights reserved.
                    </td>
                </tr>
            </table>
        </td>
    </tr>
</table>
</body>
</html>
