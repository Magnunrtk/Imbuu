@extends('template.layout')
@section('title', 'Lost Account')
@section('submenuItem', 'lostaccount')
@section('content')

@if($lostAccount instanceof \App\Models\Account)
    <h2 style="text-align: center;">Account Email: {{ $emailOrChar }}</h2>
@else
    <h2 style="text-align: center;">Character: {{ $emailOrChar }}</h2>
@endif
<br>

<h3>Email Change Request</h3>

<p>To update your email to <b>{{ $newEmail }}</b>, follow these steps:</p>

<ol>
    <li>Enter your <b>2FA authentication code</b> below.</li>
    <li>Click <b>"Submit"</b>.</li>
    <li>Check your inbox for a confirmation email and follow the provided link.</li>
    <li>On the confirmation page, <b>set a new password</b> to finalize the change.</li>
</ol>

<p><b>Important:</b> The confirmation link expires in <b>24 hours</b>.</p>

<div id="error-container"></div>

<form action="{{ route('account.lost.action') }}" method="post" style="padding:0px;margin:0px;">
    @csrf
    <div class="TableContainer">
        <div class="CaptionContainer">
            <div class="CaptionInnerContainer">
                <span class="CaptionEdgeLeftTop" style="background-image:url({{ asset('/assets/tibiarl/images/content/box-frame-edge.gif') }});"></span>
                <span class="CaptionEdgeRightTop" style="background-image:url({{ asset('/assets/tibiarl/images/content/box-frame-edge.gif') }});"></span>
                <span class="CaptionBorderTop" style="background-image:url({{ asset('/assets/tibiarl/images/content/table-headline-border.gif') }});"></span>
                <span class="CaptionVerticalLeft" style="background-image:url({{ asset('/assets/tibiarl/images/content/box-frame-vertical.gif') }});"></span>
                <div class="Text">Confirm Request for New Email Address</div>
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
                                            <input type="hidden" name="step" value="check2fa">
                                            <tr>
                                                <td>
                                                    <label for="auth_code"><b>2FA Code:</b></label>
                                                    <input name="auth_code" id="auth_code" maxlength="6" size="10" autocomplete="off" style="margin-top: 5px;">
                                                    <input type="hidden" name="finder" value="{{ $emailOrChar }}">
                                                    <input type="hidden" name="step" value="checkTwoAuth">
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
                </td>
            </tr>
            </tbody>
        </table>
    </div>
    <br>
    <center>
        <input type="hidden" name="email_or_char" value="{{ $emailOrChar }}">
        <input type="hidden" name="email" value="{{ $newEmail }}">
        <div class="BigButton" style="background-image:url({{ asset('/assets/tibiarl/images/buttons/sbutton.gif') }})">
            <div onmouseover="MouseOverBigButton(this);" onmouseout="MouseOutBigButton(this);">
                <div class="BigButtonOver" style="background-image:url({{ asset('/assets/tibiarl/images/buttons/sbutton_over.gif') }});"></div>
                <input class="BigButtonText" type="submit" value="Submit">
            </div>
        </div>
    </center>
</form>
@endsection
