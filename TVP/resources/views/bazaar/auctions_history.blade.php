{{-- 
* @description Char-Bazaar - Venda de personagens
* @author Rickson Kauê
* @date Data de criação 05/12/2023
* @version 1.0
* @copyright (c) Ravenor
* @email ricksonkaue04@gmail.com
--}}

@extends('template.layout')
@section('title', 'Bazaar History')
@section('submenuItem', 'bazaarHistory')
@section('content')

<div class="TableContainer">
    <div class="CaptionContainer">
        <div class="CaptionInnerContainer">
            <span class="CaptionEdgeLeftTop" style="background-image:url(/assets/tibiarl/images/content/box-frame-edge.gif);"></span>
            <span class="CaptionEdgeRightTop" style="background-image:url(/assets/tibiarl/images/content/box-frame-edge.gif);"></span>
            <span class="CaptionBorderTop" style="background-image:url(/assets/tibiarl/images/content/table-headline-border.gif);"></span>
            <span class="CaptionVerticalLeft" style="background-image:url(/assets/tibiarl/images/content/box-frame-vertical.gif);"></span>
            <div class="Text">Bazaar History</div>
            <span class="CaptionVerticalRight" style="background-image:url(/assets/tibiarl/images/content/box-frame-vertical.gif);"></span>
            <span class="CaptionBorderBottom" style="background-image:url(/assets/tibiarl/images/content/table-headline-border.gif);"></span>
            <span class="CaptionEdgeLeftBottom" style="background-image:url(/assets/tibiarl/images/content/box-frame-edge.gif);"></span>
            <span class="CaptionEdgeRightBottom" style="background-image:url(/assets/tibiarl/images/content/box-frame-edge.gif);"></span>
        </div>
    </div>

    <table class="Table3" cellpadding="0" cellspacing="0">
        <tbody>
            <tr>
                <td>
                    <div class="InnerTableContainer">
                        <table style="width:100%;">
                            <tbody>
                                <tr>
                                    <td>
                                        <div class="TableContentContainer">
                                            <table class="TableContent" width="100%" style="border:1px solid #faf0d7;">
                                                <tbody>
                                                    <tr class="Odd">
                                                        <td class="LabelV">Player Name</td>
                                                        <td class="LabelV">Coins</td>
                                                        <td class="LabelV"><b>Method</b></td>
                                                        <td class="LabelV">Date</td>
                                                    </tr>
                                                    
                                                    @if(empty($history) || count($history) == 0)
                                                        <tr class="Even">
                                                            <td colspan="5">No history records found.</td>
                                                        </tr>
                                                    @else
                                                        @foreach($history as $entry)

                                                            @php $playerName = $entry['player_name'] @endphp

                                                            <tr class="{{ $loop->odd ? 'Odd' : 'Even' }}">
                                                                <td>
                                                                    @if($entry['player_name'])
                                                                        <a href="{{ route('community.view.character.search', [Str::strToUrl($playerName)]) }}">{{ $playerName }}</a>
                                                                    @else
                                                                        No register
                                                                    @endif
                                                                </td>
                                                                <td>{{ $entry['coins'] }}</td>
                                                                <td>Market</td>
                                                                <td>{{ \Carbon\Carbon::parse($entry['date'])->format('d/m/Y H:i') }}</td>
                                                            </tr>
                                                        @endforeach
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

@endsection