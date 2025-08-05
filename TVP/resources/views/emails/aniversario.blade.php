<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Happy Anniversary - Retronia</title>
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
            border: 4px solid #FFC100;
            border-radius: 4px;
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

        .image-container {
            text-align: center;
        }

        .unique-img {
            width: 100%;
            height: auto;
            border-radius: 4px;
            border: 2px solid #dddddd;
        }

    </style>
</head>
<body>
    <div class="container">
        <!-- Header Section with Banner -->
        <div class="header">
            <a href="https://retronia.online" target="_blank">
                <img src="https://retronia.online/images/banner.png" alt="Banner" class="banner">
            </a>
        </div>

        <!-- Table for logo and account info -->
        <table border="0" cellpadding="0" cellspacing="0" width="100%" class="logo-table">
            <tr>
                <!-- Left-aligned logo -->
                <td width="50%" class="logo">
                    <a href="https://retronia.online" target="_blank">
                        <img src="https://retronia.online/images/icon.png" alt="Retronia Logo">
                    </a>
                </td>

                <!-- Right-aligned user info -->
                <td width="50%" class="user-info">
                    <span class="account-number">Account Nº: {{ $accountNumber }}</span>
                    <img src="https://retronia.online/images/user-icon.png" alt="User Icon">
                </td>
            </tr>
        </table>

        <hr>

        <!-- Content Section with Image and Text -->
        <table border="0" cellpadding="0" cellspacing="0" width="100%" class="content-table">
            <tr>
                <td>
                    <a href="https://retronia.online">
                        <img class="unique-img" src="https://cdn.discordapp.com/attachments/1260968781367476346/1284346921070104586/Feed_Aniversario_Retronia.jpg?ex=66e64cc7&is=66e4fb47&hm=99875d1c34c8ee497466cfd748c9d5c20f5c7fde073d123c499d74f052ed7d12" alt="Retronia Anniversary Image">
                    </a>
                </td>
            </tr>
        </table>

        <!-- Footer Section -->
        <div class="footer">
            <p>To view our rules, click <a href="https://retronia.online/support/rules" target="_blank">here</a>.</p>
            <p>If you did not create this account, please ignore this email.</p>
        </div>

    </div>
</body>
</html>
