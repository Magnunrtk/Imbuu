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
       To complete the email change of your {{ config('server.serverName') }} account, you need to choose a new password. You can choose a new password for your {{ config('server.serverName') }} account if you click on the following link:<br>
       &nbsp;&nbsp; <a href="{{ route('account.manage.email.confirm', [$mailDetails['confirmationKey']]) }}">{{ route('account.manage.email.confirm', [$mailDetails['confirmationKey']]) }}</a><br>
       <br>
       If clicking on the link does not work in your email program, please copy and paste it into your browser. The link is possibly split up due to a word wrap. Please make sure to copy the complete link.<br>
       <br>
       In case you encounter any problems using the above link, please go to <a href="{{ route('account.manage.email.confirm') }}">{{ route('account.manage.email.confirm') }}</a><br>
       to enter the following key in the corresponding field:<br>
       &nbsp;&nbsp; {{ $mailDetails['confirmationKey'] }}<br>
       <br>
       Note that the link is only valid for 24 hours. If you have exceeded this time limit and used a recovery key, you can request a new email with a new confirmation key.<br>
       <br>
       Simply ignore this message if you do not want to change the email address of your {{ config('server.serverName') }} account anymore.<br>
       <br>
       See you in {{ config('server.serverName') }}!<br>
    </div>
 </span>
</font>
</body>
</html>