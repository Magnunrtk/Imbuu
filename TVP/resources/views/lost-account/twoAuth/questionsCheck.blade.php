@extends('template.layout')

@section('title', 'Answer Security Questions')

@section('content')
    <h2 style="text-align: center;">Answer Your Security Questions</h2>
    <br>

    @if(session('error'))
        <div style="color: red;">{{ session('error') }}</div>
    @endif

    <style>
        .custom-input {
            font-size: 14px;
            font-family: Arial, sans-serif;
            color: #333;
            background-color: #fff;
            border: 1.5px solid #ccc;
            box-sizing: border-box;
            transition: border-color 0.3s ease, box-shadow 0.3s ease;
        }

        .custom-input:focus {
            outline: none;
            border-color: #007bff;
            box-shadow: 0 0 6px rgba(0, 123, 255, 0.5);
        }
    </style>

    <form method="POST" action="{{ route('account.lost.action') }}">
        @csrf

        @php
            $rowClass = 'Odd';
        @endphp

        <div class="TableContainer">
            <div class="CaptionContainer">
                <div class="CaptionInnerContainer">
                    <span class="CaptionEdgeLeftTop" style="background-image:url({{ asset('/assets/tibiarl/images/content/box-frame-edge.gif') }});"></span>
                    <span class="CaptionEdgeRightTop" style="background-image:url({{ asset('/assets/tibiarl/images/content/box-frame-edge.gif') }});"></span>
                    <span class="CaptionBorderTop" style="background-image:url({{ asset('/assets/tibiarl/images/content/table-headline-border.gif') }});"></span>
                    <span class="CaptionVerticalLeft" style="background-image:url({{ asset('/assets/tibiarl/images/content/box-frame-vertical.gif') }});"></span>
                    <div class="Text">Security Questions</div>
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
                                                        @foreach($questionIndexes as $key => $questionId)
                                                            <tr class="{{ $rowClass }}">
                                                                <td class="LabelV200" style="width: 40%;">
                                                                    {{ config('security.questions')[$questionId] ?? 'Unknown Question' }}
                                                                </td>
                                                                <td>
                                                                    <input type="hidden" name="{{ $key }}" value="{{ $questionId }}">
                                                                    <input
                                                                        type="text"
                                                                        name="answer_{{ \Illuminate\Support\Str::after($key, 'question_') }}"
                                                                        maxlength="20"
                                                                        style="width: 150px;"
                                                                        required
                                                                        class="custon-input"
                                                                        oninput="sanitizeInput(this)"
                                                                    >
                                                                    <input type="hidden" name="type" value="questions">
                                                                    <input type="hidden" name="email_or_char" value="{{ $emailOrChar }}">
                                                                    <input type="hidden" name="finder" value="{{ $emailOrChar }}">
                                                                    <input type="hidden" name="email" value="{{ $newEmail }}">
                                                                </td>
                                                            </tr>
                                                            @php
                                                                $rowClass = ($rowClass === 'Odd') ? 'Even' : 'Odd';
                                                            @endphp
                                                        @endforeach
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

        <script>
            function sanitizeInput(el) {
                el.value = el.value.replace(/[^a-z ]/g, '');
            }
        </script>

        <br>
        <center>
            <div class="BigButton" style="background-image:url({{ asset('/assets/tibiarl/images/buttons/sbutton.gif') }})">
                <div onmouseover="MouseOverBigButton(this);" onmouseout="MouseOutBigButton(this);">
                    <div class="BigButtonOver" style="background-image:url({{ asset('/assets/tibiarl/images/buttons/sbutton_over.gif') }});"></div>
                    <input class="BigButtonText" type="submit" value="Verify Answers">
                </div>
            </div>
        </center>
    </form>
@endsection
