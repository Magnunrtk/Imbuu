@extends('template.layout')
@section('title', 'Lost Account')
@section('submenuItem', 'lostaccount')
@section('content')
<h2>Welcome to the Lost Account Interface!</h2>

<p>If you have lost access to your account, this interface can help you. Of course, you need to prove that your claim to the account is justified. Enter the requested data and follow the instructions carefully. <b>Please understand there is no way to get access to your lost account if the interface cannot help you.</b> Further options to change account data are available if you have a registered account.</p>

<p>By using the Lost Account Interface you can</p>
<ul class="CustomBulletPointList" style="list-style-image: url({{ asset('/assets/tibiarl/images/content/bullet.gif') }});">
    <li>get a new password if you have lost the current password,</li>
    <li>get your account back if it has been hacked,</li>
    <li>change the email address of your account instantly (only possible with a valid recovery key)</li>
</ul>
<p></p>
<p>As a first step to use the Lost Account Interface, please enter the name of a character or the email address of your account and click on "Submit".</p>
<form action="{{ route('account.lost.action') }}" method="post">
    @csrf
    <div class="TableContainer">
        <div class="CaptionContainer">
            <div class="CaptionInnerContainer">
                <span class="CaptionEdgeLeftTop" style="background-image:url({{ asset('/assets/tibiarl/images/content/box-frame-edge.gif') }});"></span>
                <span class="CaptionEdgeRightTop" style="background-image:url({{ asset('/assets/tibiarl/images/content/box-frame-edge.gif') }});"></span>
                <span class="CaptionBorderTop" style="background-image:url({{ asset('/assets/tibiarl/images/content/table-headline-border.gif') }});"></span>
                <span class="CaptionVerticalLeft" style="background-image:url({{ asset('/assets/tibiarl/images/content/box-frame-vertical.gif') }});"></span>
                <div class="Text">Recover by Email or Character Name</div>
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
                                                    <div class="ThreeColumnsForm">
                                                        <div class="LabelV ThreeColumnsFormCell">Email Address/Character Name:</div>
                                                        <div class="ThreeColumnsFormCell ThreeColumnsFormInputCell">
                                                            <input name="email_or_char" maxlength="50">
                                                        </div>
                                                        <div class="ThreeColumnsFormCell ThreeColumnsFormButton">
                                                            <div class="BigButton" style="background-image:url({{ asset('/assets/tibiarl/images/buttons/sbutton.gif') }})">
                                                                <div onmouseover="MouseOverBigButton(this);" onmouseout="MouseOutBigButton(this);"><div class="BigButtonOver" style="background-image:url({{ asset('/assets/tibiarl/images/buttons/sbutton_over.gif') }});"></div>
                                                                    <input class="BigButtonText" type="submit" value="Submit">
                                                                </div>
                                                            </div>
                                                        </div>
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
                </td>
            </tr>
            </tbody>
        </table>
    </div>
    <br>
    <br>
</form>
@endsection
