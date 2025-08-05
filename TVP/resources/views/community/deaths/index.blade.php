@extends('template.layout')
@section('title', 'Latest Deaths')
@section('submenuItem', 'latestdeath')
@section('content')
<div class="TableContainer">
    <div class="CaptionContainer">
        <div class="CaptionInnerContainer">
            <span class="CaptionEdgeLeftTop" style="background-image:url({{ asset('/assets/tibiarl/images/content/box-frame-edge.gif') }});"></span>
            <span class="CaptionEdgeRightTop" style="background-image:url({{ asset('/assets/tibiarl/images/content/box-frame-edge.gif') }});"></span>
            <span class="CaptionBorderTop" style="background-image:url({{ asset('/assets/tibiarl/images/content/table-headline-border.gif') }});"></span>
            <span class="CaptionVerticalLeft" style="background-image:url({{ asset('/assets/tibiarl/images/content/box-frame-vertical.gif') }});"></span>
            <div class="Text">Latest Deaths</div>
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
                                        @forelse($latestDeaths as $death)
                                        @php
                                            date_default_timezone_set('America/Sao_Paulo');
                                            $rowClass = $loop->index % 2 == 0 ? 'Odd' : 'Even';
                                        @endphp
                                        <tr class="{{ $rowClass }}">
                                            <td style="width: 25%">
                                                <nobr>{{ date('M d Y, H:i:s', $death->time) }} BRT</nobr>
                                            </td>
                                            <td style="width: 75%">
                                                <a href="{{ route('community.view.character.search',  Str::strToUrl($death->player->name)) }}">{{$death->player->name }}</a> killed at Level {{ $death->level }} by @if(!$death->is_player) {{ Str::strWithArticle($death->killed_by) }} @else <a href="{{ route('community.view.character.search',  Str::strToUrl($death->killed_by)) }}" class="text-gray-600 text-hover-primary">{{ $death->killed_by }}</a>@if($death->unjustified) <span class="ColorRed">(Unjustified)</span> @endif @endif @if($death->killed_by !== $death->mostdamage_by) and by @if(!$death->mostdamage_is_player) {{ Str::strWithArticle($death->mostdamage_by) }} @else <a href="{{ route('community.view.character.search', Str::strToUrl($death->mostdamage_by)) }}">{{ $death->mostdamage_by }}</a>@if($death->unjustified) <span class="ColorRed">(Unjustified)</span> @endif @endif @endif
                                            </td>
                                        </tr>
                                        @empty
                                        <tr class="Odd">
                                            <td colspan="2">
                                                No one has died yet.
                                            </td>
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
            </td>
        </tr>
        </tbody>
    </table>
</div>
@endsection
