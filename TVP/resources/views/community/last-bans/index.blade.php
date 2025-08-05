@extends('template.layout')
@section('title', 'Last Bans')
@section('submenuItem', 'lastbans')
@section('content')
<div class="TableContainer">
    <div class="CaptionContainer">
        <div class="CaptionInnerContainer">
            <span class="CaptionEdgeLeftTop" style="background-image:url({{ asset('/assets/tibiarl/images/content/box-frame-edge.gif') }});"></span>
            <span class="CaptionEdgeRightTop" style="background-image:url({{ asset('/assets/tibiarl/images/content/box-frame-edge.gif') }});"></span>
            <span class="CaptionBorderTop" style="background-image:url({{ asset('/assets/tibiarl/images/content/table-headline-border.gif') }});"></span>
            <span class="CaptionVerticalLeft" style="background-image:url({{ asset('/assets/tibiarl/images/content/box-frame-vertical.gif') }});"></span>
            <div class="Text">Last Bans</div>
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
                    <table style="width:100%;" id="LastBansTable">
                        <tbody>
                        <tr>
                            <td>
                                <div class="TableContentContainer">
                                    <table class="TableContent" width="100%" style="border:1px solid #faf0d7;">
                                        <tbody>
                                        <tr class="LabelH TextCenter">
                                            <td>Account ID</td>
                                            <td>Reason</td>
                                            <td>Banned At</td>
                                            <td>Expires At</td>
                                            <td>Banned By</td>
                                        </tr>
                                        @foreach($bans as $ban)
                                            @php
                                                $rowClass = $loop->index % 2 == 0 ? 'Even' : 'Odd';
                                            @endphp
                                            <tr class="{{ $rowClass }} TextRight DataRow">
                                                <td>
                                                    @if (!$ban->player_name)
                                                        <p style="font-size: 10px">Player not found</p>
                                                    @else
                                                        <p style="font-size: 10px">
                                                            <a href="{{ route('community.view.character.search', ['characterName' => urlencode($ban->player_name)]) }}">
                                                                {{ strlen($ban->player_name) > 13 ? substr($ban->player_name, 0, 13) . '...' : $ban->player_name }}
                                                            </a>  Lv.{{ $ban->player_level }}
                                                        </p>
                                                    @endif
                                                </td>
                                                <td><p style="font-size: 10px">{{ $ban->reason }}</p></td>
                                                <td><p style="font-size: 10px">{{ $ban->banned_at_formatted }}</p></td>
                                                <td>
                                                    <p style="font-size: 10px; color: {{ ( Carbon\Carbon::createFromTimestamp($ban->expires_at)->year >= 2051 || $ban->expires_at == 0 ) ? 'red' : '#5A2800' }}">
                                                        @if(Carbon\Carbon::createFromTimestamp($ban->expires_at)->year >= 2051 || $ban->expires_at == 0)
                                                            Permanent.
                                                        @else
                                                            {{ $ban->expires_at_formatted }}
                                                        @endif
                                                    </p>
                                                </td>
                                                <td><p style="font-size: 10px">{{ $ban->adm_name }}</p></td>
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
@endsection