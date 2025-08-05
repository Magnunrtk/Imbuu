@if(Auth::user()->banned && config('shop.extraServices')['unban']['enabled'])
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
                            <div class="BigButton" onclick="RedirectToUrl('{{ route('account.manage.unban.index') }}');" style="background-image:url({{ asset('/assets/tibiarl/images/buttons/sbutton_green.gif') }})">
                                <div onmouseover="MouseOverBigButton(this)" onmouseout="MouseOutBigButton(this)"><div class="BigButtonOver" style="background-image:url({{ asset('/assets/tibiarl/images/buttons/sbutton_green_over.gif') }})"></div>
                                    <input class="BigButtonText" type="submit" value="Purchase Unban">
                                </div>
                            </div>
                        </div>
                        <p style="color: red;"><b>Your account has been banned!</b></p>
                        <p>You account has been banned until {{ date('M d Y, H:i:s T', Auth::user()->banned->expires_at) }} due to {{ Auth::user()->banned->reason }}</p>
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