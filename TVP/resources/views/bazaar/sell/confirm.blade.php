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

    {!! $formaters->progressBar([[2, 0], [0, 0], [0, 0], [0, 0]], 0) !!}

    <br>
    <div class="TableContainer">
        <div class="CaptionContainer">
          <div class="CaptionInnerContainer"> <span class="CaptionEdgeLeftTop" style="background-image:url(/assets/tibiarl/images/content/box-frame-edge.gif);"></span> <span class="CaptionEdgeRightTop" style="background-image:url(/assets/tibiarl/images/content/box-frame-edge.gif);"></span> <span class="CaptionBorderTop" style="background-image:url(/assets/tibiarl/images/content/table-headline-border.gif);"></span> <span class="CaptionVerticalLeft" style="background-image:url(/assets/tibiarl/images/content/box-frame-vertical.gif);"></span>
            <div class="Text">Confirm Auction (4/4)</div>
            <span class="CaptionVerticalRight" style="background-image:url(/assets/tibiarl/images/content/box-frame-vertical.gif);"></span> <span class="CaptionBorderBottom" style="background-image:url(/assets/tibiarl/images/content/table-headline-border.gif);"></span> <span class="CaptionEdgeLeftBottom" style="background-image:url(/assets/tibiarl/images/content/box-frame-edge.gif);"></span> <span class="CaptionEdgeRightBottom" style="background-image:url(/assets/tibiarl/images/content/box-frame-edge.gif);"></span> </div>
        </div>
        <table class="Table3" cellspacing="0" cellpadding="0">
          <tbody>
            <tr>		  
                <td><div class="InnerTableContainer">
                  <table style="width:100%;">
                    <tbody>
                      <tr>
                        <td><div class="TableContentContainer">
                            <table class="TableContent" style="border:1px solid #faf0d7;" width="100%">
                              <tbody>
                                {{-- <tr>
                                  <td style="font-weight:bold;">Auction total days: </td>
                                  <td style="font-weight:normal;">{{ $_POST['auctionDays'] }} days</td>
                                </tr> --}}
                                <tr>
                                  <td style="font-weight:bold;">Start auction: </td>
                                  <td style="font-weight:normal;">{{ date('d M Y') }}</td>
                                </tr>
                                {{-- <tr>
                                  <td style="font-weight:bold;">End auction: </td>
                                  <td style="font-weight:normal;"><?php echo $auction_end ?></td>
                                </tr>--}}
                                <tr>
                                    <td style="font-weight:bold;">Auction Start Price: </td>
                                    <td style="font-weight:normal;">
                                        {{ $_POST['auctionPrice'] }} Ravenor Coins
                                    </td>
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
    <div class="TableContainer">
    <div class="CaptionContainer">
        <div class="CaptionInnerContainer"> <span class="CaptionEdgeLeftTop" style="background-image:url(/assets/tibiarl/images/content/box-frame-edge.gif);"></span> <span class="CaptionEdgeRightTop" style="background-image:url(/assets/tibiarl/images/content/box-frame-edge.gif);"></span> <span class="CaptionBorderTop" style="background-image:url(/assets/tibiarl/images/content/table-headline-border.gif);"></span> <span class="CaptionVerticalLeft" style="background-image:url(/assets/tibiarl/images/content/box-frame-vertical.gif);"></span>
        <div class="Text">Select character</div>
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
    {{-- <input type="hidden" name="auction_character" value="<?php echo $getCharacter['id']; ?>"> --}}

                </tbody>
                </table>
            </div></td>
        </tr>
        </tbody>
    </table>
    </div>
    <br>

    @if(request("directSale") == "on")
        @php
            $warMsg = "Attention direct sale is active."; 
            echo $formaters->small_box($warMsg);
        @endphp
    @endif

    <br>
    <table class="InnerTableButtonRow" cellspacing="0" cellpadding="0">
        <tbody>
            <tr>
                <td>
                    <form id="resetForm" method="post"  action="{{ route('account.bazaar.myAuctions.post')}}">
                        @csrf
                        <input type="text" name="auction_character" value="{{ $_POST["auction_character"] }}" hidden>
                        {{-- <input type="number" name="auctionDays" value="{{ $_POST["auctionDays"] }}" hidden> --}}
                        <input type="number" name="auctionPrice" value="{{ $_POST["auctionPrice"] }}" hidden>
                        <div style="float: left;">
                            <a href="{{ route('account.bazaar.sell_characters')}}">
                                <div class="BigButton" style="background-image:url(/assets/tibiarl/images/buttons/sbutton.gif)"><div onmouseover="MouseOverBigButton(this);" onmouseout="MouseOutBigButton(this);"><div class="BigButtonOver" style="background-image: url(/assets/tibiarl/images/buttons/sbutton_over.gif); visibility: hidden;"></div><input class="BigButtonText" type="button" value="Back"></div></div>
                            </a>
                        </div>
                        <div style="float: right;">
                            <div class="BigButton" style="background-image:url(/assets/tibiarl/images/buttons/sbutton_green.gif)"><div onmouseover="MouseOverBigButton(this);" onmouseout="MouseOutBigButton(this);"><div class="BigButtonOver" style="background-image: url(/assets/tibiarl/images/buttons/sbutton_green_over.gif); visibility: hidden;"></div><input name="auction_submit" class="BigButtonText" type="submit" value="Next"></div></div>
                        </div>

                        @if(request("directSale") == "on")
                            <input name="directSale" value="1" type="number" hidden>
                        @else
                            <input name="directSale" value="0" type="number" hidden>
                        @endif
                    </form>
                </td>
            </tr>
        </tbody>
    </table> 
@endsection
