<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <style>
        <!-- .EmailQuote { margin-left: 1pt; padding-left: 4pt; border-left: #800000 2px solid; } -->
    </style>
</head>
<body>
<font size="2">
 <span style="font-size:11pt;">
<div class="PlainText">Dear customer,<br>
   <br>
   Thank you again for your order with {{ config('server.serverName') }}.<br>
   <br>
   Product: {{ config('server.serverName') }}<br>
   Service: New Recovery Key<br>
   Price:&nbsp;{{ config('shop.extraServices')['recoveryKey']['price'] }} {{ config('server.serverName') }} Coins<br>
   New Recovery Key: {{ $mailDetails['recoveryKey'] }}<br>
   <br>
   The amount has been deducted from account.<br>
   <br>
   Best regards,<br>
   Your {{ config('server.serverName') }} Team<br>
</div>
 </span>
</font>
</body>
</html>