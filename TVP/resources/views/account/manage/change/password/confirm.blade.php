@extends('template.layout')
@section('title', 'Account Management')
@section('submenuItem', 'accountmanagement')
@section('content')
<form action="{{ route('account.manage.change.password.method') }}" method="post">
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
        <table class="Table1" cellpadding="0" cellspacing="0">
            <tbody>
            <tr>
                <td>
                    <div class="InnerTableContainer" style="max-width: unset;">
                        <table style="width:100%;">
                            <tbody>
                            <tr>
                                <td colspan="2">
                                    <p>An <b>email</b> containing a link with a confirmation key has been sent to the email address assigned to the account. The confirmation key will be <b>valid for the next 24 hours</b>.</p>
                                    <p>To change the password, click on the confirmation link in the email. If you have trouble using the link, simply enter the confirmation key below.</p>
                                </td>
                            </tr>
                            <tr>
                                <td class="LabelV150"><span>Confirmation Key:</span></td>
                                <td>
                                    @if(isset($confirmationKey))
                                        <input class="LowerCaseInput" type="text" name="confirmationKey" value="{{ $confirmationKey }}" size="40" maxlength="30" autocomplete="off">
                                    @else
                                        <input class="LowerCaseInput" type="text" name="confirmationKey" value="" size="40" maxlength="30" autocomplete="off">
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
    <br>
    <table style="width: 100%;">
        <tbody>
        <tr align="center">
            <td>
                <input type="hidden" name="step" value="enterpasswords">
                <div class="BigButton" style="background-image:url({{ asset('/assets/tibiarl/images/buttons/sbutton.gif') }})">
                    <div onmouseover="MouseOverBigButton(this);" onmouseout="MouseOutBigButton(this);"><div class="BigButtonOver" style="background-image:url({{ asset('/assets/tibiarl/images/buttons/sbutton_over.gif') }});"></div>
                        <input class="BigButtonText" type="submit" value="Submit">
                    </div>
                </div>
            </td>
            <td>
                <div class="BigButton" onclick="RedirectToUrl('{{ route('account.manage.index') }}');" style="background-image:url({{ asset('/assets/tibiarl/images/buttons/sbutton.gif') }})">
                    <div onmouseover="MouseOverBigButton(this);" onmouseout="MouseOutBigButton(this);"><div class="BigButtonOver" style="background-image:url({{ asset('/assets/tibiarl/images/buttons/sbutton_over.gif') }});"></div>
                        <input class="BigButtonText" type="submit" value="Back">
                    </div>
                </div>
            </td>
        </tr>
        </tbody>
    </table>
</form>
@endsection
