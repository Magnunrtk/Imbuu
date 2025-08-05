@extends('template.layout')
@section('title', 'Houses')
@section('submenuItem', 'houses')
@section('content')
    Here you can see the list of all available houses, flats or guildhalls. Please select the game world of your choice. Click on any view button to get more information about a house or adjust the search criteria and start a new search. <br>
    <br>
    <br>
    <div class="TableContainer">
        <div class="CaptionContainer">
            <div class="CaptionInnerContainer">
                <span class="CaptionEdgeLeftTop" style="background-image:url({{ asset('/assets/tibiarl/images/content/box-frame-edge.gif') }});"></span>
                <span class="CaptionEdgeRightTop" style="background-image:url({{ asset('/assets/tibiarl/images/content/box-frame-edge.gif') }});"></span>
                <span class="CaptionBorderTop" style="background-image:url({{ asset('/assets/tibiarl/images/content/table-headline-border.gif') }});"></span>
                <span class="CaptionVerticalLeft" style="background-image:url({{ asset('/assets/tibiarl/images/content/box-frame-vertical.gif') }});"></span>
                <div class="Text">Available Houses and Flats in {{ $town['name'] }} on {{ \App\Utils\World::getCurrentWorld()['name'] }}</div>
                <span class="CaptionVerticalRight" style="background-image:url({{ asset('/assets/tibiarl/images/content/box-frame-vertical.gif') }});"></span>
                <span class="CaptionBorderBottom" style="background-image:url({{ asset('/assets/tibiarl/images/content/table-headline-border.gif') }});"></span>
                <span class="CaptionEdgeLeftBottom" style="background-image:url({{ asset('/assets/tibiarl/images/content/box-frame-edge.gif') }});"></span>
                <span class="CaptionEdgeRightBottom" style="background-image:url({{ asset('/assets/tibiarl/images/content/box-frame-edge.gif') }});"></span>
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
                                            <tr class="LabelH">
                                                <td style="width: 40%;">
                                                    <b>Name</b>
                                                </td>
                                                <td style="width: 10%;">
                                                    <b>Size</b>
                                                </td>
                                                <td style="width: 10%;">
                                                    <b>Rent</b>
                                                </td>
                                                <td style="width: 40%;">
                                                    <b>Status</b>
                                                </td>
                                                <td></td>
                                            </tr>
                                            @foreach($houseList as $house)
                                                @php
                                                    $rowClass = $loop->index % 2 == 0 ? 'Even' : 'Odd';
                                                @endphp
                                                <tr class="{{ $rowClass }}">
                                                    <td width="40%">
                                                        <nobr>{{ $house->name }}</nobr>
                                                    </td>
                                                    <td width="10%">
                                                        <nobr>{{ $house->size }}&nbsp;sqm</nobr>
                                                    </td>
                                                    <td width="10%">
                                                        <nobr>{{ \App\Utils\FormatNumber::properConvert($house->rent) }}&nbsp;gold</nobr>
                                                    </td>
                                                    <td width="40%">
                                                    @if($house->owner === 0)
                                                        @if($house->bid_end === 0)
                                                            <nobr>auctioned (no bid yet)</nobr>
                                                        @else
                                                            <nobr>auctioned ({{ \App\Utils\FormatNumber::properConvert($house->last_bid) }} gold; {{ Carbon\Carbon::now()->startOfDay()->diffInDays(Carbon\Carbon::createFromTimestamp($house->bid_end)) }} days left)</nobr>
                                                        @endif
                                                    @else
                                                        <nobr>rented</nobr>
                                                    @endif
                                                    <td>
                                                        <div class="BigButton" onclick="RedirectToUrl('{{ route('community.view.house.index', [$house->id]) }}');" style="background-image:url({{ asset('/assets/tibiarl/images/buttons/sbutton.gif') }})">
                                                            <div onmouseover="MouseOverBigButton(this);" onmouseout="MouseOutBigButton(this);"><div class="BigButtonOver" style="background-image:url({{ asset('/assets/tibiarl/images/buttons/sbutton_over.gif') }});"></div>
                                                                <input class="BigButtonText" type="submit" value="View">
                                                            </div>
                                                        </div>
                                                    </td>
                                                    </td>
                                                </tr>
                                            @endforeach
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
    <br>
    <form action="{{ route('community.houses.loadList') }}" method="POST">
        @csrf
        <div class="TableContainer">
            <div class="CaptionContainer">
                <div class="CaptionInnerContainer">
                    <span class="CaptionEdgeLeftTop" style="background-image:url({{ asset('/assets/tibiarl/images/content/box-frame-edge.gif') }});"></span>
                    <span class="CaptionEdgeRightTop" style="background-image:url({{ asset('/assets/tibiarl/images/content/box-frame-edge.gif') }});"></span>
                    <span class="CaptionBorderTop" style="background-image:url({{ asset('/assets/tibiarl/images/content/table-headline-border.gif') }});"></span>
                    <span class="CaptionVerticalLeft" style="background-image:url({{ asset('/assets/tibiarl/images/content/box-frame-vertical.gif') }});"></span>
                    <div class="Text">House Search</div>
                    <span class="CaptionVerticalRight" style="background-image:url({{ asset('/assets/tibiarl/images/content/box-frame-vertical.gif') }});"></span>
                    <span class="CaptionBorderBottom" style="background-image:url({{ asset('/assets/tibiarl/images/content/table-headline-border.gif') }});"></span>
                    <span class="CaptionEdgeLeftBottom" style="background-image:url({{ asset('/assets/tibiarl/images/content/box-frame-edge.gif') }});"></span>
                    <span class="CaptionEdgeRightBottom" style="background-image:url({{ asset('/assets/tibiarl/images/content/box-frame-edge.gif') }});"></span>
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
                                @if(config('multi_world.enabled'))
                                <tr>
                                    <td>
                                        <div class="TableContentContainer">
                                            <table class="TableContent" width="100%" style="border:1px solid #faf0d7;">
                                                <tbody>
                                                <tr>
                                                    <td>
                                                        <div class="HousesWorldSelection">
                                                            <div class="WorldSelectionLabel">World</div>
                                                            <div class="WorldSelectionDropDown">
                                                                <select size="1" name="world" style="width:165px;">
                                                                    @foreach(config('multi_world.worlds') as $selectWorld)
                                                                        <option value="{{ $selectWorld['slug'] }}" @if($selectWorld['slug'] === $world['slug']) selected="selected" @endif>{{ $selectWorld['name'] }}</option>
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
                                @endif
                                <tr>
                                    <td>
                                        <div class="TableContentContainer">
                                            <table class="TableContent" width="100%" style="border:1px solid #faf0d7;">
                                                <tbody>
                                                <tr class="LabelH">
                                                    <td>
                                                        <b>Town</b>
                                                    </td>
                                                    <td>
                                                        <b>Status</b>
                                                    </td>
                                                    <td>
                                                        <b>Order</b>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td valign="top">
                                                        @foreach(config('towns.town_ids') as $filterableTown)
                                                            @if($filterableTown['filterable'])
                                                                <label>
                                                                    <input type="radio" name="town" value="{{ $filterableTown['slug'] }}" @if($filterableTown['slug'] === $town['slug']) checked="" @endif> {{ $filterableTown['name'] }} </label>
                                                                <br>
                                                            @endif
                                                        @endforeach
                                                    </td>
                                                    <td valign="top">
                                                        <label>
                                                            <input type="radio" name="status" value="all" @if($status === 'all') checked="" @endif> all states </label>
                                                        <br>
                                                        <label>
                                                            <input type="radio" name="status" value="available" @if($status === 'available') checked="" @endif> auctioned </label>
                                                        <br>
                                                        <label>
                                                            <input type="radio" name="status" value="rented" @if($status === 'rented') checked="" @endif> rented </label>
                                                        <br>
                                                    </td>
                                                    <td valign="top">
                                                        <label>
                                                            <input type="radio" name="orderBy" value="name" @if($orderBy === 'name') checked="" @endif> by name </label>
                                                        <br>
                                                        <label>
                                                            <input type="radio" name="orderBy" value="size" @if($orderBy === 'size') checked="" @endif> by size </label>
                                                        <br>
                                                        <label>
                                                            <input type="radio" name="orderBy" value="rent" @if($orderBy === 'rent') checked="" @endif> by rent </label>
                                                        <br>
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
        <center>
            <div class="BigButton" style="background-image:url({{ asset('/assets/tibiarl/images/buttons/sbutton.gif') }})">
                <div onmouseover="MouseOverBigButton(this);" onmouseout="MouseOutBigButton(this);"><div class="BigButtonOver" style="background-image:url({{ asset('/assets/tibiarl/images/buttons/sbutton_over.gif') }});"></div>
                    <input class="BigButtonText" type="submit" value="Submit">
                </div>
            </div>
        </center>
    </form>
@endsection
