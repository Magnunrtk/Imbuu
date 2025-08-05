@if(!is_null(Auth::user()->onGoingEmailChange()) && is_null(Auth::user()->onGoingEmailChange()->confirmation_key))
<div class="SmallBox">
    <div class="MessageContainer">
        <div class="BoxFrameHorizontal" style="background-image:url({{ asset('/assets/tibiarl/images/content/box-frame-horizontal.gif') }});"></div>
        <div class="BoxFrameEdgeLeftTop" style="background-image:url({{ asset('/assets/tibiarl/images/content/box-frame-edge.gif') }});"></div>
        <div class="BoxFrameEdgeRightTop" style="background-image:url({{ asset('/assets/tibiarl/images/content/box-frame-edge.gif') }});"></div>
        <div class="Message">
            <div class="BoxFrameVerticalLeft" style="background-image:url({{ asset('/assets/tibiarl/images/content/box-frame-vertical.gif') }});"></div>
            <div class="BoxFrameVerticalRight" style="background-image:url({{ asset('/assets/tibiarl/images/content/box-frame-vertical.gif') }});"></div>
            <table class="HintBox">
                <tbody>
                <tr>
                    <td>
                        <div class="BoxButtons">
                            <div class="BigButton" onclick="RedirectToUrl('{{ route('account.manage.email.index') }}');" style="background-image:url({{ asset('/assets/tibiarl/images/buttons/sbutton.gif') }})">
                                <div onmouseover="MouseOverBigButton(this)" onmouseout="MouseOutBigButton(this)"><div class="BigButtonOver" style="background-image:url({{ asset('/assets/tibiarl/images/buttons/sbutton_over.gif') }})"></div>
                                    <input class="BigButtonText" type="submit" value="View">
                                </div>
                            </div>
                        </div>
                        <p><b>There is an email change request for the account!</b></p>
                        <p>A request has been submitted to change the email address of this account to <b>{{ Auth::user()->onGoingEmailChange()->email }}</b>. After a waiting period of <b>{{ config('server.days_until_email_change') }} days</b> you can accept the new email address and finish the process. </p>
                        <p>Please cancel the request if you do not want your email address to be changed! Also cancel the request if you have no access to the new email address!</p>
                    </td>
                </tr>
                <tr></tr>
                </tbody>
            </table>
        </div>
        <div class="BoxFrameHorizontal" style="background-image:url({{ asset('/assets/tibiarl/images/content/box-frame-horizontal.gif') }});"></div>
        <div class="BoxFrameEdgeRightBottom" style="background-image:url({{ asset('/assets/tibiarl/images/content/box-frame-edge.gif') }});"></div>
        <div class="BoxFrameEdgeLeftBottom" style="background-image:url({{ asset('/assets/tibiarl/images/content/box-frame-edge.gif') }});"></div>
    </div>
</div>
<br>
@endif