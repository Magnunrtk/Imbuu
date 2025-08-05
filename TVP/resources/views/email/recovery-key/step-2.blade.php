@extends('template.layout')
@section('title', 'Create Account')
@section('submenuItem', 'createaccount')
@section('content')
<form class="form" action="{{ route('account.confirm.action') }}" method="post">
    @csrf
    <input type="hidden" name="email" value="{{ $emailHash }}">
    <input type="hidden" name="confirmationKey" value="{{ $confirmationKey }}">
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
                    <div class="StepText" style="font-weight:normal;">Write Down Recovery Key</div>
                </div>
            </div>
            <div id="StepsContainer1">
                <div id="StepsContainer2">
                    <div class="Steps" style="width:50%">
                        <div class="TubeContainer"> <img class="Tube" src="{{ asset('/assets/tibiarl/images/content/progressbar/progress-bar-tube-green.gif') }}"> </div>
                        <div class="SingleStepContainer">
                            <img class="StepIcon" src="{{ asset('/assets/tibiarl/images/content/progressbar/progress-bar-icon-3-green.gif') }}">
                            <div class="StepText" style="font-weight:bold;">Enter Recovery Key</div>
                        </div>
                    </div>
                    <div class="Steps" style="width:50%">
                        <div class="TubeContainer"> <img class="Tube" src="{{ asset('/assets/tibiarl/images/content/progressbar/progress-bar-tube-green-blue.gif') }}"> </div>
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
                <div class="Text">Account Confirmation: Step 2</div>
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
                                                <td colspan="2">
                                                    <p>Enter your recovery key! Click on "Back" to see your recovery key once more.</p>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="LabelV"><span>Recovery key:</span></td>
                                                <td><input class="UpperCaseInput" name="key1" value="" size="5" maxlength="5" autocomplete="off" onpaste="return false;">-<input class="UpperCaseInput" name="key2" value="" size="5" maxlength="5" autocomplete="off" onpaste="return false;">-<input class="UpperCaseInput" name="key3" value="" size="5" maxlength="5" autocomplete="off" onpaste="return false;">-<input class="UpperCaseInput" name="key4" value="" size="5" maxlength="5" autocomplete="off" onpaste="return false;"></td>
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
                <div class="BigButton" style="background-image:url({{ asset('/assets/tibiarl/images/buttons/sbutton_green.gif') }})">
                    <div onmouseover="MouseOverBigButton(this);" onmouseout="MouseOutBigButton(this);"><div class="BigButtonOver" style="background-image:url({{ asset('/assets/tibiarl/images/buttons/sbutton_green_over.gif') }});"></div>
                        <input class="BigButtonText" type="submit" value="Confirm">
                    </div>
                </div>
            </td>
            <td>
                    <div class="BigButton" onclick="checkRecoveryKey();"  style="background-image:url({{ asset('/assets/tibiarl/images/buttons/sbutton.gif') }})">
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
    <script type="text/javascript">
        function checkRecoveryKey() {
            event.preventDefault();
            let emailHash = "{{ $emailHash }}";
            let confirmationKey = "{{ $confirmationKey }}";

            let url = "{{ route('account.confirm.checkRecoveryKey', ['emailHash' => ':emailHash', 'confirmationKey' => ':confirmationKey']) }}";
            url = url.replace(':emailHash', emailHash);
            url = url.replace(':confirmationKey', confirmationKey);

            let form = document.createElement('form');
            form.action = url;
            form.method = 'POST';
            form.style.display = 'none';

            let csrfToken = document.createElement('input');
            csrfToken.name = '_token';
            csrfToken.value = '{{ csrf_token() }}';

            form.appendChild(csrfToken);
            document.body.appendChild(form);

            form.submit();
        }

    </script>
@endsection