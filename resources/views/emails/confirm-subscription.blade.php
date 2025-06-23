<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Confirm Your Email</title>
</head>
<body style="margin: 0; padding: 0; font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; background-color: #f4f4f4;">
<table width="100%" cellpadding="0" cellspacing="0" style="padding: 40px 0;">
    <tr>
        <td align="center">
            <table width="600" cellpadding="0" cellspacing="0" style="background-color: #ffffff; border-radius: 10px; box-shadow: 0 5px 15px rgba(0,0,0,0.1); padding: 40px;">
                <tr>
                    <td align="center" style="padding-bottom: 30px;">
                        <h1 style="color: #2f855a; margin: 0;">🌲 Confirm Your Subscription</h1>
                    </td>
                </tr>
                <tr>
                    <td style="font-size: 16px; color: #333333; text-align: center;">
                        <p style="margin-bottom: 25px;">
                            Thanks for subscribing to local park updates!<br>
                            Just one more step to confirm your email address.
                        </p>

                        <a href="{{ $confirmationLink }}"
                           style="display: inline-block; background-color: #38a169; color: #ffffff; text-decoration: none; padding: 12px 30px; font-weight: bold; border-radius: 6px;">
                            ✅ Confirm My Email
                        </a>

                        <p style="margin-top: 30px; color: #777;">
                            If the button doesn't work, copy and paste the link below into your browser:
                        </p>

                        <p style="word-break: break-all; color: #4a5568;">
                            <a href="{{ $confirmationLink }}" style="color: #3182ce;">{{ $confirmationLink }}</a>
                        </p>
                    </td>
                </tr>

                <tr>
                    <td style="padding-top: 40px; font-size: 14px; color: #a0aec0; text-align: center;">
                        © {{ date('Y') }} RVParkHQ. All rights reserved.
                    </td>
                </tr>
            </table>
        </td>
    </tr>
</table>
</body>
</html>
