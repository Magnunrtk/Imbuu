@extends('template.layout')
@section('title', 'Houses')
@section('submenuItem', 'houses')
@section('content')
    <div class="TableContainer">
        <div class="CaptionContainer">
            <div class="CaptionInnerContainer">
                <span class="CaptionEdgeLeftTop" style="background-image:url({{ asset('/assets/tibiarl/images/content/box-frame-edge.gif') }});"></span>
                <span class="CaptionEdgeRightTop" style="background-image:url({{ asset('/assets/tibiarl/images/content/box-frame-edge.gif') }});"></span>
                <span class="CaptionBorderTop" style="background-image:url({{ asset('/assets/tibiarl/images/content/table-headline-border.gif') }});"></span>
                <span class="CaptionVerticalLeft" style="background-image:url({{ asset('/assets/tibiarl/images/content/box-frame-vertical.gif') }});"></span>
                <div class="Text">Transfer Submitted</div>
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
                                    Transfer scheduled for {{ $moveOut->date->format('M d Y') }} at the daily server save. Note that the new owner has to accept the transfer.
                                    <br><br><br>
                                    <b>Note:</b>
                                    <br><br>
                                    Please <b>take all your personal belongings</b> out of the house before the daily server save on the day you move out.<br>
                                    Everything that remains in the house becomes the property of the new owner after the transfer.
                                    <br><br>
                                    If you are <b>transferring a guildhall, do not disband</b> the guild until the other guild leader has received the guildhall.<br>
                                    Otherwise the transfer will fail and the guildhall is put up for auction.<br>
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
                <div class="BigButton" onclick="RedirectToUrl('{{ route('community.view.house.index', $house->id) }}');" style="background-image:url({{ asset('/assets/tibiarl/images/buttons/sbutton.gif') }})">
                    <div onmouseover="MouseOverBigButton(this);" onmouseout="MouseOutBigButton(this);"><div class="BigButtonOver" style="background-image:url({{ asset('/assets/tibiarl/images/buttons/sbutton_over.gif') }});"></div>
                        <input class="BigButtonText" type="submit" value="Back">
                    </div>
                </div>
            </td>
        </tr>
        </tbody>
    </table>
@endsection