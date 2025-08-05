@extends('template.layout')
@section('title', 'Lost Account')
@section('submenuItem', 'lostaccount')
@section('content')
    @if($lostAccount instanceof \App\Models\Account)
        <h2 style="text-align: center;">Email: {{ $emailOrChar }}</h2>
    @else
        <h2 style="text-align: center;">Character Name: {{ $emailOrChar }}</h2>
    @endif

    <ol style="line-height: 1.8;">
        <li>Enter the email address assigned to your {{ config('server.serverName') }} account in the "Account email address" field.</li>
        <li>You will receive an email with a link and a confirmation key. Click the link or copy and paste it into your browser.</li>
        <li>On the page, enter your account's email address and the confirmation key. Use the link within 24 hours, or you will need to request a new one.</li>
        <li>If the information is correct, you can set a new password.</li>
    </ol>
    
<form action="{{ route('account.lost.action') }}" method="post" style="padding:0px;margin:0px;">
    @csrf
    <div class="TableContainer">
        <div class="CaptionContainer">
            <div class="CaptionInnerContainer">
                <span class="CaptionEdgeLeftTop" style="background-image:url({{ asset('/assets/tibiarl/images/content/box-frame-edge.gif') }});"></span>
                <span class="CaptionEdgeRightTop" style="background-image:url({{ asset('/assets/tibiarl/images/content/box-frame-edge.gif') }});"></span>
                <span class="CaptionBorderTop" style="background-image:url({{ asset('/assets/tibiarl/images/content/table-headline-border.gif') }});"></span>
                <span class="CaptionVerticalLeft" style="background-image:url({{ asset('/assets/tibiarl/images/content/box-frame-vertical.gif') }});"></span>
                <div class="Text">Request New Password</div>
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
                                                <td>
                                                    <input type="hidden" name="step" value="sendconfirmation">
                                                    <table>
                                                        <tbody>
                                                        <tr>
                                                            <td><span>Account email address:</span></td>
                                                            <td><input name="email" value="" size="30" maxlength="50"></td>
                                                        </tr>
                                                        </tbody>
                                                    </table>
                                                </td>
                                            </tr>
                                            <tr>
                                                {{-- <td><label><input type="radio" name="step" value="provider"> I have lost access to that email account.</label></td> --}}
                                            </tr>
                                            @if($emailOrChar instanceof \App\Models\Player)
                                            <tr>
                                                <td><label><input type="radio" name="step" value="think"> I do not know that email address anymore.</label></td>
                                            </tr>
                                            @endif
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
    <table style="width:100%">
        <tbody>
        <tr align="center">
            <td>
                <input type="hidden" name="email_or_char" value="{{ $emailOrChar }}">
                <div class="BigButton" style="background-image:url({{ asset('/assets/tibiarl/images/buttons/sbutton.gif') }})">
                    <div onmouseover="MouseOverBigButton(this);" onmouseout="MouseOutBigButton(this);"><div class="BigButtonOver" style="background-image:url({{ asset('/assets/tibiarl/images/buttons/sbutton_over.gif') }});"></div>
                        <input class="BigButtonText" type="submit" value="Submit">
                    </div>
                </div>
            </td>
        </tr>
        </tbody>
    </table>
</form>
@endsection
