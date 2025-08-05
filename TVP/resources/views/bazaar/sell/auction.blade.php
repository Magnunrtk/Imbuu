{{-- 
* @description Char-Bazaar - Venda de personagenssolid
* @author Rickson Kauê
* @date Data de criação 05/12/2023
* @version 1.0
* @copyright (c) Ravenor
* @email ricksonkaue04@gmail.com
--}}

@extends('template.layout')
@section('title', 'Char Bazaar')
@section('submenuItem', 'sellCharacters')
@section('content')

    {!! $formaters->progressBar([[2, 0], [0, 0], [0, 0], [1, 2]], 2) !!}
        
    <br>

    <div class="TableContainer">
    <div class="CaptionContainer">
        <div class="CaptionInnerContainer"> <span class="CaptionEdgeLeftTop" style="background-image:url(/assets/tibiarl/images/content/box-frame-edge.gif);"></span> <span class="CaptionEdgeRightTop" style="background-image:url(/assets/tibiarl/images/content/box-frame-edge.gif);"></span> <span class="CaptionBorderTop" style="background-image:url(/assets/tibiarl/images/content/table-headline-border.gif);"></span> <span class="CaptionVerticalLeft" style="background-image:url(/assets/tibiarl/images/content/box-frame-vertical.gif);"></span>
        <div class="Text">Set up auction (3/4)</div>
        <span class="CaptionVerticalRight" style="background-image:url(/assets/tibiarl/images/content/box-frame-vertical.gif);"></span> <span class="CaptionBorderBottom" style="background-image:url(/assets/tibiarl/images/content/table-headline-border.gif);"></span> <span class="CaptionEdgeLeftBottom" style="background-image:url(/assets/tibiarl/images/content/box-frame-edge.gif);"></span> <span class="CaptionEdgeRightBottom" style="background-image:url(/assets/tibiarl/images/content/box-frame-edge.gif);"></span> </div>
    </div>
    <table class="Table5" cellspacing="0" cellpadding="0">
        <tbody>
        <tr>
            <td><div class="InnerTableContainer">
                <table style="width:100%;">
                <tbody>
                    <tr>
                        <td><div class="TableContentContainer">
                            <table class="TableContent" style="border:1px solid #faf0d7;" width="100%">
                                <tbody>
                                    <tr>
                                        <td>
                                            <div class="AuctionHeader" style="padding: 5px">
                                                <div class="AuctionCharacterName">
                                                    <b>{{ $_POST["auction_character"] }}</b>
                                                </div>
                                                <div style="padding: 2px"></div>
                                                Level: {{ $playerData["level"] }} | Vocation: {{ $playerData["vocation"] }} | {{ $playerData["sex"] }}<br>
                                            </div>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                            </div>
                        </td>
                    </tr>
                    
    <tr>
    <td><table style="width: 100%;" cellspacing="0" cellpadding="0">
        <tbody>
            <tr>
            <td style="vertical-align:top;width:210px;;"><div class="TableContentContainer">
                <table class="TableContent" style="border:1px solid #faf0d7;" width="100%">
                    <tbody>
                        <tr class="Odd">
                            <td>
                                <span class="LabelV">Health:</span>
                                <div style="float:right; text-align: right;">
                                    {{ $playerData['health'] }} / {{ $playerData["healthmax"] }}
                                </div>
                            </td>
                        </tr>
                        <tr class="Even">
                            <td>
                                <span class="LabelV">Mana:</span>
                                <div style="float:right; text-align: right;">{{ $playerData['mana'] }} / {{ $playerData['manamax'] }}</div>
                            </td>
                        </tr>
                        <tr class="Odd">
                            <td>
                                <span class="LabelV">Capacity:</span>
                                <div style="float:right; text-align: right;">
                                    {{ $playerData['cap'] }}
                                </div>
                            </td>
                        </tr>
                        {{-- <tr class="Even">
                            <td>
                                <span class="LabelV">Soul:</span>
                                <div style="float:right; text-align: right;">
                                    {{ $playerData['soul'] }}
                                </div>
                            </td>
                        </tr> --}}
                        <tr class="Even">
                            <td>
                                <span class="LabelV">Blessings:</span>
                                <div style="float:right; text-align: right;">
                                    {{ $playerData['blessings'] }}
                                </div>
                            </td>
                        </tr>
                    </tbody>
                </table>
                </div></td>
            <td><div class="TableContentContainer">
                <table class="TableContent" style="border:1px solid #faf0d7;" width="100%">
                    <tbody>
                        <tr class="Odd">
                            <td class="LabelColumn"><b>Axe Fighting</b></td>
                            <td class="LevelColumn">{{ $playerData['skill_axe'] }}</td>
                            <td class="PercentageColumn"><div id="SkillBar" class="PercentageBar" style="width: {{ $playerData['skill_axe_tries'] }}%">
                                <div class="PercentageBarSpacer"></div>
                            </div>
                            <div class="PercentageStringContainer"><span class="PercentageString">{{ $playerData['skill_axe_tries'] }}%</span></div></td>
                        </tr>
                        <tr class="Even">
                            <td class="LabelColumn"><b>Club Fighting</b></td>
                            <td class="LevelColumn">{{ $playerData['skill_club'] }}</td>
                            <td class="PercentageColumn"><div id="SkillBar" class="PercentageBar" style="width: {{ $playerData['skill_club_tries'] }}%">
                                <div class="PercentageBarSpacer"></div>
                            </div>
                            <div class="PercentageStringContainer"><span class="PercentageString">{{ $playerData['skill_club_tries'] }}%</span></div></td>
                        </tr>
                        <tr class="Odd">
                            <td class="LabelColumn"><b>Distance Fighting</b></td>
                            <td class="LevelColumn">{{ $playerData['skill_dist'] }}</td>
                            <td class="PercentageColumn"><div id="SkillBar" class="PercentageBar" style="width: {{ $playerData['skill_dist_tries'] }}%">
                                <div class="PercentageBarSpacer"></div>
                            </div>
                            <div class="PercentageStringContainer"><span class="PercentageString">{{ $playerData['skill_dist_tries'] }} %</span></div></td>
                        </tr>
                        <tr class="Even">
                            <td class="LabelColumn"><b>Fishing</b></td>
                            <td class="LevelColumn">{{ $playerData["skill_fishing"] }}</td>
                            <td class="PercentageColumn"><div id="SkillBar" class="PercentageBar" style="width:{{ $playerData["skill_fishing_tries"] }}%">
                                <div class="PercentageBarSpacer"></div>
                            </div>
                            <div class="PercentageStringContainer"><span class="PercentageString">{{ $playerData["skill_fishing_tries"] }}%</span></div></td>
                        </tr>
                        <tr class="Odd">
                            <td class="LabelColumn"><b>Fist Fighting</b></td>
                            <td class="LevelColumn">{{ $playerData['skill_fist'] }}</td>
                            <td class="PercentageColumn"><div id="SkillBar" class="PercentageBar" style="width: {{ $playerData['skill_fist_tries'] }}%">
                                <div class="PercentageBarSpacer"></div>
                            </div>
                            <div class="PercentageStringContainer"><span class="PercentageString">{{ $playerData["skill_fist_tries"] }}%</span></div></td>
                        </tr>
                        <tr class="Even">
                            <td class="LabelColumn"><b>Magic Level</b></td>
                            <td class="LevelColumn">{{ $playerData["maglevel"] }}</td>
                            <td class="PercentageColumn"><div id="SkillBar" class="PercentageBar" style="width: {{ $playerData["maglevel"] }}<>%">
                                <div class="PercentageBarSpacer"></div>
                            </div>
                            <div class="PercentageStringContainer"><span class="PercentageString">{{ $playerData["maglevel"] }}%</span></div></td>
                        </tr>
                        <tr class="Odd">
                            <td class="LabelColumn"><b>Shielding</b></td>
                            <td class="LevelColumn">{{ $playerData["skill_shielding"] }}</td>
                            <td class="PercentageColumn"><div id="SkillBar" class="PercentageBar" style="width: {{ $playerData["skill_shielding_tries"] }}>%">
                                <div class="PercentageBarSpacer"></div>
                            </div>
                            <div class="PercentageStringContainer"><span class="PercentageString"></span>{{ $playerData["skill_shielding_tries"] }}%</span></div></td>
                        </tr>
                        <tr class="Even">
                            <td class="LabelColumn"><b>Sword Fighting</b></td>
                            <td class="LevelColumn">{{ $playerData["skill_sword"] }}</td>
                            <td class="PercentageColumn"><div id="SkillBar" class="PercentageBar" style="width: {{ $playerData["skill_sword_tries"] }}%">
                                <div class="PercentageBarSpacer"></div>
                            </div>
                            <div class="PercentageStringContainer"><span class="PercentageString">{{ $playerData["skill_sword_tries"] }}%</span></div></td>
                        </tr>
                    </tbody>
                </table>
                </div></td>
            </tr>
        </tbody>
        </table></td>
    </tr>
    <tr>
    <td><div class="TableContentContainer">
        <table class="TableContent" style="border:1px solid #faf0d7;" width="100%">
            <tbody>
                <tr class="Odd">
                    <td><span class="LabelV">Creation Date:</span>
                        <div style="float:right; text-align: right;">{{ $playerData['created'] }}</div>
                    </td>
                </tr>
                <tr class="Even">
                    <td><span class="LabelV">Experience:</span>
                    <div style="float:right; text-align: right;">{{ $playerData['experience'] }}</div></td>
                </tr> 
            </tbody>
        </table>
        </div></td>
    </tr>

    <form id="formSend" method="POST" action="{{ route('account.bazaar.auction_confirm.post')}}">
        @csrf
    <input type="hidden" name="auction_character" value="{{ $_POST['auction_character'] }}">
    <tr>
    <td><div class="TableContentContainer">
        <table class="TableContent" style="border:1px solid #faf0d7;" width="100%">
            <tbody>
            <tr>
                <td><table style="width:100%;">
                    <tbody>
                        <tr>
                            <td style="vertical-align:middle" class="LabelV150">Price:</td>
                            <td class="GreedyCell">
                                <input id="auctionPrice" style="width: 100%;" name="auctionPrice" type="number" min="1" max="10000" placeholder="In Ravenor Coins" size="29" maxlength="29" autofocus oninput="this.value = this.value.replace(/[.,]/g, '');" required>
                            </td>
                        </tr>
                        <tr>
                            <td style="vertical-align:middle" class="LabelV150">Recovery Key:</td>
                            <td class="GreedyCell">
                                <div style="display: flex; height: 20px; gap: 5px">
                                    <input class="inputBoxRk" type="text" name="rkBlock1" oninput="this.value = this.value.toUpperCase(); autoFill(this, 1)" onkeyup="handleBackspace(this, 1)" style="width: 60px" required>
                                    -
                                    <input class="inputBoxRk" type="text" name="rkBlock2" oninput="this.value = this.value.toUpperCase(); autoFill(this, 2)" onkeyup="handleBackspace(this, 2)" style="width: 60px" required>
                                    -
                                    <input class="inputBoxRk" type="text" name="rkBlock3" oninput="this.value = this.value.toUpperCase(); autoFill(this, 3)" onkeyup="handleBackspace(this, 3)" style="width: 60px" required>
                                    -
                                    <input class="inputBoxRk" type="text" name="rkBlock4" oninput="this.value = this.value.toUpperCase(); autoFill(this, 4)" onkeyup="handleBackspace(this, 4)" style="width: 60px" required>
                                    
                                    <label><img src="/images/paste.png" style="width: 25px" onclick="autoFillClipboardText()"></label>       
                                </div>   
                            </td>
                        </tr>
                        <tr>
                            <td style="vertical-align:middle" class="LabelV150">Direct Sale:</td>
                            <td class="GreedyCell">
                                <label class="toggle-switch">
                                    <input id="directSaleCheckbox" name="directSale" type="checkbox" onchange="toggleAuctionPrice()">
                                    <span class="toggle-slider"></span>
                                </label>
                            </td>
                        </tr>
                        {{-- <tr>
                            <td style="vertical-align:middle; text-align: right;" class="LabelV150">Days to end:</td>
                            <td class="GreedyCell">
                                <input style="width: 100%;" name="auctionDays" type="number" placeholder="min 1 day and max 28 days" size="29" maxlength="2" autofocus min="1" max="28" oninput="this.value = this.value.replace(/[.,]/g, '');" required>
                            </td>
                            <td><div id="auction_result"></div></td>
                        </tr> --}}
                    </tbody>
                </table></td>
            </tr>
            </tbody>
        </table>
        </div></td>
    </tr>

                </tbody>
                </table>
            </div></td>
        </tr>
        </tbody>
    </table>
    </div>

    <br>

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
                    <p>
                        For your information about direct selling:
                        <br>
                        <ul>
                            <li>
                                <b>If direct sale is enabled</b>, the character will not be listed on the marketplace.
                            </li>
                            <li>
                                Instead, a code will be generated for access to an exclusive offer with <b>different taxation</b> from the standard rate. However, the buyer will <b>receive the character instantly.</b>
                            </li>
                        </ul>
                    </p>
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
    <table class="InnerTableButtonRow" cellspacing="0" cellpadding="0">
    <tbody>
        <tr>
            <td>
                <div style="float: left;">
                <a href="{{ route('account.bazaar.sell_characters')}}">
                    <div class="BigButton" style="background-image:url(/assets/tibiarl/images/buttons/sbutton.gif)"><div onmouseover="MouseOverBigButton(this);" onmouseout="MouseOutBigButton(this);"><div class="BigButtonOver" style="background-image: url(/assets/tibiarl/images/buttons/sbutton_over.gif); visibility: hidden;"></div><input class="BigButtonText" type="button" value="Back"></div></div>
                </a>
                </div><div style="float: right;">
                <div class="BigButton" style="background-image:url(/assets/tibiarl/images/buttons/sbutton_green.gif)"><div onmouseover="MouseOverBigButton(this);" onmouseout="MouseOutBigButton(this);"><div class="BigButtonOver" style="background-image: url(/assets/tibiarl/images/buttons/sbutton_green_over.gif); visibility: hidden;"></div><input name="auction_submit" class="BigButtonText" type="submit" value="Next"></div></div>
                </div>
            </td>
        </tr>
    </tbody>
    </table>
    </form> 
    
    <style>

        .toggle-switch {
            position: relative;
            display: inline-block;
            width: 40px; 
            height: 20px; 
        }

        .toggle-switch input {
            opacity: 0;
            width: 0;
            height: 0;
        }

        .toggle-slider {
            position: absolute;
            cursor: pointer;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background-color: #ccc;
            transition: .4s;
            border-radius: 20px; 
        }

        .toggle-slider:before {
            position: absolute;
            content: "";
            height: 16px; 
            width: 16px;
            left: 2px;
            bottom: 2px; 
            background-color: white;
            transition: .4s;
            border-radius: 50%; 
        }

        input:checked + .toggle-slider {
            background-color: #2196F3;
        }

        input:checked + .toggle-slider:before {
            transform: translateX(20px);
        }
    </style>

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

        const directSaleCheckbox = document.getElementById('directSaleCheckbox');
        const auctionPriceInput = document.getElementById('auctionPrice');

        function toggleAuctionPrice() {

            auctionPriceInput.value = 1;

            if (directSaleCheckbox.checked) {
                auctionPriceInput.parentElement.style.display = 'none';
            } else {
                auctionPriceInput.parentElement.style.display = 'block';
            }
        }

        document.addEventListener('DOMContentLoaded', (event) => {
            setTimeout(() => {
                document.getElementById('formSend').reset();
            }, 100);
        });

    </script>

@endsection
