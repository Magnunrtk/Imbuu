@extends('template.layout')
@section('title', 'Who is online?')
@section('submenuItem', 'whoisonline')
@section('content')
    @if(config('multi_world.enabled'))
    <form action="{{ route('community.players-online.selectWorldAction') }}" method="post" class="form">
        @csrf
        <div class="TableContainer">
            <div class="CaptionContainer">
                <div class="CaptionInnerContainer">
                    <span class="CaptionEdgeLeftTop" style="background-image:url({{ asset('/assets/tibiarl/images/content/box-frame-edge.gif') }});"></span>
                    <span class="CaptionEdgeRightTop" style="background-image:url({{ asset('/assets/tibiarl/images/content/box-frame-edge.gif') }});"></span>
                    <span class="CaptionBorderTop" style="background-image:url({{ asset('/assets/tibiarl/images/content/table-headline-border.gif') }});"></span>
                    <span class="CaptionVerticalLeft" style="background-image:url({{ asset('/assets/tibiarl/images/content/box-frame-vertical.gif') }});"></span>
                    <div class="Text">World Selection</div>
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
                                    <td>
                                        <div class="ThreeColumnsForm">
                                            <div class="LabelV120 ThreeColumnsFormCell">World Name:</div>
                                            <div class="ThreeColumnsFormCell ThreeColumnsFormInputCell">
                                                <select size="1" name="world" style="width:165px;">
                                                    @foreach(config('multi_world.worlds') as $selectWorld)
                                                        <option value="{{ $selectWorld['slug'] }}" @if($selectWorld['slug'] === $world['slug']) selected="selected" @endif>{{ $selectWorld['name'] }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="ThreeColumnsFormButton ThreeColumnsFormCell">
                                                <div class="BigButton" style="background-image:url({{ asset('/assets/tibiarl/images/buttons/sbutton.gif') }})">
                                                    <div onmouseover="MouseOverBigButton(this);" onmouseout="MouseOutBigButton(this);"><div class="BigButtonOver" style="background-image:url({{ asset('/assets/tibiarl/images/buttons/sbutton_over.gif') }});"></div>
                                                        <input class="BigButtonText" type="submit" value="Submit">
                                                    </div>
                                                </div>
                                            </div>
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
    </form>
    <br>
    <br>
    @endif

    <div class="TableContainer">
        <div class="CaptionContainer">
            <div class="CaptionInnerContainer">
                <span class="CaptionEdgeLeftTop" style="background-image:url({{ asset('/assets/tibiarl/images/content/box-frame-edge.gif') }});"></span>
                <span class="CaptionEdgeRightTop" style="background-image:url({{ asset('/assets/tibiarl/images/content/box-frame-edge.gif') }});"></span>
                <span class="CaptionBorderTop" style="background-image:url({{ asset('/assets/tibiarl/images/content/table-headline-border.gif') }});"></span>
                <span class="CaptionVerticalLeft" style="background-image:url({{ asset('/assets/tibiarl/images/content/box-frame-vertical.gif') }});"></span>
                <div class="Text">World Information</div>
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
                                <td class="LabelV200">Status:</td>
                                <td>
                                    Online
                                </td>
                            </tr>
                            <tr>
                                <td class="LabelV200">Players Online:</td>
                                <td>{{ number_format($playersOnline->count()) }}</td>
                            </tr>
                            <tr>
                                <td class="LabelV200">Location:</td>
                                <td>
                                {{-- {{ \App\Utils\World::getCurrentWorld()['location'] }} --}}BR
                                </td>
                            </tr>
                            <tr>
                                <td class="LabelV200">PvP Type:</td>
                                <td>{{ \App\Utils\World::getCurrentWorld()['pvp_type'] }}</td>
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
    <div class="TableContainer">
        <div class="CaptionContainer">
            <div class="CaptionInnerContainer">
                <span class="CaptionEdgeLeftTop" style="background-image:url({{ asset('/assets/tibiarl/images/content/box-frame-edge.gif') }});"></span>
                <span class="CaptionEdgeRightTop" style="background-image:url({{ asset('/assets/tibiarl/images/content/box-frame-edge.gif') }});"></span>
                <span class="CaptionBorderTop" style="background-image:url({{ asset('/assets/tibiarl/images/content/table-headline-border.gif') }});"></span>
                <span class="CaptionVerticalLeft" style="background-image:url({{ asset('/assets/tibiarl/images/content/box-frame-vertical.gif') }});"></span>
                <div class="Text">Players Online</div>
                <span class="CaptionVerticalRight" style="background-image:url({{ asset('/assets/tibiarl/images/content/box-frame-vertical.gif') }});"></span>
                <span class="CaptionBorderBottom" style="background-image:url({{ asset('/assets/tibiarl/images/content/table-headline-border.gif') }});"></span>
                <span class="CaptionEdgeLeftBottom" style="background-image:url({{ asset('/assets/tibiarl/images/content/box-frame-edge.gif') }});"></span>
                <span class="CaptionEdgeRightBottom" style="background-image:url({{ asset('/assets/tibiarl/images/content/box-frame-edge.gif') }});"></span>
            </div>
        </div>
        <table class="Table2" cellpadding="0" cellspacing="0">
            <tbody>
            <tr>
                <td>
                    <div class="InnerTableContainer" style="max-width: unset;">
                        <table style="width:100%;">
                            <tbody>
                            <tr class="LabelH">
                                <td style="text-align:left;width:90%">Name&nbsp;<small style="font-weight:normal;">[<a href="{{ route('community.players-online.index', ['name']) }}">sort</a>]</small></td>
                                <td style="text-align:right;">Level&nbsp;<small style="font-weight:normal;">[<a href="{{ route('community.players-online.index', ['level']) }}">sort</a>]</small></td>
                                <td>Vocation&nbsp;<small style="font-weight:normal;">[<a href="{{ route('community.players-online.index', ['vocation']) }}">sort</a>]</small></td>
                            </tr>

                            @forelse($playersOnline as $online)
                                @php

                                    if (Str::startsWith($online->player->name, 'GOD')) {
                                        continue;
                                    }

                                    if (Str::startsWith($online->player->name, 'GM')) {
                                        continue;
                                    }

                                    $rowClass = $loop->index % 2 == 0 ? 'Even' : 'Odd';

                                @endphp
                                <tr class="{{ $rowClass }}" style="text-align:right;">
                                    <td style="width:70%;text-align:left;">
                                        <a href="{{ route('community.view.character.search',  Str::strToUrl($online->player->name)) }}">{{$online->player->name }}</a>
                                    </td>
                                    <td style="width:10%;">{{ $online->player->level }}</td>
                                    <td style="width:20%;"><nobr>{{ \App\Utils\Vocation::getNameByVocationId($online->player->vocation) }}</nobr></td>
                                </tr>
                            @empty
                                <tr class="Even">
                                    <td colspan="3">Nobody is currently online.</td>
                                </tr>
                            @endforelse


                            </tbody>
                        </table>
                    </div>
                </td>
            </tr>
            </tbody>
        </table>
    </div>
@endsection