@extends('template.layout')
@section('title', 'Create Account')
@section('submenuItem', 'createaccount')
@section('content')
    @if(isset($errorMessage))
    
    @else
        <form class="form" action="{{ route('account.confirm.confirmRecoveryKey', compact('emailHash', 'confirmationKey')) }}" method="get">
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
                    <img id="TubeRightEnd" src="{{ asset('/assets/tibiarl/images/content/progressbar/progress-bar-tube-right-blue.gif') }}">
                    <div id="FirstStep" class="Steps">
                        <div class="SingleStepContainer">
                            <img class="StepIcon" src="{{ asset('/assets/tibiarl/images/content/progressbar/progress-bar-icon-1-green.gif') }}">
                            <div class="StepText" style="font-weight:bold;">Write Down Recovery Key</div>
                        </div>
                    </div>
                    <div id="StepsContainer1">
                        <div id="StepsContainer2">
                            <div class="Steps" style="width:50%">
                                <div class="TubeContainer"> <img class="Tube" src="{{ asset('/assets/tibiarl/images/content/progressbar/progress-bar-tube-green-blue.gif') }}"> </div>
                                <div class="SingleStepContainer">
                                    <img class="StepIcon" src="{{ asset('/assets/tibiarl/images/content/progressbar/progress-bar-icon-3-blue.gif') }}">
                                    <div class="StepText" style="font-weight:normal;">Enter Recovery Key</div>
                                </div>
                            </div>
                            <div class="Steps" style="width:50%">
                                <div class="TubeContainer"> <img class="Tube" src="{{ asset('/assets/tibiarl/images/content/progressbar/progress-bar-tube-blue.gif') }}"> </div>
                                <div class="SingleStepContainer">
                                    <img class="StepIcon" src="{{ asset('/assets/tibiarl/images/content/progressbar/progress-bar-icon-4-blue.gif') }}">
                                    <div class="StepText" style="font-weight:normal;">Confirmation Complete</div>
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
                        <div class="Text">Account Confirmation: Step 1</div>
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
                                            <p class="ColorRed">Please write your recovery key on a piece of paper! You will have to enter it on the next page in order to confirm your account and your email address.</p>
                                            <p></p>
                                            <center>
                                                <font size="5">
                                                    <b>Recovery Key<br><br>
                                                        @if(isset($recoveryKey)) {{ $recoveryKey }} @endif
                                                    </b>
                                                </font>
                                            </center>
                                            <p></p>
                                            <b>Important:</b>
                                            <ul>
                                                <li>The recovery key allows you to reassign your account to a new email address instantly.</li>
                                                <li>Store your recovery key in a safe place! Do not save it on your computer!</li>
                                                <li>The recovery key is only displayed here. You will <b>not</b> receive it per email!</li>
                                            </ul>
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
            <table style="width: 100%;">
                <tbody>
                <tr align="center">
                    <td>
                        <div class="BigButton" style="background-image:url({{ asset('/assets/tibiarl/images/buttons/sbutton_green.gif') }})"><div onmouseover="MouseOverBigButton(this);" onmouseout="MouseOutBigButton(this);"><div class="BigButtonOver" style="background-image:url({{ asset('/assets/tibiarl/images/buttons/sbutton_green_over.gif') }});"></div>
                                <input class="BigButtonText" type="submit" value="Confirm">
                            </div>
                        </div>
                    </td>
                </tr>
                </tbody>
            </table>
        </form>
    @endif
@endsection
