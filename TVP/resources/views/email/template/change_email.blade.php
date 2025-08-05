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
  <div class="PlainText">Dear {{ config('server.serverName') }} player,<br>
     <br>
     A request to change the email address of your {{ config('server.serverName') }} account to <br>
     &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; {{ $mailDetails['changeEmail'] }}&nbsp; <br>
     has been submitted. The actual change can only be performed<br>
     in {{ config('server.days_until_email_change') }} days.<br>
     <br>
     If this request has not been submitted by you, somebody else<br>
     seems to know the password of your account and tries to<br>
     take possession of it. In this case do the following things:<br>
     - Cancel the request by logging into your account, clicking on<br>
     &nbsp; "Change email address" and clicking on "Cancel".<br>
     - Change the password of your account.<br>
     - Take a look at our security page at<br>
     &nbsp;&nbsp;&nbsp; <a href="{{ route('support.securityHints') }}">{{ route('support.securityHints') }}</a><br>
     &nbsp; in order to avoid being hacked again.<br>
     - If you cannot access your account, you have to use our<br>
     &nbsp; Lost Account Interface at<br>
     &nbsp;&nbsp;&nbsp; <a href="{{ route('account.lost.index') }}">{{ route('account.lost.index') }}</a><br>
     &nbsp; in order to receive a new account password.<br>
     <br>
      See you in {{ config('server.serverName') }}!<br>
  </div>
 </span>
</font>
</body>
</html>