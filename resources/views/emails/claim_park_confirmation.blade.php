<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Park Claim Confirmation</title>
    <style>
        body {
            font-family: 'Segoe UI', sans-serif;
            background-color: #f8f9fa;
            margin: 0;
            padding: 0;
            color: #343a40;
        }
        .container {
            max-width: 600px;
            margin: 30px auto;
            background-color: #ffffff;
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 0 15px rgba(0,0,0,0.08);
            padding: 30px;
        }
        h1 {
            color: #007bff;
            font-size: 24px;
            margin-bottom: 20px;
        }
        .details {
            margin: 20px 0;
            border-collapse: collapse;
            width: 100%;
        }
        .details th, .details td {
            padding: 10px 15px;
            text-align: left;
        }
        .details th {
            background-color: #f1f1f1;
            width: 30%;
        }
        .status {
            font-weight: bold;
        }
        .status.pending { color: #ffc107; }
        .status.approved { color: #28a745; }
        .status.rejected { color: #dc3545; }
        .button {
            display: inline-block;
            margin-top: 25px;
            padding: 12px 25px;
            background-color: #007bff;
            color: white;
            text-decoration: none;
            border-radius: 5px;
        }
        .footer {
            margin-top: 40px;
            font-size: 14px;
            color: #6c757d;
            text-align: center;
        }
    </style>
</head>
<body>
<div class="container">
    <h1>🎉 Park Claim Submission Received</h1>
    <p>Hi <strong>{{ $claimPark->user->name }}</strong>,</p>

    <p>Thanks for submitting your claim for the park <strong>{{ $claimPark->park->name }}</strong>. Our team will review your request shortly, and you’ll be notified once there is an update on your claim status.</p>

    <table class="details">
        <tr>
            <th>Park Name:</th>
            <td>{{ $claimPark->park->name }}</td>
        </tr>
        <tr>
            <th>Contact Name:</th>
            <td>{{ $claimPark->contact_name }}</td>
        </tr>
        <tr>
            <th>Contact Email:</th>
            <td>{{ $claimPark->contact_email }}</td>
        </tr>
        <tr>
            <th>Status:</th>
            <td class="status {{ strtolower($claimPark->status) }}">{{ ucfirst($claimPark->status) }}</td>
        </tr>
    </table>

    <p>If you have any questions, feel free to reply to this email.</p>

    <a href="{{ url('/') }}" class="button text-white">Visit Website</a>

    <div class="footer">
        Regards, <br>
        {{ config('app.name') }} Team
    </div>
</div>
</body>
</html>
