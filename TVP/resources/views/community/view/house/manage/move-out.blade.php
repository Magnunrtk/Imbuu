@extends('template.layout')
@section('title', 'Houses')
@section('submenuItem', 'houses')
@section('styles')
    <link rel="stylesheet" type="text/css" href="{{ asset('/assets/css/daterangepicker.css') }}" />
@endsection
@section('content')
    The house <a href="{{ route('community.view.house.index', [$house->id]) }}">{{ $house->name }}</a> is currently rented by <a href="{{ route('community.view.character.search', Str::strToUrl($house->ownerPlayer->name)) }}">{{ $house->ownerPlayer->name }}</a>. If you want to leave this house, fill in the form and click on "Submit".<br><br>
    <form method="post" action="{{ route('community.view.house.manage.move-out.action', [$house->id]) }}" class="form">
        @csrf
        <div class="TableContainer">
            <div class="CaptionContainer">
                <div class="CaptionInnerContainer">
                    <span class="CaptionEdgeLeftTop" style="background-image:url({{ asset('/assets/tibiarl/images/content/box-frame-edge.gif') }});"></span>
                    <span class="CaptionEdgeRightTop" style="background-image:url({{ asset('/assets/tibiarl/images/content/box-frame-edge.gif') }});"></span>
                    <span class="CaptionBorderTop" style="background-image:url({{ asset('/assets/tibiarl/images/content/table-headline-border.gif') }});"></span>
                    <span class="CaptionVerticalLeft" style="background-image:url({{ asset('/assets/tibiarl/images/content/box-frame-vertical.gif') }});"></span>
                    <div class="Text">Move Out</div>
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
                                                    <td>I want to <b>leave</b> my house {{ $house->name }}<br><br>on <input type="text" id="move_out_daterangepicker" name="date" required="required" size="10" maxlength="20"> at the daily server save.<br><br><br></td>
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
        <br><br>
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
@section('scripts')
    <script type="text/javascript" src="{{ asset('/assets/js/moment.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('/assets/js/daterangepicker.min.js') }}"></script>
    <script type="text/javascript">
        $("#move_out_daterangepicker").daterangepicker({
                minDate: new Date(),
                autoApply: true,
                locale: {
                    firstDay: 1,
                    format: 'DD/MM/YYYY'
                },
                singleDatePicker: true,
                showDropdowns: true,
            }
        );
    </script>
@endsection