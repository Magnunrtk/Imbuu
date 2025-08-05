@extends('template.layout')
@section('title', 'Account Management')
@section('submenuItem', 'accountmanagement')
@section('content')

<br>
<b>The email exchange system is undergoing maintenance, please wait...</b>

<br><br>

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
                                                <div class="InTableRightButtonContainer">
                                                    @role('unconfirmeduser')
                                                    <div class="BigButton" onclick="RedirectToUrl('{{ route('account.index') }}');" style="background-image:url({{ asset('/assets/tibiarl/images/buttons/sbutton.gif') }})">
                                                        <div onmouseover="MouseOverBigButton(this);" onmouseout="MouseOutBigButton(this);"><div class="BigButtonOver" style="background-image:url({{ asset('/assets/tibiarl/images/buttons/sbutton_over.gif') }});"></div>
                                                            <input class="BigButtonText" type="submit" value="Register Account">
                                                        </div>
                                                    </div>
                                                    @endrole
                                                    @role('admin|user')
                                                    @if(!is_null(Auth::user()->onGoingEmailChange()) && !is_null(Auth::user()->onGoingEmailChange()->confirmation_key))
                                                        <div class="BigButton" onclick="RedirectToUrl('{{ route('account.manage.email.confirm') }}');" style="background-image:url({{ asset('/assets/tibiarl/images/buttons/sbutton_green.gif') }})">
                                                            <div onmouseover="MouseOverBigButton(this);" onmouseout="MouseOutBigButton(this);"><div class="BigButtonOver" style="background-image:url({{ asset('/assets/tibiarl/images/buttons/sbutton_green_over.gif') }});"></div>
                                                                <input class="BigButtonText" type="submit" value="Accept">
                                                            </div>
                                                        </div>
                                                        <div style="font-size:1px;height:4px;"></div>
                                                        <form action="{{ route('account.manage.email.cancel') }}" method="post" class="form">
                                                            @csrf
                                                            <div class="BigButton" style="background-image:url({{ asset('/assets/tibiarl/images/buttons/sbutton_red.gif') }})">
                                                                <div onmouseover="MouseOverBigButton(this);" onmouseout="MouseOutBigButton(this);"><div class="BigButtonOver" style="background-image:url({{ asset('/assets/tibiarl/images/buttons/sbutton_red_over.gif') }});"></div>
                                                                    <input class="BigButtonText" type="submit" value="Cancel">
                                                                </div>
                                                            </div>
                                                        </form>
                                                    @else
                                                    <form action="{{ route('account.manage.email.method') }}" method="post" class="form">
                                                        @csrf
                                                        <input type="hidden" name="method" value="2">
                                                        <div class="BigButton" style="background-image:url({{ asset('/assets/tibiarl/images/buttons/sbutton_green.gif') }})">
                                                            <div onmouseover="MouseOverBigButton(this);" onmouseout="MouseOutBigButton(this);"><div class="BigButtonOver" style="background-image:url({{ asset('/assets/tibiarl/images/buttons/sbutton_green_over.gif') }});"></div>
                                                                <input class="BigButtonText" type="submit" value="Use Recovery Key">
                                                            </div>
                                                        </div>
                                                        @if(config('shop.extraServices')['recoveryKey']['enabled'])
                                                        <div style="font-size:1px;height:4px;"></div>
                                                        <div class="BigButton" onclick="RedirectToUrl('{{ route('account.manage.index') }}');" style="background-image:url({{ asset('/assets/tibiarl/images/buttons/sbutton.gif') }})">
                                                            <div onmouseover="MouseOverBigButton(this);" onmouseout="MouseOutBigButton(this);"><div class="BigButtonOver" style="background-image:url({{ asset('/assets/tibiarl/images/buttons/sbutton_over.gif') }});"></div>
                                                                <input class="BigButtonText" type="submit" value="Get Extra Service">
                                                            </div>
                                                        </div>
                                                        @endif
                                                    </form>
                                                    @endif
                                                    @endrole
                                                </div>
                                                <b>By Recovery Key</b><br>
                                                @if(!is_null(Auth::user()->onGoingEmailChange()) && !is_null(Auth::user()->onGoingEmailChange()->confirmation_key))
                                                <p></p>
                                                <p>A request has been submitted to change the email address of this account to <b>{{ Auth::user()->onGoingEmailChange()->email }}</b>.<br></p>
                                                <p>A link with a confirmation key was sent to your new email address. <b>You need to use this confirmation key to create a new password within the next 24 hours to complete the email change.</b></p>
                                                <p>If you do not want to change your email address, please click on "Cancel".</p>
                                                @else
                                                <p></p>
                                                <p>Change your email address <b>instantly</b> by a using a <b>recovery key</b>.<br>You will receive an email containing a confirmation link to verify your new email address.<br>To finish the email change request you will have to choose a new password.</p>
                                                @endif
                                                @role('unconfirmeduser')
                                                <span class="ColorRed">You need to <b>register</b> your {{ config('server.serverName') }} account before you can change your email address <b>instantly</b>.</span><br>
                                                @endrole
                                            </td>
                                        </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td>

                                {{-- <div class="TableContentContainer">
                                    <table class="TableContent" width="100%" style="border:1px solid #faf0d7;">
                                        <tbody>
                                        <tr>
                                            <td>
                                                <div class="InTableRightButtonContainer">

                                                    @if(Auth::user()->onGoingEmailChange() && is_null(Auth::user()->onGoingEmailChange()->confirmation_key))

                                                    <div class="BigButton" style="background-image:url({{ asset('/assets/tibiarl/images/buttons/sbutton_green.gif') }})">
                                                        <div onmouseover="MouseOverBigButton(this);" onmouseout="MouseOutBigButton(this);"><div class="BigButtonOver" style="background-image:url({{ asset('/assets/tibiarl/images/buttons/sbutton_green_over.gif') }});"></div>
                                                            <input class="BigButtonText" type="submit" value="Send Me a Email">
                                                        </div>
                                                    </div>

                                                    <div style="padding: 1.5%"></div>

                                                    <form action="{{ route('account.manage.email.cancel') }}" method="post" class="form">
                                                        @csrf
                                                        <div class="BigButton" style="background-image:url({{ asset('/assets/tibiarl/images/buttons/sbutton_red.gif') }})">
                                                            <div onmouseover="MouseOverBigButton(this);" onmouseout="MouseOutBigButton(this);"><div class="BigButtonOver" style="background-image:url({{ asset('/assets/tibiarl/images/buttons/sbutton_red_over.gif') }});"></div>
                                                                <input class="BigButtonText" type="submit" value="Cancel">
                                                            </div>
                                                        </div>
                                                    </form>
                                                    @else
                                                    <form action="{{ route('account.manage.email.method') }}" method="post" class="form">
                                                        @csrf
                                                        <input type="hidden" name="method" value="1">
                                                        <div class="BigButton" style="background-image:url({{ asset('/assets/tibiarl/images/buttons/sbutton_green.gif') }})">
                                                            <div onmouseover="MouseOverBigButton(this);" onmouseout="MouseOutBigButton(this);"><div class="BigButtonOver" style="background-image:url({{ asset('/assets/tibiarl/images/buttons/sbutton_green_over.gif') }});"></div>
                                                                <input class="BigButtonText" type="submit" value="Change Email">
                                                            </div>
                                                        </div>
                                                    </form>
                                                    @endif
                                                </div>

                                                @if(Auth::user()->onGoingEmailChange() && is_null(Auth::user()->onGoingEmailChange()->confirmation_key))

                                                    <b>By {{ config('server.days_until_email_change') }} days waiting period</b>
                                                    <p>Change your email address by a using your <b>password</b>.<br>You will receive an email containing a confirmation link to verify your new email address.<br>To finish the email change request you will have to choose a new password.</p>
                                                    <p>For security reasons the password change will be executed after a <b>{{ config('server.days_until_email_change') }} days waiting period</b>. After this time period you can "cancel" or "accept" your password change request.</p>
                                                    
                                                @else
                                                
                                                    <b>Complete waiting period</b>
                                                    <p style="width: 80%">Now you must choose whether to complete or cancel the operation. When you click confirm, you will be sent an email to {x} confirm that your new email is valid.</p>
                                                @endif

                                            </td>
                                        </tr>
                                        </tbody>
                                    </table>
                                </div> --}}
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
    <div class="BigButton" onclick="RedirectToUrl('{{ route('account.manage.index') }}');" style="background-image:url({{ asset('/assets/tibiarl/images/buttons/sbutton.gif') }})">
        <div onmouseover="MouseOverBigButton(this);" onmouseout="MouseOutBigButton(this);"><div class="BigButtonOver" style="background-image:url({{ asset('/assets/tibiarl/images/buttons/sbutton_over.gif') }});"></div>
            <input class="BigButtonText" type="submit" value="Back">
        </div>
    </div>
    <center></center>
</center>
@endsection
