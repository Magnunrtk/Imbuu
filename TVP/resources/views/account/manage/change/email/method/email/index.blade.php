@extends('template.layout')
@section('title', 'Account Management')
@section('submenuItem', 'accountmanagement')
@section('content')
    <p>Please enter your password and the new email address. Make sure that you enter a valid email address which you have access to. <b>For security reasons, the actual change will be finalised after a waiting period of {{ config('server.days_until_email_change') }} days.</b></p>
    <p>Please note that you will also need to <b>choose a new password</b> to complete the email change.</p>
    <br>
    <form action="{{ route('account.manage.email.method') }}" method="post" class="form">
        @csrf
        <input type="hidden" name="method" value="1">
        <input type="hidden" name="step" value="changeemailrequest">
        <div class="TableContainer">
            <div class="CaptionContainer">
                <div class="CaptionInnerContainer">
                    <span class="CaptionEdgeLeftTop" style="background-image:url({{ asset('/assets/tibiarl/images/content/box-frame-edge.gif') }});"></span>
                    <span class="CaptionEdgeRightTop" style="background-image:url({{ asset('/assets/tibiarl/images/content/box-frame-edge.gif') }});"></span>
                    <span class="CaptionBorderTop" style="background-image:url({{ asset('/assets/tibiarl/images/content/table-headline-border.gif') }});"></span>
                    <span class="CaptionVerticalLeft" style="background-image:url({{ asset('/assets/tibiarl/images/content/box-frame-vertical.gif') }});"></span>
                    <div class="Text">Change Email Address</div>
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
                        <div class="InnerTableContainer">
                            <table style="width:100%;">
                                <tbody>
                                <tr>
                                    <td class="LabelV">
                                        <span>New Email Address:</span>
                                    </td>
                                    <td style="width:90%;">
                                        <input name="email" value="" maxlength="100" autofocus="">
                                    </td>
                                </tr>
                                <tr>
                                    <td class="LabelV">
                                        <span>Password:</span>
                                    </td>
                                    <td>
                                        <input type="password" name="password" size="30" maxlength="29">
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
        <table style="width:100%;">
            <tbody>
            <tr align="center">
                <td>
                    <table border="0" cellspacing="0" cellpadding="0">
                        <tbody>
                        <tr>
                            <td style="border:0px;">
                                <div class="BigButton" style="background-image:url({{ asset('/assets/tibiarl/images/buttons/sbutton_green.gif') }})">
                                    <div onmouseover="MouseOverBigButton(this);" onmouseout="MouseOutBigButton(this);"><div class="BigButtonOver" style="background-image:url({{ asset('/assets/tibiarl/images/buttons/sbutton_green_over.gif') }});"></div>
                                        <input class="BigButtonText" type="submit" value="Submit">
                                    </div>
                                </div>
                            </td>
                        </tr>
                        <tr></tr>
                        </tbody>
                    </table>
                </td>
                <td>
                    <table border="0" cellspacing="0" cellpadding="0">
                        <tbody>
                        <tr>
                            <td style="border:0px;">
                                <div class="BigButton" onclick="RedirectToUrl('{{ route('account.manage.index') }}');" style="background-image:url({{ asset('/assets/tibiarl/images/buttons/sbutton.gif') }})">
                                    <div onmouseover="MouseOverBigButton(this);" onmouseout="MouseOutBigButton(this);"><div class="BigButtonOver" style="background-image:url({{ asset('/assets/tibiarl/images/buttons/sbutton_over.gif') }});"></div>
                                        <input class="BigButtonText" type="submit" value="Back">
                                    </div>
                                </div>
                            </td>
                        </tr>
                        </tbody>
                    </table>
                </td>
            </tr>
            </tbody>
        </table>
    </form>
@endsection
