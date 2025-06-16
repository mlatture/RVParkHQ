<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Confirm Your Review</title>
</head>
<body style="font-family: Arial, sans-serif; background-color: #f9f9f9; padding: 20px; color: #333;">

<div style="background-color: #ffffff; padding: 25px; border-radius: 8px; box-shadow: 0 2px 5px rgba(0,0,0,0.1);">
    <h2 style="margin-top: 0;">Hello {{ $pendingFeedback->name }},</h2>

    <p>Thank you for submitting a review for <strong>{{ $pendingFeedback->park->name ?? 'the campground' }}</strong>.</p>

    <ul style="list-style: none; padding: 0;">
        <li><strong>Name:</strong> {{ $pendingFeedback->name }}</li>
        <li><strong>Email:</strong> {{ $pendingFeedback->email }}</li>
        <li><strong>Rating:</strong>
            @for ($i = 0; $i < $pendingFeedback->rating; $i++)
                ⭐
            @endfor
        </li>
        <li><strong>Message:</strong> {{ $pendingFeedback->message }}</li>
    </ul>

    <p style="text-align: center; margin: 30px 0;">
        <a href="{{ route('rv-park.conform-review', $pendingFeedback->token) }}"
           style="background-color: #28a745; color: white; text-decoration: none; padding: 12px 20px; border-radius: 5px; font-weight: bold;">
            Confirm My Review
        </a>
    </p>

    <p>If you did not submit this review, you can safely ignore this email.</p>

    <p style="margin-top: 40px;">Thanks,<br>The Team Rv Park And Campground</p>
</div>

</body>
</html>
