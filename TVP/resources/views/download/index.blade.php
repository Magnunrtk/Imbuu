@extends('template.layout')
@section('title', 'Download Client')
@section('submenuItem', 'download')
@if(Session::has('downloadClient'))
@section('metaTag')
    <meta http-equiv="refresh" content="3;url={{ route('download.start') }}">
@endsection
@endif
@section('content')
    <div class="TableContainer">
        <div class="CaptionContainer">
            <div class="CaptionInnerContainer">
                <span class="CaptionEdgeLeftTop" style="background-image:url({{ asset('/assets/tibiarl/images/content/box-frame-edge.gif') }});"></span>
                <span class="CaptionEdgeRightTop" style="background-image:url({{ asset('/assets/tibiarl/images/content/box-frame-edge.gif') }});"></span>
                <span class="CaptionBorderTop" style="background-image:url({{ asset('/assets/tibiarl/images/content/table-headline-border.gif') }});"></span>
                <span class="CaptionVerticalLeft" style="background-image:url({{ asset('/assets/tibiarl/images/content/box-frame-vertical.gif') }});"></span>
                <div class="Text">Download Client</div>
                <span class="CaptionVerticalRight" style="background-image:url({{ asset('/assets/tibiarl/images/content/box-frame-vertical.gif') }});"></span>
                <span class="CaptionBorderBottom" style="background-image:url({{ asset('/assets/tibiarl/images/content/table-headline-border.gif') }});"></span>
                <span class="CaptionEdgeLeftBottom" style="background-image:url({{ asset('/assets/tibiarl/images/content/box-frame-edge.gif') }});"></span>
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
                                                    <td style="text-align: center;">
                                                        <h1>New Client</h1>
                                                        Click 'Download client' below.
                                                        <br><b>Extract the Zip file.</b>
                                                        <br><br>

                                                        <img style="width: 72px; height: 72px; border: 0px;" src="images/icon.png">
                                                        <br><br>

                                                        @if(config('server.enableClientDownload'))
                                                            <center>
                                                                <div class="BigButton" onclick="RedirectToUrl('{{ asset('Ravenor_Online.zip') }}?v=<?php echo bin2hex(random_bytes(16)) . uniqid(); ?>')" style="background-image:url({{ asset('/assets/tibiarl/images/buttons/sbutton.gif') }})">
                                                                    <div onmouseover="MouseOverBigButton(this)" onmouseout="MouseOutBigButton(this)">
                                                                        <div class="BigButtonOver" style="background-image:url({{ asset('/assets/tibiarl/images/buttons/sbutton_over.gif') }})"></div>
                                                                        <input class="BigButtonText" type="submit" value="Ravenor_Online.zip">
                                                                    </div>
                                                                </div>                                                            
                                                            </center>
                                                            <br>
                                                        @endif

                                                        <br>Inside the extracted folder, you will find two executable files: '<b>Ravenor_dx.exe</b>' and '<b>Ravenor_gl.exe</b>'.
                                                        <br>Select the one that best suits your hardware:
                                                        <ul>
                                                            <p><b>Ravenor_dx.exe</b> - Recommended for systems with DirectX support.</p>
                                                            <p><b>Ravenor_gl.exe</b> - Recommended for systems with OpenGL support.</p>
                                                        </ul>
                                                        <br>
                                                        <b>Do not extract data.zip.</b> If you extract the client you will not receive updates.
                                                        <br><br>
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </td>
                            </tr>

                            <tr>
                                <td>
                                    <div class="TableContentContainer">
                                        <table class="TableContent" width="100%" style="border:1px solid #faf0d7;">
                                            <tbody>
                                            <tr>
                                                <td colspan="2" style="text-align: center;">
                                                    <h2>Client Problems?</h2>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td style="text-align: center;">
                                                    Required OS: <b>Windows 7, 8, 8.1, 10 or preferably 11</b>
                                                    <br>
                                                    <b>If you have problems starting the client, install <a href="https://aka.ms/vs/16/release/vc_redist.x86.exe" target="_blank">microsoft vc_redist.x86</a>.</b>
                                                    <br>If problems persist, try running <b>UpdaterCacheFile.bat</b> to clear the cache.
                                                    <br>
                                                    <br>
                                                </td>
                                            </tr>
                                            <tr></tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <div class="TableContentContainer">
                                        <table class="TableContent" width="100%" style="border:1px solid #faf0d7;">
                                            <tbody>
                                            <tr>
                                                <td class="LabelV">Disclaimer</td>
                                            </tr>
                                            <tr>
                                                <td>The software and any related documentation is provided "as is" without warranty of any kind. The entire risk arising out of use of the software remains with you. In no event shall {{ config('server.serverName') }} be liable for any damages to your computer or loss of data.<br></td>
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
@endsection