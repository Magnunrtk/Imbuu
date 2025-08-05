@extends('template.layout')
@section('title','Support list')
@section('submenuItem', 'team')
@section('content')

    @php date_default_timezone_set('America/Sao_Paulo'); @endphp

    <p>
        On this page {{ config('server.serverName') }} has appointed the following people as <b>Tutors</b> whom you can contact in case of questions or help in the game.
        They are active in the game in the <b>Help channel</b>.
    </p>
    <p>
        To report a violation of the <a href="{{ route('support.rules') }}">{{ config('server.serverName') }} Rules</a> please use the "Rule Violation Report" by pressing <b>Ctrl+R</b> in the game.
    </p>
    <p>
        Moreover, you may contact a gamemaster concerning general questions on rule violations or banishments at the <b>Gamemaster channel</b>. Please understand that you should not message gamemasters directly in the game.
    </p>
    <p> Another quick and effective option to contact the server support and build a larger {{ config('server.serverName') }} community is to join and use our <a href="{{ config('server.socials.discord') }}">Discord</a>.</p>
    <br>
    <div class="TableContainer">
        <div class="CaptionContainer">
            <div class="CaptionInnerContainer">
                <span class="CaptionEdgeLeftTop" style="background-image:url({{ asset('/assets/tibiarl/images/content/box-frame-edge.gif') }});"></span>
                <span class="CaptionEdgeRightTop" style="background-image:url({{ asset('/assets/tibiarl/images/content/box-frame-edge.gif') }});"></span>
                <span class="CaptionBorderTop" style="background-image:url({{ asset('/assets/tibiarl/images/content/table-headline-border.gif') }});"></span>
                <span class="CaptionVerticalLeft" style="background-image:url({{ asset('/assets/tibiarl/images/content/box-frame-vertical.gif') }});"></span>
                <div class="Text">Support List</div>
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
                                                <td>Group</td>
                                                <td>Name</td>
                                                <td>Last Login</td>
                                            </tr>

                                            @foreach($supportGroups as $groupId => $group)
                                                @foreach($group as $player)
                                                    @php
                                                        $rowClass = 'Even';
                                                    @endphp
                                                    <tr class="{{ $rowClass }}">
                                                        <td style="width: 20%">
                                                            @if(isset(config('positions')[$groupId]))
                                                                {{ config('positions')[$groupId]['name'] }}
                                                            @else
                                                                Unknown
                                                            @endif
                                                        </td>
                                                        <td style="width: 40%">
                                                            <a href="{{ route('community.view.character.search', Str::strToUrl($player->name)) }}">{{ $player->name }}</a>
                                                        </td>
                                                        <td style="width: 40%">
                                                            @if($player->lastlogin === 0)
                                                                Never logged in
                                                            @else
                                                                {{ date('M d Y, H:i:s', $player->lastlogin) }} BRT
                                                            @endif
                                                        </td>
                                                    </tr>
                                                @endforeach
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
