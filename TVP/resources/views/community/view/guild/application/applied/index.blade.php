@extends('template.layout')
@section('title', 'Guilds')
@section('submenuItem', 'guilds')
@section('content')
    <div class="TableContainer">
        <div class="CaptionContainer">
            <div class="CaptionInnerContainer">
                <span class="CaptionEdgeLeftTop" style="background-image:url({{ asset('/assets/tibiarl/images/content/box-frame-edge.gif') }});"></span>
                <span class="CaptionEdgeRightTop" style="background-image:url({{ asset('/assets/tibiarl/images/content/box-frame-edge.gif') }});"></span>
                <span class="CaptionBorderTop" style="background-image:url({{ asset('/assets/tibiarl/images/content/table-headline-border.gif') }});"></span>
                <span class="CaptionVerticalLeft" style="background-image:url({{ asset('/assets/tibiarl/images/content/box-frame-vertical.gif') }});"></span>
                <div class="Text">My Applications to this Guild</div>
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
                                            <tr class="LabelH">
                                                <td>Date</td>
                                                <td>Character</td>
                                                <td>Level</td>
                                                <td>Vocation</td>
                                                <td>Status</td>
                                                <td>Action</td>
                                            </tr>
                                            @forelse($guildApplications as $application)
                                                @php
                                                    $rowClass = $loop->index % 2 == 0 ? '#f1e0c6' : '#d5c0a1';
                                                @endphp
                                                <tr style="background-color: {{ $rowClass }};">
                                                    <td>{{ date('M d Y, H:i:s T', $application->created_at->timestamp) }}</td>
                                                    <td>{{ $application->player->name }}</td>
                                                    <td>{{ $application->player->level }}</td>
                                                    <td>{{ \App\Utils\Vocation::getNameByVocationId($application->player->vocation) }}</td>
                                                    <td>
                                                        @if($application->status === \App\Utils\GuildApplicationStatus::OPEN)
                                                            open
                                                        @elseif($application->status === \App\Utils\GuildApplicationStatus::ACCEPTED)
                                                            accepted
                                                        @elseif($application->status === \App\Utils\GuildApplicationStatus::REJECTED)
                                                            rejected
                                                        @endif
                                                    </td>
                                                    <td>
                                                        @if($application->status === \App\Utils\GuildApplicationStatus::OPEN)
                                                            [<a href="{{ route('community.view.guild.my.applications.withdraw', [Str::strToUrl($guild->name), Str::strToUrl($application->player->name)]) }}">Withdraw</a>]
                                                        @endif
                                                    </td>
                                                </tr>
                                            @empty
                                                <tr style="background-color:#F1E0C6;">
                                                    <td colspan="7">You have no applications in this guild.</td>
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
    @if(!empty(\App\Utils\GuildApplications::getGuildApplicationCharacters($guild)))
        @if($guild->applications_enabled)
        <br>
        <form action="{{ route('community.view.guild.my.applications.apply', $guild->name) }}" method="post" class="form">
            @csrf
            <div class="TableContainer">
                <div class="CaptionContainer">
                    <div class="CaptionInnerContainer">
                        <span class="CaptionEdgeLeftTop" style="background-image:url({{ asset('/assets/tibiarl/images/content/box-frame-edge.gif') }});"></span>
                        <span class="CaptionEdgeRightTop" style="background-image:url({{ asset('/assets/tibiarl/images/content/box-frame-edge.gif') }});"></span>
                        <span class="CaptionBorderTop" style="background-image:url({{ asset('/assets/tibiarl/images/content/table-headline-border.gif') }});"></span>
                        <span class="CaptionVerticalLeft" style="background-image:url({{ asset('/assets/tibiarl/images/content/box-frame-vertical.gif') }});"></span>
                        <div class="Text">Application Form</div>
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
                                        <td bgcolor="#D4C0A1">
                                            <table border="0" cellpadding="1">
                                                <colgroup>
                                                    <col width="20%">
                                                    <col width="80%">
                                                </colgroup>
                                                <tbody>
                                                <tr>
                                                    <td>Character:&nbsp;</td>
                                                    <td>
                                                        <select size="1" name="character">
                                                            @forelse(\App\Utils\GuildApplications::getGuildApplicationCharacters($guild) as $character)
                                                                <option value="{{ $character }}">{{ $character }}</option>
                                                            @empty
                                                                <option>No character available</option>
                                                            @endforelse
                                                        </select>
                                                    </td>
                                                </tr>
                                                </tbody>
                                            </table>
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
            <table style="width:100%;">
                <tbody>
                <tr align="center">
                    <td>
                        <div class="BigButton" style="background-image:url({{ asset('/assets/tibiarl/images/buttons/sbutton.gif') }})">
                            <div onmouseover="MouseOverBigButton(this);" onmouseout="MouseOutBigButton(this);"><div class="BigButtonOver" style="background-image:url({{ asset('/assets/tibiarl/images/buttons/sbutton_over.gif') }});"></div>
                                <input class="BigButtonText" type="submit" value="Submit">
                            </div>
                        </div>
                    </td>
                    <td>
                        <div class="BigButton" onclick="RedirectToUrl('{{ route('community.view.guild.index', Str::strToUrl($guild->name)) }}');" style="background-image:url({{ asset('/assets/tibiarl/images/buttons/sbutton.gif') }})">
                            <div onmouseover="MouseOverBigButton(this);" onmouseout="MouseOutBigButton(this);"><div class="BigButtonOver" style="background-image:url({{ asset('/assets/tibiarl/images/buttons/sbutton_over.gif') }});"></div>
                                <input class="BigButtonText" type="submit" value="Back">
                            </div>
                        </div>
                    </td>
                </tr>
                </tbody>
            </table>
            <script type="text/javascript">
                SetRemainingLenCounter("application_input", "application_counter", 4096);
            </script>
        </form>
        @endif
    @else
        <br>
        <table style="width:100%;">
            <tbody>
            <tr align="center">
                <td>
                    <div class="BigButton" onclick="RedirectToUrl('{{ route('community.view.guild.index', Str::strToUrl($guild->name)) }}');" style="background-image:url({{ asset('/assets/tibiarl/images/buttons/sbutton.gif') }})">
                        <div onmouseover="MouseOverBigButton(this);" onmouseout="MouseOutBigButton(this);"><div class="BigButtonOver" style="background-image:url({{ asset('/assets/tibiarl/images/buttons/sbutton_over.gif') }});"></div>
                            <input class="BigButtonText" type="submit" value="Back">
                        </div>
                    </div>
                </td>
            </tr>
            </tbody>
        </table>
    @endif
@endsection