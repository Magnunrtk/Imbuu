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
       A request for a new password for your {{ config('server.serverName') }} account has been submitted. You can choose a new password for your {{ config('server.serverName') }} account if you click on the following link:<br>
       &nbsp;&nbsp; <a href="{{ route('account.lost.new.index', [$mailDetails['confirmationKey']]) }}">{{ route('account.lost.new.index', [$mailDetails['confirmationKey']]) }}</a><br>
       <br>
       If clicking on the link does not work in your email program, please copy and paste it into your browser. The link is possibly split up due to a word wrap. Please make sure to copy the complete link.<br>
       <br>
       In case you encounter any problems using the above link, please&nbsp; go to <a href="{{ route('account.lost.new.index') }}">{{ route('account.lost.new.index') }}</a><br>
       to enter the following key in the corresponding field:<br>
       &nbsp;&nbsp; {{ $mailDetails['confirmationKey'] }}<br>
       <br>
       Note that the link is only valid for 24 hours. If you exceed this time, your password request will be cancelled and you will need to request a new email with a new confirmation key.<br>
       <br>
       Simply ignore this message if you have not requested a new password or do not need a new password anymore.<br>
       <br>
       If this request has not been submitted by you, someone else who knows your account email tries to get access to your account. Please consider changing your email address and carefully read our security hints at<br>
       <a href="{{ route('support.securityHints') }}">{{ route('support.securityHints') }}</a><br>
       <br>
       See you in {{ config('server.serverName') }}!<br>
    </div>
 </span>
</font>
</body>
</html>