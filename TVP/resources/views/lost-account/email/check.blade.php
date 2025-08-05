@extends('template.layout')
@section('title', 'Lost Account')
@section('submenuItem', 'lostaccount')
@section('content')

@if($lostAccount instanceof \App\Models\Account)
    <h2 style="text-align: center;">Account Email: {{ $emailOrChar }}</h2>
@else
    <h2 style="text-align: center;">Character: {{ $emailOrChar }}</h2>
@endif
<br>

<h3>Email Change Request</h3>

<p>To update your email to <b>{{ $newEmail }}</b>, follow these steps:</p>

<ol>
    <li>Enter your <b>recovery key</b> below.</li>
    <li>Click <b>"Submit"</b>.</li>
    <li>Check your inbox for a confirmation email and follow the provided link.</li>
    <li>On the confirmation page, <b>set a new password</b> to finalize the change.</li>
</ol>

<p><b>Important:</b> The confirmation link expires in <b>24 hours</b>.</p>

<div id="error-container"></div>

<form action="{{ route('account.lost.action') }}" method="post" style="padding:0px;margin:0px;">
    @csrf
    <div class="TableContainer">
        <div class="CaptionContainer">
            <div class="CaptionInnerContainer">
                <span class="CaptionEdgeLeftTop" style="background-image:url({{ asset('/assets/tibiarl/images/content/box-frame-edge.gif') }});"></span>
                <span class="CaptionEdgeRightTop" style="background-image:url({{ asset('/assets/tibiarl/images/content/box-frame-edge.gif') }});"></span>
                <span class="CaptionBorderTop" style="background-image:url({{ asset('/assets/tibiarl/images/content/table-headline-border.gif') }});"></span>
                <span class="CaptionVerticalLeft" style="background-image:url({{ asset('/assets/tibiarl/images/content/box-frame-vertical.gif') }});"></span>
                <div class="Text">Confirm Request for New Email Address</div>
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
                                            <input type="hidden" name="step" value="checkemail">
                                            <tr>
                                                <td>
                                                    <div style="display: flex; align-items: center; gap: 5px;">
                                                        <input class="UpperCaseInput" name="key1" size="5" maxlength="5" autocomplete="off">
                                                        <span>-</span>
                                                        <input class="UpperCaseInput" name="key2" size="5" maxlength="5" autocomplete="off">
                                                        <span>-</span>
                                                        <input class="UpperCaseInput" name="key3" size="5" maxlength="5" autocomplete="off">
                                                        <span>-</span>
                                                        <input class="UpperCaseInput" name="key4" size="5" maxlength="5" autocomplete="off">
                                                    
                                                        <div class="BigButton" style="background-image:url({{ asset('/assets/tibiarl/images/buttons/sbutton.gif') }})">
                                                            <div onmouseover="MouseOverBigButton(this);" onmouseout="MouseOutBigButton(this);">
                                                                <div class="BigButtonOver" style="background-image:url({{ asset('/assets/tibiarl/images/buttons/sbutton_over.gif') }});"></div>
                                                                <input class="BigButtonText" type="button" value="Fill Recovery Key" onclick="fillRecoveryKeyFromClipboard();">
                                                            </div>
                                                        </div>
                                                    </div>
                                                </td>
                                                
                                                <script>

                                                    async function fillRecoveryKeyFromClipboard() {
                                                        try {
                                                            let text = await navigator.clipboard.readText();

                                                            text = text.toUpperCase().replace(/[^A-Z0-9]/g, "");

                                                            if (text.length !== 20) {
                                                                showErrorMessage("Invalid recovery key format. Please copy a valid 20-character key.");
                                                                return;
                                                            }

                                                            let recoveryKeyParts = text.match(/.{1,5}/g);

                                                            document.getElementsByName("key1")[0].value = recoveryKeyParts[0];
                                                            document.getElementsByName("key2")[0].value = recoveryKeyParts[1];
                                                            document.getElementsByName("key3")[0].value = recoveryKeyParts[2];
                                                            document.getElementsByName("key4")[0].value = recoveryKeyParts[3];

                                                            clearErrorMessage();

                                                        } catch (err) {
                                                            showErrorMessage("Failed to read clipboard. Please allow clipboard access.");
                                                        }
                                                    }

                                                    function showErrorMessage(message) {
                                                        let errorHTML = `
                                                            <div class="SmallBox">
                                                                <div class="MessageContainer">
                                                                    <div class="BoxFrameHorizontal" style="background-image:url(http://localhost/assets/tibiarl/images/content/box-frame-horizontal.gif);"></div>
                                                                    <div class="BoxFrameEdgeLeftTop" style="background-image:url(http://localhost/assets/tibiarl/images/content/box-frame-edge.gif);"></div>
                                                                    <div class="BoxFrameEdgeRightTop" style="background-image:url(http://localhost/assets/tibiarl/images/content/box-frame-edge.gif);"></div>
                                                                    <div class="ErrorMessage">
                                                                        <div class="BoxFrameVerticalLeft" style="background-image:url(http://localhost/assets/tibiarl/images/content/box-frame-vertical.gif);"></div>
                                                                        <div class="BoxFrameVerticalRight" style="background-image:url(http://localhost/assets/tibiarl/images/content/box-frame-vertical.gif);"></div>
                                                                        <div class="AttentionSign" style="background-image:url(http://localhost/assets/tibiarl/images/content/attentionsign.gif);"></div>
                                                                        <b>The following error has occurred:</b>
                                                                        <br>${message} <br>
                                                                    </div>
                                                                    <div class="BoxFrameHorizontal" style="background-image:url(http://localhost/assets/tibiarl/images/content/box-frame-horizontal.gif);"></div>
                                                                    <div class="BoxFrameEdgeRightBottom" style="background-image:url(http://localhost/assets/tibiarl/images/content/box-frame-edge.gif);"></div>
                                                                    <div class="BoxFrameEdgeLeftBottom" style="background-image:url(http://localhost/assets/tibiarl/images/content/box-frame-edge.gif);"></div>
                                                                </div>
                                                            </div><br>`;

                                                        document.getElementById("error-container").innerHTML = errorHTML;
                                                    }

                                                    function clearErrorMessage() {
                                                        document.getElementById("error-container").innerHTML = "";
                                                    }

                                                </script>
                                            </tr>
                                            {{-- <tr>
                                                <td colspan="2"><label><input type="radio" name="step" value="key"> I have forgotten the recovery key of my
                                                    {{ config('server.serverName') }} account.</label><br></td>
                                            </tr> --}}
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
    <br>
    <center>
        <input type="hidden" name="email_or_char" value="{{ $emailOrChar }}">
        <input type="hidden" name="email" value="{{ $newEmail }}">
        <div class="BigButton" style="background-image:url({{ asset('/assets/tibiarl/images/buttons/sbutton.gif') }})">
            <div onmouseover="MouseOverBigButton(this);" onmouseout="MouseOutBigButton(this);"><div class="BigButtonOver" style="background-image:url({{ asset('/assets/tibiarl/images/buttons/sbutton_over.gif') }});"></div>
                <input class="BigButtonText" type="submit" value="Submit">
            </div>
        </div>
    </center>
</form>
@endsection
