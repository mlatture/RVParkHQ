<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Advertisement Status Update</title>
    <style>
        body {
            font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif;
            background-color: #f8f9fa;
            color: #333;
            margin: 0;
            padding: 0;
        }
        .email-container {
            max-width: 620px;
            margin: 30px auto;
            background-color: #fff;
            border-radius: 6px;
            overflow: hidden;
            box-shadow: 0 0 10px rgba(0,0,0,0.05);
        }
        .email-header {
            background-color: #2c7be5;
            color: #fff;
            padding: 20px;
            text-align: center;
        }
        .email-content {
            padding: 30px;
        }
        .email-content table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 15px;
        }
        .email-content th, .email-content td {
            text-align: left;
            padding: 8px;
            border-bottom: 1px solid #eee;
        }
        .email-footer {
            padding: 20px;
            background-color: #f1f3f5;
            text-align: center;
            font-size: 13px;
            color: #888;
        }
        .btn {
            display: inline-block;
            background-color: #2c7be5;
            color: white;
            padding: 10px 18px;
            margin-top: 20px;
            text-decoration: none;
            border-radius: 4px;
        }
        .status-badge {
            padding: 4px 10px;
            border-radius: 4px;
            font-weight: bold;
        }
        .status-approved { background: #d4edda; color: #155724; }
        .status-rejected { background: #f8d7da; color: #721c24; }
        .status-pending { background: #fff3cd; color: #856404; }
    </style>
</head>
<body>
<div class="email-container">
    <div class="email-header">
        <h2>📣 Advertisement Inquiry Update</h2>
    </div>
    <div class="email-content">
        <p>Hi {{ $data['name'] ?? 'User' }},</p>
        <p>Your advertisement inquiry status has been updated. Here are the details:</p>

        <table>
            <tr>
                <th>Name:</th><td>{{ $data['name'] ?? '-' }}</td>
            </tr>
            <tr>
                <th>Company:</th><td>{{ $data['company'] ?? '-' }}</td>
            </tr>
            <tr>
                <th>Email:</th><td>{{ $data['email'] ?? '-' }}</td>
            </tr>
            <tr>
                <th>Phone:</th><td>{{ $data['phone'] ?? '-' }}</td>
            </tr>
            <tr>
                <th>Interest:</th><td>{{ ucfirst($data['interest']) ?? '-' }}</td>
            </tr>
            <tr>
                <th>Message:</th><td>{{ $data['message'] ?? '-' }}</td>
            </tr>
            <tr>
                <th>Status:</th>
                <td>
                    @if($data['status'] == 'approved')
                        <span class="status-badge status-approved">Approved</span>
                    @elseif($data['status'] == 'rejected')
                        <span class="status-badge status-rejected">Rejected</span>
                    @else
                        <span class="status-badge status-pending">Pending</span>
                    @endif
                </td>
            </tr>
        </table>
    </div>
    <div class="email-footer">
        &copy; {{ date('Y') }} {{ config('app.name') }} — All rights reserved.
    </div>
</div>
</body>
</html>