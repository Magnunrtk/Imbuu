<div id="ProgressBar">
    <div id="MainContainer">
        <div id="BackgroundContainer">
            <img id="BackgroundContainerLeftEnd" src="{{ asset('/assets/tibiarl/images/content/stonebar-left-end.gif') }}">
            <div id="BackgroundContainerCenter">
                <div id="BackgroundContainerCenterImage" style="background-image:url({{ asset('/assets/tibiarl/images/content/stonebar-center.gif') }});"></div>
            </div>
            <img id="BackgroundContainerRightEnd" src="{{ asset('/assets/tibiarl/images/content/stonebar-right-end.gif') }}">
        </div>
        <img id="TubeLeftEnd" src="{{ asset('/assets/tibiarl/images/content/progressbar/progress-bar-tube-left-green.gif') }}">
        <img id="TubeRightEnd" src="{{ asset('/assets/tibiarl/images/content/progressbar/progress-bar-tube-right-green.gif') }}">
        <div id="FirstStep" class="Steps">
            <div class="SingleStepContainer">
                <img class="StepIcon" src="{{ asset('/assets/tibiarl/images/content/progressbar/progress-bar-icon-1-green.gif') }}">
                <div class="StepText" style="font-weight:bold;">Select product</div>
            </div>
        </div>
        <div id="StepsContainer1">
            <div id="StepsContainer2">
                <div class="Steps" style="width:50%">
                    <div class="TubeContainer">
                        <img class="Tube" src="{{ asset('/assets/tibiarl/images/content/progressbar/progress-bar-tube-green.gif') }}">
                    </div>
                    <div class="SingleStepContainer">
                        <img class="StepIcon" src="{{ asset('/assets/tibiarl/images/content/progressbar/progress-bar-icon-3-green.gif') }}">
                        <div class="StepText" style="font-weight:normal;">Confirm your order</div>
                    </div>
                </div>
                <div class="Steps" style="width:50%">
                    <div class="TubeContainer">
                        <img class="Tube" src="{{ asset('/assets/tibiarl/images/content/progressbar/progress-bar-tube-green.gif') }}">
                    </div>
                    <div class="SingleStepContainer">
                        <img class="StepIcon" src="{{ asset('/assets/tibiarl/images/content/progressbar/progress-bar-icon-4-green.gif') }}">
                        <div class="StepText" style="font-weight:normal;">Summary</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<center>
    <div class="CustomerIdentification">Order for Account Number: <span id="DisplayAccountNumber" onmousedown="ToggleMaskedText('AccountNumber');">*********</span>
        <span id="MaskedAccountNumber">*********</span>
        <span id="ReadableAccountNumber">{{ Auth::user()->id }}</span>
        <div>
            <img id="ButtonAccountNumber" onmousedown="ToggleMaskedText('AccountNumber');" src="{{ asset('/assets/tibiarl/images/general/show.gif') }}">
        </div>
    </div>
</center>
<form role="form" action="{{ route('account.store.payment-method.transaction.cancel') }}" method="post">
    @csrf
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
                            <p style="color: red;"><b>Pending Transaction!</b></p>
                            <p>Please note that there is currently a pending transaction in progress.<br>Only one request can be processed at a time.<br><br>You have the option to cancel your request as long as it has not yet been processed.</p>
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
    <div class="TableContainer">
        <div class="CaptionContainer">
            <div class="CaptionInnerContainer">
                <span class="CaptionEdgeLeftTop" style="background-image:url({{ asset('/assets/tibiarl/images/content/box-frame-edge.gif') }});"></span>
                <span class="CaptionEdgeRightTop" style="background-image:url({{ asset('/assets/tibiarl/images/content/box-frame-edge.gif') }});"></span>
                <span class="CaptionBorderTop" style="background-image:url({{ asset('/assets/tibiarl/images/content/table-headline-border.gif') }});"></span>
                <span class="CaptionVerticalLeft" style="background-image:url({{ asset('/assets/tibiarl/images/content/box-frame-vertical.gif') }});"></span>
                <div class="Text">Summary</div>
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
                                                <td class="LabelV200" style="color: red;">IMPORTANT!</td>
                                                <td>We only accept one order at a time, you can only accept another after confirmation or rejection.</td>
                                            </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <div class="TableContentContainer">
                                        <table class="TableContent" width="100%" style="border:1px solid #faf0d7;">
                                            <tbody>
                                            <tr>
                                                <td class="LabelV200">Service</td>
                                                <td>{{ $webTransaction->coins }} Coins</td>
                                            </tr>
                                            <tr>
                                                <td class="LabelV200">Price</td>
                                                <td>{{ $webTransaction->price }} {{ $webTransaction->payment_method }}</td>
                                            </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <div class="TableContentContainer">
                                        <table class="TableContent" width="100%" style="border:1px solid #faf0d7;">
                                            <tbody>
                                            @switch($webTransaction->payment_method)
                                                @case('Medivia Coins')
                                                <tr>
                                                    <td class="LabelV200">Server:</td>
                                                    <td>{{ $webTransaction->server_name }}</td>
                                                </tr>
                                                <tr>
                                                    <td class="LabelV200">Receiver Name:</td>
                                                    <td><a href="https://medivia.online/community/character/{{ $webTransaction->receiver_name }}" target="_blank">{{ $webTransaction->receiver_name }}</a></td>
                                                </tr>
                                                <tr>
                                                    <td colspan="2">Your character needs to send a Parcel containing {{ $webTransaction->price }} Medivia Coins to the character <span style="color: red;font-weight: bold;">{{ $webTransaction->receiver_name }}</span> in <span style="color: red;font-weight: bold;">{{ $webTransaction->server_name }}</span> server on city <span style="color: red;font-weight: bold;">{{ \App\Http\Controllers\Payment\MediviaCoinsController::getCityByName($webTransaction->server_name) }}</span>.<br><br>To complete the order, click confirm, we advise you to send the Medivia Coins before ordering to avoid misunderstandings.</td>
                                                </tr>
                                                @break

                                                @default
                                                <tr>
                                                    <td class="LabelV200">Receiver Name:</td>
                                                    <td><a href="https://www.tibia.com/community/?name={{ $webTransaction->receiver_name }}" target="_blank">{{ $webTransaction->receiver_name }}</a></td>
                                                </tr>
                                                <tr>
                                                    <td colspan="2">To complete the order, click confirm, we advise you to send the {{ $webTransaction->payment_method }} before ordering to avoid misunderstandings.</td>
                                                </tr>
                                            @endswitch
                                            </tbody>
                                        </table>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <div class="TableContentContainer">
                                        <table class="TableContent" width="100%" style="border:1px solid #faf0d7;">
                                            <tbody>
                                            <tr>
                                                <td class="LabelV200">Payment Method</td>
                                                <td>{{ $webTransaction->payment_method }}</td>
                                            </tr>
                                            @switch($webTransaction->payment_method)
                                                @case('Medivia Coins')
                                                <tr>
                                                    <td class="LabelV200">Medivia Character Name:</td>
                                                    <td><input type="text" value="{{ $webTransaction->external_name }}" readonly></td>
                                                </tr>
                                                @break

                                                @default
                                                <tr>
                                                    <td class="LabelV200">Tibia Character Name:</td>
                                                    <td><input type="text" value="{{ $webTransaction->external_name }}" readonly></td>
                                                </tr>
                                            @endswitch
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
    <div class="SubmitButtonRow">
        <div class="LeftButton">
            <div class="BigButton" style="background-image:url({{ asset('/assets/tibiarl/images/buttons/sbutton_red.gif') }})"><div onmouseover="MouseOverBigButton(this);" onmouseout="MouseOutBigButton(this);"><div class="BigButtonOver" style="background-image:url({{ asset('/assets/tibiarl/images/buttons/sbutton_red_over.gif') }});"></div>
                    <input class="BigButtonText" type="submit" value="Cancel request">
                </div>
            </div>
        </div>
        <div class="RightButton">
            <div class="BigButton" onclick="RedirectToUrl('{{ route('account.store.index') }}');" style="background-image:url({{ asset('/assets/tibiarl/images/buttons/sbutton.gif') }})"><div onmouseover="MouseOverBigButton(this);" onmouseout="MouseOutBigButton(this);"><div class="BigButtonOver" style="background-image:url({{ asset('/assets/tibiarl/images/buttons/sbutton_over.gif') }});"></div>
                    <input class="BigButtonText" type="submit" value="Previous">
                </div>
            </div>
        </div>
    </div>
</form>