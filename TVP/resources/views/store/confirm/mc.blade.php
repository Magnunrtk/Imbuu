@extends('template.layout')
@section('title', 'Store')
@section('submenuItem', 'getcoins')
@section('content')
    @php
        $webTransaction = \App\Models\WebManualTransaction::whereAccountId(Auth::user()->id)->whereStatus(0)->first();
    @endphp
    @if(!$webTransaction)
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
    <form role="form" action="{{ route('account.store.payment-method.medivia-coins.action') }}" method="post">
        @csrf
        <input type="hidden" name="action" value="confirm">
        <input type="hidden" name="pmid" value="{{ $product->payment->id }}">
        <input type="hidden" name="product_id" value="{{ $product->id }}">
        <input type="hidden" name="acceptTerms" value="1">
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
                                                    <td>{{ $product->coins }} Coins</td>
                                                </tr>
                                                <tr>
                                                    <td class="LabelV200">Price</td>
                                                    <td>@if(!empty($product->prefix)) {{ $product->prefix }} @endif {{ number_format($product->value, $product->decimals, ',') }} @if(!empty($product->suffix)) {{ $product->suffix }} @endif</td>
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
                                                    <td>
                                                        <div class="StoreWorldSelection">
                                                            <div class="LabelV200">Server</div>
                                                            <div class="WorldSelectionDropDown">
                                                                <select size="1" id="select_server" name="server" style="width:165px;">
                                                                    @foreach(config('shop.payment_options')['medivia_coins']['server_list'] as $key => $server)
                                                                        <option value="{{ $key }}">{{ $server }}</option>
                                                                    @endforeach
                                                                </select>
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
                                                    <td class="LabelV200">Receiver Name:</td>
                                                    <td><a id="receiverNameHref" target="_blank"></a></td>
                                                </tr>
                                                <tr>
                                                    <td colspan="2">Your character needs to send a Parcel containing @if(!empty($product->prefix)) {{ $product->prefix }} @endif {{ number_format($product->value, $product->decimals, ',') }} @if(!empty($product->suffix)) {{ $product->suffix }} @endif to the character <span id="receiverName" style="color: red;font-weight: bold;"></span> in <span id="serverName" style="color: red;font-weight: bold;"></span> server on city <span id="serverCity" style="color: red;font-weight: bold;"></span>.<br><br>To complete the order, click confirm, we advise you to send the Medivia Coins before ordering to avoid misunderstandings.</td>
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
                                                    <td class="LabelV200">Payment Method</td>
                                                    <td>{{ ucfirst($paymentMethod->name) }}</td>
                                                </tr>
                                                <tr>
                                                    <td class="LabelV200">Account Email:</td>
                                                    <td>{{ Auth::user()->email }}</td>
                                                </tr>
                                                <tr>
                                                    <td class="LabelV200">Medivia Character Name:</td>
                                                    <td><input type="text" name="characterName" size="25" maxlength="30"></td>
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
            <div class="LeftButton">
                <div class="BigButton" style="background-image:url({{ asset('/assets/tibiarl/images/buttons/sbutton_green.gif') }})"><div onmouseover="MouseOverBigButton(this);" onmouseout="MouseOutBigButton(this);"><div class="BigButtonOver" style="background-image:url({{ asset('/assets/tibiarl/images/buttons/sbutton_green_over.gif') }});"></div>
                        <input class="BigButtonText" type="submit" value="Buy Now">
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
    @else
        @include('store.pending-transaction')
    @endif
@endsection
@section('scripts')
    <script type="text/javascript">
        $(document).ready(function() {
            document.getElementById('select_server').addEventListener('change', function(e) {
                getServerInfo(e);
            });

            function getServerInfo(e) {
                const selectId = e.target.value;
                $.ajax({
                    url: '{{ route('v1.payment-method.medivia-coins.server.info', ['id' => ':id']) }}'.replace(':id', selectId),
                    type: 'GET',
                    success: function(response) {
                        if (typeof response === 'string') {
                            response = JSON.parse(response);
                        }
                        if (response.success === true) {
                            document.getElementById('receiverName').textContent = response.receiver_name;
                            document.getElementById('serverName').textContent = response.name;
                            document.getElementById('serverCity').textContent = response.city;
                            const baseUrl = "https://medivia.online/community/character/";
                            const receiverNameHrefElement = document.getElementById('receiverNameHref');
                            receiverNameHrefElement.href = baseUrl + response.receiver_name;
                            receiverNameHrefElement.textContent = response.receiver_name;
                        }
                    },
                    error: function(xhr, status, error) {
                        console.error('AJAX Error:', status, error);
                    }
                });
            }

            // Funktion einmal beim Laden der Seite aufrufen
            getServerInfo({
                target: {
                    value: $('#select_server').val() // Hier kannst du den Standardwert für das ausgewählte Element festlegen
                }
            });
        });
    </script>
@endsection