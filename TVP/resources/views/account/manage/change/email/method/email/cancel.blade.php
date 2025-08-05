@extends('template.layout')
@section('title', 'Account Management')
@section('submenuItem', 'accountmanagement')
@section('content')
    <form action="{{ route('account.manage.email.cancel') }}" method="post" class="form">
        @csrf
        <div class="TableContainer">
            <div class="CaptionContainer">
                <div class="CaptionInnerContainer">
                    <span class="CaptionEdgeLeftTop" style="background-image:url({{ asset('/assets/tibiarl/images/content/box-frame-edge.gif') }});"></span>
                    <span class="CaptionEdgeRightTop" style="background-image:url({{ asset('/assets/tibiarl/images/content/box-frame-edge.gif') }});"></span>
                    <span class="CaptionBorderTop" style="background-image:url({{ asset('/assets/tibiarl/images/content/table-headline-border.gif') }});"></span>
                    <span class="CaptionVerticalLeft" style="background-image:url({{ asset('/assets/tibiarl/images/content/box-frame-vertical.gif') }});"></span>
                    <div class="Text">Note</div>
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
                                        Please read carefully, after this request you must return to the panel for confirmation, after the two days have passed, a confirmation button will appear on the main panel, just click to complete this operation, any problems should contact the administration in a discord ticket.

                                        {{-- A request has been submitted to change the email address of this account to <b>{{ $webChangeEmail->email }}</b>.<br>
                                        <p>The actual change will take place on <b>{{ date('M d Y, H:i:s T', strtotime($webChangeEmail->change_date)) }}</b>.</p>
                                        If you do not want to change your email address, please click on "Cancel". --}}
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
                                {{-- <div class="BigButton" style="background-image:url({{ asset('/assets/tibiarl/images/buttons/sbutton_red.gif') }})">
                                    <div onmouseover="MouseOverBigButton(this);" onmouseout="MouseOutBigButton(this);"><div class="BigButtonOver" style="background-image:url({{ asset('/assets/tibiarl/images/buttons/sbutton_red_over.gif') }});"></div>
                                        <input class="BigButtonText" type="submit" value="Cancel">
                                    </div>
                                </div> --}}
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
