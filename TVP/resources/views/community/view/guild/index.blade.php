@extends('template.layout')
@section('title', 'Guilds')
@section('submenuItem', 'guilds')
@section('content')
    <table border="0" width="100%">
        <tbody>
        <tr>
            <td width="64">
                <img src="{{ asset('/images/guilds/' . $guild->web_guild->logo_name) }}" width="64" height="64">
            </td>
            <td align="center" width="100%">
                <h1>{{ $guild->name }}</h1>
            </td>
            <td width="64">
                <img src="{{ asset('/images/guilds/' . $guild->web_guild->logo_name) }}" width="64" height="64">
            </td>
        </tr>
        </tbody>
    </table>
    <br>
    <table width="100%">
        <colgroup class="GuildViewCols">
            <col width="90%">
            <col width="10%">
        </colgroup>
        <tbody>
        <tr class="GuildViewInformationBlocks">
            <td class="GuildInformationTable">
                <div class="TableContainer">
                    <div class="CaptionContainer">
                        <div class="CaptionInnerContainer">
                            <span class="CaptionEdgeLeftTop" style="background-image:url({{ asset('/assets/tibiarl/images/content/box-frame-edge.gif') }});"></span>
                            <span class="CaptionEdgeRightTop" style="background-image:url({{ asset('/assets/tibiarl/images/content/box-frame-edge.gif') }});"></span>
                            <span class="CaptionBorderTop" style="background-image:url({{ asset('/assets/tibiarl/images/content/table-headline-border.gif') }});"></span>
                            <span class="CaptionVerticalLeft" style="background-image:url({{ asset('/assets/tibiarl/images/content/box-frame-vertical.gif') }});"></span>
                            <div class="Text">Guild Information</div>
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
                                                <div id="GuildInformationContainer">
                                                    @if(!empty($guild->web_guild->description))
                                                        {{ $guild->web_guild->description }}<br><br>
                                                    @endif
                                                    The guild was founded on {{ date('M d Y', $guild->creationdata) }}. <br>
                                                    @if($guild->active)
                                                        It is currently active.<br>
                                                    @else
                                                        It is still in course of formation.<br>
                                                    @endif
                                                    @if($guild->applications_enabled)
                                                        Guild is opened for applications.<br>
                                                    @else
                                                        Guild is closed for applications.<br>
                                                    @endif
                                                    @if(!$guild->active)
                                                        <b>It will be disbanded on {{ date('M d Y', $guild->creationdata + 3 * 24 * 60 * 60) }} if there are still less than four vice leaders by then.</b><br>
                                                    @endif
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
            </td>
            <td style="vertical-align:top;">
                <div class="TableContainer">
                    <div class="CaptionContainer">
                        <div class="CaptionInnerContainer">
                            <span class="CaptionEdgeLeftTop" style="background-image:url({{ asset('/assets/tibiarl/images/content/box-frame-edge.gif') }});"></span>
                            <span class="CaptionEdgeRightTop" style="background-image:url({{ asset('/assets/tibiarl/images/content/box-frame-edge.gif') }});"></span>
                            <span class="CaptionBorderTop" style="background-image:url({{ asset('/assets/tibiarl/images/content/table-headline-border.gif') }});"></span>
                            <span class="CaptionVerticalLeft" style="background-image:url({{ asset('/assets/tibiarl/images/content/box-frame-vertical.gif') }});"></span>
                            <div class="Text">Navigation</div>
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
                                            <td align="center">
                                                <div id="NavigationContainer">
                                                    <div class="BigButton" onclick="RedirectToUrl('#');" style="background-image:url({{ asset('/assets/tibiarl/images/buttons/sbutton.gif') }})">
                                                        <div onmouseover="MouseOverBigButton(this);" onmouseout="MouseOutBigButton(this);"><div class="BigButtonOver" style="background-image:url({{ asset('/assets/tibiarl/images/buttons/sbutton_over.gif') }});"></div>
                                                            <input class="BigButtonText" type="submit" value="Guild Activity Log">
                                                        </div>
                                                    </div>
                                                    @if(\App\Utils\Guild::hasLeaderOrViceLeaderPrivileges($guildLevelRank))
                                                        <div style="font-size:1px;height:4px;"></div>
                                                        <div class="BigButton" onclick="RedirectToUrl('{{ route('community.view.guild.manage.applications.index', [Str::strToUrl($guild->name)]) }}');" style="background-image:url({{ asset('/assets/tibiarl/images/buttons/sbutton.gif') }})">
                                                            <div onmouseover="MouseOverBigButton(this);" onmouseout="MouseOutBigButton(this);"><div class="BigButtonOver" style="background-image:url({{ asset('/assets/tibiarl/images/buttons/sbutton_over.gif') }});"></div>
                                                                <input class="BigButtonText" type="submit" value="Guild Applications">
                                                            </div>
                                                        </div>
                                                    @endif
                                                    <div style="font-size:1px;height:4px;"></div>
                                                    <div class="BigButton" onclick="RedirectToUrl('#');" style="background-image:url({{ asset('/assets/tibiarl/images/buttons/sbutton.gif') }})">
                                                        <div onmouseover="MouseOverBigButton(this);" onmouseout="MouseOutBigButton(this);"><div class="BigButtonOver" style="background-image:url({{ asset('/assets/tibiarl/images/buttons/sbutton_over.gif') }});"></div>
                                                            <input class="BigButtonText" type="submit" value="Report Offence">
                                                        </div>
                                                    </div>
                                                    <div style="font-size:1px;height:4px;"></div>
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
                @if(\App\Utils\Guild::hasLeaderPrivileges($guildLevelRank))
                <div style="font-size:1px;height:6px;"></div>
                <div class="TableContainer">
                    <div class="CaptionContainer">
                        <div class="CaptionInnerContainer">
                            <span class="CaptionEdgeLeftTop" style="background-image:url({{ asset('/assets/tibiarl/images/content/box-frame-edge.gif') }});"></span>
                            <span class="CaptionEdgeRightTop" style="background-image:url({{ asset('/assets/tibiarl/images/content/box-frame-edge.gif') }});"></span>
                            <span class="CaptionBorderTop" style="background-image:url({{ asset('/assets/tibiarl/images/content/table-headline-border.gif') }});"></span>
                            <span class="CaptionVerticalLeft" style="background-image:url({{ asset('/assets/tibiarl/images/content/box-frame-vertical.gif') }});"></span>
                            <div class="Text">Administration</div>
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
                                            <td align="center">
                                                <div id="AdministrationContainer">
                                                    @if($guild->active)
                                                    <div class="BigButton" onclick="RedirectToUrl('{{ route('community.view.guild.manage.edit.index', [$guild->name]) }}');" style="background-image:url({{ asset('/assets/tibiarl/images/buttons/sbutton.gif') }})">
                                                        <div onmouseover="MouseOverBigButton(this);" onmouseout="MouseOutBigButton(this);"><div class="BigButtonOver" style="background-image:url({{ asset('/assets/tibiarl/images/buttons/sbutton_over.gif') }});"></div>
                                                            <input class="BigButtonText" type="submit" value="Edit Description">
                                                        </div>
                                                    </div>
                                                    <div style="font-size:1px;height:4px;"></div>
                                                    @endif
                                                    <div class="BigButton" onclick="RedirectToUrl('{{ route('community.view.guild.manage.disband.index', [$guild->name]) }}');" style="background-image:url({{ asset('/assets/tibiarl/images/buttons/sbutton.gif') }})">
                                                        <div onmouseover="MouseOverBigButton(this);" onmouseout="MouseOutBigButton(this);"><div class="BigButtonOver" style="background-image:url({{ asset('/assets/tibiarl/images/buttons/sbutton_over.gif') }});"></div>
                                                            <input class="BigButtonText" type="submit" value="Disband Guild">
                                                        </div>
                                                    </div>
                                                    <div style="font-size:1px;height:4px;"></div>
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
                @endif
            </td>
        </tr>
        </tbody>
    </table>
    <script type="text/javascript">
        $(document).ready(function() {
            var g_GuildInformationContainerHeight = $('#GuildInformationContainer').height();
            if ($('#AdministrationContainer').length > 0) {
                var g_AdministrationContainerHeight = $('#AdministrationContainer').height() + 28;
                var g_NavigationContainerHeight = $('#NavigationContainer').height() + 28;
            } else {
                var g_NavigationContainerHeight = $('#NavigationContainer').height();
                var g_AdministrationContainerHeight = 0;
            }
            //alert(g_GuildInformationContainerHeight+' '+g_NavigationContainerHeight+' '+g_AdministrationContainerHeight);
            if (g_GuildInformationContainerHeight < g_NavigationContainerHeight + g_AdministrationContainerHeight) {
                $('#GuildInformationContainer').css('height', g_NavigationContainerHeight + g_AdministrationContainerHeight);
            } else {
                if ($('#AdministrationContainer').length > 0) {
                    $('#NavigationContainer').css('height', g_GuildInformationContainerHeight * 0.7 - 28);
                    $('#AdministrationContainer').css('height', g_GuildInformationContainerHeight * 0.3 - 28);
                } else {
                    $('#NavigationContainer').css('height', g_GuildInformationContainerHeight);
                }
            }
            if (window.matchMedia('(max-width: 768px)').matches) {
                $('#NavigationContainer').css('height', 'inherit');
            }
        });
    </script>
    <br>
    <div class="TableContainer">
        <div class="CaptionContainer">
            <div class="CaptionInnerContainer">
                <span class="CaptionEdgeLeftTop" style="background-image:url({{ asset('/assets/tibiarl/images/content/box-frame-edge.gif') }});"></span>
                <span class="CaptionEdgeRightTop" style="background-image:url({{ asset('/assets/tibiarl/images/content/box-frame-edge.gif') }});"></span>
                <span class="CaptionBorderTop" style="background-image:url({{ asset('/assets/tibiarl/images/content/table-headline-border.gif') }});"></span>
                <span class="CaptionVerticalLeft" style="background-image:url({{ asset('/assets/tibiarl/images/content/box-frame-vertical.gif') }});"></span>
                <div class="Text">Guild Members</div>
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
                                                <td>Rank</td>
                                                <td>Name and Title</td>
                                                <td>Vocation</td>
                                                <td>Level</td>
                                                <td>Status</td>
                                            </tr>
                                            @foreach($guild->members->sortBy('ranks.level')->groupBy('ranks.level') as $guildMemberGroups)
                                                @php
                                                    $rowClass = $loop->index % 2 == 0 ? 'Even' : 'Odd';
                                                @endphp
                                                @foreach($guildMemberGroups as $guildMember)
                                                    <tr class="{{ $rowClass }}">
                                                        <td>@if($loop->first) {{ $guildMember->ranks->name }} @endif</td>
                                                        <td>
                                                            <a href="{{ route('community.view.character.search', Str::strToUrl($guildMember->player->name)) }}">{{ $guildMember->player->name }}</a> @if(!empty($guildMember->nick)) ({{ $guildMember->nick }}) @endif
                                                        </td>
                                                        <td>{{ \App\Utils\Vocation::getNameByVocationId($guildMember->player->vocation) }}</td>
                                                        <td>{{ $guildMember->player->level }}</td>
                                                        <td class="onlinestatus">
                                                            @if($guildMember->player->online) online @else <span class="red">offline</span> @endif
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
    <div class="SubmitButtonRow">
        @if(\App\Utils\Guild::hasLeaderOrViceLeaderPrivileges($guildLevelRank))
        <div class="LeftButton">
            <div class="BigButton" onclick="RedirectToUrl('{{ route('community.view.guild.manage.rank.index', Str::strToUrl($guild->name)) }}');" style="background-image:url({{ asset('/assets/tibiarl/images/buttons/sbutton.gif') }})">
                <div onmouseover="MouseOverBigButton(this);" onmouseout="MouseOutBigButton(this);"><div class="BigButtonOver" style="background-image:url({{ asset('/assets/tibiarl/images/buttons/sbutton_over.gif') }});"></div>
                    <input class="BigButtonText" type="submit" value="Edit Ranks">
                </div>
            </div>
        </div>
        <div class="LeftButton">
            <div class="BigButton" onclick="RedirectToUrl('{{ route('community.view.guild.manage.member.index', Str::strToUrl($guild->name)) }}');" style="background-image:url({{ asset('/assets/tibiarl/images/buttons/sbutton.gif') }})">
                <div onmouseover="MouseOverBigButton(this);" onmouseout="MouseOutBigButton(this);"><div class="BigButtonOver" style="background-image:url({{ asset('/assets/tibiarl/images/buttons/sbutton_over.gif') }});"></div>
                    <input class="BigButtonText" type="submit" value="Edit Members">
                </div>
            </div>
        </div>
        @endif
        @if(\App\Utils\Guild::hasMemberPrivileges($guildLevelRank))
        <div class="LeftButton">
            <div class="BigButton" onclick="RedirectToUrl('{{ route('community.view.guild.manage.leave.index', Str::strToUrl($guild->name)) }}');" style="background-image:url({{ asset('/assets/tibiarl/images/buttons/sbutton.gif') }})">
                <div onmouseover="MouseOverBigButton(this);" onmouseout="MouseOutBigButton(this);"><div class="BigButtonOver" style="background-image:url({{ asset('/assets/tibiarl/images/buttons/sbutton_over.gif') }});"></div>
                    <input class="BigButtonText" type="submit" value="Leave Guild">
                </div>
            </div>
        </div>
        @endif
    </div>
    <div class="TableContainer">
        <div class="CaptionContainer">
            <div class="CaptionInnerContainer">
                <span class="CaptionEdgeLeftTop" style="background-image:url({{ asset('/assets/tibiarl/images/content/box-frame-edge.gif') }});"></span>
                <span class="CaptionEdgeRightTop" style="background-image:url({{ asset('/assets/tibiarl/images/content/box-frame-edge.gif') }});"></span>
                <span class="CaptionBorderTop" style="background-image:url({{ asset('/assets/tibiarl/images/content/table-headline-border.gif') }});"></span>
                <span class="CaptionVerticalLeft" style="background-image:url({{ asset('/assets/tibiarl/images/content/box-frame-vertical.gif') }});"></span>
                <div class="Text">Invited Characters</div>
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
                                <td></td>
                            </tr>
                            <tr>
                                <td>
                                    <div class="TableContentContainer">
                                        <table class="TableContent" width="100%" style="border:1px solid #faf0d7;">
                                            <tbody>
                                            @forelse($guild->invitations as $guildInvite)
                                                @php
                                                    $rowClass = $loop->index % 2 == 0 ? 'Even' : 'Odd';
                                                @endphp
                                                @if($loop->first)
                                                <tr class="LabelH">
                                                    <td>Name</td>
                                                    <td>Invitation Date</td>
                                                </tr>
                                                @endif
                                                <tr class="{{ $rowClass }}">
                                                    <td>
                                                        <a class="DoNotBreak" href="{{ route('community.view.character.search', Str::strToUrl($guildInvite->player->name)) }}">{{ $guildInvite->player->name }}</a>
                                                    </td>
                                                    <td>{{ date('M d Y', strtotime($guildInvite->created_at)) }}</td>
                                                </tr>
                                            @empty
                                                <tr class="Even">
                                                    <td>No invited characters found.</td>
                                                </tr>
                                            @endforelse
                                            </tbody>
                                        </table>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <table class="InnerTableButtonRow" cellpadding="0" cellspacing="0">
                                        <tbody>
                                        <tr>
                                            @if(Auth::check())
                                                @if(!empty($invitedPlayers))
                                                    <td>
                                                        <div class="BigButton" onclick="RedirectToUrl('{{ route('community.view.guild.manage.join.index', Str::strToUrl($guild->name)) }}');" style="background-image:url({{ asset('/assets/tibiarl/images/buttons/sbutton.gif') }})">
                                                            <div onmouseover="MouseOverBigButton(this);" onmouseout="MouseOutBigButton(this);"><div class="BigButtonOver" style="background-image:url({{ asset('/assets/tibiarl/images/buttons/sbutton_over.gif') }});"></div>
                                                                <input class="BigButtonText" type="submit" value="Join Guild">
                                                            </div>
                                                        </div>
                                                    </td>
                                                @endif
                                                @if(\App\Utils\Guild::hasLeaderOrViceLeaderPrivileges($guildLevelRank))
                                                    <td>
                                                        <div class="BigButton" onclick="RedirectToUrl('{{ route('community.view.guild.manage.invite.index', Str::strToUrl($guild->name)) }}');" style="background-image:url({{ asset('/assets/tibiarl/images/buttons/sbutton.gif') }})">
                                                            <div onmouseover="MouseOverBigButton(this);" onmouseout="MouseOutBigButton(this);"><div class="BigButtonOver" style="background-image:url({{ asset('/assets/tibiarl/images/buttons/sbutton_over.gif') }});"></div>
                                                                <input class="BigButtonText" type="submit" value="Invite Characters">
                                                            </div>
                                                        </div>
                                                    </td>
                                                @endif
                                                @if(!empty($applyAbleCharacters) && $guild->applications_enabled)
                                                    <td>
                                                        <div class="BigButton" onclick="RedirectToUrl('{{ route('community.view.guild.my.applications.index', [Str::strToUrl($guild->name)]) }}');" style="background-image:url({{ asset('/assets/tibiarl/images/buttons/sbutton.gif') }})">
                                                            <div onmouseover="MouseOverBigButton(this);" onmouseout="MouseOutBigButton(this);"><div class="BigButtonOver" style="background-image:url({{ asset('/assets/tibiarl/images/buttons/sbutton_over.gif') }});"></div>
                                                                <input class="BigButtonText" type="submit" value="Apply to this Guild">
                                                            </div>
                                                        </div>
                                                    </td>
                                                @endif
                                                @if(empty($applyAbleCharacters) && \App\Utils\GuildApplications::hasGuildApplications($guild) || !$guild->applications_enabled && \App\Utils\GuildApplications::hasGuildApplications($guild))
                                                     <td>
                                                         <div class="BigButton" onclick="RedirectToUrl('{{ route('community.view.guild.my.applications.index', [Str::strToUrl($guild->name)]) }}');" style="background-image:url({{ asset('/assets/tibiarl/images/buttons/sbutton.gif') }})">
                                                             <div onmouseover="MouseOverBigButton(this);" onmouseout="MouseOutBigButton(this);"><div class="BigButtonOver" style="background-image:url({{ asset('/assets/tibiarl/images/buttons/sbutton_over.gif') }});"></div>
                                                                 <input class="BigButtonText" type="submit" value="View Applications">
                                                             </div>
                                                         </div>
                                                     </td>
                                                @endif
                                            @else
                                                <td>
                                                    <div class="BigButton" onclick="RedirectToUrl('{{ route('account.login.index') }}');" style="background-image:url({{ asset('/assets/tibiarl/images/buttons/sbutton.gif') }})">
                                                        <div onmouseover="MouseOverBigButton(this);" onmouseout="MouseOutBigButton(this);"><div class="BigButtonOver" style="background-image:url({{ asset('/assets/tibiarl/images/buttons/sbutton_over.gif') }});"></div>
                                                            <input class="BigButtonText" type="submit" value="Login">
                                                        </div>
                                                    </div>
                                                </td>
                                            @endif
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
    <div class="SubmitButtonRow">
        <div class="RightButton">
            <div class="BigButton" onclick="RedirectToUrl('{{ route('community.guilds.index') }}');" style="background-image:url({{ asset('/assets/tibiarl/images/buttons/sbutton.gif') }})">
                <div onmouseover="MouseOverBigButton(this);" onmouseout="MouseOutBigButton(this);"><div class="BigButtonOver" style="background-image:url({{ asset('/assets/tibiarl/images/buttons/sbutton_over.gif') }});"></div>
                    <input class="BigButtonText" type="submit" value="Back">
                </div>
            </div>
        </div>
    </div>
@endsection