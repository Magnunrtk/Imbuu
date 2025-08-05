@extends('template.layout')
@section('title', 'Game Features')
@section('submenuItem', 'features')
@section('content')
<p>
    <b>{{ config('server.serverName') }}</b> is a real map old school gaming server, created for RPG players who love the atmosphere and gameplay of the past,
    yet still nostalgic and fascinating version 7.4. All game mechanisms, including quests, have been ported to create a perfect replication of RL 7.4.
</p>
<div class="TableContainer">
    <div class="CaptionContainer">
        <div class="CaptionInnerContainer">
            <span class="CaptionEdgeLeftTop" style="background-image:url({{ asset('/assets/tibiarl/images/content/box-frame-edge.gif') }});"></span>
            <span class="CaptionEdgeRightTop" style="background-image:url({{ asset('/assets/tibiarl/images/content/box-frame-edge.gif') }});"></span>
            <span class="CaptionBorderTop" style="background-image:url({{ asset('/assets/tibiarl/images/content/table-headline-border.gif') }});"></span>
            <span class="CaptionVerticalLeft" style="background-image:url({{ asset('/assets/tibiarl/images/content/box-frame-vertical.gif') }});"></span>
            <div class="Text">General Information</div>
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
                                        <tr class="Even">
                                            <td class="LabelV175">Client Version:</td>
                                            <td>OTCV8 7.4 Replica + Custom Stuffs</td>
                                        </tr>
                                        <tr class="Odd">
                                            <td class="LabelV175">Map:</td>
                                            <td>7.4 Real Map + Custom</td>
                                        </tr>
                                        <tr class="Even">
                                            <td class="LabelV175">Server save:</td>
                                            <td>Every day at {{ config('server.serverSaveTime') }} {{ config('server.serverTimeZone') }}</td>
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
<div class="TableContainer">
    <div class="CaptionContainer">
        <div class="CaptionInnerContainer">
            <span class="CaptionEdgeLeftTop" style="background-image:url({{ asset('/assets/tibiarl/images/content/box-frame-edge.gif') }});"></span>
            <span class="CaptionEdgeRightTop" style="background-image:url({{ asset('/assets/tibiarl/images/content/box-frame-edge.gif') }});"></span>
            <span class="CaptionBorderTop" style="background-image:url({{ asset('/assets/tibiarl/images/content/table-headline-border.gif') }});"></span>
            <span class="CaptionVerticalLeft" style="background-image:url({{ asset('/assets/tibiarl/images/content/box-frame-vertical.gif') }});"></span>
            <div class="Text">Game Information</div>
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
                                        <tr class="Odd">
                                            <td class="LabelV175">Shared Experience:</td>
                                            <td>No bonus. Range to share is 2/3 Highest Member Level</td>
                                        </tr>
                                        <tr class="Odd">
                                            <td class="LabelV175">Houses:</td>
                                            <td>Houses can only be purchased by players above level {{ config('houses.minimumLevelToPlaceBid') }}.</td>
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
<div class="TableContainer">
    <div class="CaptionContainer">
        <div class="CaptionInnerContainer">
            <span class="CaptionEdgeLeftTop" style="background-image:url({{ asset('/assets/tibiarl/images/content/box-frame-edge.gif') }});"></span>
            <span class="CaptionEdgeRightTop" style="background-image:url({{ asset('/assets/tibiarl/images/content/box-frame-edge.gif') }});"></span>
            <span class="CaptionBorderTop" style="background-image:url({{ asset('/assets/tibiarl/images/content/table-headline-border.gif') }});"></span>
            <span class="CaptionVerticalLeft" style="background-image:url({{ asset('/assets/tibiarl/images/content/box-frame-vertical.gif') }});"></span>
            <div class="Text">Rate Information</div>
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
                                        <tr class="Odd">
                                            <td class="LabelV175">Experience Rate:</td>
                                            <td>
                                                <div class="TableContentContainer">
                                                    <table class="TableContent" width="100%" style="border:1px solid #faf0d7;">
                                                        <tbody>
                                                            <tr class="LabelH">
                                                                <td>From</td>
                                                                <td>To</td>
                                                                <td>Rate</td>
                                                            </tr>
                                                            @foreach(config('server.information.rates.experience') as $index => $rate)
                                                                <tr class="{{ $index % 2 == 0 ? 'Even' : 'Odd' }}">
                                                                    <td>{{ $rate['level_from'] }}</td>
                                                                    <td>{{ $rate['level_to'] ?? 'Max' }}</td>
                                                                    <td>{{ $rate['stage'] }}x</td>
                                                                </tr>
                                                            @endforeach
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </td>
                                        </tr>
                                        <tr class="Even">
                                            <td class="LabelV175">Spawn Rate:</td>
                                            <td>{{ config('server.information.rates.spawn') }}x</td>
                                        </tr>
                                        <tr class="Odd">
                                            <td class="LabelV175">Loot Rate:</td>
                                            <td>{{ config('server.information.rates.loot') }}x</td>
                                        </tr>
                                        <tr class="Even">
                                            <td class="LabelV175">Skill Rate:</td>
                                            <td>{{ config('server.information.rates.skill') }}x</td>
                                        </tr>
                                        <tr class="Odd">
                                            <td class="LabelV175">Magic Rate:</td>
                                            <td>{{ config('server.information.rates.magic_level') }}x</td>
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
<div class="TableContainer">
    <div class="CaptionContainer">
        <div class="CaptionInnerContainer">
            <span class="CaptionEdgeLeftTop" style="background-image:url({{ asset('/assets/tibiarl/images/content/box-frame-edge.gif') }});"></span>
            <span class="CaptionEdgeRightTop" style="background-image:url({{ asset('/assets/tibiarl/images/content/box-frame-edge.gif') }});"></span>
            <span class="CaptionBorderTop" style="background-image:url({{ asset('/assets/tibiarl/images/content/table-headline-border.gif') }});"></span>
            <span class="CaptionVerticalLeft" style="background-image:url({{ asset('/assets/tibiarl/images/content/box-frame-vertical.gif') }});"></span>
            <div class="Text">PVP Information</div>
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
                                        <tr class="Odd">
                                            <td class="LabelV175">PvP Protection Zone:</td>
                                            <td>Protection zone is blocked for {{ config('server.information.pz_time_after_attack') }} after attacking another player.</td>
                                        </tr>
                                        <tr class="Even">
                                            <td class="LabelV175">White Skull:</td>
                                            <td>White skull lasts for {{ config('server.information.white_skull_time') }} on player kill.</td>
                                        </tr>
                                        <tr class="Odd">
                                            <td class="LabelV175">Red Skull:</td>
                                            <td>
                                                <div class="TableContentContainer">
                                                    <table class="TableContent" width="100%" style="border:1px solid #faf0d7;">
                                                        <tbody>
                                                        <tr class="LabelH">
                                                            <td>Daily</td>
                                                            <td>Weekly</td>
                                                            <td>Monthly</td>
                                                        </tr>
                                                        <tr class="Even">
                                                            <td>
                                                                {{ config('server.information.frags_to_red_skull.day') }}
                                                            </td>
                                                            <td>
                                                                {{ config('server.information.frags_to_red_skull.week') }}
                                                            </td>
                                                            <td>
                                                                {{ config('server.information.frags_to_red_skull.month') }}
                                                            </td>
                                                        </tr>
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </td>
                                        </tr>
                                        <tr class="Even">
                                            <td class="LabelV175" colspan="2">Red Skull Duration: {{ config('server.information.red_skull_duration') }} days</td>
                                        </tr>
                                        <tr class="Ôdd">
                                            <td class="LabelV175">Banishment:</td>
                                            <td>
                                                <div class="TableContentContainer">
                                                    <table class="TableContent" width="100%" style="border:1px solid #faf0d7;">
                                                        <tbody>
                                                        <tr class="LabelH">
                                                            <td>Daily</td>
                                                            <td>Weekly</td>
                                                            <td>Monthly</td>
                                                        </tr>
                                                        <tr class="Even">
                                                            <td>
                                                                {{ config('server.information.frags_to_ban.day') }}
                                                            </td>
                                                            <td>
                                                                {{ config('server.information.frags_to_ban.week') }}
                                                            </td>
                                                            <td>
                                                                {{ config('server.information.frags_to_ban.month') }}
                                                            </td>
                                                        </tr>
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </td>
                                        </tr>
                                        <tr class="Even">
                                            <td class="LabelV175" colspan="2">Unjustified player killing ban time: {{ config('server.information.frag_ban_time') }} days</td>
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

<div class="TableContainer">
    <div class="CaptionContainer">
        <div class="CaptionInnerContainer">
            <span class="CaptionEdgeLeftTop" style="background-image:url({{ asset('/assets/tibiarl/images/content/box-frame-edge.gif') }});"></span>
            <span class="CaptionEdgeRightTop" style="background-image:url({{ asset('/assets/tibiarl/images/content/box-frame-edge.gif') }});"></span>
            <span class="CaptionBorderTop" style="background-image:url({{ asset('/assets/tibiarl/images/content/table-headline-border.gif') }});"></span>
            <span class="CaptionVerticalLeft" style="background-image:url({{ asset('/assets/tibiarl/images/content/box-frame-vertical.gif') }});"></span>
            <div class="Text">Vocation Regeneration</div>
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
                                            <td>Vocation Name</td>
                                            <td>Gain per Level</td>
                                            <td>HP Regen</td>
                                            <td>MP Regen</td>
                                        </tr>
                                        <tr class="Even">
                                            <td style="width: 15%">
                                                <nobr>None</nobr>
                                            </td>
                                            <td style="width: 30%">
                                                <nobr>5 health, 5 mana, 10 capacity</nobr>
                                            </td>
                                            <td style="width: 30%">
                                                <nobr>1 health every 6 seconds</nobr>
                                            </td>
                                            <td style="width: 25%">
                                                <nobr>1 mana every 6 seconds</nobr>
                                            </td>
                                        </tr>
                                        <tr class="Odd">
                                            <td style="width: 15%">
                                                <nobr>Sorcerer</nobr>
                                            </td>
                                            <td style="width: 30%">
                                                <nobr>5 health, 30 mana, 10 capacity</nobr>
                                            </td>
                                            <td style="width: 30%">
                                                <nobr>1 health every 12 seconds</nobr>
                                            </td>
                                            <td style="width: 25%">
                                                <nobr>1 mana every 6 seconds</nobr>
                                            </td>
                                        </tr>
                                        <tr class="Even">
                                            <td style="width: 15%">
                                                <nobr>Druid</nobr>
                                            </td>
                                            <td style="width: 30%">
                                                <nobr>5 health, 30 mana, 10 capacity</nobr>
                                            </td>
                                            <td style="width: 30%">
                                                <nobr>1 health every 12 seconds</nobr>
                                            </td>
                                            <td style="width: 25%">
                                                <nobr>1 mana every 6 seconds</nobr>
                                            </td>
                                        </tr>
                                        <tr class="Odd">
                                            <td style="width: 15%">
                                                <nobr>Paladin</nobr>
                                            </td>
                                            <td style="width: 30%">
                                                <nobr>10 health, 15 mana, 20 capacity</nobr>
                                            </td>
                                            <td style="width: 30%">
                                                <nobr>1 health every 8 seconds</nobr>
                                            </td>
                                            <td style="width: 25%">
                                                <nobr>1 mana every 8 seconds</nobr>
                                            </td>
                                        </tr>
                                        <tr class="Even">
                                            <td style="width: 15%">
                                                <nobr>Knight</nobr>
                                            </td>
                                            <td style="width: 30%">
                                                <nobr>15 health 5 mana, 25 capacity</nobr>
                                            </td>
                                            <td style="width: 30%">
                                                <nobr>1 health every 6 seconds</nobr>
                                            </td>
                                            <td style="width: 25%">
                                                <nobr>1 mana every 12 seconds</nobr>
                                            </td>
                                        </tr>
                                        <tr class="Odd">
                                            <td colspan="4" style="text-align: center;">
                                                <nobr><b>PROMOTED VOCATIONS</b></nobr>
                                            </td>
                                        </tr>
                                        <tr class="Even">
                                            <td style="width: 15%">
                                                <nobr>Master Sorcerer</nobr>
                                            </td>
                                            <td style="width: 30%">
                                                <nobr>5 health, 30 mana, 10 capacity</nobr>
                                            </td>
                                            <td style="width: 30%">
                                                <nobr>1 health every 12 seconds</nobr>
                                            </td>
                                            <td style="width: 25%">
                                                <nobr>1 mana every 4 seconds</nobr>
                                            </td>
                                        </tr>
                                        <tr class="Odd">
                                            <td style="width: 15%">
                                                <nobr>Elder Druid</nobr>
                                            </td>
                                            <td style="width: 30%">
                                                <nobr>5 health, 30 mana, 10 capacity</nobr>
                                            </td>
                                            <td style="width: 30%">
                                                <nobr>1 health every 12 seconds</nobr>
                                            </td>
                                            <td style="width: 25%">
                                                <nobr>1 mana every 4 seconds</nobr>
                                            </td>
                                        </tr>
                                        <tr class="Even">
                                            <td style="width: 15%">
                                                <nobr>Royal Paladin</nobr>
                                            </td>
                                            <td style="width: 30%">
                                                <nobr>10 health, 15 mana, 20 capacity</nobr>
                                            </td>
                                            <td style="width: 30%">
                                                <nobr>1 health every 6 seconds</nobr>
                                            </td>
                                            <td style="width: 25%">
                                                <nobr>1 mana every 6 seconds</nobr>
                                            </td>
                                        </tr>
                                        <tr class="Odd">
                                            <td style="width: 15%">
                                                <nobr>Elite Knight</nobr>
                                            </td>
                                            <td style="width: 30%">
                                                <nobr>15 health 5 mana, 25 capacity</nobr>
                                            </td>
                                            <td style="width: 30%">
                                                <nobr>1 health every 4 seconds</nobr>
                                            </td>
                                            <td style="width: 25%">
                                                <nobr>1 mana every 12 seconds</nobr>
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

@endsection