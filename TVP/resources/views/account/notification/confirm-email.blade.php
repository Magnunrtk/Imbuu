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
                            <form method="post" action="{{ route('account.email.confirmation.action') }}" class="form">
                                @csrf
                                <div class="BigButton" style="background-image:url({{ asset('/assets/tibiarl/images/buttons/sbutton.gif') }})">
                                    <div onmouseover="MouseOverBigButton(this)" onmouseout="MouseOutBigButton(this)"><div class="BigButtonOver" style="background-image:url({{ asset('/assets/tibiarl/images/buttons/sbutton_over.gif') }})"></div>
                                        <input class="BigButtonText" type="submit" value="Re-request Email">
                                    </div>
                                </div>
                            </form>
                            <div style="font-size:1px;height:4px;"></div>
                            <div class="BigButton" onclick="RedirectToUrl('{{ route('account.email.confirmation.change.index') }}');" style="background-image:url({{ asset('/assets/tibiarl/images/buttons/sbutton.gif') }})">
                                <div onmouseover="MouseOverBigButton(this)" onmouseout="MouseOutBigButton(this)"><div class="BigButtonOver" style="background-image:url({{ asset('/assets/tibiarl/images/buttons/sbutton_over.gif') }})"></div>
                                    <input class="BigButtonText" type="submit" value="Change Email">
                                </div>
                            </div>
                        </div>
                        <p><b>Your account is not confirmed!</b><span style="position: relative; top: 3px; margin-left: 5px;"><a href="#" target="_blank"><span class="HelperDivIndicator" onmouseover="ActivateHelperDiv($(this), 'Confirm Account', '<p>An email has been sent to the address you have entered while you have created your account. Please check your emails to confirm your account.</p><p>In case you have lost your confirmation email or did not receive it, you can request the email containing the confirmation link for your account again.</p><p>If you have no longer access to the email address the confirmation link was sent to, you can change the email address and the email will be sent again automatically.</p>', '');" onmouseout="$('#HelperDivContainer').hide();"><img style="border:0px;" src="{{ asset('/assets/tibiarl/images/mmorpg/info.gif') }}"></span></a></span></p>
                        <p>Please check your emails to confirm your account.</p>
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
