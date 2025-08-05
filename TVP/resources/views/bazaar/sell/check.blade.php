{{-- 
* @description Char-Bazaar - Venda de personagens
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

    {!! $formaters->progressBar([[2, 0], [0, 0], [1, 2], [2, 2]], 2) !!}

    <form method="post"  action="{{ route('account.bazaar.auction_characters.post')}}">
        @csrf
        <input type="hidden" name="auction_character" value="{{ $_POST["auction_character"] }}">
        <div class="TableContainer">
            <div class="CaptionContainer">
                <div class="CaptionInnerContainer"> <span class="CaptionEdgeLeftTop" style="background-image:url(/assets/tibiarl/images/content/box-frame-edge.gif);"></span> <span class="CaptionEdgeRightTop" style="background-image:url(/assets/tibiarl/images/content/box-frame-edge.gif);"></span> <span class="CaptionBorderTop" style="background-image:url(/assets/tibiarl/images/content/table-headline-border.gif);"></span> <span class="CaptionVerticalLeft" style="background-image:url(/assets/tibiarl/images/content/box-frame-vertical.gif);"></span>
                    <div class="Text">Requirements (2/4)</div>
                    <span class="CaptionVerticalRight" style="background-image:url(/assets/tibiarl/images/content/box-frame-vertical.gif);"></span> <span class="CaptionBorderBottom" style="background-image:url(/assets/tibiarl/images/content/table-headline-border.gif);"></span> <span class="CaptionEdgeLeftBottom" style="background-image:url(/assets/tibiarl/images/content/box-frame-edge.gif);"></span> <span class="CaptionEdgeRightBottom" style="background-image:url(/assets/tibiarl/images/content/box-frame-edge.gif);"></span> 
                </div>
            </div>
            <table class="Table3" cellspacing="0" cellpadding="0">
                <tbody>
                    <tr>
                        <td>
                            <div class="InnerTableContainer">
                                <table style="width:100%;">
                                    <tbody>
                                        <tr>
                                            <td>
                                                <table style="width:100%;">
                                                    <tbody>
                                                        <tr>
                                                            <td>
                                                                <div class="TableContentContainer">
                                                                    <table class="TableContent" style="border:1px solid #faf0d7;" width="100%">
                                                                        <tbody>
                                                                            <tbody>
                                                                                <tr>
                                                                                    <td style="vertical-align: middle;">
                                                                                        <img src="{{ $icons[$playerData["key"]] }}">
                                                                                    </td>
                                                                                    <td>
                                                                                        Your account must have a recovery key.
                                                                                    </td>
                                                                                </tr>
                                                                                <tr>
                                                                                    <td style="vertical-align: middle;">
                                                                                        <img src="{{ $icons[$playerData["level"]] }}">
                                                                                    </td>
                                                                                    <td>
                                                                                        The character needs to be al least level 8.
                                                                                    </td>
                                                                                </tr>
                                                                                <tr>
                                                                                    <td style="vertical-align: middle;">
                                                                                        <img src="{{ $icons[$playerData["house"]] }}">
                                                                                    </td>
                                                                                    <td>
                                                                                        The character may not own any houses.
                                                                                    </td>
                                                                                </tr>
                                                                                <tr>
                                                                                    <td style="vertical-align: middle;">
                                                                                        <img src="{{ $icons[$playerData["house"]] }}">
                                                                                    </td>
                                                                                    <td>
                                                                                        The character may not bid for a house.
                                                                                    </td>
                                                                                </tr>
                                                                                <tr>
                                                                                    <td style="vertical-align: middle;">
                                                                                        <img src="{{ $icons[$playerData["house"]] }}">
                                                                                    </td>
                                                                                    <td>
                                                                                        The character may not be involved in a house transfer.
                                                                                    </td>
                                                                                </tr>
                                                                                <tr>
                                                                                    <td style="vertical-align: middle;">
                                                                                        <img src="{{ $icons[$playerData["guildGroup"]] }}">
                                                                                    </td>
                                                                                    <td>
                                                                                        The character may not be a member of a guild.
                                                                                    </td>
                                                                                </tr>
                                                                                <tr>
                                                                                    <td style="vertical-align: middle;">
                                                                                        <img src="{{ $icons[$playerData["guildApply"]] }}">
                                                                                    </td>
                                                                                    <td>
                                                                                        The character may not have applied to a guild.
                                                                                    </td>
                                                                                </tr>
                                                                                <tr>
                                                                                    <td style="vertical-align: middle;">
                                                                                        <img src="{{ $icons[$playerData["online"]] }}">
                                                                                    </td>
                                                                                    <td>
                                                                                        The character needs to be offline.
                                                                                    </td>
                                                                                </tr>
                                                                                <tr>
                                                                                    <td style="vertical-align: middle;">
                                                                                        <img src="{{ $icons[$playerData["ban"]] }}">
                                                                                    </td>
                                                                                    <td>
                                                                                        The account cannot be banned. 
                                                                                    </td>
                                                                                </tr>
                                                                        </tbody>
                                                                    </table>
                                                                </div>
                                                            </td>
                                                        </tr>
                                                    </tbody>
                                                </table>
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
        <table class="InnerTableButtonRow" cellspacing="0" cellpadding="0">
            <tbody>
                <tr>
                    <td>
                        <div style="float: left;">
                            <a href="{{ route('account.bazaar.sell_characters')}}">
                                <div class="BigButton" style="background-image:url(/assets/tibiarl/images/buttons/sbutton.gif)"><div onmouseover="MouseOverBigButton(this);" onmouseout="MouseOutBigButton(this);"><div class="BigButtonOver" style="background-image: url(/assets/tibiarl/images/buttons/sbutton_over.gif); visibility: hidden;"></div><input class="BigButtonText" type="button" value="Back"></div></div>
                            </a>
                          </div>
                        <div style="float: right">
                            @php

                                $next_step = true;

                                foreach ($playerData as $value) { 
                                    if ($value == "no") {
                                        $next_step = false;
                                    }
                                }

                            @endphp
                            @if($next_step)
                                <div class="BigButton" style="background-image:url(/assets/tibiarl/images/buttons/sbutton_green.gif)">
                                    <div onmouseover="MouseOverBigButton(this);" onmouseout="MouseOutBigButton(this);">
                                        <div class="BigButtonOver" style="background-image: url(/assets/tibiarl/images/buttons/sbutton_green_over.gif); visibility: hidden;"></div>
                                        <input name="auction_submit" class="BigButtonText" type="submit" value="Next">
                                    </div>
                                </div>
                            @else
                                <a href="{{ route('account.bazaar.sell_characters')}}">
                                    <div class="BigButton" style="background-image:url(/assets/tibiarl/images/buttons/sbutton_red.gif)">
                                        <div onmouseover="MouseOverBigButton(this);" onmouseout="MouseOutBigButton(this);">
                                            <div class="BigButtonOver" style="background-image: url(/assets/tibiarl/images/buttons/sbutton_red_over.gif); visibility: hidden;"></div>
                                            <input name="auction_submit" class="BigButtonText" type="button" value="Back / Error">
                                        </div>
                                    </div>
                                </a>
                            @endif
                        </div>
                    </td>
                </tr>
            </tbody>
        </table>
    </form>
    
@endsection
