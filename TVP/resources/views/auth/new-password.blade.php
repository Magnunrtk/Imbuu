@extends('template.layout')
@section('title', 'Lost Account')
@section('submenuItem', 'lostaccount')
@section('content')
<form action="{{ route('account.reset.password.new.action') }}" method="post" class="form">
    @csrf
    <div class="TableContainer">
        <div class="CaptionContainer">
            <div class="CaptionInnerContainer">
                <span class="CaptionEdgeLeftTop" style="background-image:url({{ asset('/assets/tibiarl/images/content/box-frame-edge.gif') }});"></span>
                <span class="CaptionEdgeRightTop" style="background-image:url({{ asset('/assets/tibiarl/images/content/box-frame-edge.gif') }});"></span>
                <span class="CaptionBorderTop" style="background-image:url({{ asset('/assets/tibiarl/images/content/table-headline-border.gif') }});"></span>
                <span class="CaptionVerticalLeft" style="background-image:url({{ asset('/assets/tibiarl/images/content/box-frame-vertical.gif') }});"></span>
                <div class="Text">Choose New Password</div>
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
                                <td colspan="2">
                                    <p>To complete your email change, you need to choose a new password.</p>
                                    <p></p>
                                    <p>Please enter your new password twice to prevent any typing mistakes and click on "Submit".</p>
                                </td>
                            </tr>
                            <tr>
                                <td class="LabelV"><span>New Password:</span></td>
                                <td style="width:90%;">
                                    <input type="password" name="newPassword" id="password1" maxlength="29" class="ChangePasswordFormInput">
                                </td>
                            </tr>
                            <tr>
                                <td class="LabelV"><span>New Password Again:</span></td>
                                <td>
                                    <input type="password" name="newPassword2" id="password2" maxlength="29" class="ChangePasswordFormInput">
                                </td>
                            </tr>
                            <tr>
                                <td></td>
                                <td><span id="password_errormessage" class="FormFieldError"></span></td>
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
        <tr align="center">
            <td>
                <div class="BigButton" style="background-image:url({{ asset('/assets/tibiarl/images/buttons/sbutton.gif') }})">
                    <div onmouseover="MouseOverBigButton(this);" onmouseout="MouseOutBigButton(this);"><div class="BigButtonOver" style="background-image:url({{ asset('/assets/tibiarl/images/buttons/sbutton_over.gif') }});"></div>
                        <input class="BigButtonText" type="submit" value="Submit">
                    </div>
                </div>
            </td>
            <td>
                <div class="BigButton" onclick="RedirectToUrl('{{ route('account.lost.index') }}');" style="background-image:url({{ asset('/assets/tibiarl/images/buttons/sbutton.gif') }})">
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