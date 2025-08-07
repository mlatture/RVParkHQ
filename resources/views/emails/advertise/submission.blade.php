<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>New Advertisement Inquiry</title>
    <style>
        body {
            font-family: 'Helvetica Neue', Arial, sans-serif;
            background-color: #f4f6f8;
            margin: 0;
            padding: 0;
            color: #333;
        }
        .email-container {
            max-width: 620px;
            margin: 30px auto;
            background-color: #fff;
            border-radius: 6px;
            overflow: hidden;
            box-shadow: 0 2px 10px rgba(0,0,0,0.05);
        }
        .email-header {
            background-color: #343a40;
            color: white;
            padding: 20px;
            text-align: center;
        }
        .email-header h2 {
            margin: 0;
        }
        .email-body {
            padding: 30px;
        }
        .email-body table {
            width: 100%;
            border-collapse: collapse;
        }
        .email-body th,
        .email-body td {
            text-align: left;
            padding: 8px 0;
        }
        .email-body th {
            width: 120px;
            color: #555;
        }
        .email-footer {
            background-color: #f1f3f5;
            padding: 20px;
            text-align: center;
            font-size: 13px;
            color: #777;
        }
    </style>
</head>
<body>
<div class="email-container">
    <div class="email-header">
        <h2>📨 New Advertisement Inquiry</h2>
    </div>
    <div class="email-body">
        <p>Hello Admin,</p>
        <p>You have received a new advertisement Advertise. Here are the details:</p>

        <table>
            <tr>
                <th>Name:</th>
                <td>{{ $data['name'] ?? '-' }}</td>
            </tr>
            <tr>
                <th>Company:</th>
                <td>{{ $data['company'] ?? '-' }}</td>
            </tr>
            <tr>
                <th>Email:</th>
                <td>{{ $data['email'] ?? '-' }}</td>
            </tr>
            <tr>
                <th>Phone:</th>
                <td>{{ $data['phone'] ?? '-' }}</td>
            </tr>
            <tr>
                <th>Interest:</th>
                <td>{{ ucfirst($data['interest']) ?? '-' }}</td>
            </tr>
            <tr>
                <th>Message:</th>
                <td>{{ $data['message'] ?? '-' }}</td>
            </tr>
        </table>
    </div>
    <div class="email-footer">
        &copy; {{ date('Y') }} {{ config('app.name') }} — All rights reserved.
    </div>
</div>
</body>
</html>
