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
   Order:&nbsp;&nbsp; {{ $mailDetails['order_item_id'] }} from {{ date('M d, Y', strtotime($mailDetails['created_at'])) }}<br>
   Product: {{ config('server.serverName') }}<br>
   Service: {{ $mailDetails['service'] }}<br>
   Price:&nbsp;&nbsp; {{ $mailDetails['price'] }} {{ config('shop.currency') }} (including 19% value added tax)<br>
   <br>
   The amount has been deducted from your PayPal account.<br>
   You can now use the service. Have fun!<br>
   <br>
   Best regards,<br>
   Your {{ config('server.serverName') }} Team<br>
</div>
 </span>
</font>
</body>
</html>