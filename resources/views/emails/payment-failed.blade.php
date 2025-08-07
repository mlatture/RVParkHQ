<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Payment Failed</title>
</head>
<body style="margin: 0; padding: 0; font-family: Arial, sans-serif; background-color: #f4f4f4;">

<table width="100%" cellpadding="0" cellspacing="0" style="background-color: #f4f4f4; padding: 20px;">
    <tr>
        <td>
            <table width="600" cellpadding="0" cellspacing="0" align="center" style="background-color: #ffffff; border-radius: 8px; overflow: hidden; box-shadow: 0 0 10px rgba(0,0,0,0.05);">
                <tr>
                    <td style="background-color: #007bff; padding: 20px; color: #ffffff; text-align: center;">
                        <h2 style="margin: 0;">{{ config('app.name') }}</h2>
                    </td>
                </tr>

                <tr>
                    <td style="padding: 30px; color: #333;">
                        <p style="font-size: 16px;">Dear <strong>{{ $bill->user->name }}</strong>,</p>

                        <p style="font-size: 16px;">
                            We were unable to process your payment of
                            <strong style="color: #dc3545;">${{ number_format($bill->amount, 2) }}</strong>
                            for the bill
                            <strong>{{ $bill->subject }}</strong>.
                        </p>

                        <p style="font-size: 16px;">
                            Please update your card information to avoid service interruption.
                        </p>

                        <p style="font-size: 16px;">
                            If you have any questions, feel free to contact our support team.
                        </p>

                        <p style="font-size: 16px;">Regards,<br><strong>{{ config('app.name') }} Team</strong></p>
                    </td>
                </tr>

                <tr>
                    <td style="background-color: #f8f9fa; padding: 15px; text-align: center; color: #999; font-size: 12px;">
                        &copy; {{ date('Y') }} {{ config('app.name') }}. All rights reserved.
                    </td>
                </tr>
            </table>
        </td>
    </tr>
</table>

</body>
</html>
