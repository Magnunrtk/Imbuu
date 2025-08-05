@extends('template.layout')
@section('title', 'Get Coins')
@section('submenuItem', 'getcoins')
@section('content')
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
            <img id="TubeRightEnd" src="{{ asset('/assets/tibiarl/images/content/progressbar/progress-bar-tube-right-blue.gif') }}">
            <div id="FirstStep" class="Steps">
                <div class="SingleStepContainer">
                    <img class="StepIcon" src="{{ asset('/assets/tibiarl/images/content/progressbar/progress-bar-icon-2-green.gif') }}">
                    <div class="StepText">Rules</div>
                </div>
            </div>
            <div id="StepsContainer1">
                <div id="StepsContainer2">
                    <div class="Steps" style="width:25%">
                        <div class="TubeContainer">
                            <img class="Tube" src="{{ asset('/assets/tibiarl/images/content/progressbar/progress-bar-tube-green.gif') }}">
                        </div>
                        <div class="SingleStepContainer">
                            <img class="StepIcon" src="{{ asset('/assets/tibiarl/images/content/progressbar/progress-bar-icon-1-green.gif') }}">
                            <div class="StepText" style="font-weight:bold;">Payment methods</div>
                        </div>
                    </div>
                    <div class="Steps" style="width:25%">
                        <div class="TubeContainer">
                            <img class="Tube" src="{{ asset('/assets/tibiarl/images/content/progressbar/progress-bar-tube-green-blue.gif') }}">
                        </div>
                        <div class="SingleStepContainer">
                            <img class="StepIcon" src="{{ asset('/assets/tibiarl/images/content/progressbar/progress-bar-icon-3-blue.gif') }}">
                            <div class="StepText">Select product</div>
                        </div>
                    </div>
                    <div class="Steps" style="width:25%">
                        <div class="TubeContainer">
                            <img class="Tube" src="{{ asset('/assets/tibiarl/images/content/progressbar/progress-bar-tube-blue.gif') }}">
                        </div>
                        <div class="SingleStepContainer">
                            <img class="StepIcon" src="{{ asset('/assets/tibiarl/images/content/progressbar/progress-bar-icon-0-blue.gif') }}">
                            <div class="StepText">Confirm your order</div>
                        </div>
                    </div>
                    <div class="Steps" style="width:25%">
                        <div class="TubeContainer">
                            <img class="Tube" src="{{ asset('/assets/tibiarl/images/content/progressbar/progress-bar-tube-blue.gif') }}">
                        </div>
                        <div class="SingleStepContainer">
                            <img class="StepIcon" src="{{ asset('/assets/tibiarl/images/content/progressbar/progress-bar-icon-4-blue.gif') }}">
                            <div class="StepText">Summary</div>
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
    <form method="post" action="{{ route('account.store.action') }}">
        @csrf
        <input type="hidden" name="action" value="payment">
        <input type="hidden" name="acceptTerms" value="1">
        <div class="TableContainer">
            <div class="CaptionContainer">
                <div class="CaptionInnerContainer">
                    <span class="CaptionEdgeLeftTop" style="background-image:url({{ asset('/assets/tibiarl/images/content/box-frame-edge.gif') }});"></span>
                    <span class="CaptionEdgeRightTop" style="background-image:url({{ asset('/assets/tibiarl/images/content/box-frame-edge.gif') }});"></span>
                    <span class="CaptionBorderTop" style="background-image:url({{ asset('/assets/tibiarl/images/content/table-headline-border.gif') }});"></span>
                    <span class="CaptionVerticalLeft" style="background-image:url({{ asset('/assets/tibiarl/images/content/box-frame-vertical.gif') }});"></span>
                    <div class="Text">Select payment method</div>
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
                            <div class="TableScrollbarContainer"></div>
                        </div>
                        <div class="InnerTableContainer" style="max-width: unset;">
                            <table style="width:100%;">
                                <tbody>
                                <tr class="ProductCategoryTabRow">
                                    <td>
                                        <span class="HelperDivIndicator" onmouseover="ActivateHelperDiv($(this), 'ServerName Coins<br/>', 'ServerName Coins are ServerName\'s currency to purchase exclusive products in the Store.<br /><br />They can be used right after the purchase to buy all products offered for ServerName Coins in the Store, e.g. mounts, outfits, Premium Time, boosts or decoration items.<br /><br />', 'ProductCategoryHelperDiv_1', '{{ config('server.serverName') }}');" onmouseout="$('#HelperDivContainer').hide();">
                                            <div class="InnerTableTab WideTab ActiveInnerTableTab">
                                                <div id="ProductCategoryHelperDiv_1" class="ProductCategoryHelperDiv"></div>
                                                <a href="#">
                                                    <img src="{{ asset('/assets/tibiarl/images/content/tab_wide_active.png') }}">
                                                    <div class="InnerTableTabLabel">{{ config('server.serverName') }} Coins</div>
                                                </a>
                                            </div>
                                        </span>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <div class="TableContentContainer">
                                            <table class="TableContent" width="100%" style="border:1px solid #faf0d7;">
                                                <tbody>
                                                <tr>
                                                    <td style="text-align: center;" align="center">
                                                        <div class="OptionsContainer">
                                                            @foreach(\App\Models\WebPaymentOption::whereActive(true)->take(2)->get() as $option)

                                                            <div class="PMCID_Icon_Container" id="PMCID_Icon_Container_{{ $option->id }}">
                                                                <div class="PMCID_Icon" id="PMCID_Icon_{{ $option->id }}" style="background-image:url({{ asset('/assets/tibiarl/images/payment/pmcid_icon_normal.png') }});" onclick="ChangePMC({{ $option->id }});" onmouseover="MouseOverPMCID({{ $option->id }});" onmouseout="MouseOutPMCID({{ $option->id }});">
                                                                    <div class="PermanentDeactivated PMCID_Deactivated_ByChoice" id="PMCID_NotAllowed_{{ $option->id }}" style="display: none;">
                                                                        <span class=" HelperDivIndicator" onmouseover="ActivateHelperDiv($(this), 'Payment Method Info:', '<p>The payment method is not allowed for the selected service!</p>', '');" onmouseout="$('#HelperDivContainer').hide();"><div class="PMCID_Deactivated" style="background-image: url({{ asset('/assets/tibiarl/images/payment/pmcid_deactivated.png') }});"></div></span>
                                                                    </div>
                                                                    <div class="PMCID_Icon_Selected" id="PMCID_Icon_Selected_{{ $option->id }}"></div>
                                                                    <div class="PMCID_Icon_Over" id="PMCID_Icon_Over_{{ $option->id }}" style=""></div>
                                                                    <div class="PMCID_QuicknessIndicator">
                                                                    <span class="HelperDivIndicator" onmouseover="ActivateHelperDiv($(this), 'Usual Process Time:', '<p>It usually takes <b>{{ \App\Enum\ProcessingTime::getTimeEstimation($option->processing_time) }}</b> until you receive the ordered product if you use this payment method.</p><p>However, in some cases, the process time <b>can also take several days!</b></p>', '');" onmouseout="$('#HelperDivContainer').hide();">
                                                                        <div class="PMCID_QuicknessIndicatorLabelContainer">
                                                                            <div class="PMCID_QuicknessIndicatorLabel">Usual Process Time: <br>{{ \App\Enum\ProcessingTime::getString($option->processing_time) }} </div>
                                                                        </div>
                                                                    </span>
                                                                    </div>
                                                                    @if(!empty($option->additional_title) && !empty($option->additional_text))
                                                                    <span style="position: absolute; left: 125px; top: 53px; z-index: 99;">
                                                                        <span style="margin-left: 5px; position: absolute; margin-top: 2px;">
                                                                            <a href="#" target="_blank">
                                                                                <span class="HelperDivIndicator" onmouseover="ActivateHelperDiv($(this), '{{ $option->additional_title }}', '{{ $option->additional_text }}', '');" onmouseout="$('#HelperDivContainer').hide();">
                                                                                    <img style="border:0px;" src="{{ asset('/assets/tibiarl/images/mmorpg/info.gif') }}">
                                                                                </span>
                                                                            </a>
                                                                        </span>
                                                                    </span>
                                                                    @endif
                                                                    <img class="PMCID_CP_Icon" src="{{ asset('/assets/tibiarl/images/payment/'. $option->slug .'.gif') }}">
                                                                    <div class="PMCID_CP_Label">
                                                                        <input type="radio" id="PMCID_{{ $option->id }}" name="pmid" value="{{ $option->id }}" style="display: none;">
                                                                        <label for="PMCID_{{ $option->id }}">{{ $option->name }} </label>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            @endforeach
                                                        </div>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>
                                                        <small>
                                                            <div style="float: left; margin-right: 5px;">*</div>
                                                            <div style="float: left;">
                                                                <div id="ExchangeRateNote">Please note that the prices may vary depending on the current exchange rate.</div>Different prices may apply depending on your selected payment method.
                                                            </div>
                                                        </small>
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
        <div class="SubmitButtonRow">
            <div class="LeftButton">
                <div class="BigButton" onclick="RedirectToUrl('{{ route('account.store.index') }}');" style="background-image:url({{ asset('/assets/tibiarl/images/buttons/sbutton.gif') }})"><div onmouseover="MouseOverBigButton(this);" onmouseout="MouseOutBigButton(this);"><div class="BigButtonOver" style="background-image:url({{ asset('/assets/tibiarl/images/buttons/sbutton_over.gif') }});"></div>
                        <input class="BigButtonText" type="submit" value="Previous">
                    </div>
                </div>
            </div>
            
            <div class="RightButton">
                <div class="BigButton" style="background-image:url({{ asset('/assets/tibiarl/images/buttons/sbutton_green.gif') }})"><div onmouseover="MouseOverBigButton(this);" onmouseout="MouseOutBigButton(this);"><div class="BigButtonOver" style="background-image:url({{ asset('/assets/tibiarl/images/buttons/sbutton_green_over.gif') }});"></div>
                        <input class="BigButtonText" type="submit" value="Next">
                    </div>
                </div>
            </div>
        </div>
    </form>
@endsection

@section('scripts')
    <script type="text/javascript">
        function ChangePMC(a_PaymentMethodID) {
            $('.PMCID_Icon_Selected').css('background-image', '');
            $('#PMCID_Icon_Selected_' + a_PaymentMethodID).css('background-image', 'url(\'{{ asset('/assets/tibiarl/images/payment/pmcid_icon_selected.png') }}\')');
            document.getElementById("PMCID_" + a_PaymentMethodID).checked = true;
        }

        function MouseOverPMCID(a_PMCID) {
            $('#PMCID_Icon_Over_' + a_PMCID).css('background-image', 'url(\'{{ asset('/assets/tibiarl/images/payment/pmcid_icon_over.png') }}\')');
        }

        function MouseOutPMCID(a_PMCID) {
            $('#PMCID_Icon_Over_' + a_PMCID).css('background-image', '');
        }
    </script>
    <script type="text/javascript">
        $('.PMCID_CP_Label > input').hide();
        $('#ExchangeRateNote').hide();
    </script>
@endsection
