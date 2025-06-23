<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>New Park Request</title>
</head>
<body style="font-family: Arial, sans-serif; background-color: #f6f9fc; padding: 20px;">

<div style="max-width: 600px; margin: 0 auto; background-color: #ffffff; border-radius: 10px; box-shadow: 0 2px 8px rgba(0,0,0,0.05); overflow: hidden;">
    <div style="background-color: #4CAF50; padding: 20px; color: #fff; text-align: center;">
        <h2 style="margin: 0;">🌲 New Park Access Request</h2>
    </div>

    <div style="padding: 20px;">
        <p style="font-size: 16px; color: #333;">
            <strong>{{ $user->name }}</strong> (<a href="mailto:{{ $user->email }}" style="color: #4CAF50;">{{ $user->email }}</a>)
            has requested access to the park:
        </p>

        <div style="margin-top: 15px; padding: 15px; background-color: #f0f8f5; border-left: 4px solid #4CAF50;">
            <strong>🏞️ Park Name:</strong> {{ $park->name }}
        </div>

        <p style="margin-top: 30px; font-size: 14px; color: #888;">Please log in to the admin dashboard to review and approve this request.</p>
    </div>

    <div style="background-color: #f1f1f1; text-align: center; padding: 15px; font-size: 12px; color: #999;">
        &copy; {{ date('Y') }} Your {{ config("app.name") }}. All rights reserved.
    </div>
</div>

</body>
</html>
