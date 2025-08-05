@extends('template.layout')
@section('title', 'Guilds')
@section('submenuItem', 'guilds')
@section('content')
    Click on any view button to get more information about a guild. <br>
    <br>
    <br>
    @if(config('multi_world.enabled'))
        <form action="{{ route('community.guilds.loadList') }}" method="POST">
            @csrf
            <div class="TableContainer">
                <div class="CaptionContainer">
                    <div class="CaptionInnerContainer">
                        <span class="CaptionEdgeLeftTop" style="background-image:url({{ asset('/assets/tibiarl/images/content/box-frame-edge.gif') }});"></span>
                        <span class="CaptionEdgeRightTop" style="background-image:url({{ asset('/assets/tibiarl/images/content/box-frame-edge.gif') }});"></span>
                        <span class="CaptionBorderTop" style="background-image:url({{ asset('/assets/tibiarl/images/content/table-headline-border.gif') }});"></span>
                        <span class="CaptionVerticalLeft" style="background-image:url({{ asset('/assets/tibiarl/images/content/box-frame-vertical.gif') }});"></span>
                        <div class="Text">World Selection</div>
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
                                            <div class="ThreeColumnsForm">
                                                <div class="LabelV120 ThreeColumnsFormCell">World Name:</div>
                                                <div class="ThreeColumnsFormCell ThreeColumnsFormInputCell">
                                                    <select size="1" name="world" style="width:165px;">
                                                        <option value="" selected="">(choose world)</option>
                                                        @foreach(config('multi_world.worlds') as $selectWorld)
                                                            <option value="{{ $selectWorld['slug'] }}">{{ $selectWorld['name'] }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                                <div class="ThreeColumnsFormButton ThreeColumnsFormCell">
                                                    <div class="BigButton" style="background-image:url({{ asset('/assets/tibiarl/images/buttons/sbutton.gif') }})">
                                                        <div onmouseover="MouseOverBigButton(this);" onmouseout="MouseOutBigButton(this);"><div class="BigButtonOver" style="background-image: url({{ asset('/assets/tibiarl/images/buttons/sbutton_over.gif') }}); visibility: hidden;"></div>
                                                            <input class="BigButtonText" type="submit" value="View">
                                                        </div>
                                                    </div>
                                                </div>
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
    </form>
    <br>
    <br>
    @endif
    <div class="TableContainer">
        <div class="CaptionContainer">
            <div class="CaptionInnerContainer">
                <span class="CaptionEdgeLeftTop" style="background-image:url({{ asset('/assets/tibiarl/images/content/box-frame-edge.gif') }});"></span>
                <span class="CaptionEdgeRightTop" style="background-image:url({{ asset('/assets/tibiarl/images/content/box-frame-edge.gif') }});"></span>
                <span class="CaptionBorderTop" style="background-image:url({{ asset('/assets/tibiarl/images/content/table-headline-border.gif') }});"></span>
                <span class="CaptionVerticalLeft" style="background-image:url({{ asset('/assets/tibiarl/images/content/box-frame-vertical.gif') }});"></span>
                <div class="Text">Active Guilds</div>
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
                                            <tr bgcolor="#D4C0A1">
                                                <td width="64">
                                                    <b>Logo</b>
                                                </td>
                                                <td width="100%">
                                                    <b>Description</b>
                                                </td>
                                                <td width="56">
                                                    <b>&nbsp;</b>
                                                </td>
                                            </tr>
                                            @forelse($guildList as $guild)
                                                @php
                                                    $rowClass = $loop->index % 2 == 0 ? 'Even' : 'Odd';
                                                @endphp
                                                <tr class="{{ $rowClass }}">
                                                    <td>
                                                        <img src="{{ asset('/images/guilds/' . $guild->web_guild->logo_name) }}" width="64" height="64">
                                                    </td>
                                                    <td>
                                                        <b>{{ $guild->name }}</b>
                                                        <br>{{ $guild->web_guild->description }}
                                                    </td>
                                                    <td>
                                                        <div class="BigButton" onclick="RedirectToUrl('{{ route('community.view.guild.index',  Str::strToUrl($guild->name)) }}');" style="background-image:url({{ asset('/assets/tibiarl/images/buttons/sbutton.gif') }})">
                                                            <div onmouseover="MouseOverBigButton(this);" onmouseout="MouseOutBigButton(this);"><div class="BigButtonOver" style="background-image: url({{ asset('/assets/tibiarl/images/buttons/sbutton_over.gif') }}); visibility: hidden;"></div>
                                                                <input class="BigButtonText" type="submit" value="View">
                                                            </div>
                                                        </div>
                                                    </td>
                                                </tr>
                                            @empty
                                                <tr class="Even">
                                                    <td colspan="3">There is currently no Guild on this Gameworld.</td>
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
    <table border="0" cellspacing="1" cellpadding="4" width="100%">
        <tbody>
        <tr>
            <td>No guild found that suits your needs?</td>
        </tr>
        <tr>
            <td>
                <div class="BigButton" onclick="RedirectToUrl('{{ route('community.guild.create.index') }}');" style="background-image:url({{ asset('/assets/tibiarl/images/buttons/sbutton.gif') }})">
                    <div onmouseover="MouseOverBigButton(this);" onmouseout="MouseOutBigButton(this);"><div class="BigButtonOver" style="background-image:url({{ asset('/assets/tibiarl/images/buttons/sbutton_over.gif') }});"></div>
                        <input class="BigButtonText" type="submit" value="Found Guild">
                    </div>
                </div>
            </td>
        </tr>
        </tbody>
    </table>
@endsection