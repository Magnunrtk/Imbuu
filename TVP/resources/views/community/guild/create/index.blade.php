@extends('template.layout')
@section('title', 'Guilds')
@section('submenuItem', 'guilds')
@section('content')
    Do you want to found a new guild? In order to do that, you need a premium account and none of your characters may hold one of the two highest ranks in any other guild. Note that you need four other players with premium accounts that also meet these requirements, before the guild is active in the game. <br>
    <br> Now enter the name of the new guild, select the world it should exist on, specify the name of your character that should become the first leader and confirm with your account password. Then click on "Submit". Note that the first two data cannot be changed later. <br>
    <br>
    <form action="{{ route('community.guild.create.action') }}" method="post" class="form">
        @csrf
        <div class="TableContainer">
            <div class="CaptionContainer">
                <div class="CaptionInnerContainer">
                    <span class="CaptionEdgeLeftTop" style="background-image:url({{ asset('/assets/tibiarl/images/content/box-frame-edge.gif') }});"></span>
                    <span class="CaptionEdgeRightTop" style="background-image:url({{ asset('/assets/tibiarl/images/content/box-frame-edge.gif') }});"></span>
                    <span class="CaptionBorderTop" style="background-image:url({{ asset('/assets/tibiarl/images/content/table-headline-border.gif') }});"></span>
                    <span class="CaptionVerticalLeft" style="background-image:url({{ asset('/assets/tibiarl/images/content/box-frame-vertical.gif') }});"></span>
                    <div class="Text">Found Guild</div>
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
                                                <td>Guild Name:</td>
                                                <td>
                                                    <input name="guildName" value="" size="30" maxlength="29">
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>Leader:</td>
                                                <td>
                                                    <select name="character">
                                                        @forelse(Auth::user()->characters as $character)
                                                            <option value="{{ $character->name }}">{{ $character->name }}</option>
                                                        @empty
                                                            <option>No character available</option>
                                                        @endforelse
                                                    </select>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>Password:</td>
                                                <td>
                                                    <input type="password" name="password" size="30" maxlength="29">
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
            <tr>
                <td align="center">
                    <img src="{{ asset('/assets/tibiarl/images/general/blank.gif') }}" width="120" height="1" border="0">
                    <br>
                </td>
                <td align="center">
                    <div class="BigButton" style="background-image:url({{ asset('/assets/tibiarl/images/buttons/sbutton.gif') }})">
                        <div onmouseover="MouseOverBigButton(this);" onmouseout="MouseOutBigButton(this);"><div class="BigButtonOver" style="background-image:url({{ asset('/assets/tibiarl/images/buttons/sbutton_over.gif') }});"></div>
                            <input class="BigButtonText" type="submit" value="Submit">
                        </div>
                    </div>
                </td>
                <td align="center">
                    <div class="BigButton" onclick="RedirectToUrl('{{ route('community.guilds.index') }}');" style="background-image:url({{ asset('/assets/tibiarl/images/buttons/sbutton.gif') }})">
                        <div onmouseover="MouseOverBigButton(this);" onmouseout="MouseOutBigButton(this);"><div class="BigButtonOver" style="background-image:url({{ asset('/assets/tibiarl/images/buttons/sbutton_over.gif') }});"></div>
                            <input class="BigButtonText" type="submit" value="Back">
                        </div>
                    </div>
                </td>
                <td align="center">
                    <img src="{{ asset('/assets/tibiarl/images/general/blank.gif') }}" width="120" height="1" border="0">
                    <br>
                </td>
            </tr>
            </tbody>
        </table>
    </form>
@endsection
