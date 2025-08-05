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
                            <div class="StepText">Payment methods</div>
                        </div>
                    </div>
                    <div class="Steps" style="width:25%">
                        <div class="TubeContainer">
                            <img class="Tube" src="{{ asset('/assets/tibiarl/images/content/progressbar/progress-bar-tube-green.gif') }}">
                        </div>
                        <div class="SingleStepContainer">
                            <img class="StepIcon" src="{{ asset('/assets/tibiarl/images/content/progressbar/progress-bar-icon-3-green.gif') }}">
                            <div class="StepText" style="font-weight:bold;">Select product</div>
                        </div>
                    </div>
                    <div class="Steps" style="width:25%">
                        <div class="TubeContainer">
                            <img class="Tube" src="{{ asset('/assets/tibiarl/images/content/progressbar/progress-bar-tube-green-blue.gif') }}">
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

    @php
        $serverPath = config('server.fullServerDomain');
    @endphp
    
    <form method="post" action="{{ route('account.store.action') }}">
        @csrf
        <input type="hidden" name="action" value="product">
        <input type="hidden" name="pmid" value="{{ $paymentId }}">
        <input type="hidden" name="acceptTerms" value="1">
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
                        
                        {{-- <div style="Position: absolute; width: 200px; left: 150px">
                            <span>
                            </span>
                        </div> --}}

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
                                                            @foreach(\App\Models\WebShopProduct::wherePaymentOptionId($paymentId)->whereActive(true)->orderBy('value')->get() as $product)
                                                                <div class="ServiceID_Icon_Container" id="ServiceID_Icon_Container_{{ $product->id }}">
                                                                    <div class="ServiceID_Icon_Container_Background" id="" style="background-image:url({{ asset('/assets/tibiarl/images/payment/serviceid_icon_normal.png') }});">
                                                                        <div class="ServiceID_Icon" id="ServiceID_Icon_{{ $product->id }}" style="" onclick="ChangeService({{ $product->id }});" onmouseover="MouseOverServiceID({{ $product->id }});" onmouseout="MouseOutServiceID({{ $product->id }});">

                                                                            <div class="ServiceID_Icon_New" id="ServiceID_Icon_New_{{ $product->id }}" style="background-image:url({{ asset('/assets/tibiarl/images/payment/' . $product->image) }}); left: -12px"></div>
                                                                            
                                                                            <div class="ServiceID_Icon_Selected" id="ServiceID_Icon_Selected_{{ $product->id }}"></div>
                                                                            <div class="ServiceID_Icon_Over" id="ServiceID_Icon_Over_{{ $product->id }}" style=""></div>
                                                                            <label for="ServiceID_{{ $product->id }}">
                                                                                <div class="ServiceIDLabelContainer">

                                                                                    <div class="ServiceIDLabel">
                                                                                        <input type="radio" id="ServiceID_{{ $product->id }}" name="product_id" value="{{ $product->id }}">{{ $product->coins }} 
                                                                                        
                                                                                        Coins

                                                                                    </div>

                                                                                </div>

                                                                                <div class="ServiceIDPriceContainer">
                                                                                    <span class="ServiceIDPrice" id="PD_{{ $product->id }}">
                                                                                        
                                                                                        @if(!empty($product->prefix)) {{ $product->prefix }} @endif 
                                                                                        
                                                                                        {{ number_format($product->value, $product->decimals, ',') }}
                                                                                        
                                                                                        @if(!empty($product->suffix)) {{ $product->suffix }} @endif
                                                                                    
                                                                                    </span> 

                                                                                </div>
                                                                            </label>
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
                <div class="BigButton" style="background-image:url({{ asset('/assets/tibiarl/images/buttons/sbutton_green.gif') }})"><div onmouseover="MouseOverBigButton(this);" onmouseout="MouseOutBigButton(this);"><div class="BigButtonOver" style="background-image:url({{ asset('/assets/tibiarl/images/buttons/sbutton_green_over.gif') }});"></div>
                        <input class="BigButtonText" type="submit" value="Next">
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
@endsection

@section('scripts')
    <script type="text/javascript">
        function ChangeService(a_ServiceID)
        {
            // set the ServiceID for the change country form
            $('#CC_ServiceID').val(a_ServiceID);
            $('#CC_ServiceID').attr('name', 'InitialServiceID');
            // activate the radio button itself and set the price
            $('#ServiceID_' + a_ServiceID).attr('checked', 'checked');
            $('.ServiceID_Icon_Container').css('background-color', '');
            // activate and mark the selected icon
            $('.ServiceID_Icon_Selected').css('background-image', '');
            $('#ServiceID_Icon_Selected_' + a_ServiceID).css('background-image', 'url(' + JS_DIR_IMAGES + 'payment/serviceid_icon_selected.png)');
            return;
        }

        function MouseOverServiceID(a_ServiceID) {
            $('#ServiceID_Icon_Over_' + a_ServiceID).css('background-image', 'url(\'{{ asset('/assets/tibiarl/images/payment/serviceid_icon_over.png') }}\')');
        }

        function MouseOutServiceID(a_ServiceID) {
            $('#ServiceID_Icon_Over_' + a_ServiceID).css('background-image', '');
        }
    </script>
    <script type="text/javascript">
        $('.ServiceIDLabel > input').hide();
    </script>
@endsection