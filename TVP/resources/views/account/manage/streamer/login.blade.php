@extends('template.layout')

@section('title', 'Streamer Dashboard Login')
@section('submenuItem', 'accountmanagement')

@section('content')

    @if ($errors->any())
        <div class="SmallBox">
            <div class="MessageContainer">
                <div class="BoxFrameHorizontal" style="background-image:url({{ asset('/assets/tibiarl/images/content/box-frame-horizontal.gif') }});"></div>
                <div class="BoxFrameEdgeLeftTop" style="background-image:url({{ asset('/assets/tibiarl/images/content/box-frame-edge.gif') }});"></div>
                <div class="BoxFrameEdgeRightTop" style="background-image:url({{ asset('/assets/tibiarl/images/content/box-frame-edge.gif') }});"></div>
                <div class="ErrorMessage">
                    <div class="BoxFrameVerticalLeft" style="background-image:url({{ asset('/assets/tibiarl/images/content/box-frame-vertical.gif') }});"></div>
                    <div class="BoxFrameVerticalRight" style="background-image:url({{ asset('/assets/tibiarl/images/content/box-frame-vertical.gif') }});"></div>
                    <div class="AttentionSign" style="background-image:url({{ asset('/assets/tibiarl/images/content/attentionsign.gif') }});"></div>
                    <b>The following error has occurred:</b>
                    <br>
                    @foreach ($errors->all() as $error)
                        <span>{{ $error }}</span><br>
                    @endforeach
                </div>
                <div class="BoxFrameHorizontal" style="background-image:url({{ asset('/assets/tibiarl/images/content/box-frame-horizontal.gif') }});"></div>
                <div class="BoxFrameEdgeRightBottom" style="background-image:url({{ asset('/assets/tibiarl/images/content/box-frame-edge.gif') }});"></div>
                <div class="BoxFrameEdgeLeftBottom" style="background-image:url({{ asset('/assets/tibiarl/images/content/box-frame-edge.gif') }});"></div>
            </div>
        </div>

        <br>
    @endif

    <div class="TableContainer">
        <form action="{{ route('account.manage.streamer.login.submit') }}" method="post" style="margin: 0px; padding: 0px;">
            @csrf
            <div class="CaptionContainer">
                <div class="CaptionInnerContainer">
                    <span class="CaptionEdgeLeftTop" style="background-image:url({{ asset('/assets/tibiarl/images/content/box-frame-edge.gif') }});"></span>
                    <span class="CaptionEdgeRightTop" style="background-image:url({{ asset('/assets/tibiarl/images/content/box-frame-edge.gif') }});"></span>
                    <span class="CaptionBorderTop" style="background-image:url({{ asset('/assets/tibiarl/images/content/table-headline-border.gif') }});"></span>
                    <span class="CaptionVerticalLeft" style="background-image:url({{ asset('/assets/tibiarl/images/content/box-frame-vertical.gif') }});"></span>
                    <div class="Text">Streamer Dashboard Login</div>
                    <span class="CaptionVerticalRight" style="background-image:url({{ asset('/assets/tibiarl/images/content/box-frame-vertical.gif') }});"></span>
                    <span class="CaptionBorderBottom" style="background-image:url({{ asset('/assets/tibiarl/images/content/table-headline-border.gif') }});"></span>
                    <span class="CaptionEdgeLeftBottom" style="background-image:url({{ asset('/assets/tibiarl/images/content/box-frame-edge.gif') }});"></span>
                    <span class="CaptionEdgeRightBottom" style="background-image:url({{ asset('/assets/tibiarl/images/content/box-frame-edge.gif') }});"></span>
                </div>
            </div>
            <table class="Table4" cellpadding="0" cellspacing="0">
                <tbody>
                    <tr>
                        <td>
                            <div class="InnerTableContainer">
                                <table style="width:100%;">
                                    <tbody>
                                        <tr>
                                            <td>
                                                <div class="TableContentContainer">
                                                    <table class="TableContent" width="100%" style="border:1px solid #faf0d7;">
                                                        <tbody>
                                                            <tr>
                                                                <td>
                                                                    <table style="float: left; width: 370px;" cellpadding="0" cellspacing="0">
                                                                        <tbody>
                                                                            <tr>
                                                                                <td class="LabelV120"><span>Streamer Name:</span></td>
                                                                                <td><input type="text" name="streamer_name" size="29" maxlength="30" required></td>
                                                                            </tr>
                                                                            <tr>
                                                                                <td class="LabelV120"><span>Access Code:</span></td>
                                                                                <td><input type="password" name="access_code" size="29" maxlength="29" required></td>
                                                                            </tr>
                                                                        </tbody>
                                                                    </table>
                                                                    <div style="float: right; font-size: 1px;">

                                                                        <div class="BigButton" style="background-image:url({{ asset('/assets/tibiarl/images/buttons/sbutton.gif') }})">
                                                                            <div onmouseover="MouseOverBigButton(this);" onmouseout="MouseOutBigButton(this);"><div class="BigButtonOver" style="background-image:url({{ asset('/assets/tibiarl/images/buttons/sbutton_over.gif') }});"></div>
                                                                                <input class="BigButtonText" type="submit" value="Login">
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
                        </td>
                    </tr>
                </tbody>
            </table>
        </form>
    </div>
@endsection
