@extends('template.layout')
@section('title', 'Lost Account')
@section('submenuItem', 'lostaccount')
@section('content')
@if(isset($lostAccount))
    @if($lostAccount instanceof \App\Models\Account)
        <h2 style="text-align: center;">Email: {{ $emailOrChar }}</h2>
    @else
        <h2 style="text-align: center;">Character Name: {{ $emailOrChar }}</h2>
    @endif
@endif
@if(isset($recoverSuccess))
    <br>
    <div class="TableContainer">
        <div class="CaptionContainer">
            <div class="CaptionInnerContainer">
                <span class="CaptionEdgeLeftTop" style="background-image:url({{ asset('/assets/tibiarl/images/content/box-frame-edge.gif') }});"></span>
                <span class="CaptionEdgeRightTop" style="background-image:url({{ asset('/assets/tibiarl/images/content/box-frame-edge.gif') }});"></span>
                <span class="CaptionBorderTop" style="background-image:url({{ asset('/assets/tibiarl/images/content/table-headline-border.gif') }});"></span>
                <span class="CaptionVerticalLeft" style="background-image:url({{ asset('/assets/tibiarl/images/content/box-frame-vertical.gif') }});"></span>
                <div class="Text">Confirmation Key Sent</div>
                <span class="CaptionVerticalRight" style="background-image:url({{ asset('/assets/tibiarl/images/content/box-frame-vertical.gif') }});"></span>
                <span class="CaptionBorderBottom" style="background-image:url({{ asset('/assets/tibiarl/images/content/table-headline-border.gif') }});"></span>
                <span class="CaptionEdgeLeftBottom" style="background-image:url({{ asset('/assets/tibiarl/images/content/box-frame-edge.gif') }});"></span>
                <span class="CaptionEdgeRightBottom" style="background-image:url({{ asset('/assets/tibiarl/images/content/box-frame-edge.gif') }});"></span>
            </div>
        </div>
        <table class="Table1" cellpadding="0" cellspacing="0">
            <tbody>
            <tr>
                <td>
                    <div class="InnerTableContainer" style="max-width: unset;">
                        <table style="width:100%;">
                            <tbody>
                            <tr>
                                <td>
                                    <p>An email with a confirmation key has been sent to your new email address. Note that this confirmation key is only <b>valid for 24 hours</b>.</p>
                                    <p>Click on the link in the email or enter your data below to choose a new password.</p>
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
@endif
<form action="{{ route('account.lost.new.action') }}" method="post" style="padding:0px;margin:0px;">
    @csrf
    <div class="TableContainer">
        <div class="CaptionContainer">
            <div class="CaptionInnerContainer">
                <span class="CaptionEdgeLeftTop" style="background-image:url({{ asset('/assets/tibiarl/images/content/box-frame-edge.gif') }});"></span>
                <span class="CaptionEdgeRightTop" style="background-image:url({{ asset('/assets/tibiarl/images/content/box-frame-edge.gif') }});"></span>
                <span class="CaptionBorderTop" style="background-image:url({{ asset('/assets/tibiarl/images/content/table-headline-border.gif') }});"></span>
                <span class="CaptionVerticalLeft" style="background-image:url({{ asset('/assets/tibiarl/images/content/box-frame-vertical.gif') }});"></span>
                <div class="Text">Enter Confirmation Key</div>
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
                                                <td colspan="2"><label><input type="checkbox" name="confirmation" value="yes" @if(isset($confirmation)) checked="checked" @endif> Yes, I want to choose a new password.<br></label></td>
                                            </tr>
                                            <tr>
                                                <td class="LabelV200">Current Email Address:</td>
                                                <td>
                                                    @if(isset($email))
                                                        <input type="text" name="email" value="{{ $email }}" size="30" maxlength="50">
                                                    @else
                                                        <input type="text" name="email" value="" size="30" maxlength="50">
                                                    @endif
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="LabelV200">Confirmation Key:</td>
                                                <td>
                                                    @if(isset($confirmationKey))
                                                        <input class="LowerCaseInput" name="confirmationKey" value="{{ $confirmationKey }}" size="30" maxlength="30" autocomplete="off">
                                                    @else
                                                        <input class="LowerCaseInput" name="confirmationKey" value="" size="30" maxlength="30" autocomplete="off">
                                                    @endif
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
    <br><br>
    <center>
        <input type="hidden" name="step" value="setpasswordcheckconfirmationkey">
        <div class="BigButton" style="background-image:url({{ asset('/assets/tibiarl/images/buttons/sbutton.gif') }})">
            <div onmouseover="MouseOverBigButton(this);" onmouseout="MouseOutBigButton(this);"><div class="BigButtonOver" style="background-image:url({{ asset('/assets/tibiarl/images/buttons/sbutton_over.gif') }});"></div>
                <input class="BigButtonText" type="submit" value="Submit">
            </div>
        </div>
    </center>
</form>
@endsection
