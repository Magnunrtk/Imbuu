@extends('template.layout')
@section('title', 'Lost Account')
@section('submenuItem', 'lostaccount')
@section('content')
@if($lostAccount instanceof \App\Models\Account)
<h2 style="text-align: center;">Email: {{ $emailOrChar }}</h2>
@else
<h2 style="text-align: center;">Character Name: {{ $emailOrChar }}</h2>
@endif
<br>
<p>The Lost Account Interface can help you to solve all problems listed below. Please select your problem and click on "Submit".</p>

{{-- <p>If your problem is not listed here, you might be able to find the answer on our website. Answers to the most common questions about {{ config('server.serverName') }} can be found in the <a href="#">FAQ</a>. You can also consult the <a href="#">manual</a>. If you have questions concerning the security of your account, please take a look at the <a href="#">security hints</a>.</p> --}}

<form action="{{ route('account.lost.action') }}" method="post">
    @csrf
    <div class="TableContainer">
        <div class="CaptionContainer">
            <div class="CaptionInnerContainer">
                <span class="CaptionEdgeLeftTop" style="background-image:url({{ asset('/assets/tibiarl/images/content/box-frame-edge.gif') }});"></span>
                <span class="CaptionEdgeRightTop" style="background-image:url({{ asset('/assets/tibiarl/images/content/box-frame-edge.gif') }});"></span>
                <span class="CaptionBorderTop" style="background-image:url({{ asset('/assets/tibiarl/images/content/table-headline-border.gif') }});"></span>
                <span class="CaptionVerticalLeft" style="background-image:url({{ asset('/assets/tibiarl/images/content/box-frame-vertical.gif') }});"></span>
                <div class="Text">Specify Your Problem</div>
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
                                                    <b>Recover by email</b><br>
                                                    <hr class="InnerTableSeparator">
                                                    <label><input type="radio" name="step" value="password"> I have forgotten my password.
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
                                                <td>
                                                    <b>Recover by recovery key</b><br>
                                                    <hr class="InnerTableSeparator">
                                                    <span style="margin-left: 5px;">I want to change the email address of my account instantly and my password.</span><br><label><input type="radio" name="step" value="email">I have a recovery key</label><br>
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
                                                    <td>
                                                        <b>Recover using two-factor code authentication</b><br>
                                                        <hr class="InnerTableSeparator">
                                                        <span style="margin-left: 5px;">
                                                            I want to change my email and password using my 2FA authenticator code.
                                                        </span><br>
                                                        <label>
                                                            <input type="radio" name="step" value="2fa">
                                                            I have a 2FA code
                                                        </label><br>
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
                                                    <td>
                                                        <b>Recover using security questions</b><br>
                                                        <hr class="InnerTableSeparator">
                                                        <span style="margin-left: 5px;">
                                                            I want to recover access by answering my account’s security questions.
                                                        </span><br>
                                                        <label>
                                                            <input type="radio" name="step" value="questions">
                                                            I know the answers to my security questions
                                                        </label><br>
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </td>
                            </tr>

                            {{-- <tr>
                                <td>
                                    <div class="TableContentContainer">
                                        <table class="TableContent" width="100%" style="border:1px solid #faf0d7;">
                                            <tbody>
                                            <tr>
                                                <td>
                                                    <b>Recovery Key</b><br>
                                                    <hr class="InnerTableSeparator">
                                                    <label><input type="radio" name="step" value="key"> I need a new recovery key.</label><br>
                                                </td>
                                            </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </td>
                            </tr> --}}
                            </tbody>
                        </table>
                    </div>
                </td>
            </tr>
            </tbody>
        </table>
    </div>
    <br>
    <table style="width:100%">
        <tbody>
        <tr align="center">
            <td>
                <input type="hidden" name="email_or_char" value="{{ $emailOrChar }}">
                <div class="BigButton" style="background-image:url({{ asset('/assets/tibiarl/images/buttons/sbutton.gif') }})">
                    <div onmouseover="MouseOverBigButton(this);" onmouseout="MouseOutBigButton(this);"><div class="BigButtonOver" style="background-image:url({{ asset('/assets/tibiarl/images/buttons/sbutton_over.gif') }});"></div>
                        <input class="BigButtonText" type="submit" value="Submit">
                    </div>
                </div>
            </td>
        </tr>
        </tbody>
    </table>
</form>
@endsection
