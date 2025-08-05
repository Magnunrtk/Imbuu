@extends('template.layout')
@section('title', 'Houses')
@section('submenuItem', 'houses')
@section('content')
    The house <a href="{{ route('community.view.house.index', [$house->id]) }}">{{ $house->name }}</a> is currently rented by <a href="{{ route('community.view.character.search', Str::strToUrl($house->ownerPlayer->name)) }}" class="text-dark text-hover-primary">{{ $house->ownerPlayer->name }}</a>. He will move out on {{ \Carbon\Carbon::parse($house->moveOut->date)->format('M, d, Y') }}, {{ config('server.serverSaveTime') }} {{ config('server.serverTimeZone') }} @if($house->moveOut->transfer) and wants to pass the house to <a href="{{ route('community.view.character.search', Str::strToUrl($house->moveOut->transfer->player->name)) }}" class="text-dark text-hover-primary">{{ $house->moveOut->transfer->player->name }}</a> for <b>{{ $house->moveOut->transfer->price }} gold coins.</b> @endif If you want to take this house, fill in the form and click on "Submit".<br><br>
    <form method="post" action="{{ route('community.view.house.manage.transfer.accept.action', [$house->id]) }}" class="form">
        @csrf
        <div class="TableContainer">
            <div class="CaptionContainer">
                <div class="CaptionInnerContainer">
                    <span class="CaptionEdgeLeftTop" style="background-image:url({{ asset('/assets/tibiarl/images/content/box-frame-edge.gif') }});"></span>
                    <span class="CaptionEdgeRightTop" style="background-image:url({{ asset('/assets/tibiarl/images/content/box-frame-edge.gif') }});"></span>
                    <span class="CaptionBorderTop" style="background-image:url({{ asset('/assets/tibiarl/images/content/table-headline-border.gif') }});"></span>
                    <span class="CaptionVerticalLeft" style="background-image:url({{ asset('/assets/tibiarl/images/content/box-frame-vertical.gif') }});"></span>
                    <div class="Text">Accept House Transfer</div>
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
                                                    <td class="LabelV200">Your Answer:</td>
                                                    <td><input type="radio" name="action" value="1" checked="checked"> Yes, I want to take this house for <b>{{ $house->moveOut->transfer->price }} gold</b>.<br><input type="radio" name="action" value="2"> No, I don't want to take this house.</td>
                                                </tr>
                                                <tr>
                                                    <td class="LabelV200">Your Account Password:</td>
                                                    <td><input type="password" name="password" size="30" maxlength="29"></td>
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
        <br><br>Please make sure that you pay the cost for this house transfer and that you can afford to pay the following monthly rents. The rent is currently paid until {{ date('M d, Y', $house->paid) }}. Note that no door list but only the guest list is reset.<br><br>
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