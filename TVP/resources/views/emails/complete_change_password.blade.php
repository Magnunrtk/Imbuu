
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Change Password Successfully.</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f4f4;
        }

        .container {
            width: 100%;
            max-width: 600px;
            margin: 0 auto;
            background-color: #ffffff;
            padding: 20px;
            border: 1px solid #dddddd;
            border-radius: 5px;
        }

        .header {
            text-align: center;
        }

        .header img.banner {
            width: 100%;
            height: auto;
        }

        .logo {
            margin-top: 8px;
        }

        .logo img {
            width: 50px;
            height: 50px;
        }

        .user-info {
            font-size: 14px;
            color: #555555;
            text-align: right;
        }

        .user-info img {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            margin-left: 10px;
            vertical-align: middle;
        }

        .user-info .account-number {
            font-weight: bold;
        }

        .content {
            margin-top: 20px;
            font-size: 14px;
            line-height: 1.5;
            color: #080809;
        }

        .content a {
            color: #007bff;
            text-decoration: none;
        }

        .content a:hover {
            text-decoration: underline;
        }

        .welcome-message {
            font-weight: bold;
            font-size: 16px;
            margin-bottom: 15px;
        }

        .rules-link {
            margin-top: 10px;
            font-size: 12px;
        }

        .footer {
            font-size: 12px;
            color: #777777;
            margin-top: 20px;
            text-align: left;
        }

        .watermark {
            width: 100px;
            display: block;
            margin-left: auto;
            margin-right: 0;
            margin-bottom: 0;
            margin-top: -50px;
        }

        .footer-table {
            width: 100%;
            text-align: left;
            margin-top: 20px;
        }

        .footer-table td {
            vertical-align: top;
        }

        .banner{

            border: 4px solid #9b9a9a; 
            border-radius: 4px
        }

        .raven-logo {
            position: absolute;
            width: 60px;
            height: 60px;
            bottom: 15px;
            right: 15px;
        }

    </style>
</head>
<body>
    <div class="container">

        <div class="header">
            <a href="https://ravenor.online" target="_blank">
                <img src="https://ravenor.online/images/banner.jpeg" alt="Banner" class="banner">
            </a>
        </div>

        <table border="0" cellpadding="0" cellspacing="0" width="100%" class="logo-table">
            <tr>
                <td width="50%" class="logo">
                    <a href="https://ravenor.online" target="_blank">
                        <img src="https://ravenor.online/images/icon.jpg" alt="Ravenor Logo">
                    </a>
                </td>

                <td width="50%" class="user-info">
                    <span class="account-number">Account Nº: {{ $accountNumber }}</span>
                    <img src="https://ravenor.online/images/user-icon.png" alt="User Icon">
                </td>
            </tr>
        </table>

        <hr>

        <div class="content" style="padding: 20px; font-family: Arial, sans-serif; font-size: 14px;">

            <p>Your password has been <strong>successfully changed</strong>.</p>

            Please save this password in a safe place. It is required to access your account.<br>

            <br>
            
            <code style="font-weight: bold; font-size: 15px; color: #1d3557;">
                <strong style="color:black">New Password:</strong> {{ $actionLink }}
            </code>

            <p>If you did not request this password change, please contact support immediately.<br>
            To view our rules, click <a href="https://ravenor.online/support/rules" target="_blank">here</a>.</p>

            <table role="presentation" width="100%" cellspacing="0" cellpadding="0">
                <tr>
                    <td style="padding-right: 10px;">
                    </td>
                    <td width="50">
                        <img src="https://ravenor.online/images/raven.gif" alt="Raven Logo" width="60" height="60">
                    </td>
                </tr>
            </table>
        </div>

    </div>
</body>
</html>


