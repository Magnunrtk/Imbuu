@extends('template.layout')
@section('title', 'Store')
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
                    <img class="StepIcon" src="{{ asset('/assets/tibiarl/images/content/progressbar/progress-bar-icon-1-green.gif') }}">
                    <div class="StepText" style="font-weight:bold;">Select product</div>
                </div>
            </div>
            <div id="StepsContainer1">
                <div id="StepsContainer2">
                    <div class="Steps" style="width:50%">
                        <div class="TubeContainer">
                            <img class="Tube" src="{{ asset('/assets/tibiarl/images/content/progressbar/progress-bar-tube-green-blue.gif') }}">
                        </div>
                        <div class="SingleStepContainer">
                            <img class="StepIcon" src="{{ asset('/assets/tibiarl/images/content/progressbar/progress-bar-icon-3-blue.gif') }}">
                            <div class="StepText" style="font-weight:normal;">Confirm your order</div>
                        </div>
                    </div>
                    <div class="Steps" style="width:50%">
                        <div class="TubeContainer">
                            <img class="Tube" src="{{ asset('/assets/tibiarl/images/content/progressbar/progress-bar-tube-blue.gif') }}">
                        </div>
                        <div class="SingleStepContainer">
                            <img class="StepIcon" src="{{ asset('/assets/tibiarl/images/content/progressbar/progress-bar-icon-4-blue.gif') }}">
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
    <form method="post" action="{{ route('account.store.confirm') }}">
        @csrf
        <div class="TableContainer">
            <div class="CaptionContainer">
                <div class="CaptionInnerContainer">
                    <span class="CaptionEdgeLeftTop" style="background-image:url({{ asset('/assets/tibiarl/images/content/box-frame-edge.gif') }});"></span>
                    <span class="CaptionEdgeRightTop" style="background-image:url({{ asset('/assets/tibiarl/images/content/box-frame-edge.gif') }});"></span>
                    <span class="CaptionBorderTop" style="background-image:url({{ asset('/assets/tibiarl/images/content/table-headline-border.gif') }});"></span>
                    <span class="CaptionVerticalLeft" style="background-image:url({{ asset('/assets/tibiarl/images/content/box-frame-vertical.gif') }});"></span>
                    <div class="Text">Select product</div>
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
                                        <span class="HelperDivIndicator" onmouseover="ActivateHelperDiv($(this), 'ServerName Coins', 'ServerName Coins are ServerName\'s currency to purchase exclusive products in the Store.<br /><br />They can be used right after the purchase to buy all products offered for ServerName Coins in the Store, e.g. mounts, outfits, Premium Time, boosts or decoration items.<br /><br />', 'ProductCategoryHelperDiv_1', '{{ config('server.serverName') }}');" onmouseout="$('#HelperDivContainer').hide();">
                                            <div class="InnerTableTab WideTab">
                                                <div id="ProductCategoryHelperDiv_1" class="ProductCategoryHelperDiv"></div>
                                                <a href="{{ route('account.store.index') }}">
                                                    <img src="{{ asset('/assets/tibiarl/images/content/tab_wide_nonactive.png') }}">
                                                    <div class="InnerTableTabLabel">{{ config('server.serverName') }} Coins
                                                    </div>
                                                </a>
                                            </div>
                                        </span>
                                        <span class="HelperDivIndicator" onmouseover="ActivateHelperDiv($(this), 'ServerName Coins', 'ServerName Coins are ServerName\'s currency to purchase exclusive products in the Store.<br /><br />They can be used right after the purchase to buy all products offered for ServerName Coins in the Store, e.g. mounts, outfits, Premium Time, boosts or decoration items.<br /><br />', 'ProductCategoryHelperDiv_2', '{{ config('server.serverName') }}');" onmouseout="$('#HelperDivContainer').hide();">
                                            <div class="InnerTableTab WideTab ActiveInnerTableTab">
                                                <div id="ProductCategoryHelperDiv_2" class="ProductCategoryHelperDiv"></div>
                                                <a href="{{ route('account.store.extraService') }}">
                                                    <img src="{{ asset('/assets/tibiarl/images/content/tab_wide_active.png') }}">
                                                    <div class="InnerTableTabLabel">Extra Services</div>
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
                                                            <div class="ServiceID_Icon_Container" id="ServiceID_Icon_Container_200">
                                                                <div class="ServiceID_Icon_Container_Background" id="" style="background-image:url({{ asset('/assets/tibiarl/images/payment/serviceid_icon_normal.png') }});">
                                                                    <div class="ServiceID_Icon" id="ServiceID_Icon_200" style="background-image:url({{ asset('/assets/tibiarl/images/payment/serviceid_200.png') }});" onclick="ChangeService(200, 13);" onmouseover="MouseOverServiceID(200, 13);" onmouseout="MouseOutServiceID(200, 13);">
                                                                        <div class="ServiceID_Icon_Selected" id="ServiceID_Icon_Selected_200" style="background-image: url({{ asset('/assets/tibiarl/images/payment/serviceid_icon_selected.png') }});"></div>
                                                                        <div class="ServiceID_Icon_Over" id="ServiceID_Icon_Over_200" style=""></div>
                                                                        <label for="ServiceID_200">
                                                                            <div class="ServiceIDLabelContainer">
                                                                                <div class="ServiceIDLabel">
                                                                                    <input type="radio" id="ServiceID_200" name="product_id" value="200">Unban Account
                                                                                </div>
                                                                            </div>
                                                                            <div class="ServiceIDPriceContainer">
                                                                                <span class="ServiceIDPrice" id="PD_200">10 {{ config('shop.currency') }}</span> *
                                                                            </div>
                                                                        </label>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>
                                                        <small>
                                                            <div style="float: left; margin-right: 5px;">*</div>
                                                            <div style="float: left;">
                                                                Prices include 19% value added tax.<br>
                                                                <div id="ExchangeRateNote" style="display: none;">Please note that the prices may vary depending on the current exchange rate.</div>
                                                                Different prices may apply depending on your selected payment method.
                                                            </div>
                                                        </small>
                                                    </td>
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
                                                    <td style="text-align: center;" align="center">
                                                        <div class="OptionsContainer">
                                                            <div class="PMCID_Icon_Container" id="PMCID_Icon_Container_1">
                                                                <div class="PMCID_Icon" id="PMCID_Icon_1" style="background-image:url({{ asset('/assets/tibiarl/images/payment/pmcid_icon_normal.png') }});" onclick="ChangePMC(1);" onmouseover="MouseOverPMCID(1);" onmouseout="MouseOutPMCID(1);">
                                                                    <div class="PermanentDeactivated PMCID_Deactivated_ByChoice" id="PMCID_NotAllowed_1" style="display: none;">
                                                                        <span class=" HelperDivIndicator" onmouseover="ActivateHelperDiv($(this), 'Payment Method Info:', '<p>The payment method is not allowed for the selected service!</p>', '');" onmouseout="$('#HelperDivContainer').hide();"><div class="PMCID_Deactivated" style="background-image: url({{ asset('/assets/tibiarl/images/payment/pmcid_deactivated.png') }});"></div></span>
                                                                    </div>
                                                                    <div class="PMCID_Icon_Selected" id="PMCID_Icon_Selected_1"></div>
                                                                    <div class="PMCID_Icon_Over" id="PMCID_Icon_Over_1" style=""></div>
                                                                    <div class="PMCID_QuicknessIndicator">
                                                                    <span class="HelperDivIndicator" onmouseover="ActivateHelperDiv($(this), 'Usual Process Time:', '<p>It usually takes <b>several minutes</b> until you receive the ordered product if you use this payment method.</p><p>However, in some cases, the process time <b>can also take several days!</b></p>', '');" onmouseout="$('#HelperDivContainer').hide();">
                                                                        <div class="PMCID_QuicknessIndicatorLabelContainer">
                                                                            <div class="PMCID_QuicknessIndicatorLabel">Usual Process Time: <br>very fast </div>
                                                                        </div>
                                                                    </span>
                                                                    </div>
                                                                    <span style="position: absolute; left: 125px; top: 53px; z-index: 99;">
                                                                        <span style="margin-left: 5px; position: absolute; margin-top: 2px;">
                                                                            <a href="#" target="_blank">
                                                                                <span class="HelperDivIndicator" onmouseover="ActivateHelperDiv($(this), 'Information:', 'Visa, MasterCard, American Express and other, national credit or debit cards', '');" onmouseout="$('#HelperDivContainer').hide();">
                                                                                    <img style="border:0px;" src="{{ asset('/assets/tibiarl/images/mmorpg/info.gif') }}">
                                                                                </span>
                                                                            </a>
                                                                        </span>
                                                                    </span>
                                                                    <img class="PMCID_CP_Icon" src="{{ asset('/assets/tibiarl/images/payment/stripe.gif') }}">
                                                                    <div class="PMCID_CP_Label">
                                                                        <input type="radio" id="PMCID_1" name="pmid" value="stripe" style="display: none;">
                                                                        <label for="PMCID_1">Stripe </label>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="PMCID_Icon_Container" id="PMCID_Icon_Container_2">
                                                                <div class="PMCID_Icon" id="PMCID_Icon_2" style="background-image:url({{ asset('/assets/tibiarl/images/payment/pmcid_icon_normal.png') }});" onclick="ChangePMC(2);" onmouseover="MouseOverPMCID(2);" onmouseout="MouseOutPMCID(2);">
                                                                    <div class="PermanentDeactivated PMCID_Deactivated_ByChoice" id="PMCID_NotAllowed_2" style="display: none;">
                                                                        <span class=" HelperDivIndicator" onmouseover="ActivateHelperDiv($(this), 'Payment Method Info:', '<p>The payment method is not allowed for the selected service!</p>', '');" onmouseout="$('#HelperDivContainer').hide();"><div class="PMCID_Deactivated" style="background-image: url({{ asset('/assets/tibiarl/images/payment/pmcid_deactivated.png') }});"></div></span></div>
                                                                    <div class="PMCID_Icon_Selected" id="PMCID_Icon_Selected_2"></div>
                                                                    <div class="PMCID_Icon_Over" id="PMCID_Icon_Over_2" style=""></div>
                                                                    <div class="PMCID_QuicknessIndicator">
                                                                <span class="HelperDivIndicator" onmouseover="ActivateHelperDiv($(this), 'Usual Process Time:', '<p>It usually takes <b>several minutes</b> until you receive the ordered product if you use this payment method.</p><p>However, in some cases, the process time <b>can also take several days!</b></p>', '');" onmouseout="$('#HelperDivContainer').hide();">
                                                                    <div class="PMCID_QuicknessIndicatorLabelContainer">
                                                                        <div class="PMCID_QuicknessIndicatorLabel">Usual Process Time: <br>very fast </div>
                                                                    </div>
                                                                </span>
                                                                    </div>
                                                                    <span style="position: absolute; left: 125px; top: 53px; z-index: 99;"></span>
                                                                    <img class="PMCID_CP_Icon" src="{{ asset('/assets/tibiarl/images/payment/paypal.gif') }}">
                                                                    <div class="PMCID_CP_Label">
                                                                        <input type="radio" id="PMCID_2" name="pmid" value="paypal" style="display: none;">
                                                                        <label for="PMCID_2">PayPal </label>
                                                                    </div>
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
        </div>
        <div class="SubmitButtonRow">
            <div class="LeftButton">
                <div class="BigButton" style="background-image:url({{ asset('/assets/tibiarl/images/buttons/sbutton_green.gif') }})"><div onmouseover="MouseOverBigButton(this);" onmouseout="MouseOutBigButton(this);"><div class="BigButtonOver" style="background-image:url({{ asset('/assets/tibiarl/images/buttons/sbutton_green_over.gif') }});"></div>
                        <input class="BigButtonText" type="submit" value="Next">
                    </div>
                </div>
            </div>
            <div class="RightButton">
                <div class="BigButton" onclick="RedirectToUrl('{{ route('account.index') }}');" style="background-image:url({{ asset('/assets/tibiarl/images/buttons/sbutton_red.gif') }})"><div onmouseover="MouseOverBigButton(this);" onmouseout="MouseOutBigButton(this);"><div class="BigButtonOver" style="background-image:url({{ asset('/assets/tibiarl/images/buttons/sbutton_red_over.gif') }});"></div>
                        <input class="BigButtonText" type="submit" value="Cancel">
                    </div>
                </div>
            </div>
        </div>
    </form>
@endsection

@section('scripts')
    <script type="text/javascript">
        // define data structures
        var g_Services = [1,2,3,4,5,6];
        var g_PaymentMethodCategories = [1,2];
        var g_Prices = {"133":{"13":"9.40 EUR","20":"9.40 EUR","30":"9.40 EUR","73":"11.00 EUR","100":"9.51 EUR","103":"9.40 EUR","23":"9.40 EUR","134":"9.40 EUR","135":"9.40 EUR","80":"9.40 EUR","81":"9.40 EUR","90":"price on application"},"134":{"13":"26.15 EUR","20":"26.15 EUR","30":"26.15 EUR","73":"30.00 EUR","100":"26.44 EUR","103":"26.15 EUR","23":"26.15 EUR","134":"26.15 EUR","135":"26.15 EUR","80":"26.15 EUR","81":"26.15 EUR","90":"price on application"},"135":{"13":"52.30 EUR","20":"52.30 EUR","30":"52.30 EUR","73":"The product is not available for the selected payment method!","100":"52.89 EUR","103":"52.30 EUR","23":"52.30 EUR","134":"52.30 EUR","135":"52.30 EUR","80":"52.30 EUR","81":"52.30 EUR","90":"price on application"},"136":{"13":"104.60 EUR","20":"104.60 EUR","30":"104.60 EUR","73":"The product is not available for the selected payment method!","100":"105.78 EUR","103":"104.60 EUR","23":"104.60 EUR","134":"104.60 EUR","135":"104.60 EUR","80":"104.60 EUR","81":"104.60 EUR","90":"price on application"},"137":{"13":"156.90 EUR","20":"156.90 EUR","30":"156.90 EUR","73":"The product is not available for the selected payment method!","100":"158.66 EUR","103":"156.90 EUR","23":"156.90 EUR","134":"156.90 EUR","135":"156.90 EUR","80":"156.90 EUR","81":"156.90 EUR","90":"price on application"},"138":{"13":"The product is not available for the selected payment method!","20":"523.00 EUR","30":"The product is not available for the selected payment method!","73":"The product is not available for the selected payment method!","100":"The product is not available for the selected payment method!","103":"The product is not available for the selected payment method!","23":"The product is not available for the selected payment method!","134":"The product is not available for the selected payment method!","135":"The product is not available for the selected payment method!","80":"The product is not available for the selected payment method!","81":"The product is not available for the selected payment method!","90":"price on application"}};

        function ChangeService(a_ServiceID, a_ServiceCategoryID)
        {
            // console.log('### ChangeService() ### a_ServiceID #' + a_ServiceID + '# a_ServiceCategoryID #' + a_ServiceCategoryID + '#');
            // set the ServiceID for the change country form
            $('#CC_ServiceID').val(a_ServiceID);
            $('#CC_ServiceID').attr('name', 'InitialServiceID');
            // activate the radio button itself and set the price
            $('#ServiceID_' + a_ServiceID).attr('checked', 'checked');
            $('.ServiceID_Icon_Container').css('background-color', '');
            // handle payment methods
            for (var i = 0; i < g_PaymentMethodCategories.length; i++) {
                if (typeof g_Prices[a_ServiceID] !== 'undefined') {
                    if (typeof g_Prices[a_ServiceID][g_PaymentMethodCategories[i]] === 'undefined' // ###peter: [TIBIA-10665]
                        || typeof g_Prices[a_ServiceID][g_PaymentMethodCategories[i]] === 'string' && g_Prices[a_ServiceID][g_PaymentMethodCategories[i]] == 'The product is not available for the selected payment method!') {
                        // deactivate the payment method
                        // note: the radio button can not be disabled or we will receive the wrong error message
                        $('#PMCID_NotAllowed_' + g_PaymentMethodCategories[i]).show();
                    } else {
                        // activate the payment method
                        $('#PMCID_NotAllowed_' + g_PaymentMethodCategories[i]).hide();
                    }
                }
            }
            // activate and mark the selected icon
            $('.ServiceID_Icon_Selected').css('background-image', '');
            $('#ServiceID_Icon_Selected_' + a_ServiceID).css('background-image', 'url(' + JS_DIR_IMAGES + 'payment/serviceid_icon_selected.png)');
            return;
        }
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

        function MouseOverServiceID(a_ServiceID) {
            $('#ServiceID_Icon_Over_' + a_ServiceID).css('background-image', 'url(\'{{ asset('/assets/tibiarl/images/payment/serviceid_icon_over.png') }}\')');
        }

        function MouseOutServiceID(a_ServiceID) {
            $('#ServiceID_Icon_Over_' + a_ServiceID).css('background-image', '');
        }
    </script>
    <script type="text/javascript">
        $('#SelectCountrySubmitButton').hide();
        $('.PMCID_CP_Label > input').hide();
        $('.ServiceIDLabel > input').hide();
        $('#ExchangeRateNote').hide();
        ChangeService(1, 13);
    </script>
@endsection