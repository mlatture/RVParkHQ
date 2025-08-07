<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>New Purchase Notification</title>
</head>
<body style="margin: 0; padding: 0; background-color: #f8fafc; font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;">

<div style="max-width: 600px; margin: 30px auto; background-color: #ffffff; border-radius: 10px; box-shadow: 0 4px 12px rgba(0,0,0,0.1); overflow: hidden;">

    <!-- Header -->
    <div style="background-color: #2563eb; color: white; padding: 20px 30px;">
        <h2 style="margin: 0;">New Purchase Alert</h2>
        <p style="margin: 5px 0 0;">A user has made a new purchase.</p>
    </div>

    <!-- Body -->
    <div style="padding: 30px; color: #333;">
        <p style="font-size: 16px;">Here are the details of the transaction:</p>

        <table style="width: 100%; margin-top: 20px; border-collapse: collapse;">
            <tr>
                <td style="padding: 8px 0;"><strong>User Name:</strong></td>
                <td style="padding: 8px 0;">{{ $user->name }}</td>
            </tr>
            <tr>
                <td style="padding: 8px 0;"><strong>User Email:</strong></td>
                <td style="padding: 8px 0;">{{ $user->email }}</td>
            </tr>
            <tr style="background-color: #f9f9f9;">
                <td style="padding: 8px 0;"><strong>Bill Subject:</strong></td>
                <td style="padding: 8px 0;">{{ $bill->subject }}</td>
            </tr>
            <tr>
                <td style="padding: 8px 0;"><strong>Description:</strong></td>
                <td style="padding: 8px 0;">{{ $bill->description }}</td>
            </tr>
            <tr style="background-color: #f9f9f9;">
                <td style="padding: 8px 0;"><strong>Amount:</strong></td>
                <td style="padding: 8px 0;">${{ number_format($bill->amount, 2) }}</td>
            </tr>
            <tr>
                <td style="padding: 8px 0;"><strong>Status:</strong></td>
                <td style="padding: 8px 0;">{{ ucfirst($bill->status) }}</td>
            </tr>
            <tr style="background-color: #f9f9f9;">
                <td style="padding: 8px 0;"><strong>Due Date:</strong></td>
                <td style="padding: 8px 0;">
                    {{ $bill->due_date ? \Carbon\Carbon::parse($bill->due_date)->format('F d, Y') : 'N/A' }}
                </td>
            </tr>
        </table>
    </div>

    <!-- Footer -->
    <div style="background-color: #f1f5f9; padding: 20px 30px; text-align: center; font-size: 13px; color: #6b7280;">
        This notification was sent to the admin panel. If you believe this transaction is suspicious, please verify with the user.
    </div>

</div>
</body>
</html>
