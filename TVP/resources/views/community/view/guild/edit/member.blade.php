@extends('template.layout')
@section('title', 'Guilds')
@section('submenuItem', 'guilds')
@section('content')
    Select a member and the action you want to perform, then click on "Submit". <br>
    <br>
    <form action="{{ route('community.view.guild.manage.member.action', [$guild->name]) }}" method="post" class="form">
        @csrf
        <div class="TableContainer">
            <div class="CaptionContainer">
                <div class="CaptionInnerContainer">
                    <span class="CaptionEdgeLeftTop" style="background-image:url({{ asset('/assets/tibiarl/images/content/box-frame-edge.gif') }});"></span>
                    <span class="CaptionEdgeRightTop" style="background-image:url({{ asset('/assets/tibiarl/images/content/box-frame-edge.gif') }});"></span>
                    <span class="CaptionBorderTop" style="background-image:url({{ asset('/assets/tibiarl/images/content/table-headline-border.gif') }});"></span>
                    <span class="CaptionVerticalLeft" style="background-image:url({{ asset('/assets/tibiarl/images/content/box-frame-vertical.gif') }});"></span>
                    <div class="Text">Edit Members</div>
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
                                            <tbody>
                                            <tr>
                                                <td valign="top">
                                                    <table border="0" cellspacing="0" cellpadding="1">
                                                        <tbody>
                                                        <tr>
                                                            <td>Name:</td>
                                                            <td>
                                                                <select name="character">
                                                                    @foreach($guild->members as $guildMember)
                                                                        <option value="{{ $guildMember->player->name }}">{{ $guildMember->player->name }} ({{ $guildMember->ranks->name }})</option>
                                                                    @endforeach
                                                                </select>
                                                            </td>
                                                        </tr>
                                                        </tbody>
                                                    </table>
                                                </td>
                                                <td>&nbsp;&nbsp;&nbsp;</td>
                                                <td valign="top">
                                                    <table border="0" cellspacing="0" cellpadding="1">
                                                        <tbody>
                                                        <tr>
                                                            <td>Action:</td>
                                                            <td>
                                                                <input type="radio" id="changeRank" name="action" required="required" value="1" checked="checked"> Set rank to
                                                                <select name="rank_id">
                                                                    @foreach($guild->ranks as $rank)
                                                                        @if($rank->level === \App\Utils\GuildRanks::LEADER_LEVEL)
                                                                            @continue
                                                                        @endif
                                                                        <option value="{{ $rank->order_id }}">{{ $rank->order_id }}
                                                                            : {{ $rank->name }}</option>
                                                                    @endforeach
                                                                </select>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td></td>
                                                            <td>
                                                                <input type="radio" id="changeTitle" name="action" required="required" value="2"> Set title to <input name="title" size="30" maxlength="29">
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td></td>
                                                            <td>
                                                                <input type="radio" id="excludeFromGuild" name="action" required="required" value="3"> Exclude from guild
                                                            </td>
                                                        </tr>
                                                        </tbody>
                                                    </table>
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
        <table border="0" width="100%">
            <tbody>
            <tr align="center">
                <td align="center">
                    <div class="BigButton" style="background-image:url({{ asset('/assets/tibiarl/images/buttons/sbutton.gif') }})">
                        <div onmouseover="MouseOverBigButton(this);" onmouseout="MouseOutBigButton(this);"><div class="BigButtonOver" style="background-image:url({{ asset('/assets/tibiarl/images/buttons/sbutton_over.gif') }});"></div>
                            <input class="BigButtonText" type="submit" value="Submit">
                        </div>
                    </div>
                </td>
                <td align="center">
                    <div class="BigButton" onclick="RedirectToUrl('{{ route('community.view.guild.index', Str::strToUrl($guild->name)) }}');" style="background-image:url({{ asset('/assets/tibiarl/images/buttons/sbutton.gif') }})">
                        <div onmouseover="MouseOverBigButton(this);" onmouseout="MouseOutBigButton(this);"><div class="BigButtonOver" style="background-image:url({{ asset('/assets/tibiarl/images/buttons/sbutton_over.gif') }});"></div>
                            <input class="BigButtonText" type="submit" value="Back">
                        </div>
                    </div>
                </td>
            </tr>
            </tbody>
        </table>
    </form>
@endsection