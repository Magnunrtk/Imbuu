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
   A request to change the password of your {{ config('server.serverName') }} account has been submitted.<br>
   <br>
   To change your password, you need to be logged into your account on the {{ config('server.serverName') }} website. Also you have to change your password within 24 hours after you have started the request. If you exceed this time, the sent confirmation key will become invalid and you will have to start the process again. <br>
   <br>
   Please confirm your request at<br>
   &nbsp;&nbsp; <a href="{{ route('account.manage.change.password.confirm', [$mailDetails['confirmationKey']]) }}">{{ route('account.manage.change.password.confirm', [$mailDetails['confirmationKey']]) }}</a><br>
   <br>
   If clicking on the link does not work in your email program, please copy and paste it into your browser. The link is possibly split up due to a word-wrap. Please make sure to copy the complete link.<br>
   <br>
   Alternatively, if you should encounter any problems using the above link, simply go back to the "Change Password" function on your account management page to enter the following key in the corresponding form:<br>
   &nbsp;&nbsp; {{ $mailDetails['confirmationKey'] }}<br>
   <br>
   If this request has not been submitted by you, somebody else has access to your account. Please change the password of your account immediately and carefully read our security hints at<br>
   <a href="{{ route('support.securityHints') }}">{{ route('support.securityHints') }}</a><br>
   <br>
   See you in Tibia!<br>
   Your CipSoft Team<br>
</div>
 </span>
</font>
</body>
</html>