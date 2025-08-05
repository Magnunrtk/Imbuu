<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Approved in Streamer Program - Ravenor</title>
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
                    <span class="account-number">Streamer: {{ $accountNumber }}</span>
                    <img src="https://ravenor.online/images/user-icon.png" alt="User Icon">
                </td>
            </tr>
        </table>

        <hr>

        <!-- Content Section with Recovery Key Info -->
        <div class="content">
            <p class="welcome-message">Congratulations!</p>
            <p>We are pleased to inform you that you have been <strong>approved</strong> for the <strong>Ravenor Streamers Program</strong>.</p>
            <p>As a participant, you will have special rewards and opportunities to grow within our platform.</p>
            
            <p><strong>Your Streamer Code:</strong> <span style="color: red; font-weight: bold; font-size: 18px;">{{ $accountName }}</span></p>
        
            <p>Your next steps:</p>
            <ul>
                <li>Log in to your account and visit the Streamers Dashboard.</li>
                <li>Make sure your payment details are updated.</li>
                <li>Start streaming and earning rewards!</li>
            </ul>
            <p>If you have any questions or need assistance, feel free to reach out to our support team on Discord.</p>
            <p>We are excited to have you on board and can't wait to see your content thrive!</p>
        </div>
        
        <!-- Footer Section -->
        <div class="footer">
            <p>To review the program rules, click <a href="https://ravenor.online/support/rules" target="_blank">here</a>.</p>
            <p>If you did not apply for this program, please contact our support team immediately.</p>
        </div>
        

    </div>
</body>
</html>

