@extends('template.layout')
@section('title', 'Guilds')
@section('submenuItem', 'guilds')
@section('content')
    To change the number of ranks or to change the name of a rank, simply edit number or name in the corresponding field and confirm the change by clicking on "Submit". <br>
    <br>
    <div class="TableContainer">
        <div class="CaptionContainer">
            <div class="CaptionInnerContainer">
                <span class="CaptionEdgeLeftTop" style="background-image:url({{ asset('/assets/tibiarl/images/content/box-frame-edge.gif') }});"></span>
                <span class="CaptionEdgeRightTop" style="background-image:url({{ asset('/assets/tibiarl/images/content/box-frame-edge.gif') }});"></span>
                <span class="CaptionBorderTop" style="background-image:url({{ asset('/assets/tibiarl/images/content/table-headline-border.gif') }});"></span>
                <span class="CaptionVerticalLeft" style="background-image:url({{ asset('/assets/tibiarl/images/content/box-frame-vertical.gif') }});"></span>
                <div class="Text">Edit Guild Ranks</div>
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
                                            <tr>
                                                <td bgcolor="#D4C0A1">
                                                    <nobr></nobr>
                                                    <form action="{{ route('community.view.guild.manage.rank.updateNumberOfRank', [$guild->name]) }}" method="post">
                                                        @csrf
                                                        <table border="0" cellpadding="2">
                                                            <tbody>
                                                            <tr>
                                                                <td>Number&nbsp;of&nbsp;ranks:</td>
                                                                <td>
                                                                    <input name="ranks" value="{{ $currentGuildRanksAmount }}" size="2" maxlength="2">
                                                                </td>
                                                                <td>
                                                                    <small>(minimum&nbsp;3,&nbsp;maximum&nbsp;20)</small>
                                                                </td>
                                                                <td width="100%" align="right">
                                                                    <div class="BigButton" style="background-image:url({{ asset('/assets/tibiarl/images/buttons/sbutton.gif') }})">
                                                                        <div onmouseover="MouseOverBigButton(this);" onmouseout="MouseOutBigButton(this);"><div class="BigButtonOver" style="background-image:url({{ asset('/assets/tibiarl/images/buttons/sbutton_over.gif') }});"></div>
                                                                            <input class="BigButtonText" type="submit" value="Submit">
                                                                        </div>
                                                                    </div>
                                                                </td>
                                                            </tr>
                                                            </tbody>
                                                        </table>
                                                    </form>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td bgcolor="#D4C0A1">
                                                    <form action="{{ route('community.view.guild.manage.rank.updateRankName', [$guild->name]) }}" method="post" class="form">
                                                        @csrf
                                                        <table border="0" cellpadding="2">
                                                            <tbody>
                                                            <tr>
                                                                <td>Set&nbsp;rank&nbsp;name</td>
                                                                <td>
                                                                    <select name="rank_id">
                                                                        @foreach($guild->ranks as $rank)
                                                                            <option value="{{ $rank->order_id }}">{{ $rank->order_id }}: {{ $rank->name }}</option>
                                                                        @endforeach
                                                                    </select>
                                                                </td>
                                                                <td>to:</td>
                                                                <td>
                                                                    <input name="newRankName" value="" size="30" maxlength="29">
                                                                </td>
                                                                <td width="100%" align="right">
                                                                    <div class="BigButton" style="background-image:url({{ asset('/assets/tibiarl/images/buttons/sbutton.gif') }})">
                                                                        <div onmouseover="MouseOverBigButton(this);" onmouseout="MouseOutBigButton(this);"><div class="BigButtonOver" style="background-image:url({{ asset('/assets/tibiarl/images/buttons/sbutton_over.gif') }});"></div>
                                                                            <input class="BigButtonText" type="submit" value="Submit">
                                                                        </div>
                                                                    </div>
                                                                </td>
                                                            </tr>
                                                            </tbody>
                                                        </table>
                                                    </form>
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
    <br>
    <table border="0" width="100%">
        <tbody>
        <tr>
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
@endsection