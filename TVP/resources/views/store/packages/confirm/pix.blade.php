@extends('template.layout')
@section('title', 'Get Packages')
@section('submenuItem', 'packages')
@section('content')
    @include('store.confirm.progress-bar')
    <center>
        <div class="CustomerIdentification">Order for Account Number: <span id="DisplayAccountNumber" onmousedown="ToggleMaskedText('AccountNumber');">*********</span>
            <span id="MaskedAccountNumber">*********</span>
            <span id="ReadableAccountNumber">{{ Auth::user()->id }}</span>
            <div>
                <img id="ButtonAccountNumber" onmousedown="ToggleMaskedText('AccountNumber');" src="{{ asset('/assets/tibiarl/images/general/show.gif') }}">
            </div>
        </div>
    </center>
    <form role="form" action="{{ route('account.store.packages.payment-method.mercado-pago.pix.action') }}" method="post">
        @csrf
        <input type="hidden" name="action" value="confirm">
        <input type="hidden" name="pmid" value="{{ $product->payment->id }}">
        <input type="hidden" name="product_id" value="{{ $product->id }}">
        <input type="hidden" name="acceptTerms" value="1">

        <input type="hidden" name="bronze" value="{{$bronze}}">
        <input type="hidden" name="silver" value="{{$silver}}">
        <input type="hidden" name="gold" value="{{$gold}}}">

        <div class="TableContainer">
            <div class="CaptionContainer">
                <div class="CaptionInnerContainer">
                    <span class="CaptionEdgeLeftTop" style="background-image:url({{ asset('/assets/tibiarl/images/content/box-frame-edge.gif') }});"></span>
                    <span class="CaptionEdgeRightTop" style="background-image:url({{ asset('/assets/tibiarl/images/content/box-frame-edge.gif') }});"></span>
                    <span class="CaptionBorderTop" style="background-image:url({{ asset('/assets/tibiarl/images/content/table-headline-border.gif') }});"></span>
                    <span class="CaptionVerticalLeft" style="background-image:url({{ asset('/assets/tibiarl/images/content/box-frame-vertical.gif') }});"></span>
                    <div class="Text">Confirm your order</div>
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
                                                    <tr id="totalPriceRow">
                                                        <td class="LabelV200" id="totalPriceLabel">Total Price:</td>
                                                        <td>
                                                            @php
                                                                $totalPrice = ($bronze * 130) + ($silver * 210) + ($gold * 330);
                                                            @endphp
                                                    
                                                            @if(!empty($product->prefix)) {{ $product->prefix }} @endif
                                                            <span id="originalPrice">{{ number_format($totalPrice, $product->decimals, ',', '') }}</span>
                                                            @if(!empty($product->suffix)) {{ $product->suffix }} @endif
                                                        </td>
                                                    </tr>
                                                    
                                                    <tr id="discountRow" style="display: none;">
                                                        <td class="LabelV200">Discount Applied:</td>
                                                        <td>
                                                            <span id="discountValue">0</span>%
                                                        </td>
                                                    </tr>
                                                    
                                                    <tr id="finalPriceRow" style="display: none;">
                                                        <td class="LabelV200">Final Price (After Discount):</td>
                                                        <td>
                                                            @if(!empty($product->prefix)) {{ $product->prefix }} @endif
                                                            <span id="finalPrice"></span>
                                                            @if(!empty($product->suffix)) {{ $product->suffix }} @endif
                                                        </td>
                                                    </tr>

                                                    
                                                    <script>
                                                        document.addEventListener("DOMContentLoaded", function () {
                                                            let originalPrice = parseFloat("{{ $totalPrice }}");
                                                            let discountPercentage = parseFloat("{{ $discountConfig }}") || 0;
                                                            let coupons = @json($coupons);
                                                    
                                                            document.getElementById("applyCoupon").addEventListener("click", function (event) {
                                                                event.preventDefault();
                                                    
                                                                let enteredCoupon = document.getElementById("couponCode").value.trim();
                                                    
                                                                if (coupons.includes(enteredCoupon)) {
                                                                    let discountAmount = (originalPrice * discountPercentage) / 100;
                                                                    let finalPrice = originalPrice - discountAmount;
                                                    
                                                                    document.getElementById("totalPriceLabel").textContent = "Before Discount:";
                                                                    
                                                                    document.getElementById("discountValue").textContent = discountPercentage;
                                                                    document.getElementById("finalPrice").textContent = finalPrice.toFixed(2).replace('.', ',');
                                                                    document.getElementById("discountRow").style.display = "table-row";
                                                                    document.getElementById("finalPriceRow").style.display = "table-row";
                                                                } else {
                                                                    alert("Invalid coupon code!");
                                                                }
                                                            });
                                                        });
                                                    </script>                                                 
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
                                                    <td class="LabelV200">Select Character:</td>
                                                    <td>
                                                        <select name="character_name" id="character_name" required>
                                                            <option value="" disabled selected>Select your character</option>
                                                            @foreach($playerNames as $name)
                                                                <option value="{{ $name }}">{{ $name }}</option>
                                                            @endforeach
                                                        </select>
                                                    </td>
                                                </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </td>
                                </tr>

                                <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">

                                <tr>
                                    <td>
                                        <div class="TableContentContainer">
                                            <table class="TableContent" width="100%" style="border:1px solid #faf0d7;">
                                                <tbody>
                                                    <tr>
                                                        <td class="LabelV200">Coupon Code:</td>
                                                        <td style="display: flex; gap: 10px">
                                                            <input type="text" id="couponCode" name="coupon_code" placeholder="Enter your coupon">
                                                    
                                                            <div class="RightButton">
                                                                <div class="BigButton" style="background-image:url({{ asset('/assets/tibiarl/images/buttons/sbutton.gif') }})">
                                                                    <div onmouseover="MouseOverBigButton(this);" onmouseout="MouseOutBigButton(this);">
                                                                        <div class="BigButtonOver" style="background-image:url({{ asset('/assets/tibiarl/images/buttons/sbutton_over.gif') }});"></div>
                                                                        <input class="BigButtonText" type="button" id="applyCoupon" value="Apply">
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
                                       
                                <tr>
                                    <td>
                                        <div class="TableContentContainer">
                                            <table class="TableContent" width="100%" style="border:1px solid #faf0d7;">
                                                <tbody>
                                                <tr>
                                                    <td class="LabelV200">Payment Method:</td>
                                                    <td>{{ ucfirst($paymentMethod->name) }}</td>
                                                </tr>
                                                <tr>
                                                    <td class="LabelV200">Account Number:</td>
                                                    <td>shown above</td>
                                                </tr>
                                                <tr>
                                                    <td class="LabelV200">Account Email:</td>
                                                    <td>{{ Auth::user()->email }}</td>
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
                                                    <td colspan="2">
                                                        <input type="checkbox" name="acceptTermsAndAgreement" value="1" id="AgreementsCheckbox"> <span><label for="AgreementsCheckbox">I have read, and I agree that payments are not refundable, and I read the <a href="{{ route('privacy.terms.index') }}" target="_blank">{{ config('server.serverName') }} Privacy Policy</a>.</label></span>
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
                        <input class="BigButtonText" type="submit" value="Buy Now">
                    </div>
                </div>
            </div>
        </div>
    </form>

    <script>
        document.getElementById('openUrlIcon').addEventListener('click', function(event) {
            event.preventDefault();
            var select = document.getElementById('streamerSelect');
            var selectedOption = select.options[select.selectedIndex];
    
            if (selectedOption.value) {
                var url = selectedOption.getAttribute('data-url');
                window.open(url, '_blank'); 
            } else {
                alert('Please select a streamer first.'); 
            }
        });
    </script>
@endsection