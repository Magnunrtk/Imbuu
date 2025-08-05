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
            <img id="TubeRightEnd" src="{{ asset('/assets/tibiarl/images/content/progressbar/progress-bar-tube-right-green.gif') }}">
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
                            <div class="StepText">Select product</div>
                        </div>
                    </div>
                    <div class="Steps" style="width:25%">
                        <div class="TubeContainer">
                            <img class="Tube" src="{{ asset('/assets/tibiarl/images/content/progressbar/progress-bar-tube-green.gif') }}">
                        </div>
                        <div class="SingleStepContainer">
                            <img class="StepIcon" src="{{ asset('/assets/tibiarl/images/content/progressbar/progress-bar-icon-0-green.gif') }}">
                            <div class="StepText">Confirm your order</div>
                        </div>
                    </div>
                    <div class="Steps" style="width:25%">
                        <div class="TubeContainer">
                            <img class="Tube" src="{{ asset('/assets/tibiarl/images/content/progressbar/progress-bar-tube-green.gif') }}">
                        </div>
                        <div class="SingleStepContainer">
                            <img class="StepIcon" src="{{ asset('/assets/tibiarl/images/content/progressbar/progress-bar-icon-4-green.gif') }}">
                            <div class="StepText" style="font-weight:bold;">Summary</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <center>
        <div class="CustomerIdentification">Order for Account Number: <span id="DisplayAccountNumber" onmousedown="ToggleMaskedText('AccountNumber');">*********</span>
            <span id="MaskedAccountNumber">*********</span>
            <span id="ReadableAccountNumber">{{ $webOrderHistory->account_id }}</span>
            <div>
                <img id="ButtonAccountNumber" onmousedown="ToggleMaskedText('AccountNumber');" src="{{ asset('/assets/tibiarl/images/general/show.gif') }}">
            </div>
        </div>
    </center>
    <form role="form" action="{{ route('account.store.payment-method.mercado-pago.pix.action') }}" method="post">
        @csrf
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
                            <table class="TableContent" width="100%">
                                                <tbody>
                                                <tr>
                                                    <td>Thank you for your order. You will be redirected after you completed the payment. Please keep in mind that depending on the selected payment method your order may take several days to be finalised, particularly when using an offline payment method.
                                                        <br><br>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>
                                                        <div class="TableContentContainer">
                                                            <table class="TableContent" width="100%" style="border:1px solid #faf0d7;">
                                                                <tbody>
                                                                    
                                                                    @if(!empty($couponCode) && !empty($streamerUrl))
                                                                        <tr>
                                                                            <td class="LabelV200">Original Price</td>
                                                                            <td>
                                                                                
                                                                                @if(!empty($webOrderHistory->product->prefix)) 
                                                                                    {{ $webOrderHistory->product->prefix }} 
                                                                                @endif
                                                                                
                                                                                <s>{{ number_format($oldPrice, 2, ',', '.') }}</s>
                                                                            
                                                                            </td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td class="LabelV200">Discount Applied</td>
                                                                            <td>
                                                                                
                                                                                @if(!empty($webOrderHistory->product->prefix)) 
                                                                                    {{ $webOrderHistory->product->prefix }} 
                                                                                @endif
                                                                                
                                                                                -{{ number_format( ( $oldPrice - $totalPrice ) , 2, ',', '.') }} ({{ $discountPercentage }}%)

                                                                            </td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td class="LabelV200">Final Price</td>
                                                                            <td>
                                                                                @if(!empty($webOrderHistory->product->prefix)) 
                                                                                    {{ $webOrderHistory->product->prefix }} 
                                                                                @endif
                                                                                <strong>{{ number_format($totalPrice, 2, ',', '.') }}</strong>
                                                                            </td>
                                                                        </tr>
                                                                    @else
                                                                        <tr>
                                                                            <td class="LabelV200">Price</td>
                                                                            <td>
                                                                                @if(!empty($webOrderHistory->product->prefix)) 
                                                                                    {{ $webOrderHistory->product->prefix }} 
                                                                                @endif 
                                                                                
                                                                                {{ number_format($webOrderHistory->price, $webOrderHistory->product->decimals, ',') }} 
                                                                                
                                                                                @if(!empty($webOrderHistory->product->suffix)) 
                                                                                    {{ $webOrderHistory->product->suffix }} 
                                                                                @endif
                                                                            </td>
                                                                        </tr>
                                                                    @endif                                                                
                                                                    
                                                                    @if(!empty($couponCode))
                                                                        <tr>
                                                                            <td class="LabelV200">Coupon Code</td>
                                                                            <td>{{ $couponCode }} - {{ $discountPercentage }}% discount</td>
                                                                        </tr>
                                                                    @endif
                                                                    
                                                                    @if(!empty($streamerUrl))
                                                                        <tr>
                                                                            <td class="LabelV200">Streamer</td>
                                                                            <td><a href="{{ $streamerUrl->url }}" target="_blank">{{ $streamerUrl->name }}</a></td>
                                                                        </tr>
                                                                    @endif                                                                    
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
                                                                    <td>{{ ucfirst($webOrderHistory->product->payment->name) }}</td>
                                                                </tr>
                                                                <tr>
                                                                    <td class="LabelV200">Account Number:</td>
                                                                    <td>shown above</td>
                                                                </tr>
                                                                <tr>
                                                                    <td class="LabelV200">Account Email:</td>
                                                                    <td>{{ $webOrderHistory->account->email }}</td>
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
                                                                @if(isset($response['qr_code_base64']))
                                                                    <tr class="text-center">
                                                                        <td colspan="2">
                                                                            <img width="200" height="200" src="data:image/png;base64,{{ $response['qr_code_base64'] }}">
                                                                        </td>
                                                                    </tr>
                                                                @endif
                                                                @if(isset($response['qr_code']))
                                                                    <tr>
                                                                        <td class="LabelV200">Code PIX:</td>
                                                                        <td>
                                                                            <input type="text" style="width: 75%" value="{{ $response['qr_code'] }}" onclick="this.select()" readonly>
                                                                        </td>
                                                                    </tr>
                                                                @endif
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
                        <input class="BigButtonText" type="submit" value="Back">
                    </div>
                </div>
            </div>
        </div>
    </form>
@endsection
@section('scripts')
    <script type="text/javascript">
        $(document).ready(function() {
            let intervalId = null;
            function checkPaymentStatus() {
                $.ajax({
                    url: '{{ route('v1.payment-method.mercado-pago.status') }}',
                    type: 'GET',
                    data: {
                        session_id: '{{ $sessionId }}'
                    },
                    success: function(response) {
                        if (typeof response === 'string') {
                            response = JSON.parse(response);
                        }
                        if (response.success === true) {
                            clearInterval(intervalId);
                            window.location.href = '{{ route('account.store.payment-method.mercado-pago.pix.success') }}';
                        }
                    },
                    error: function(xhr, status, error) {
                        console.error('AJAX Error:', status, error);
                    }
                });
            }
            intervalId = setInterval(checkPaymentStatus, 10000);
            checkPaymentStatus();
        });
    </script>
@endsection