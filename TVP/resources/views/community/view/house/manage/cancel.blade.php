@extends('template.layout')
@section('title', 'Houses')
@section('submenuItem', 'houses')
@section('content')
    He will move out on {{ \Carbon\Carbon::parse($house->moveOut->date)->format('M, d, Y') }}, {{ config('server.serverSaveTime') }} {{ config('server.serverTimeZone') }} (time of daily server save) @if($house->moveOut->transfer) and wants to pass the house to <a href="{{ route('community.view.character.search', Str::strToUrl($house->moveOut->transfer->player->name)) }}" class="text-dark text-hover-primary">{{ $house->moveOut->transfer->player->name }}</a> for <b>{{ $house->moveOut->transfer->price }} gold coins.</b> @endif If you want to revoke your termination, fill in the form and click on "Submit".
    <br>
    <br>
    <form method="post" action="{{ route('community.view.house.manage.keep-house.action', [$house->id]) }}" class="form">
        @csrf
        <div class="TableContainer">
            <div class="CaptionContainer">
                <div class="CaptionInnerContainer">
                    <span class="CaptionEdgeLeftTop" style="background-image:url({{ asset('/assets/tibiarl/images/content/box-frame-edge.gif') }});"></span>
                    <span class="CaptionEdgeRightTop" style="background-image:url({{ asset('/assets/tibiarl/images/content/box-frame-edge.gif') }});"></span>
                    <span class="CaptionBorderTop" style="background-image:url({{ asset('/assets/tibiarl/images/content/table-headline-border.gif') }});"></span>
                    <span class="CaptionVerticalLeft" style="background-image:url({{ asset('/assets/tibiarl/images/content/box-frame-vertical.gif') }});"></span>
                    <div class="Text">Cancel Action</div>
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
                            <div class="TableScrollbarContainer"> </div>
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
                                                    <td>I do <b>not</b> want to <b>leave or transfer</b> my house {{ $house->name }}<br><br></td>
                                                </tr>
                                                <tr>
                                                    <td>To continue please <b>enter your password</b>.</td>
                                                </tr>
                                                <tr>
                                                    <td>Password: <input type="password" name="password" size="30" maxlength="29"></td>
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
        <br>
        <table style="width: 100%;">
            <tbody>
            <tr align="center" valign="top">
                <td>
                    <div class="BigButton" style="background-image:url({{ asset('/assets/tibiarl/images/buttons/sbutton.gif') }})">
                        <div onmouseover="MouseOverBigButton(this);" onmouseout="MouseOutBigButton(this);"><div class="BigButtonOver" style="background-image:url({{ asset('/assets/tibiarl/images/buttons/sbutton_over.gif') }});"></div>
                            <input class="BigButtonText" type="submit" value="Submit">
                        </div>
                    </div>
                </td>
                <td>
                    <div class="BigButton" onclick="RedirectToUrl('{{ route('community.view.house.index', $house->id) }}');" style="background-image:url({{ asset('/assets/tibiarl/images/buttons/sbutton.gif') }})">
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