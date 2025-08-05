@extends('template.layout')
@section('title', 'Welcome to ' . config('server.serverName'))
@section('submenuItem', 'accountmanagement')
@if(Session::has('downloadClient'))
@section('metaTag')
    <meta http-equiv="refresh" content="3;url={{ route('download.start') }}">
@endsection
@endif
@section('content')
    <div id="StartDownloadContainer">
        <div class="TableContainer">
            <div class="CaptionContainer">
                <div class="CaptionInnerContainer">
                    <span class="CaptionEdgeLeftTop" style="background-image:url({{ asset('/assets/tibiarl/images/content/box-frame-edge.gif') }});"></span>
                    <span class="CaptionEdgeRightTop" style="background-image:url({{ asset('/assets/tibiarl/images/content/box-frame-edge.gif') }});"></span>
                    <span class="CaptionBorderTop" style="background-image:url({{ asset('/assets/tibiarl/images/content/table-headline-border.gif') }});"></span>
                    <span class="CaptionVerticalLeft" style="background-image:url({{ asset('/assets/tibiarl/images/content/box-frame-vertical.gif') }});"></span>
                    <div class="Text">Welcome to {{ config('server.serverName') }}</div>
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
                        <div class="InnerTableContainer">
                            <table style="width:100%;">
                                <tbody>
                                <tr>
                                    <td>
                                        <h3>{{ config('server.serverName') }}...</h3>
                                        <div style="margin-left: 10px; margin-bottom: 40px;">
                                            <p>... where hardcore gaming meets fantasy.</p>
                                            <p>... where friendships last a lifetime.</p>
                                        </div>
                                        <div style="margin-right: 215px;">
                                            <h3>Thank you for creating a {{ config('server.serverName') }} Account!</h3>
                                            <p>The download of the {{ config('server.serverName') }} Client should start automatically. If the download did not start automatically please click on the "Download" button.</p>
                                        </div>
                                        <br>
                                        <table style="width: 100%;">
                                            <tbody>
                                            <tr align="center" valign="top">
                                                <td>
                                                    <div style="float: right; margin-right: 20px;">
                                                        <div class="BigButton" onclick="RedirectToUrl('{{ route('account.index') }}');" style="background-image:url({{ asset('/assets/tibiarl/images/buttons/sbutton.gif') }})">
                                                            <div onmouseover="MouseOverBigButton(this);" onmouseout="MouseOutBigButton(this);"><div class="BigButtonOver" style="background-image: url({{ asset('/assets/tibiarl/images/buttons/sbutton_over.gif') }}); visibility: hidden;"></div>
                                                                <input class="BigButtonText" type="submit" value="Manage Account">
                                                            </div>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td>
                                                    <div style="float: left; margin-left: 20px;">
                                                        <div class="BigButton" onclick="RedirectToUrl('{{ route('download.index') }}');" style="background-image:url({{ asset('/assets/tibiarl/images/buttons/sbutton.gif') }})">
                                                            <div onmouseover="MouseOverBigButton(this);" onmouseout="MouseOutBigButton(this);"><div class="BigButtonOver" style="background-image: url({{ asset('/assets/tibiarl/images/buttons/sbutton_over.gif') }}); visibility: hidden;"></div>
                                                                <input class="BigButtonText" type="submit" value="Download">
                                                            </div>
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
    </div>
@endsection
@section('scripts')
    <script type="text/javascript">
        $("#StartDownloadContainer .Table1").css("background-image", "url({{ asset('/assets/tibiarl/images/account/start-download-druid.jpg') }})");
    </script>
@endsection