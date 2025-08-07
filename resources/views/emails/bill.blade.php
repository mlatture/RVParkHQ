<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Your Bill</title>
</head>
<body style="margin: 0; padding: 0; background-color: #f9f9f9;">
<div style="max-width: 600px; margin: 30px auto; background: #ffffff; border-radius: 10px; box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1); overflow: hidden;">
    <div style="background-color: #0d6efd; padding: 20px 30px;">
        <h2 style="color: #ffffff; margin: 0;">🧾 Invoice from {{ config('app.name') }}</h2>
    </div>

    <div style="padding: 30px;">
        <p style="font-size: 16px; color: #333333; margin-bottom: 10px;">Hi {{ $bill->user->name ?? 'Customer' }},</p>
        <p style="font-size: 14px; color: #555555;">Thanks for your continued trust in us. Here are the details of your latest invoice:</p>

        <table style="width: 100%; margin-top: 20px; font-size: 14px; border-collapse: collapse;">
            <tr>
                <td style="padding: 10px 0; color: #777777;">📌 <strong>Subject</strong></td>
                <td style="padding: 10px 0; color: #333333;">{{ $bill->subject }}</td>
            </tr>
            <tr>
                <td style="padding: 10px 0; color: #777777;">📝 <strong>Description</strong></td>
                <td style="padding: 10px 0; color: #333333;">{{ $bill->description }}</td>
            </tr>
            <tr>
                <td style="padding: 10px 0; color: #777777;">💰 <strong>Amount</strong></td>
                <td style="padding: 10px 0; color: #333333;">${{ number_format($bill->amount, 2) }}</td>
            </tr>
            <tr>
                <td style="padding: 10px 0; color: #777777;">🕛 <strong>Schedule</strong></td>
                <td style="padding: 10px 0; color: #333333;">{{ $bill->schedule }}</td>
            </tr>
            @if($bill->schedule != 'One Time')
                <tr>
                    <td style="padding: 10px 0; color: #777777;">📅 <strong>Due Date</strong></td>
                    <td style="padding: 10px 0; color: #333333;">{{ \Carbon\Carbon::parse($bill->due_date)->format('F d, Y') }}</td>
                </tr>
            @endif
            <tr>
                <td style="padding: 10px 0; color: #777777;">📦 <strong>Status</strong></td>
                <td style="padding: 10px 0; color: {{ $bill->status === 'paid' ? '#198754' : '#dc3545' }};">
                    <strong>{{ ucfirst($bill->status) }}</strong>
                </td>
            </tr>
        </table>

        <p style="margin-top: 30px; text-align: center;">
            <a href="{{ url('/pay-bill/' . $bill->payment_link_token) }}" style="display: inline-block; padding: 12px 30px; background-color: #0d6efd; color: #fff; border-radius: 5px; text-decoration: none; font-size: 16px; font-weight: bold;">Pay Now</a>
        </p>

        <p style="margin-top: 40px; font-size: 14px; color: #333333;">
            Regards,<br><strong>{{ config('app.name') }} Team</strong>
        </p>
    </div>

    <div style="background-color: #f1f1f1; text-align: center; padding: 15px; font-size: 12px; color: #999999;">
        &copy; {{ date('Y') }} {{ config('app.name') }}. All rights reserved.
    </div>
</div>
</body>
</html>
