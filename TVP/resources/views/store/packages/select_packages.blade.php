@extends('template.layout')
@section('title', 'Get Packages')
@section('submenuItem', 'packages')
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
    
    <form method="post" action="{{ route('account.store.packages.action') }}">
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
                    <div class="Text">Select packages</div>
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
                                <tr>
                                    <td>
                                        <div class="TableContentContainer">
                                            <table class="TableContent" width="100%" style="border:1px solid #faf0d7;">
                                                <tbody>
                                                    <tr>
                                                        <td style="text-align: center;" align="center">
                                                            <div class="OptionsContainer">
                                                                <div class="image-container">

                                                                    <div class="image-wrapper">
                                                                        <img src="{{ asset('bronze.png') }}?v=a1" alt="Bronze" class="option-image" data-color="bronze">
                                                                        <div class="custom-input-container" id="input-bronze" style="display:none;">
                                                                            <button type="button" class="decrement">-</button>
                                                                            <input name="bronze" type="text" class="quantity-input" value="0" readonly>
                                                                            <button type="button" class="increment">+</button>
                                                                        </div>

                                                                        @php
                                                                            $idServ = \App\Models\WebShopProduct::wherePaymentOptionId(6)->whereId(21)->first();
                                                                        @endphp

                                                                    
                                                                        @if ($idServ)
                                                                            @php
                                                                                $pmid = request()->input('pmid');
                                                                        
                                                                                $prefix = ($pmid == 1) ? 'USD$:' : $idServ->prefix;
                                                                                $value = ($pmid == 1) ? "23.00" : $idServ->value;
                                                                            @endphp
                                                                            
                                                                            <div class="price-label" style="color: #5A2800; font-size: 16px; font-weight: 900; bottom: 0px; padding: 10px">
                                                                                {{ $prefix }} <span id="bronzeValue"> {{ $value }}</span>
                                                                            </div>
                                                                        @endif
                                                                    
                                                                    </div>

                                                                    <div class="image-wrapper">
                                                                        <img src="{{ asset('silver.png') }}?v=a1" alt="Silver" class="option-image" data-color="silver">
                                                                        <div class="custom-input-container" id="input-silver" style="display:none;">
                                                                            <button type="button" class="decrement">-</button>
                                                                            <input name="silver" type="text" class="quantity-input" value="0" readonly>
                                                                            <button type="button" class="increment">+</button>
                                                                        </div>

                                                                        @php
                                                                            $idServ = \App\Models\WebShopProduct::wherePaymentOptionId(6)->whereId(22)->first();
                                                                        @endphp
                                                                    
                                                                        @if ($idServ)
                                                                            @php
                                                                                $prefix = ($pmid == 1) ? 'USD$:' : $idServ->prefix;
                                                                                $value = ($pmid == 1) ? "37.00" : $idServ->value;
                                                                            @endphp
                                                                            
                                                                            <div class="price-label" style="color: #5A2800; font-size: 16px; font-weight: 900; bottom: 0px; padding: 10px">
                                                                                {{ $prefix }} <span id="silverValue"> {{ $value }}</span>
                                                                            </div>
                                                                        @endif
                                                                    </div>

                                                                    <div class="image-wrapper">
                                                                        <img src="{{ asset('gold.png') }}?v=a1" alt="Gold" class="option-image" data-color="gold">
                                                                        <div class="custom-input-container" id="input-gold" style="display:none;">
                                                                            <button type="button" class="decrement">-</button>
                                                                            <input name="gold" type="text" class="quantity-input" value="0" readonly>
                                                                            <button type="button" class="increment">+</button>
                                                                        </div>
                                                                   
                                                                        @php
                                                                            $idServ = \App\Models\WebShopProduct::wherePaymentOptionId(6)->whereId(23)->first();
                                                                        @endphp
                                                                    
                                                                        @if ($idServ)
                                                                            @php
                                                                                $prefix = ($pmid == 1) ? 'USD$:' : $idServ->prefix;
                                                                                $value = ($pmid == 1) ? "58.00" : $idServ->value;
                                                                            @endphp
                                                                            
                                                                            <div class="price-label" style="color: #5A2800; font-size: 16px; font-weight: 900; bottom: 0px; padding: 10px">
                                                                                {{ $prefix }} <span id="goldValue"> {{ $value }}</span>
                                                                            </div>
                                                                        @endif
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

            <div class="RightButton">
                <div class="BigButton" onclick="RedirectToUrl('{{ route('account.store.packages.index') }}');" style="background-image:url({{ asset('/assets/tibiarl/images/buttons/sbutton.gif') }})"><div onmouseover="MouseOverBigButton(this);" onmouseout="MouseOutBigButton(this);"><div class="BigButtonOver" style="background-image:url({{ asset('/assets/tibiarl/images/buttons/sbutton_over.gif') }});"></div>
                        <input class="BigButtonText" type="submit" value="Previous">
                    </div>
                </div>
            </div>

            <div class="LeftButton">
                <div class="BigButton" style="background-image:url({{ asset('/assets/tibiarl/images/buttons/sbutton_green.gif') }})"><div onmouseover="MouseOverBigButton(this);" onmouseout="MouseOutBigButton(this);"><div class="BigButtonOver" style="background-image:url({{ asset('/assets/tibiarl/images/buttons/sbutton_green_over.gif') }});"></div>
                        <input class="BigButtonText" type="submit" value="Next">
                    </div>
                </div>
            </div>
        </div>

        <style>
                                        
            .image-container {
                display: flex;
                justify-content: space-around;
                gap: 20px;
                margin-left: 30px;
            }
        
            .image-wrapper {
                position: relative;
                text-align: center;
            }
        
            .option-image {
                width: 200px;
                height: 400px;
                transition: transform 0.3s, box-shadow 0.3s;
                border: 4px solid transparent;
                border-radius: 10px;
                cursor: pointer;
            }
        
            .option-image:hover {
                transform: scale(1.05);
                /* box-shadow: 0px 0px 20px rgba(0, 0, 0, 0.2); */
            }
        
            /* .option-image[data-color="bronze"]:hover {
                border: 4px solid #cd7f32;
            }

            .option-image[data-color="silver"]:hover {
                border: 4px solid #c0c0c0;
            }

            .option-image[data-color="gold"]:hover {
                border: 4px solid #ffd700;
            } */

            .custom-input-container {
                display: flex;
                align-items: center;
                justify-content: center;
                margin-top: 10px;
            }

            .quantity-input {
                width: 50px;
                height: 30px;
                text-align: center;
                font-size: 16px;
                border: 1px solid #ddd;
                margin: 0 5px;
                background-color: #f9f9f9;
                pointer-events: none;
            }

            .custom-input-container button {
                background-color: #003366;
                color: white;
                border: none;
                padding: 5px 10px;
                font-size: 18px;
                cursor: pointer;
                transition: background-color 0.3s;
            }

            .custom-input-container button:hover {
                background-color: #002244; 
            }

            .custom-input-container button:disabled {
                background-color: #ccc;
                cursor: not-allowed;
            }

        </style>
  
        <script>

            var pmid = {{ request()->input('pmid') }};

            document.querySelectorAll('.option-image').forEach(function(image) {
                image.addEventListener('click', function() {
                    const color = image.getAttribute('data-color');
                    const inputContainer = document.getElementById('input-' + color);
                    const input = inputContainer.querySelector('.quantity-input');

                    if (inputContainer.style.display === 'flex') {
                        inputContainer.style.display = 'none';
                        input.value = 0;
                        updatePrice(color, 1); 
                    } else {
                        inputContainer.style.display = 'flex';
                    }
                });
            });

            document.querySelectorAll('.custom-input-container').forEach(function(container) {
                const input = container.querySelector('.quantity-input');
                const incrementButton = container.querySelector('.increment');
                const decrementButton = container.querySelector('.decrement');
                const color = container.id.split('-')[1]; 

                incrementButton.addEventListener('click', function() {
                    let currentValue = parseInt(input.value);
                    if (currentValue < 10) {
                        input.value = currentValue + 1;
                    }

                    updateButtonState(input, decrementButton, incrementButton);
                    updatePrice(color, input.value); 
                });

                decrementButton.addEventListener('click', function() {
                    let currentValue = parseInt(input.value);
                    if (currentValue > 1) {
                        input.value = currentValue - 1;
                    }

                    updateButtonState(input, decrementButton, incrementButton);
                    updatePrice(color, input.value);
                });

                function updateButtonState(input, decrementButton, incrementButton) {
                    const value = parseInt(input.value);
                    decrementButton.disabled = value <= 1;
                    incrementButton.disabled = value >= 10;
                }

                updateButtonState(input, decrementButton, incrementButton);
            });

            function updatePrice(color, quantity) {
                let baseValue;

                // Ajustar os valores para dólar quando pmid == 1
                if (pmid == 1) {
                    if (color === 'bronze') {
                        baseValue = 23;
                    } else if (color === 'silver') {
                        baseValue = 37;
                    } else if (color === 'gold') {
                        baseValue = 58;
                    }
                } else {
                    // Valores padrão quando pmid for diferente de 1
                    if (color === 'bronze') {
                        baseValue = 130;
                    } else if (color === 'silver') {
                        baseValue = 210;
                    } else if (color === 'gold') {
                        baseValue = 330;
                    }
                }

                const totalValue = baseValue * quantity;

                if (color === 'bronze') {
                    document.getElementById('bronzeValue').textContent = totalValue.toFixed(2);
                } else if (color === 'silver') {
                    document.getElementById('silverValue').textContent = totalValue.toFixed(2);
                } else if (color === 'gold') {
                    document.getElementById('goldValue').textContent = totalValue.toFixed(2);
                }
            }

        </script>    
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