@extends('template.layout')
@section('title', 'Account Management')
@section('submenuItem', 'accountmanagement')
@section('content')
<div class="TableContainer">
    <form action="{{ route('account.login.loginPost') }}" method="post" style="margin: 0px; padding: 0px;">
        @csrf
        <div class="CaptionContainer">
            <div class="CaptionInnerContainer">
                <span class="CaptionEdgeLeftTop" style="background-image:url({{ asset('/assets/tibiarl/images/content/box-frame-edge.gif') }});"></span>
                <span class="CaptionEdgeRightTop" style="background-image:url({{ asset('/assets/tibiarl/images/content/box-frame-edge.gif') }});"></span>
                <span class="CaptionBorderTop" style="background-image:url({{ asset('/assets/tibiarl/images/content/table-headline-border.gif') }});"></span>
                <span class="CaptionVerticalLeft" style="background-image:url({{ asset('/assets/tibiarl/images/content/box-frame-vertical.gif') }});"></span>
                <div class="Text">Account Login</div>
                <span class="CaptionVerticalRight" style="background-image:url({{ asset('/assets/tibiarl/images/content/box-frame-vertical.gif') }});"></span>
                <span class="CaptionBorderBottom" style="background-image:url({{ asset('/assets/tibiarl/images/content/table-headline-border.gif') }});"></span>
                <span class="CaptionEdgeLeftBottom" style="background-image:url({{ asset('/assets/tibiarl/images/content/box-frame-edge.gif') }});"></span>
                <span class="CaptionEdgeRightBottom" style="background-image:url({{ asset('/assets/tibiarl/images/content/box-frame-edge.gif') }});"></span>
            </div>
        </div>
        <table class="Table4" cellpadding="0" cellspacing="0">
            <tbody>
            <tr>
                <td>
                    <div class="InnerTableContainer">
                        <table style="width:100%;">
                            <tbody>
                            <tr>
                                <td>
                                    <div class="TableContentContainer">
                                        <table class="TableContent" width="100%" style="border:1px solid #faf0d7;">
                                            <tbody>
                                            <tr>
                                                <td>
                                                    <table style="float: left; width: 370px;" cellpadding="0" cellspacing="0">
                                                        <tbody>
                                                        <tr>
                                                            <td class="LabelV120"><span><span>Account Number:</span></span></td>
                                                            <td><input type="text" name="account" size="29" maxlength="30"></td>
                                                        </tr>
                                                        <tr>
                                                            <td class="LabelV120"><span><span>Password:</span></span></td>
                                                            <td><input type="password" name="password" size="29" maxlength="29"></td>
                                                        </tr>
                                                        </tbody>
                                                    </table>
                                                    <div style="float: right; font-size: 1px;">
                                                        <div class="BigButton" style="background-image:url({{ asset('/assets/tibiarl/images/buttons/sbutton.gif') }})">
                                                            <div onmouseover="MouseOverBigButton(this);" onmouseout="MouseOutBigButton(this);"><div class="BigButtonOver" style="background-image:url({{ asset('/assets/tibiarl/images/buttons/sbutton_over.gif') }});"></div>
                                                                <input class="BigButtonText" type="submit" value="Login">
                                                            </div>
                                                        </div>

                                                        <div style="width: 2px; height: 2px;"></div>
                                                        <div class="BigButton" onclick="RedirectToUrl('{{ route('account.lost.index') }}');" style="background-image:url({{ asset('/assets/tibiarl/images/buttons/sbutton.gif') }})">
                                                            <div onmouseover="MouseOverBigButton(this);" onmouseout="MouseOutBigButton(this);"><div class="BigButtonOver" style="background-image:url({{ asset('/assets/tibiarl/images/buttons/sbutton_over.gif') }});"></div>
                                                                <input class="BigButtonText" type="submit" value="Account Lost?">
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
    </form>
</div>
<br>
<center>
    <h1>New to {{ config('server.serverName') }}?</h1>
</center>
<div class="TableContainer">
    <div class="CaptionContainer">
        <div class="CaptionInnerContainer">
            <span class="CaptionEdgeLeftTop" style="background-image:url({{ asset('/assets/tibiarl/images/content/box-frame-edge.gif') }});"></span>
            <span class="CaptionEdgeRightTop" style="background-image:url({{ asset('/assets/tibiarl/images/content/box-frame-edge.gif') }});"></span>
            <span class="CaptionBorderTop" style="background-image:url({{ asset('/assets/tibiarl/images/content/table-headline-border.gif') }});"></span>
            <span class="CaptionVerticalLeft" style="background-image:url({{ asset('/assets/tibiarl/images/content/box-frame-vertical.gif') }});"></span>
            <div class="Text">New Player</div>
            <span class="CaptionVerticalRight" style="background-image:url({{ asset('/assets/tibiarl/images/content/box-frame-vertical.gif') }});"></span>
            <span class="CaptionBorderBottom" style="background-image:url({{ asset('/assets/tibiarl/images/content/table-headline-border.gif') }});"></span>
            <span class="CaptionEdgeLeftBottom" style="background-image:url({{ asset('/assets/tibiarl/images/content/box-frame-edge.gif') }});"></span>
            <span class="CaptionEdgeRightBottom" style="background-image:url({{ asset('/assets/tibiarl/images/content/box-frame-edge.gif') }});"></span>
        </div>
    </div>
    <table class="Table4" cellpadding="0" cellspacing="0">
        <tbody>
        <tr>
            <td>
                <div class="InnerTableContainer">
                    <table style="width:100%;">
                        <tbody>
                        <tr>
                            <td>
                                <div class="TableContentContainer">
                                    <table class="TableContent" width="100%" style="border:1px solid #faf0d7;">
                                        <tbody>
                                        <tr>
                                            <td>
                                                <div style="float: right; margin-top: 20px;" onclick="window.location.href='{{ route('account.create.index') }}'">
                                                    <div class="MediumButtonBackground" style="background-image:url({{ asset('/assets/tibiarl/images/buttons/mediumbutton.gif') }})" onmouseover="MouseOverMediumButton(this);" onmouseout="MouseOutMediumButton(this);"><div class="MediumButtonOver" style="background-image: url({{ asset('/assets/tibiarl/images/buttons/mediumbutton-over.gif') }}); visibility: hidden;" onmouseover="MouseOverMediumButton(this);" onmouseout="MouseOutMediumButton(this);"></div>
                                                        <input class="MediumButtonText" type="image" name="Create Account" alt="Create Account" src="{{ asset('/assets/tibiarl/images/buttons/mediumbutton_createaccount.png') }}">
                                                    </div>
                                                </div>
                                                <div id="LoginCreateAccountBox">
                                                    <p><b>{{ config('server.serverName') }}...</b></p>
                                                    <div style="margin-left: 10px;">
                                                        <p>... where hardcore gaming meets fantasy.</p>
                                                        <p>... where friendships last a lifetime.</p>
                                                        <p>... where adventurers will never end!</p>
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
@endsection
