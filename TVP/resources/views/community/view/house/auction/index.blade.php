@extends('template.layout')
@section('title', 'House')
@section('submenuItem', 'houses')
@section('content')
    The house <a href="{{ route('community.view.house.index', [$house->id]) }}">{{ $house->name }}</a> is currently being auctioned.
    @if($house->bid_end === 0)
        There is no bid so far.<br>
    @else
        The auction will end at {{ date('M d Y, H:i:s T', $house->bid_end) }} (time of daily server save). The highest bid so far is {{ $house->last_bid }} gold and has been submitted by <a href="{{ route('community.view.character.search', Str::strToUrl($house->highestBidderPlayer->name)) }}">{{ $house->highestBidderPlayer->name }}</a><br>
    @endif
    <br>
    <form action="{{ route('community.view.house.auction.bid.action', [$house->id]) }}" method="post" class="form">
        @csrf
        <div class="TableContainer">
            <div class="CaptionContainer">
                <div class="CaptionInnerContainer">
                    <span class="CaptionEdgeLeftTop" style="background-image:url({{ asset('/assets/tibiarl/images/content/box-frame-edge.gif') }});"></span>
                    <span class="CaptionEdgeRightTop" style="background-image:url({{ asset('/assets/tibiarl/images/content/box-frame-edge.gif') }});"></span>
                    <span class="CaptionBorderTop" style="background-image:url({{ asset('/assets/tibiarl/images/content/table-headline-border.gif') }});"></span>
                    <span class="CaptionVerticalLeft" style="background-image:url({{ asset('/assets/tibiarl/images/content/box-frame-vertical.gif') }});"></span>
                    <div class="Text">Enter Bid</div>
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
                                                    <td class="LabelV100">Your Limit:</td>
                                                    <td>
                                                        <input name="bid" value="0" size="10" maxlength="11">
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td class="LabelV100">Your Character:</td>
                                                    <td>
                                                        <select name="character">
                                                            @forelse(Auth::user()->characters as $character)
                                                                <option value="{{ $character->name }}">{{ $character->name }}</option>
                                                            @empty
                                                                <option>No character available</option>
                                                            @endforelse
                                                        </select>
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
        <br>Bids increase in steps of 1 gold. You will automatically outbid the current bid by 1 gold until your specified limit is reached.<br>
        @if($house->bid_end === 0)
            <br>When the auction ends, the <b>winning bid plus the rent of {{ $house->rent }} gold</b> for the first month will be debited to the depot of <b>{{ \App\Utils\Town::getTownById($house->town_id)['name'] }}</b>.<br>
        @else
            <br>When the auction ends at {{ date('M d Y, H:i:s T', $house->bid_end) }} (time of daily server save), the <b>winning bid plus the rent of {{ $house->rent }} gold</b> for the first month will be debited to the depot of
            <b>{{ \App\Utils\Town::getTownById($house->town_id)['name'] }}</b>.<br>
        @endif
        <br>
        <br>
        <table style="width: 100%;">
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
                    <div class="BigButton" onclick="RedirectToUrl('{{ route('community.view.house.index', $house->id) }}');" style="background-image:url({{ asset('/assets/tibiarl/images/buttons/sbutton.gif') }})">
                        <div onmouseover="MouseOverBigButton(this);" onmouseout="MouseOutBigButton(this);"><div class="BigButtonOver" style="background-image:url({{ asset('/assets/tibiarl/images/buttons/sbutton_over.gif') }});"></div>
                            <input class="BigButtonText" type="submit" value="Back">
                        </div>
                    </div>
                </td>
            </tr>
            </tbody>
        </table>
    </form>
@endsection
