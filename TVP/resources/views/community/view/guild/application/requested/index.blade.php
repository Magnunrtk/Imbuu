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
                <div class="Text">Guild Applications</div>
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
                                                    <td>@if($application->status === \App\Utils\GuildApplicationStatus::OPEN) [ <a href="{{ route('community.view.guild.manage.applications.accept', [Str::strToUrl($guild->name), Str::strToUrl($application->player->name)]) }}">Accept</a>] <br>[ <a href="{{ route('community.view.guild.manage.applications.reject', [Str::strToUrl($guild->name), Str::strToUrl($application->player->name)]) }}">Reject</a>] @endif</td>
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
    <br>
    <table style="width:100%;">
        <tbody>
        <tr align="center">
            @if($guild->applications_enabled)
            <td>
                <form action="{{ route('community.view.guild.manage.applications.deny', [Str::strToUrl($guild->name)]) }}" method="post" class="form">
                    @csrf
                    <div class="BigButton" style="background-image:url({{ asset('/assets/tibiarl/images/buttons/sbutton.gif') }})">
                        <div onmouseover="MouseOverBigButton(this);" onmouseout="MouseOutBigButton(this);"><div class="BigButtonOver" style="background-image:url({{ asset('/assets/tibiarl/images/buttons/sbutton_over.gif') }});"></div>
                            <input class="BigButtonText" type="submit" value="Deny">
                        </div>
                    </div>
                </form>
            </td>
            @else
            <td>
                <form action="{{ route('community.view.guild.manage.applications.allow', [Str::strToUrl($guild->name)]) }}" method="post" class="form">
                    @csrf
                    <div class="BigButton" style="background-image:url({{ asset('/assets/tibiarl/images/buttons/sbutton.gif') }})">
                        <div onmouseover="MouseOverBigButton(this);" onmouseout="MouseOutBigButton(this);"><div class="BigButtonOver" style="background-image:url({{ asset('/assets/tibiarl/images/buttons/sbutton_over.gif') }});"></div>
                            <input class="BigButtonText" type="submit" value="Allow">
                        </div>
                    </div>
                </form>
            </td>
            @endif
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
@endsection