@extends('template.layout')
@section('title', 'Lost Account')
@section('submenuItem', 'lostaccount')
@section('content')
@if($lostAccount instanceof \App\Models\Account)
    <h2 style="text-align: center;">Email: {{ $emailOrChar }}</h2>
@else
    <h2 style="text-align: center;">Character Name: {{ $emailOrChar }}</h2>
@endif
<br>
<p>If your {{ config('server.serverName') }} account has been hacked, there are certain things that you must take care of before you can get your account back. If you do not remove the security problem first, you risk being hacked again. Therefore, you need to find out how the hacker got access to your account.</p>
<p>Here are some questions that might help you to find out how somebody could get hold of your account data:</p>
<ul>
    <li>Is it possible that you have a computer virus or a spy program on your computer? Please use one or two up-to-date anti-virus programs to check your computer. If a virus is found, remove it before you do anything else.</li>
    <li>Did you share your account data with anybody? A person that knows your account data can easily hack you. Do not take that risk again.</li>
    <li>Is your email address safe? Try to secure your email address by changing the password of your email account.</li>
</ul>
<p></p>
<p>To find out more about possible security leaks read our <a href="#">security hints</a> carefully. If you cannot find a security leak, do not simply forget about it. There must be a security leak, otherwise you would not have been hacked. Before you try to get your account back the security leak must be removed. You might still have a keylogger on your computer that cannot be found by your anti-virus programs. To make sure you get rid of all viruses and keyloggers you might need to format your hard disk as a last resort.</p>
<p style="text-align: center; font-weight: bold; font-size: 10pt; margin: 40px;">Always keep in mind that if you try to get your account back before the security leak is removed it is very likely that the hacker will again get access to your account.</p>
<form action="{{ route('account.lost.action') }}" method="post" style="padding:0px;margin:0px;">
    @csrf
    <div class="TableContainer">
        <div class="CaptionContainer">
            <div class="CaptionInnerContainer">
                <span class="CaptionEdgeLeftTop" style="background-image:url({{ asset('/assets/tibiarl/images/content/box-frame-edge.gif') }});"></span>
                <span class="CaptionEdgeRightTop" style="background-image:url({{ asset('/assets/tibiarl/images/content/box-frame-edge.gif') }});"></span>
                <span class="CaptionBorderTop" style="background-image:url({{ asset('/assets/tibiarl/images/content/table-headline-border.gif') }});"></span>
                <span class="CaptionVerticalLeft" style="background-image:url({{ asset('/assets/tibiarl/images/content/box-frame-vertical.gif') }});"></span>
                <div class="Text">Confirm Removal of Security Problem</div>
                <span class="CaptionVerticalRight" style="background-image:url({{ asset('/assets/tibiarl/images/content/box-frame-vertical.gif') }});"></span>
                <span class="CaptionBorderBottom" style="background-image:url({{ asset('/assets/tibiarl/images/content/table-headline-border.gif') }});"></span>
                <span class="CaptionEdgeLeftBottom" style="background-image:url({{ asset('/assets/tibiarl/images/content/box-frame-edge.gif') }});"></span>
                <span class="CaptionEdgeRightBottom" style="background-image:url({{ asset('/assets/tibiarl/images/content/box-frame-edge.gif') }});"></span>
            </div>
        </div>
        <table class="Table5" cellpadding="0" cellspacing="0">
            <tbody>
            <tr>
                <td>
                    <div class="TableScrollbarWrapper" style="width: unset;">
                        <div class="TableScrollbarContainer"> </div>
                    </div>
                    <div class="InnerTableContainer" style="max-width: unset;">
                        <table style="width:100%;">
                            <tbody>
                            <tr>
                                <td>
                                    <div class="TableContentContainer">
                                        <table class="TableContent" width="100%" style="border:1px solid #faf0d7;">
                                            <tbody>
                                            <tr>
                                                <td><label><input type="radio" name="step" value="password"> I confirm that I have removed the security problem of my account.</label></td>
                                            </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                </td>
            </tr>
            </tbody>
        </table>
    </div>
    <br>
    <center>
        <input type="hidden" name="email_or_char" value="{{ $emailOrChar }}">
        <div class="BigButton" style="background-image:url({{ asset('/assets/tibiarl/images/buttons/sbutton.gif') }})">
            <div onmouseover="MouseOverBigButton(this);" onmouseout="MouseOutBigButton(this);"><div class="BigButtonOver" style="background-image:url({{ asset('/assets/tibiarl/images/buttons/sbutton_over.gif') }});"></div>
                <input class="BigButtonText" type="submit" value="Submit">
            </div>
        </div>
    </center>
</form>
@endsection
