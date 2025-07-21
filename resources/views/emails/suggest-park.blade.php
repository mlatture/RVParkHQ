<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>New Suggested Park</title>
</head>
<body style="font-family: Arial, sans-serif; background-color: #f6f9fc; padding: 20px;">

<div style="max-width: 600px; margin: 0 auto; background-color: #ffffff; border-radius: 10px; box-shadow: 0 2px 8px rgba(0,0,0,0.05); overflow: hidden;">
    <div style="background-color: #4CAF50; padding: 20px; color: #fff; text-align: center;">
        <h2 style="margin: 0;">🌲 New Park Suggestion Submitted</h2>
    </div>

    <div style="padding: 20px;">
        <p style="font-size: 16px; color: #333;">
            A new park has been suggested by <strong>{{ $suggestedPark->user_name }}</strong>
            (<a href="mailto:{{ $suggestedPark->user_email }}" style="color: #4CAF50;">{{ $suggestedPark->user_email }}</a>).
        </p>

        <div style="margin-top: 20px; padding: 15px; background-color: #f0f8f5; border-left: 4px solid #4CAF50;">
            <p><strong>🏞️ Park Name:</strong> {{ $suggestedPark->park_name }}</p>
            <p><strong>📍 Location:</strong> {{ $suggestedPark->address_line_1 }}</p>
            @if($suggestedPark->zip)
                <p><strong>📬 ZIP Code:</strong> {{ $suggestedPark->zip }}</p>
            @endif
            @if($suggestedPark->website_url)
                <p><strong>🔗 Website:</strong> <a href="{{ $suggestedPark->website_url }}" style="color: #4CAF50;">{{ $suggestedPark->website_url }}</a></p>
            @endif
            @if($suggestedPark->email)
                <p><strong>📧 Email:</strong> {{ $suggestedPark->email }}</p>
            @endif
            @if($suggestedPark->phone)
                <p><strong>📞 Phone:</strong> {{ $suggestedPark->phone }}</p>
            @endif
        </div>

        <p style="margin-top: 30px; font-size: 14px; color: #555;">
            Please log in to the admin dashboard to review and manage this park suggestion.
        </p>
    </div>

    <div style="background-color: #f1f1f1; text-align: center; padding: 15px; font-size: 12px; color: #999;">
        &copy; {{ date('Y') }} {{ config("app.name") }}. All rights reserved.
    </div>
</div>

</body>
</html>
