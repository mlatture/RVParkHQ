<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Park Updated Notification</title>
</head>
<body style="margin: 0; padding: 0; background-color: #f4f4f4; font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;">

<div style="max-width: 600px; margin: 30px auto; background: #ffffff; border-radius: 8px; overflow: hidden; box-shadow: 0 0 12px rgba(0,0,0,0.08);">
    <div style="background-color: #16a34a; color: #ffffff; padding: 20px;">
        <h2 style="margin: 0;">🌿 Park Updated</h2>
    </div>

    <div style="padding: 20px;">
        <p style="font-size: 16px; line-height: 1.6;">
            The following update was made in the system:
        </p>

        <div style="background-color: #f0fdf4; border-left: 4px solid #16a34a; padding: 15px 20px; margin: 20px 0; border-radius: 4px;">
            <p style="margin: 0; font-size: 15px;">
                <strong>Park Name:</strong> {{ $park->name }}<br>
                <strong>Updated By:</strong> {{ $user->name }} ({{ $user->email }})
            </p>
        </div>

        <p style="font-size: 15px; color: #555;">
            If you were not expecting this change, please review the park settings or contact the system administrator.
        </p>

        <p style="margin-top: 40px; font-size: 15px;">
            Regards,<br>
            <strong>{{ config('app.name') }}</strong>
        </p>
    </div>
</div>

</body>
</html>
