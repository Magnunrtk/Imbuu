@extends('template.layout')
@section('title', 'Houses')
@section('submenuItem', 'houses')
@section('metaTag')
    <meta property="og:locale" content="en_US" />
    <meta property="og:type" content="article" />
    <meta property="og:title" content="{{ $house->name }} in {{ \App\Utils\Town::getTownById($house->town_id)['name'] }} | {{ config('server.serverName') }}" />
    <meta property="og:description" content="{{ $house->name }} in {{ \App\Utils\Town::getTownById($house->town_id)['name'] }} with a size of {{ $house->size }} sqm and {{ $house->beds }} beds for a rent of {{ $house->rent }} gold coins."/>
    <meta property="og:url" content="{{ config('server.fullServerDomain') }}" />
    <meta property="og:site_name" content="{{ config('server.worlds')[0] }} | House Details" />
    <meta property="og:image" content="{{ config('server.fullServerDomain') }}{{ \App\Http\Controllers\House\HousesListController::houseMainFloorPath($housePreviewArray) }}" />
@endsection
@section('styles')
    <link href="{{ asset('/assets/css/leaflet.css') }}" rel="stylesheet" type="text/css" />
    <style>
        .leaflet-control-layers-toggle {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            padding: 0;
        }
    </style>
@endsection
@section('content')
    <table border="0" cellspacing="1" cellpadding="4">
        <tbody>
        <tr>
            <td valign="top">
                <img src="{{ \App\Http\Controllers\House\HousesListController::houseMainFloorPath($housePreviewArray) }}" width="150" height="150">
            </td>
            <td valign="top">
                <b>{{ $house->name }}</b>
                <br>This house has {{ $house->beds }} beds. <br>
                <br>The house has a size of <b>{{ $house->size }} square meters</b>. The monthly rent is <b>{{ $house->rent }} gold</b> and will be debited to the depot in <b>{{ \App\Utils\Town::getTownById($house->town_id)['name'] }}</b>. <br>
                <br>
                @if($house->owner)
                    The house has been rented by <a href="{{ route('community.view.character.search', Str::strToUrl($house->ownerPlayer->name)) }}">{{ $house->ownerPlayer->name }}</a>. He has paid the rent until <b>{{ date('M d, Y', $house->paid) }}, {{ config('server.serverSaveTime') }} {{ config('server.serverTimeZone') }}</b>.
                    @if($house->moveOut)
                        He will move out on {{ \Carbon\Carbon::parse($house->moveOut->date)->format('M, d, Y') }}, {{ config('server.serverSaveTime') }} {{ config('server.serverTimeZone') }} (time of daily server save) @if($house->moveOut->transfer) and @if($house->moveOut->transfer->accepted) will pass @else wants to pass @endif the house to <a href="{{ route('community.view.character.search', Str::strToUrl($house->moveOut->transfer->player->name)) }}">{{ $house->moveOut->transfer->player->name }}</a> for <b>{{ $house->moveOut->transfer->price }} gold coins.</b> @endif
                    @endif
                @else
                    @if($house->bid === 0)
                        The house is currently being auctioned. No bid has been submitted so far.
                    @else
                        The house is currently being auctioned. The auction will end at {{ date('M d, Y', $house->bid_end) }}, {{ config('server.serverSaveTime') }} {{ config('server.serverTimeZone') }}. The highest bid so far is {{ $house->last_bid }} gold and has been submitted by <a href="{{ route('community.view.character.search', Str::strToUrl($house->highestBidderPlayer->name)) }}">{{ $house->highestBidderPlayer->name }}</a>.
                    @endif
                @endif
            </td>
        </tr>
        </tbody>
    </table>
    <br>
    <div class="SubmitButtonRow">
        @if(Auth::check())
            @if($house->owner)
                @if($house->moveOut && $house->moveOut->transfer && !$house->moveOut->transfer->accepted)
                    @if($house->moveOut->transfer->player->account_id === Auth::user()->id)
                        <div class="LeftButton">
                            <div class="BigButton" onclick="RedirectToUrl('{{ route('community.view.house.manage.transfer.accept.index', [$house->id]) }}');" style="background-image:url({{ asset('/assets/tibiarl/images/buttons/sbutton.gif') }})">
                                <div onmouseover="MouseOverBigButton(this);" onmouseout="MouseOutBigButton(this);"><div class="BigButtonOver" style="background-image:url({{ asset('/assets/tibiarl/images/buttons/sbutton_over.gif') }});"></div>
                                    <input class="BigButtonText" type="submit" value="Accept">
                                </div>
                            </div>
                        </div>
                    @endif
                @endif
                @if($house->ownerOnLoggedInAccount())
                    @if($house->moveOut)
                        @if($house->moveOut->transfer && !$house->moveOut->transfer->accepted)
                            @if(!$house->moveOut->transfer->accepted)
                                <div class="LeftButton">
                                    <div class="BigButton" onclick="RedirectToUrl('{{ route('community.view.house.manage.keep-house.index', [$house->id]) }}');" style="background-image:url({{ asset('/assets/tibiarl/images/buttons/sbutton.gif') }})">
                                        <div onmouseover="MouseOverBigButton(this);" onmouseout="MouseOutBigButton(this);"><div class="BigButtonOver" style="background-image:url({{ asset('/assets/tibiarl/images/buttons/sbutton_over.gif') }});"></div>
                                            <input class="BigButtonText" type="submit" value="Keep House">
                                        </div>
                                    </div>
                                </div>
                            @endif
                        @endif
                        @if($house->moveOut && !$house->moveOut->transfer)
                            <div class="LeftButton">
                                <div class="BigButton" onclick="RedirectToUrl('{{ route('community.view.house.manage.keep-house.index', [$house->id]) }}');" style="background-image:url({{ asset('/assets/tibiarl/images/buttons/sbutton.gif') }})">
                                    <div onmouseover="MouseOverBigButton(this);" onmouseout="MouseOutBigButton(this);"><div class="BigButtonOver" style="background-image:url({{ asset('/assets/tibiarl/images/buttons/sbutton_over.gif') }});"></div>
                                        <input class="BigButtonText" type="submit" value="Keep House">
                                    </div>
                                </div>
                            </div>
                        @endif
                    @else
                        <div class="LeftButton">
                            <div class="BigButton" onclick="RedirectToUrl('{{ route('community.view.house.manage.move-out.index', [$house->id]) }}');" style="background-image:url({{ asset('/assets/tibiarl/images/buttons/sbutton.gif') }})">
                                <div onmouseover="MouseOverBigButton(this);" onmouseout="MouseOutBigButton(this);"><div class="BigButtonOver" style="background-image:url({{ asset('/assets/tibiarl/images/buttons/sbutton_over.gif') }});"></div>
                                    <input class="BigButtonText" type="submit" value="Move Out">
                                </div>
                            </div>
                        </div>
                        <div class="LeftButton">
                            <div class="BigButton" onclick="RedirectToUrl('{{ route('community.view.house.manage.transfer.index', [$house->id]) }}');" style="background-image:url({{ asset('/assets/tibiarl/images/buttons/sbutton.gif') }})">
                                <div onmouseover="MouseOverBigButton(this);" onmouseout="MouseOutBigButton(this);"><div class="BigButtonOver" style="background-image:url({{ asset('/assets/tibiarl/images/buttons/sbutton_over.gif') }});"></div>
                                    <input class="BigButtonText" type="submit" value="Transfer">
                                </div>
                            </div>
                        </div>
                    @endif
                @endif
            @else
                <div class="LeftButton">
                    <div class="BigButton" onclick="RedirectToUrl('{{ route('community.view.house.auction.index', [$house->id]) }}');" style="background-image:url({{ asset('/assets/tibiarl/images/buttons/sbutton.gif') }})">
                        <div onmouseover="MouseOverBigButton(this);" onmouseout="MouseOutBigButton(this);"><div class="BigButtonOver" style="background-image:url({{ asset('/assets/tibiarl/images/buttons/sbutton_over.gif') }});"></div>
                            <input class="BigButtonText" type="submit" value="Bid">
                        </div>
                    </div>
                </div>
            @endif
        @else
            <div class="LeftButton">
                <div class="BigButton" onclick="RedirectToUrl('{{ route('account.login.index') }}');" style="background-image:url({{ asset('/assets/tibiarl/images/buttons/sbutton.gif') }})">
                    <div onmouseover="MouseOverBigButton(this);" onmouseout="MouseOutBigButton(this);"><div class="BigButtonOver" style="background-image:url({{ asset('/assets/tibiarl/images/buttons/sbutton_over.gif') }});"></div>
                        <input class="BigButtonText" type="submit" value="Login">
                    </div>
                </div>
            </div>
        @endif
        <div class="LeftButton">
            <div class="BigButton" onclick="javascript:history.go(-1)" style="background-image:url({{ asset('/assets/tibiarl/images/buttons/sbutton.gif') }})">
                <div onmouseover="MouseOverBigButton(this);" onmouseout="MouseOutBigButton(this);"><div class="BigButtonOver" style="background-image:url({{ asset('/assets/tibiarl/images/buttons/sbutton_over.gif') }});"></div>
                    <input class="BigButtonText" type="submit" value="Back">
                </div>
            </div>
        </div>
    </div>
@endsection
@section('scripts')
    <script src="{{ asset('/assets/js/fslightbox.bundle.js') }}"></script>
    <script src="{{ asset('/assets/js/leaflet.js') }}"></script>
    <script type="text/javascript">
        $(document).ready(function() {
            let showHouse = function () {
                let house = L.map('house_preview', {
                    maxZoom: 24,
                    minZoom: 1,
                    crs: L.CRS.Simple
                }).setView([0, 0], 1);

                house.setMaxBounds(new L.LatLngBounds([0,275], [275,0]));
                let bounds = [[275,0], [0,275]];
                let floors = {
                    @foreach($housePreviewArray as $housePreview)
                    "{{ $housePreview['floor'] }}": L.imageOverlay('{{ $housePreview['image'] }}', bounds),
                    @endforeach
                }
                L.control.layers(floors).addTo(house);
                house.addLayer(floors["Main Floor"]);
                house.fitBounds(bounds);
            }
            showHouse();
            $('.leaflet-container').css('background-color', '#000000')
            $('.leaflet-control-attribution').remove();
            $('.leaflet-control-layers-toggle').append('<i class="fas fa-layer-group fs-1 text-primary"></i>');
        });
    </script>
@endsection