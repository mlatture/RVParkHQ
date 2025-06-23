<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Park Request Status Update</title>
</head>
<body style="font-family: Arial, sans-serif; background-color: #f6f9fc; padding: 20px;">

<div style="max-width: 600px; margin: 0 auto; background-color: #ffffff; border-radius: 10px; box-shadow: 0 2px 8px rgba(0,0,0,0.05); overflow: hidden;">
    <div style="background-color: #2196F3; padding: 20px; color: #fff; text-align: center;">
        <h2 style="margin: 0;">🏞️ Park Request Status</h2>
    </div>

    <div style="padding: 20px;">
        <p style="font-size: 16px; color: #333;">
            Dear <strong>{{ $owner->name }}</strong>,
        </p>
        <p style="font-size: 16px; color: #333;">
            Your request for the park <strong>{{ $park->name }}</strong> has been
            <span style="color: {{ $status == 'approved' ? '#4CAF50' : '#F44336' }}; font-weight: bold; text-transform: capitalize;">{{ $status }}</span>
            by the admin.
        </p>
        <p style="margin-top: 30px; font-size: 14px; color: #888;">If you have any questions, please contact support.</p>
    </div>

    <div style="background-color: #f1f1f1; text-align: center; padding: 15px; font-size: 12px; color: #999;">
        &copy; {{ date('Y') }} Your {{ config("app.name") }}. All rights reserved.
    </div>
</div>

</body>
</html> 