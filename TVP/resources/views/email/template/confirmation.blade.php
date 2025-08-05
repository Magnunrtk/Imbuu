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
   <div class="PlainText">Welcome to {{ config('server.serverName') }}!<br>
      &nbsp;&nbsp;&nbsp; <br>
      You have requested a resent of the email containing the confirmation<br>
      link.<br>
      <br>
      To be able to fully experience all features of a {{ config('server.serverName') }} free account,<br>
      you need to confirm your account. To do so, please click on the<br>
      following link:<br>
      &nbsp;&nbsp; <a href="{{ route('account.confirm.index', [md5($mailDetails['to']),$mailDetails['confirmationKey']]) }}">{{ route('account.confirm.index', [md5($mailDetails['to']),$mailDetails['confirmationKey']]) }}</a>&nbsp; <br>
      <br>
      If clicking on the link does not work in your email program, please<br>
      copy and paste it into your browser. The link is possibly split up<br>
      due to a word-wrap.<br>
      Please make sure to copy the complete link.<br>
      <br>
      Moreover, you will receive your recovery key while confirming your account.<br>
      The recovery key is an important security feature:<br>
      &nbsp;&nbsp; <a href="{{ route('support.securityHints') }}">{{ route('support.securityHints') }}</a><br>
      <br>
      See you in {{ config('server.serverName') }}!<br>
   </div>
</span>
</font>
</body>
</html>