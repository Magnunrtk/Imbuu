@extends('template.layout')
@section('title', 'Account Management')
@section('submenuItem', 'accountmanagement')
@section('content')

    <style>

        .custom-select {
            width: 325px;
            font-size: 14px;
            padding-left: 2px;
            font-family: Arial, sans-serif;
            color: #333;
            background-color: #fff;
            border: 1.5px solid #ccc;
            appearance: none; 
            -webkit-appearance: none;
            -moz-appearance: none;
            background-image: url('data:image/svg+xml;utf8,<svg fill="%23666" height="20" viewBox="0 0 24 24" width="20" xmlns="http://www.w3.org/2000/svg"><path d="M7 10l5 5 5-5z"/></svg>');
            background-repeat: no-repeat;
            background-position: right 10px center;
            background-size: 14px 14px;
            cursor: pointer;
            transition: border-color 0.3s ease;
        }

        .custom-select:focus {
            outline: none;
            border-color: #007bff;
            box-shadow: 0 0 6px rgba(0, 123, 255, 0.5);
        }

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

    <div class="info-text" style="margin-bottom: 15px; font-size: 14px;">
        <strong>Security Questions</strong><br>
        These security questions will be used to help you recover your account in case you forget your password or lose access. Keeping your answers safe and accurate is very important.<br><br>
        By correctly answering these questions in the recovery panel, you will be able to change your account email and password.<br><br>
        <b style="color: #a00;">Tip:</b> Keep your answers simple — use single words, avoid spaces and capital letters, because during recovery you will need to enter the answers exactly as you wrote them.
        <b>Important restrictions on answers:</b> Answers must contain only lowercase letters (a–z) and spaces, without special characters. Please enter simple words or short phrases only.
    </div>

    <div class="TableContainer">
        <div class="CaptionContainer">
            <div class="CaptionInnerContainer">
                <span class="CaptionEdgeLeftTop" style="background-image:url({{ asset('/assets/tibiarl/images/content/box-frame-edge.gif') }});"></span>
                <span class="CaptionEdgeRightTop" style="background-image:url({{ asset('/assets/tibiarl/images/content/box-frame-edge.gif') }});"></span>
                <span class="CaptionBorderTop" style="background-image:url({{ asset('/assets/tibiarl/images/content/table-headline-border.gif') }});"></span>
                <span class="CaptionVerticalLeft" style="background-image:url({{ asset('/assets/tibiarl/images/content/box-frame-vertical.gif') }});"></span>
                <div class="Text">Set Security Questions</div>
                <span class="CaptionVerticalRight" style="background-image:url({{ asset('/assets/tibiarl/images/content/box-frame-vertical.gif') }});"></span>
                <span class="CaptionBorderBottom" style="background-image:url({{ asset('/assets/tibiarl/images/content/table-headline-border.gif') }});"></span>
                <span class="CaptionEdgeLeftBottom" style="background-image:url({{ asset('/assets/tibiarl/images/content/box-frame-edge.gif') }});"></span>
                <span class="CaptionEdgeRightBottom" style="background-image:url({{ asset('/assets/tibiarl/images/content/box-frame-edge.gif') }});"></span>
            </div>
        </div>
        <table class="Table3" cellpadding="0" cellspacing="0">
            <tbody>
                <tr>
                    <td>
                        <div class="InnerTableContainer">
                            <form id="security-questions-form" action="{{ route('account.manage.security-questions.save') }}" method="POST">
                                @csrf

                                <div class="TableContentAndRightShadow">
                                    <div class="TableContentContainer">
                                        <table class="TableContent" width="100%">
                                            <tbody>
                                                @php
                                                    $questions = config('security.questions');
                                                    $questionsPerRow = 3;
                                                    $rowClass = 'Even';
                                                @endphp

                                                @for ($i = 0; $i < 3; $i++)
                                                    <tr class="{{ $rowClass }}">
                                                        <td class="LabelV">Question {{ $i + 1 }}:</td>
                                                        <td>
                                                            <select name="question_{{ $i + 1 }}" class="custom-select" required>
                                                                <option value="">-- Select a question --</option>
                                                                @for ($j = 0; $j < $questionsPerRow; $j++)
                                                                    @php
                                                                        $index = $i * $questionsPerRow + $j + 1; 
                                                                        if (!isset($questions[$index])) {
                                                                            continue; 
                                                                        }
                                                                    @endphp
                                                                    <option value="{{ $index }}" {{ old("question_" . ($i + 1)) == $index ? 'selected' : '' }}>
                                                                        {{ $questions[$index] }}
                                                                    </option>
                                                                @endfor
                                                            </select>

                                                            <input type="text" name="answer_{{ $i + 1 }}" placeholder="Answer" class="form-control mt-2 custom-input" value="{{ old("answer_" . ($i + 1)) }}" required oninput="sanitizeInput(this)">
                                                        </td>
                                                    </tr>

                                                    @php $rowClass = ($rowClass === 'Odd') ? 'Even' : 'Odd'; @endphp
                                                @endfor


                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </form>
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

    <table class="InnerTableButtonRow" cellpadding="0" cellspacing="0" style="width: 100%; text-align: center;">
        <tr>
            <td style="text-align: center;">
                <div style="display: inline-flex; gap: 20px;">

                   <div class="BigButton" onclick="RedirectToUrl('{{ route('account.manage.index') }}');" style="background-image:url({{ asset('/assets/tibiarl/images/buttons/sbutton.gif') }})">
                        <div onmouseover="MouseOverBigButton(this);" onmouseout="MouseOutBigButton(this);"><div class="BigButtonOver" style="background-image:url({{ asset('/assets/tibiarl/images/buttons/sbutton_over.gif') }});"></div>
                            <input class="BigButtonText" type="submit" value="Back">
                        </div>
                    </div>

                    <div class="BigButton" onclick="document.getElementById('security-questions-form').submit();" style="background-image:url({{ asset('/assets/tibiarl/images/buttons/sbutton.gif') }})">
                        <div onmouseover="MouseOverBigButton(this);" onmouseout="MouseOutBigButton(this);"><div class="BigButtonOver" style="background-image:url({{ asset('/assets/tibiarl/images/buttons/sbutton_over.gif') }});"></div>
                            <input class="BigButtonText" type="button" value="Save">
                        </div>
                    </div>
                </div>
            </td>
        </tr>
    </table>

@endsection
