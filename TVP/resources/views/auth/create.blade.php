@extends('template.layout')
@section('title', 'Create Account')
@section('submenuItem', 'createaccount')
@section('content')

    @if($vipDays > 0)
                
        <div style="display: flex; align-items: center;">
            <img class="AccountStatusImage" src="/assets/tibiarl/images/account/account-status_green.gif" alt="free account" style="margin-right: 10px;">
            <img src="/images/part.gif" style="width: 65px; position: absolute; left: 5px">
            <span class="BigBoldText">Bonus activated <span style="color: green; font-weight: normal" class="pulsating-text">{{ $vipDays }} DAYS</span> Premium Account <span style="font-weight: normal; font-size: 14px; color: red">(only new accounts!)</span></span>
        </div>
        
        <br>

    @endif

    <div id="error-container">

    </div>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('assets/tibiarl/css/auth/create.css') }}?v=27">

    <form id="registerTraffic" action="{{ route('account.create.store') }}" method="post" class="form">
        @csrf
        <div style="position:relative;top:0px;left:0px">
            <div class="TableContainer">
                <div class="CaptionContainer">
                    <div class="CaptionInnerContainer">
                        <span class="CaptionEdgeLeftTop" style="background-image:url({{ asset('/assets/tibiarl/images/content/box-frame-edge.gif') }});"></span>
                        <span class="CaptionEdgeRightTop" style="background-image:url({{ asset('/assets/tibiarl/images/content/box-frame-edge.gif') }});"></span>
                        <span class="CaptionBorderTop" style="background-image:url({{ asset('/assets/tibiarl/images/content/table-headline-border.gif') }});"></span>
                        <span class="CaptionVerticalLeft" style="background-image:url({{ asset('/assets/tibiarl/images/content/box-frame-vertical.gif') }});"></span>
                        <div class="Text">Create New Account</div>
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
                            <div class="InnerTableContainer">
                                <table style="width:100%">
                                    <tbody>
                                    <tr>
                                        <td>
                                            <div class="TableContentContainer">
                                                <table class="TableContent" width="100%" style="border:1px solid #faf0d7;">
                                                    <tbody>
                                                    <tr>
                                                        <td class="LabelV150" width="20%">
                                                            <span id="accountname_label">
                                                                <b>Account Number:</b>
                                                            </span>
                                                        </td>

                                                        <td>

                                                            <div style="display: flex">                               
                                                                <input id="accountname" name="id" autocomplete="off" style="width: 206px; margin-right: 10px;" size="30" maxlength="30"  autofocus>

                                                                <div id="account_indicator" class="InputIndicator" style="background-image: url('/images/icons/nok.gif'); left: -5 !important"></div>
                                                        
                                                                <i id="loading-icon" class="fas fa-spinner fa-spin" style="margin-left: 10px; display: none"></i>
                                                            </div>

                                                            <div style="padding: 2px"></div>

                                                            <small id="generate-id-icon"><a>[suggest number]</a></small>

                                                            <br>
                                                        </td>                                                        
                                                    </tr>

                                                    <tr>
                                                        <td></td>
                                                        <td>
                                                            <span id="account_number_error_message" class="FormFieldError" style="min-height: 20px; display: inline-block; visibility: hidden;"></span>
                                                        </td>
                                                    </tr>

                                                    <tr>
                                                        <td class="LabelV150">
                                                            <span id="email_label">
                                                                <b>Email Address:</b>
                                                            </span>
                                                        </td>
                                                        <td>
                                                            <div style="display: flex">
                                                                <input id="email" name="email" style="width:206px;float:left" value="" autocomplete="off" size="30" maxlength="50">

                                                                <div id="email_indicator" class="InputIndicator" style="background-image: url('/images/icons/nok.gif'); left: 5 !important; top: 2px"></div>

                                                                <i id="loadingIconMail" class="fas fa-spinner fa-spin" style="margin-left: 10px; display: none"></i>
                                                            </div>
                                                        </td>
                                                        </td>
                                                    </tr>

                                                    <tr>
                                                        <td></td>
                                                        <td>
                                                            <span id="email_error_message" class="FormFieldError" style="min-height: 20px; display: inline-block; visibility: hidden;"></span>
                                                        </td>
                                                    </tr>

                                                    <tr>
                                                        <td class="LabelV150">
                                                            <span id="password1_label">
                                                                <b>Password:</b>
                                                            </span>
                                                        </td>
                                                        <td>
                                                            <div style="display: flex">
                                                                <input id="password1" type="password" autocomplete="off" name="password" style="width:206px;float:left" value="" size="30" maxlength="30">

                                                                <div id="CapsLockWarning" style="position: absolute; top: 133px; left: 176px; width: 175px; background-color: white; color: black; border: 1px solid grey; text-align: left; font-size: 10pt; font-family: Verdana, Arial, &quot;Times New Roman&quot;, sans-serif; padding: 8px; z-index: 1000; display: none">

                                                                    <img src="/images/icons/attentionsign.gif" style="width: 15px; height: 13px; float: left; margin-right: 5px;" alt="Caps Lock Warning">
                                                                    
                                                                    Caps Lock is active!
                                                                
                                                                </div>
                                                                

                                                                <div id="password1_indicator" class="InputIndicator" style="background-image: url('/images/icons/nok.gif'); left: 5 !important; top: 3px !important"></div>
                                                                
                                                            </div>
                                                            
                                                            <div id="password_strength_indicator" class="PWStrengthIndicator PWStrengthLevel1">Very Weak</div>
                                                        </td>
                                                    </tr>

                                                    <tr>
                                                        <td class="LabelV150">
                                                            <span id="password2_label">
                                                                <b>Password Again:</b>
                                                            </span>
                                                        </td>
                                                        <td>
                                                            <div style="display: flex">                                                              
                                                                <input id="password2" type="password" name="confirmPassword" style="width:206px;float:left" value="" size="30" maxlength="30">

                                                                <div id="password2_indicator" class="InputIndicator" style="background-image: url('/images/icons/nok.gif'); left: 5 !important"></div>
                                                            </div>
                                                        </td>
                                                    </tr>

                                                    <tr>
                                                        <td></td>
                                                        <td>
                                                            <span id="password_error_message" class="FormFieldError" style="min-height: 20px; display: inline-block; visibility: hidden;"></span>
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
                                                            <td class="LabelV150">
                                                                <span id="password2_label">
                                                                    <b>Country:</b>
                                                                </span>
                                                            </td>
                                                            <td>
                                                                <div style="display: flex; align-items: center; gap: 2px;">
                                                                    <select name="country_code" id="countryCode" required="" style="width:206px;" onchange="updateFlag()">
                                                                        @foreach ($countrys as $code => $name)
                                                                            <option value="{{ $code }}">{{ $name }}</option>
                                                                        @endforeach
                                                                    </select>
                                                                
                                                                    <div id="flagContainer" style="display: flex; gap: 2px;">
                                                                        <img src="/images/flags/br.gif" onclick="selectCountry('br')" alt="Português" class="flag-icon" data-code="br">
                                                                        <img src="/images/flags/us.gif" onclick="selectCountry('us')" alt="English" class="flag-icon" data-code="us">
                                                                        <img src="/images/flags/gb.gif" onclick="selectCountry('gb')" alt="English" class="flag-icon" data-code="gb">
                                                                    </div>
                                                                </div>

                                                                <script>
                                                                    function selectCountry(countryCode) {
                                                                        document.getElementById("countryCode").value = countryCode;
                                                                        updateFlag();
                                                                    }
                                                                
                                                                    function updateFlag() {
                                                                        const select = document.getElementById("countryCode");
                                                                        const selectedCode = select.value;
                                                                        const flagContainer = document.getElementById("flagContainer");
      
                                                                        const defaultFlags = ["br", "us", "gb"];
                                                                
                                                                        if (defaultFlags.includes(selectedCode)) {
                                                                            flagContainer.innerHTML = `
                                                                                <img src="/images/flags/br.gif" onclick="selectCountry('br')" alt="Português" class="flag-icon" data-code="br">
                                                                                <img src="/images/flags/us.gif" onclick="selectCountry('us')" alt="English" class="flag-icon" data-code="us">
                                                                                <img src="/images/flags/gb.gif" onclick="selectCountry('gb')" alt="English" class="flag-icon" data-code="gb">
                                                                            `;
                                                                        } else {
                                                                            
                                                                            flagContainer.innerHTML = `
                                                                                <img src="/images/flags/${selectedCode}.gif" onclick="selectCountry('${selectedCode}')" alt="${selectedCode}" class="flag-icon">
                                                                            `;
                                                                        }
                                                                    }
                                                                </script>
                                                            </td>
                                                        </tr>
                                                        @env('production')
                                                            @if(config('services.recaptcha.key'))
                                                                <tr>
                                                                    <td class="LabelV150">
                                                                        <span>Verification:</span>
                                                                    </td>
                                                                    <td>
                                                                        <div class="g-recaptcha" data-sitekey="{{ config('services.recaptcha.key') }}" data-theme="light"></div>
                                                                    </td>
                                                                </tr>
                                                            @endif
                                                        @endenv

                                                        <tr>
                                                            <td class="LabelV150">
                                                                <span id="charactername_label">
                                                                    <b>Character Name:</b>
                                                                </span>
                                                            </td>
                                                            <td>
                                                                <div style="display: flex">
                                                                    <input id="charactername_input" type="text" name="name" style="width:206px;float:left" value="" size="30" maxlength="30">

                                                                    <div id="name_indicator" class="InputIndicator" style="background-image: url('/images/icons/nok.gif'); left: 5 !important;"></div>

                                                                    <i id="loadingIconName" class="fas fa-spinner fa-spin" style="margin-left: 10px; display: none"></i>
                                                                </div>

                                                                <div style="padding: 2px"></div>

                                                                <small id="suggest-name-link">[<a href="#">suggest name</a>]</small>

                                                                <br><br>

                                                            </td>
                                                        </tr>

                                                        <tr>
                                                            <td></td>
                                                            <td>
                                                                <span id="name_error_message" class="FormFieldError" style="min-height: 20px; display: inline-block; visibility: hidden;"></span>
                                                            </td>
                                                        </tr>
                                                    <tr>
                                                        <td class="LabelV150"><span>Sex:</span></td>
                                                        <td>
                                                            <table width="100%">
                                                                <tbody>
                                                                <tr>
                                                                    <td>
                                                                        <span style="margin-right:75px;" class="OptionContainer">
                                                                            <label for="sex_male">
                                                                                <span class="OptionContainer">
                                                                                    <input id="sex_male" type="radio" name="sex" value="1" checked="checked">
                                                                                    <label for="sex_male">male</label>
                                                                                </span>
                                                                            </label>
                                                                        </span>
                                                                        <span class="OptionContainer">
                                                                            <label for="sex_female">
                                                                                <span class="OptionContainer">
                                                                                    <input id="sex_female" type="radio" name="sex" value="0">
                                                                                    <label for="sex_female">female</label>
                                                                                </span>
                                                                            </label>
                                                                        </span>
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
                                    <tr>
                                        <td>
                                            <div class="TableContentContainer">
                                                <table class="TableContent" width="100%" style="border:1px solid #faf0d7;">
                                                    <tbody>
                                                    <tr>
                                                        <td>
                                                            <b>Please select all the following check boxes:</b>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td colspan="2">
                                                            <input type="checkbox" name="rulesAgreement" value="1" id="RulesCheckbox"> <span><label for="RulesCheckbox">I have read, and I agree the <a href="{{ route('support.rules') }}" target="_blank">{{ config('server.serverName') }} Rules</a>.</label></span>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td colspan="2">
                                                            <input type="checkbox" name="termsAgreement" value="1" id="TermsCheckbox"> <span><label for="TermsCheckbox">I have read, and I agree the <a href="{{ route('privacy.terms.index') }}" target="_blank">{{ config('server.serverName') }} Terms</a>.</label></span>
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
        </div>
        <center>
            <table border="0" cellspacing="0" cellpadding="0">
                <tbody>
                <tr>
                    <td style="border:0px">
                        <div class="BigButton" id="submitButton" style="background-image:url({{ asset('/assets/tibiarl/images/buttons/sbutton.gif') }}); opacity: 0.5">
                            <div onmouseover="MouseOverBigButton(this);" onmouseout="MouseOutBigButton(this);"><div class="BigButtonOver" style="background-image:url({{ asset('/assets/tibiarl/images/buttons/sbutton_over.gif') }});"></div>
                                <input class="BigButtonText" type="submit" value="Submit">
                            </div>
                        </div>
                    </td>
                </tr>
                <tr></tr>
                </tbody>
            </table>
        </center>
    </form>

    <script>
        const csrfToken = '{{ csrf_token() }}';
        const routeAccountCheck = "/account/check-id";
        const routeEmailCheck = "/account/check-email";
        const routeAccountIdCheck = "/account/check-account-id";
        const routeCharacterNameCheck = "/account/check-character-name";
    </script>

    <script src="{{ asset('assets/tibiarl/js/auth/create.min.js') }}?v=a1" defer></script>

@endsection

@section('scripts')
    @if(isset($_SERVER['HTTP_CF_IPCOUNTRY']))
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                let countryCodeSelect = document.getElementById('countryCode');
                if (countryCodeSelect) {
                    countryCodeSelect.value = '{{ Str::lower($_SERVER['HTTP_CF_IPCOUNTRY']) }}';
                }
            });
        </script>
    @endif

    @env('production')
        @if(config('services.recaptcha.key'))
            <script src="https://www.google.com/recaptcha/api.js"></script>
        @endif
    @endenv
@endsection