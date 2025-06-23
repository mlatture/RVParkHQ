<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Park Claim Status Updated</title>
</head>
<body style="font-family: Arial, sans-serif; background-color: #f8f9fa; padding: 30px; color: #333;">
<div style="max-width: 600px; margin: auto; background-color: #ffffff; border-radius: 6px; box-shadow: 0 2px 5px rgba(0,0,0,0.05); padding: 30px;">
    <h2 style="color: #2c3e50;">Your Park Claim Status has been Updated</h2>

    <p>Hello <strong>{{ $claimPark->user->name }}</strong>,</p>

    <p>
        The status of your claim for the park <strong>{{ $claimPark->park->name }}</strong> has been updated.
    </p>

    <p>
        <strong>New Status:</strong> {{ ucfirst($claimPark->status) }}
    </p>

    @if ($claimPark->status == 'approved')
        <p style="color: green;">
            🎉 Congratulations! Your claim has been approved. You are now the official owner of this park listing on our platform.
            You can now manage the park's details.
        </p>
        <p style="margin: 20px 0;">
            <a href="{{ route('admin.parks.edit', $claimPark->park->id) }}" style="display: inline-block; background-color: #28a745; color: #fff; padding: 12px 24px; text-decoration: none; border-radius: 4px;">
                Edit Park
            </a>
        </p>
    @elseif ($claimPark->status == 'rejected')
        <p style="color: red;">
            ❌ We regret to inform you that your claim has been rejected. If you believe this is an error, please contact our support team.
        </p>
    @endif

    <p>Thank you for using our platform.</p>

    <p style="margin-top: 40px;">Regards,<br><strong>{{ config('app.name') }}</strong></p>
</div>
</body>
</html>
