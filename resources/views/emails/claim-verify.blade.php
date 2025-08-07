<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Claim Park Verification</title>
</head>
<body style="font-family: Arial, sans-serif; background-color: #f4f4f4; margin: 0; padding: 0;">
<table width="100%" bgcolor="#f4f4f4" cellpadding="0" cellspacing="0">
    <tr>
        <td>
            <table align="center" width="600" cellpadding="0" cellspacing="0" style="margin: 30px auto; background-color: #ffffff; border-radius: 8px; overflow: hidden; box-shadow: 0 2px 5px rgba(0,0,0,0.1);">
                <tr>
                    <td style="padding: 30px; text-align: center; background-color: #4CAF50; color: white;">
                        <h2>Thank You for Claiming the Park!</h2>
                    </td>
                </tr>
                <tr>
                    <td style="padding: 30px;">
                        <p style="font-size: 16px; color: #333333;">
                            Hello <strong>{{ $submission->contact_name ?? 'Sir/Madam' }}</strong>,
                        </p>
                        <p style="font-size: 16px; color: #333333;">
                            Thank you for claiming the park. Please click the button below to verify your email and complete your claim process.
                        </p>
                        <p style="text-align: center; margin: 30px 0;">
                            <a href="{{ url('/claim-park/verify/'.$submission->verify_token) }}"
                               style="background-color: #4CAF50; color: white; text-decoration: none; padding: 12px 25px; border-radius: 5px; display: inline-block; font-size: 16px;">
                                Verify Email
                            </a>
                        </p>
                        <p style="font-size: 14px; color: #888888;">
                            If the button above doesn’t work, copy and paste the following link into your browser:
                        </p>
                        <p style="font-size: 14px; word-break: break-all; color: #0066cc;">
                            {{ url('/claim-park/verify/'.$submission->verify_token) }}
                        </p>
                    </td>
                </tr>
                <tr>
                    <td style="padding: 20px; text-align: center; font-size: 13px; color: #aaaaaa;">
                        &copy; {{ date('Y') }} Your Website. All rights reserved.
                    </td>
                </tr>
            </table>
        </td>
    </tr>
</table>
</body>
</html>
