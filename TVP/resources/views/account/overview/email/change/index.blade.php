@extends('template.layout')
@section('title', 'Account Management')
@section('submenuItem', 'accountmanagement')
@section('content')

@if($accountVerify == true)

<form method="post" action="{{ route('account.email.confirmation.change.action') }}" class="form">
    @csrf
    <div class="TableContainer">
        <div class="CaptionContainer">
            <div class="CaptionInnerContainer">
                <span class="CaptionEdgeLeftTop" style="background-image:url({{ asset('/assets/tibiarl/images/content/box-frame-edge.gif') }});"></span>
                <span class="CaptionEdgeRightTop" style="background-image:url({{ asset('/assets/tibiarl/images/content/box-frame-edge.gif') }});"></span>
                <span class="CaptionBorderTop" style="background-image:url({{ asset('/assets/tibiarl/images/content/table-headline-border.gif') }});"></span>
                <span class="CaptionVerticalLeft" style="background-image:url({{ asset('/assets/tibiarl/images/content/box-frame-vertical.gif') }});"></span>
                <div class="Text">Confirmation Email Sent</div>
                <span class="CaptionVerticalRight" style="background-image:url({{ asset('/assets/tibiarl/images/content/box-frame-vertical.gif') }});"></span>
                <span class="CaptionBorderBottom" style="background-image:url({{ asset('/assets/tibiarl/images/content/table-headline-border.gif') }});"></span>
                <span class="CaptionEdgeLeftBottom" style="background-image:url({{ asset('/assets/tibiarl/images/content/box-frame-edge.gif') }});"></span>
                <span class="CaptionEdgeRightBottom" style="background-image:url({{ asset('/assets/tibiarl/images/content/box-frame-edge.gif') }});"></span>
            </div>
        </div>
        <table class="Table1" cellpadding="0" cellspacing="0">
            <tbody>
            <tr>
                <td>
                    <div class="InnerTableContainer" style="max-width: unset;">
                        <table style="width:100%;">
                            <tbody>
                            <tr>
                                <td class="LabelV"><span>New Email Address:</span></td>
                                <td><input name="email" value="" size="30" maxlength="50"></td>
                            </tr>

                            <style>
                                .inputBoxRk{
                                    width: 60px
                                }
                            </style>

                            <tr>
                                <td class="LabelV"><span>Recovery Key:</span></td>

                                <td width="90%">
                                    <div style="display: flex; height: 20px; gap: 5px">
                                        <input class="inputBoxRk" type="text" name="rkBlock1" oninput="this.value = this.value.toUpperCase(); autoFill(this, 1)" onkeyup="handleBackspace(this, 1)">
                                        -
                                        <input class="inputBoxRk" type="text" name="rkBlock2" oninput="this.value = this.value.toUpperCase(); autoFill(this, 2)" onkeyup="handleBackspace(this, 2)">
                                        -
                                        <input class="inputBoxRk" type="text" name="rkBlock3" oninput="this.value = this.value.toUpperCase(); autoFill(this, 3)" onkeyup="handleBackspace(this, 3)">
                                        -
                                        <input class="inputBoxRk" type="text" name="rkBlock4" oninput="this.value = this.value.toUpperCase(); autoFill(this, 4)" onkeyup="handleBackspace(this, 4)">
                                        
                                        <label><img src="/images/paste.png" style="width: 25px" onclick="autoFillClipboardText()"></label>       
                                    </div>      
                                </td>
                            </tr>

                            <script>

                                function autoFillClipboardText() {
                                    navigator.clipboard.readText().then(function(clipboardText) {

                                        var sanitizedText = clipboardText.replace(/-/g, '');
                                        var blocks = sanitizedText.match(/.{1,5}/g) || [];
                                        var inputs = document.querySelectorAll('.inputBoxRk');
                                        
                                        for (var i = 0; i < blocks.length && i < inputs.length; i++) {
                                            inputs[i].value = blocks[i].toUpperCase();
                                            autoFill(inputs[i], i + 1); 
                                        }
                                    });
                                }

                                function autoFill(input, blockIndex) {

                                    var pastedValue = input.value.replace(/-/g, '').trim().toUpperCase();

                                    if (pastedValue.length > 5 && pastedValue.length != 20) {
                                        input.value = pastedValue.substring(0, 5); 

                                        if(blockIndex < 4) {
                                            var nextBlock = document.getElementsByName("rkBlock" + (blockIndex + 1))[0];
                                            nextBlock.focus(); 
                                        }
                                        
                                        return; 
                                    }

                                    var inputs = document.getElementsByClassName("inputBoxRk");
                                    var remainingChars = pastedValue.length;
                                    var startIndex = Array.from(inputs).indexOf(input); 
                                
                                    for (var i = startIndex; i < inputs.length && remainingChars > 0; i++) {
                                        var charsToFill = Math.min(remainingChars, 5);
                                        inputs[i].value = pastedValue.substring(pastedValue.length - remainingChars, pastedValue.length - remainingChars + charsToFill);
                                        remainingChars -= charsToFill;
                                    }
                                }

                                function handleBackspace(input, blockIndex) {
                                    var pastedValue = input.value.replace(/-/g, '').trim().toUpperCase(); 

                                    if (!pastedValue) {
                                        if (blockIndex > 1) {
                                            var previousBlock = document.getElementsByName("rkBlock" + (blockIndex - 1))[0];
                                            previousBlock.focus(); r
                                        }
                                        return; 
                                    }
                                }

                                </script>

                            </tbody>
                        </table>
                    </div>
                </td>
            </tr>
            </tbody>
        </table>
    </div>
    <br>
    <table style="width:100%;">
        <tbody>
        <tr align="center" valign="top">
            <td>
                <div class="BigButton" style="background-image:url({{ asset('/assets/tibiarl/images/buttons/sbutton.gif') }})">
                    <div onmouseover="MouseOverBigButton(this);" onmouseout="MouseOutBigButton(this);"><div class="BigButtonOver" style="background-image:url({{ asset('/assets/tibiarl/images/buttons/sbutton_over.gif') }});"></div>
                        <input class="BigButtonText" type="submit" value="Submit">
                    </div>
                </div>
            </td>
            <td>
                <div class="BigButton" onclick="RedirectToUrl('{{ route('account.index') }}');" style="background-image:url({{ asset('/assets/tibiarl/images/buttons/sbutton.gif') }})">
                    <div onmouseover="MouseOverBigButton(this);" onmouseout="MouseOutBigButton(this);"><div class="BigButtonOver" style="background-image:url({{ asset('/assets/tibiarl/images/buttons/sbutton_over.gif') }});"></div>
                        <input class="BigButtonText" type="submit" value="Back">
                    </div>
                </div>
            </td>
        </tr>
        </tbody>
    </table>
</form>

@else

<form method="post" action="{{ route('account.email.confirmation.change.action') }}" class="form">
    @csrf
    <div class="TableContainer">
        <div class="CaptionContainer">
            <div class="CaptionInnerContainer">
                <span class="CaptionEdgeLeftTop" style="background-image:url({{ asset('/assets/tibiarl/images/content/box-frame-edge.gif') }});"></span>
                <span class="CaptionEdgeRightTop" style="background-image:url({{ asset('/assets/tibiarl/images/content/box-frame-edge.gif') }});"></span>
                <span class="CaptionBorderTop" style="background-image:url({{ asset('/assets/tibiarl/images/content/table-headline-border.gif') }});"></span>
                <span class="CaptionVerticalLeft" style="background-image:url({{ asset('/assets/tibiarl/images/content/box-frame-vertical.gif') }});"></span>
                <div class="Text">Confirmation Email Sent</div>
                <span class="CaptionVerticalRight" style="background-image:url({{ asset('/assets/tibiarl/images/content/box-frame-vertical.gif') }});"></span>
                <span class="CaptionBorderBottom" style="background-image:url({{ asset('/assets/tibiarl/images/content/table-headline-border.gif') }});"></span>
                <span class="CaptionEdgeLeftBottom" style="background-image:url({{ asset('/assets/tibiarl/images/content/box-frame-edge.gif') }});"></span>
                <span class="CaptionEdgeRightBottom" style="background-image:url({{ asset('/assets/tibiarl/images/content/box-frame-edge.gif') }});"></span>
            </div>
        </div>
        <table class="Table1" cellpadding="0" cellspacing="0">
            <tbody>
            <tr>
                <td>
                    <div class="InnerTableContainer" style="max-width: unset;">
                        <table style="width:100%;">
                            <tbody>
                                <tr>
                                    <td class="LabelV"><span>New Email Address:</span></td>
                                    <td><input name="email" value="" size="30" maxlength="50"></td>
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
    <table style="width:100%;">
        <tbody>
        <tr align="center" valign="top">
            <td>
                <div class="BigButton" style="background-image:url({{ asset('/assets/tibiarl/images/buttons/sbutton.gif') }})">
                    <div onmouseover="MouseOverBigButton(this);" onmouseout="MouseOutBigButton(this);"><div class="BigButtonOver" style="background-image:url({{ asset('/assets/tibiarl/images/buttons/sbutton_over.gif') }});"></div>
                        <input class="BigButtonText" type="submit" value="Submit">
                    </div>
                </div>
            </td>
            <td>
                <div class="BigButton" onclick="RedirectToUrl('{{ route('account.index') }}');" style="background-image:url({{ asset('/assets/tibiarl/images/buttons/sbutton.gif') }})">
                    <div onmouseover="MouseOverBigButton(this);" onmouseout="MouseOutBigButton(this);"><div class="BigButtonOver" style="background-image:url({{ asset('/assets/tibiarl/images/buttons/sbutton_over.gif') }});"></div>
                        <input class="BigButtonText" type="submit" value="Back">
                    </div>
                </div>
            </td>
        </tr>
        </tbody>
    </table>
</form>

@endif

@endsection
