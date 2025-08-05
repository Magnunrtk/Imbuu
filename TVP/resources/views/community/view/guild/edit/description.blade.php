@extends('template.layout')
@section('title', 'Guilds')
@section('submenuItem', 'guilds')
@section('content')
If you want to change the description or the URL of the official homepage of your guild, edit the corresponding field and click on the "Submit" button.<br><br>
<form action="{{ route('community.view.guild.manage.edit.description.action', [$guild->name]) }}" method="post">
    @csrf
    <div class="TableContainer">
        <div class="CaptionContainer">
            <div class="CaptionInnerContainer">
                <span class="CaptionEdgeLeftTop" style="background-image:url({{ asset('/assets/tibiarl/images/content/box-frame-edge.gif') }});"></span>
                <span class="CaptionEdgeRightTop" style="background-image:url({{ asset('/assets/tibiarl/images/content/box-frame-edge.gif') }});"></span>
                <span class="CaptionBorderTop" style="background-image:url({{ asset('/assets/tibiarl/images/content/table-headline-border.gif') }});"></span>
                <span class="CaptionVerticalLeft" style="background-image:url({{ asset('/assets/tibiarl/images/content/box-frame-vertical.gif') }});"></span>
                <div class="Text">Guild Description</div>
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
                                            <td valign="top"><br>Description:</td>
                                            <td>
                                                <textarea name="description" rows="10" cols="50" wrap="virtual">{{ $guild->web_guild->description }}</textarea>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td></td>
                                            <td></td>
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
</form>
<br>If you want to change the logo of your guild, enter the path to a 64*64 pixels GIF icon and click on the "Submit" button.<br>Leave the path empty if you want to use the default logo.<br>
It can take up to 15 minutes until the change of your logo takes effect. Please be patient.<br><br>
<form action="{{ route('community.view.guild.manage.edit.logo.action', [$guild->name]) }}" method="post" enctype="multipart/form-data">
    @csrf
    <div class="TableContainer">
        <div class="CaptionContainer">
            <div class="CaptionInnerContainer">
                <span class="CaptionEdgeLeftTop" style="background-image:url({{ asset('/assets/tibiarl/images/content/box-frame-edge.gif') }});"></span>
                <span class="CaptionEdgeRightTop" style="background-image:url({{ asset('/assets/tibiarl/images/content/box-frame-edge.gif') }});"></span>
                <span class="CaptionBorderTop" style="background-image:url({{ asset('/assets/tibiarl/images/content/table-headline-border.gif') }});"></span>
                <span class="CaptionVerticalLeft" style="background-image:url({{ asset('/assets/tibiarl/images/content/box-frame-vertical.gif') }});"></span>
                <div class="Text">Guild Logo</div>
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
                                            <td valign="top"><br>Current&nbsp;logo:</td>
                                            <td><img src="{{ asset('/images/guilds/' . $guild->web_guild->logo_name) }}" width="64" height="64"></td>
                                        </tr>
                                        <tr>
                                            <td>New logo:</td>
                                            <td>
                                                <input type="hidden" name="MAX_FILE_SIZE" value="65536">
                                                <input type="file" name="logo" size="40" accept="image/gif">
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
</form>
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