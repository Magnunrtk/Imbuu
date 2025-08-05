@extends('template.layout')
@section('title', 'Guilds')
@section('submenuItem', 'guilds')
@section('content')
    Do you really want to disband your guild? Confirm this decision with your password and click on "Submit". <br>
    <br>
    <form action="{{ route('community.view.guild.manage.disband.action', [$guild->name]) }}" method="post" class="form">
        @csrf
        <div class="TableContainer">
            <div class="CaptionContainer">
                <div class="CaptionInnerContainer">
                    <span class="CaptionEdgeLeftTop" style="background-image:url({{ asset('/assets/tibiarl/images/content/box-frame-edge.gif') }});"></span>
                    <span class="CaptionEdgeRightTop" style="background-image:url({{ asset('/assets/tibiarl/images/content/box-frame-edge.gif') }});"></span>
                    <span class="CaptionBorderTop" style="background-image:url({{ asset('/assets/tibiarl/images/content/table-headline-border.gif') }});"></span>
                    <span class="CaptionVerticalLeft" style="background-image:url({{ asset('/assets/tibiarl/images/content/box-frame-vertical.gif') }});"></span>
                    <div class="Text">Disband Guild</div>
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
                    <div class="BigButton" onclick="RedirectToUrl('{{ route('community.view.guild.index', Str::strToUrl($guild->name)) }}');" style="background-image:url({{ asset('/assets/tibiarl/images/buttons/sbutton.gif') }})">
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