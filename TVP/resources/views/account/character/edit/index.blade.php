@extends('template.layout')
@section('title', 'Account Management')
@section('submenuItem', 'accountmanagement')
@section('content')

    <div class="SmallBox">
        <div class="MessageContainer">
        <div class="BoxFrameHorizontal" style="background-image:url(/assets/tibiarl/images/content/box-frame-horizontal.gif);"></div>
        <div class="BoxFrameEdgeLeftTop" style="background-image:url(/assets/tibiarl/images/content/box-frame-edge.gif);"></div>
        <div class="BoxFrameEdgeRightTop" style="background-image:url(/assets/tibiarl/images/content/box-frame-edge.gif);"></div>
        <div class="Message">
            <div class="BoxFrameVerticalLeft" style="background-image:url(/assets/tibiarl/images/content/box-frame-vertical.gif);"></div>
            <div class="BoxFrameVerticalRight" style="background-image:url(/assets/tibiarl/images/content/box-frame-vertical.gif);"></div>
            <table class="HintBox">
            <tbody>
                <tr>
                    <td>
                        @if($nameLockExists)
                            This name violates the naming rules so the change will cost <b>0 ravenor coins.</b><br>
                        @else
                            Here you can change your character's name. <br> This change will cost <b>100 ravenor coins.</b><br>        
                        @endif

                        <br>
                    
                        <p>After changing your name, please note there will be a <b>30-day lock</b> period for further changes. <br>You can search for your old and new names here, both will lead to <br>the character profile: <a href="/community/view/character">Search Character.</a></p>
                    </td>
                </tr>
            </tbody>
            </table>
        </div>
        <div class="BoxFrameHorizontal" style="background-image:url(/assets/tibiarl/images/content/box-frame-horizontal.gif);"></div>
        <div class="BoxFrameEdgeRightBottom" style="background-image:url(/assets/tibiarl/images/content/box-frame-edge.gif);"></div>
        <div class="BoxFrameEdgeLeftBottom" style="background-image:url(/assets/tibiarl/images/content/box-frame-edge.gif);"></div>
        </div>
    </div>

    <br>
    <form action="{{ route('account.character.edit.action', Str::strToUrl($player->name)) }}" method="post" class="form">
        @csrf
        <div class="TableContainer">
            <div class="CaptionContainer">
                <div class="CaptionInnerContainer">
                    <span class="CaptionEdgeLeftTop" style="background-image:url(https://static.tibia.com/images/global/content/box-frame-edge.gif);"></span>
                    <span class="CaptionEdgeRightTop" style="background-image:url(https://static.tibia.com/images/global/content/box-frame-edge.gif);"></span>
                    <span class="CaptionBorderTop" style="background-image:url(https://static.tibia.com/images/global/content/table-headline-border.gif);"></span>
                    <span class="CaptionVerticalLeft" style="background-image:url(https://static.tibia.com/images/global/content/box-frame-vertical.gif);"></span>
                    <div class="Text">Character Data</div>
                    <span class="CaptionVerticalRight" style="background-image:url(https://static.tibia.com/images/global/content/box-frame-vertical.gif);"></span>
                    <span class="CaptionBorderBottom" style="background-image:url(https://static.tibia.com/images/global/content/table-headline-border.gif);"></span>
                    <span class="CaptionEdgeLeftBottom" style="background-image:url(https://static.tibia.com/images/global/content/box-frame-edge.gif);"></span>
                    <span class="CaptionEdgeRightBottom" style="background-image:url(https://static.tibia.com/images/global/content/box-frame-edge.gif);"></span>
                </div>
            </div>
            <table class="Table3" cellpadding="0" cellspacing="0">
                <tbody>
                    <tr>
                        <td>
                            <div class="TableScrollbarWrapper" style="width: unset;">
                                <div class="TableScrollbarContainer"></div>
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
                                                                <td class="LabelV200" style="vertical-align:middle;">Current Name:</td>
                                                                <td>{{ $player->name }}</td>
                                                            </tr>
                                                            <tr>
                                                                <td class="LabelV200" style="vertical-align:middle;">New Name:</td>
                                                                <td>
                                                                    <input type="text" name="new_name" id="new_name" maxlength="15" value="">
                                                                    <label>(15) Max</label>
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
        <br>
        <table style="width:100%">
            <tbody>
                <tr align="center">
                    <td>
                        <table border="0" cellspacing="0" cellpadding="0">
                            <tbody>
                                <tr>
                                    <td style="border:0px;">
                                        <div class="BigButton" style="background-image:url({{ asset('/assets/tibiarl/images/buttons/sbutton.gif') }})">
                                            <div onmouseover="MouseOverBigButton(this);" onmouseout="MouseOutBigButton(this);">
                                                <div class="BigButtonOver" style="background-image:url({{ asset('/assets/tibiarl/images/buttons/sbutton_over.gif') }});"></div>
                                                <input class="BigButtonText" type="submit" value="Submit">
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </td>
                    <td>
                        <table border="0" cellspacing="0" cellpadding="0">
                            <tbody>
                                <tr>
                                    <td style="border:0px;">
                                        <div class="BigButton" onclick="RedirectToUrl('{{ route('account.index') }}');" style="background-image:url({{ asset('/assets/tibiarl/images/buttons/sbutton.gif') }})">
                                            <div onmouseover="MouseOverBigButton(this);" onmouseout="MouseOutBigButton(this);">
                                                <div class="BigButtonOver" style="background-image:url({{ asset('/assets/tibiarl/images/buttons/sbutton_over.gif') }});"></div>
                                                <input class="BigButtonText" type="button" value="Back">
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </td>
                </tr>
            </tbody>
        </table>
    </form>

    <script>
        function validateForm() {
            const input = document.getElementById('new_name');
            const regex = /^[a-zA-Z]+[a-zA-Z' ]{0,14}$/;
            if (!regex.test(input.value)) {
                alert("Invalid character name. The name must start with a letter, can include one space or apostrophe, and be up to 15 characters long.");
                return false;
            }
            if (input.value.includes("  ") || input.value.startsWith("'") || input.value.endsWith("'")) {
                alert("Invalid character name. Please follow the naming rules.");
                return false;
            }
            return true;
        }
        
        document.getElementById('new_name').addEventListener('input', function() {
            const input = this;
            input.value = input.value.replace(/^\s/, ''); // Remove leading spaces
            input.value = input.value.replace(/^[']/, ''); // Remove leading apostrophes
            input.value = input.value.replace(/[^a-zA-Z' ]/g, ''); // Allow only a-z, A-Z, ', and space

            // Ensure only one apostrophe
            const apostrophes = input.value.match(/'/g);
            if (apostrophes && apostrophes.length > 1) {
                input.value = input.value.replace(/'/g, (match, offset) => (offset === input.value.indexOf("'") ? "'" : ""));
            }

            // Ensure only one space
            const spaces = input.value.match(/ /g);
            if (spaces && spaces.length > 1) {
                input.value = input.value.replace(/ /g, (match, offset) => (offset === input.value.indexOf(" ") ? " " : ""));
            }

            input.value = input.value.replace(/''/g, "'"); // Prevent two consecutive apostrophes
            input.value = input.value.replace(/  /g, ' '); // Prevent two consecutive spaces

            if (input.value.length > 0) {
                input.value = input.value.charAt(0).toUpperCase() + input.value.slice(1);
            }
        });

    </script>

@endsection
