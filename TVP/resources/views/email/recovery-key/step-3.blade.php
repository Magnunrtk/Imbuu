@extends('template.layout')
@section('title', 'Create Account')
@section('submenuItem', 'createaccount')
@section('content')
<form class="form" action="{{ route('account.confirm.action') }}" method="get">
    @csrf
    <div id="ProgressBar">
        <div id="Headline">Confirm Account</div>
        <div id="MainContainer">
            <div id="BackgroundContainer">
                <img id="BackgroundContainerLeftEnd" src="{{ asset('/assets/tibiarl/images/content/stonebar-left-end.gif') }}">
                <div id="BackgroundContainerCenter">
                    <div id="BackgroundContainerCenterImage" style="background-image:url({{ asset('/assets/tibiarl/images/content/stonebar-center.gif') }});"></div>
                </div>
                <img id="BackgroundContainerRightEnd" src="{{ asset('/assets/tibiarl/images/content/stonebar-right-end.gif') }}">
            </div>
            <img id="TubeLeftEnd" src="{{ asset('/assets/tibiarl/images/content/progressbar/progress-bar-tube-left-green.gif') }}">
            <img id="TubeRightEnd" src="{{ asset('/assets/tibiarl/images/content/progressbar/progress-bar-tube-right-green.gif') }}">
            <div id="FirstStep" class="Steps">
                <div class="SingleStepContainer">
                    <img class="StepIcon" src="{{ asset('/assets/tibiarl/images/content/progressbar/progress-bar-icon-1-green.gif') }}">
                    <div class="StepText" style="font-weight:normal;">Write Down Recovery Key</div>
                </div>
            </div>
            <div id="StepsContainer1">
                <div id="StepsContainer2">
                    <div class="Steps" style="width:50%">
                        <div class="TubeContainer"> <img class="Tube" src="{{ asset('/assets/tibiarl/images/content/progressbar/progress-bar-tube-green.gif') }}"> </div>
                        <div class="SingleStepContainer">
                            <img class="StepIcon" src="{{ asset('/assets/tibiarl/images/content/progressbar/progress-bar-icon-3-green.gif') }}">
                            <div class="StepText" style="font-weight:normal;">Enter Recovery Key</div>
                        </div>
                    </div>
                    <div class="Steps" style="width:50%">
                        <div class="TubeContainer"> <img class="Tube" src="{{ asset('/assets/tibiarl/images/content/progressbar/progress-bar-tube-green.gif') }}"> </div>
                        <div class="SingleStepContainer">
                            <img class="StepIcon" src="{{ asset('/assets/tibiarl/images/content/progressbar/progress-bar-icon-4-green.gif') }}">
                            <div class="StepText" style="font-weight:bold;">Confirmation Complete</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="TableContainer">
        <div class="CaptionContainer">
            <div class="CaptionInnerContainer">
                <span class="CaptionEdgeLeftTop" style="background-image:url({{ asset('/assets/tibiarl/images/content/box-frame-edge.gif') }});"></span>
                <span class="CaptionEdgeRightTop" style="background-image:url({{ asset('/assets/tibiarl/images/content/box-frame-edge.gif') }});"></span>
                <span class="CaptionBorderTop" style="background-image:url({{ asset('/assets/tibiarl/images/content/table-headline-border.gif') }});"></span>
                <span class="CaptionVerticalLeft" style="background-image:url({{ asset('/assets/tibiarl/images/content/box-frame-vertical.gif') }});"></span>
                <div class="Text">Account Confirmed</div>
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
                                                <td>
                                                    <p>Congratulations, your account is now confirmed! You can fully enjoy all features of a {{ config('server.serverName') }} free account.</p>
                                                    <p>If you have not done yet, you can now download the {{ config('server.serverName') }} client by clicking on the "Download" button below.</p>
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
    </div>
    <br>
    <table style="width:100%;">
        <tbody>
        <tr align="center" valign="top">
            <td>
                <div class="BigButton" onclick="RedirectToUrl('{{ route('download.index') }}');" style="background-image:url({{ asset('/assets/tibiarl/images/buttons/sbutton.gif') }})">
                    <div onmouseover="MouseOverBigButton(this);" onmouseout="MouseOutBigButton(this);"><div class="BigButtonOver" style="background-image:url({{ asset('/assets/tibiarl/images/buttons/sbutton_over.gif') }});"></div>
                        <input class="BigButtonText" type="submit" value="Download Client">
                    </div>
                </div>
            </td>
            <td>
                <div class="BigButton" onclick="RedirectToUrl('{{ route('account.index') }}');" style="background-image:url({{ asset('/assets/tibiarl/images/buttons/sbutton.gif') }})">
                    <div onmouseover="MouseOverBigButton(this);" onmouseout="MouseOutBigButton(this);"><div class="BigButtonOver" style="background-image:url({{ asset('/assets/tibiarl/images/buttons/sbutton_over.gif') }});"></div>
                        @if(Auth::check())
                        <input class="BigButtonText" type="submit" value="My Account">
                        @else
                        <input class="BigButtonText" type="submit" value="Login">
                        @endif
                    </div>
                </div>
            </td>
        </tr>
        </tbody>
    </table>
</form>
@endsection
