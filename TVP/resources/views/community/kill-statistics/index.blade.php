@extends('template.layout')
@section('title', 'Kill Statistics')
@section('submenuItem', 'killstatistics')
@section('content')
<div class="TableContainer">
    <div class="CaptionContainer">
        <div class="CaptionInnerContainer">
            <span class="CaptionEdgeLeftTop" style="background-image:url({{ asset('/assets/tibiarl/images/content/box-frame-edge.gif') }});"></span>
            <span class="CaptionEdgeRightTop" style="background-image:url({{ asset('/assets/tibiarl/images/content/box-frame-edge.gif') }});"></span>
            <span class="CaptionBorderTop" style="background-image:url({{ asset('/assets/tibiarl/images/content/table-headline-border.gif') }});"></span>
            <span class="CaptionVerticalLeft" style="background-image:url({{ asset('/assets/tibiarl/images/content/box-frame-vertical.gif') }});"></span>
            <div class="Text">Kill Statistics<span class="RightArea">Last Update: @if(\Carbon\Carbon::now()->diffInMinutes($lastUpdatedTime) <= 1) less than a minute ago @else {{ \Carbon\Carbon::now()->diffInMinutes($lastUpdatedTime) }} minutes ago @endif</span></div>
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
                    <div class="TableScrollbarContainer"> </div>
                </div>
                <div class="InnerTableContainer" style="max-width: unset;">
                    <table style="width:100%;" id="KillStatisticsTable">
                        <tbody>
                        <tr>
                            <td>
                                <div class="TableContentContainer">
                                    <table class="TableContent" width="100%" style="border:1px solid #faf0d7;">
                                        <tbody>
                                        <tr class="LabelH TextCenter">
                                            <td></td>
                                            <td colspan="2">Last Day</td>
                                            <td colspan="2">Last Week</td>
                                        </tr>
                                        <tr class="LabelH TextCenter">
                                            <td>Race</td>
                                            <td>Killed Players</td>
                                            <td>Killed by Players</td>
                                            <td>Killed Players</td>
                                            <td>Killed by Players</td>
                                        </tr>
                                        @php
                                            $totalLastDayKilled = 0;
                                            $totalLastDayKilledBy = 0;
                                            $totalLastWeekKilled = 0;
                                            $totalLastWeekKilledBy = 0;
                                        @endphp
                                        @foreach($killStatistics as $creature_name => $timePeriods)
                                            @php
                                                $rowClass = $loop->index % 2 == 0 ? 'Even' : 'Odd';
                                                $totalLastDayKilled += $timePeriods['lastDay']->sum('killed') ?? 0;
                                                $totalLastDayKilledBy += $timePeriods['lastDay']->sum('killed_by') ?? 0;
                                                $totalLastWeekKilled += $timePeriods['lastWeek']->sum('killed') ?? 0;
                                                $totalLastWeekKilledBy += $timePeriods['lastWeek']->sum('killed_by') ?? 0;
                                            @endphp
                                            <tr class="{{ $rowClass }} TextRight DataRow">
                                                <td>{{ ucwords($creature_name) }}</td>
                                                <td>{{ $timePeriods['lastDay']->sum('killed_by') ?? 0 }}</td>
                                                <td>{{ $timePeriods['lastDay']->sum('killed') ?? 0 }}</td>
                                                <td>{{ $timePeriods['lastWeek']->sum('killed_by') ?? 0 }}</td>
                                                <td>{{ $timePeriods['lastWeek']->sum('killed') ?? 0 }}</td>
                                            </tr>
                                        @endforeach
                                        <tr class="LabelH DataRow">
                                            <td>Total</td>
                                            <td>{{ $totalLastDayKilledBy }}</td>
                                            <td>{{ $totalLastDayKilled }}</td>
                                            <td>{{ $totalLastWeekKilledBy }}</td>
                                            <td>{{ $totalLastWeekKilled }}</td>
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