
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Welcome to Sharebutter</title>
    <style>
        body {
            font-family: 'Segoe UI', Arial, sans-serif;
            background: #f8fafc;
            color: #222;
            margin: 0;
            padding: 0;
        }
        .container {
            max-width: 600px;
            margin: 40px auto;
            background: #fff;
            border-radius: 8px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.07);
            padding: 32px;
        }
        .header {
            text-align: center;
            margin-bottom: 24px;
        }
        .header h1 {
            color: #0077ff;
            margin: 0;
        }
        .content {
            font-size: 1.1em;
            line-height: 1.7;
        }
        .footer {
            margin-top: 32px;
            text-align: center;
            color: #888;
            font-size: 0.95em;
        }
        .button {
            display: inline-block;
            margin-top: 24px;
            padding: 12px 32px;
            background: #0077ff;
            color: #fff;
            border-radius: 4px;
            text-decoration: none;
            font-weight: 500;
            box-shadow: 0 1px 4px rgba(0,0,0,0.08);
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>Welcome to Sharebutter, {{ $user->name }}!</h1>
        </div>
        <div class="content">
            <p>Hi {{ $user->name }},</p>
            <p>
                Thank you for joining <strong>Sharebutter</strong>! We're thrilled to have you as part of our community.<br>
                Your account has been created successfully, and you can now start exploring all the features we offer.
            </p>
            <a href="{{ url('/') }}" class="button">Go to Dashboard</a>
            <p style="margin-top:32px;">If you have any questions or need assistance, feel free to reply to this email or contact our support team.</p>
            <p>Best regards,<br>The Sharebutter Team</p>
        </div>
        <div class="footer">
            &copy; {{ date('Y') }} Sharebutter. All rights reserved.
        </div>
    </div>
</body>
</html>
