@extends('template.layout')
@section('title', 'Account Management')
@section('submenuItem', 'accountmanagement')
@section('content')

<style>
    .container {
        margin: 0 auto;
        padding: 20px;
        border-radius: 8px;
    }
    .qr-code {
        margin: 20px 0;
    }
    a.button {
        display: inline-block;
        padding: 10px 20px;
        background-color: #007BFF;
        color: #fff;
        text-decoration: none;
        border-radius: 4px;
        margin-top: 20px;
    }
    a.button:hover {
        background-color: #0056b3;
    }
    .input-field {
        margin: 20px 0;
        display: inline-block;
        padding: 2px;
        width: 200px;
        text-align: center;
    }
    .button-container {
        text-align: center;
        margin-top: 20px;
    }
</style>

<div class="container">
    <h1 style="text-align: center">Activate Two-Factor Authentication</h1>
    
    @if(isset($qrCodeImageUrl))
        <div class="qr-code" style="text-align: center">
            <h3 style="font-weight: normal">
                Scan the QR Code using your authentication app.<br> If you don't have it, 
                <a href="https://play.google.com/store/apps/details?id=com.google.android.apps.authenticator2&pcampaignid=web_share" target="_blank" style="color: #007BFF; text-decoration: none;">
                    download the Google Authenticator app here.
                </a>
            </h3>

            <img src="{{ $qrCodeImageUrl }}" alt="QR Code">
        </div>
    @else
        <p>An error occurred while generating the QR Code.</p>
    @endif

    <p style="text-align: center">
        After scanning the QR Code with your authentication app, please enter the code that appears <br>in the app below <b>to confirm and activate Two-Factor Authentication</b> for your account.
    </p>

    <div style="text-align: center; display: flex; align-items: center; justify-content: center;">

        <input id="googleAuthenticatorCode" class="input-field" type="text" placeholder="Enter Authenticator Code" maxlength="6" style="margin-right: 10px;">

        <div class="BigButton" style="background-image:url(/assets/tibiarl/images/buttons/sbutton.gif);" onclick="verifyCode()">
            <div onmouseover="MouseOverBigButton(this);" onmouseout="MouseOutBigButton(this);">
                <div class="BigButtonOver" style="background-image: url(&quot;/assets/tibiarl/images/buttons/sbutton_over.gif&quot;); visibility: hidden;"></div>
                <input class="BigButtonText" type="submit" value="Verify Code">
            </div>
        </div>
    </div>
    
    <br>

    <center>
        <div class="BigButton" style="background-image:url(/assets/tibiarl/images/buttons/sbutton.gif)" onclick="javascript:history.go(-1)">
            <div onmouseover="MouseOverBigButton(this);" onmouseout="MouseOutBigButton(this);">
                <div class="BigButtonOver" style="background-image: url(&quot;/assets/tibiarl/images/buttons/sbutton_over.gif&quot;); visibility: hidden;"></div>
                <input class="BigButtonText" type="submit" value="Back">
            </div>
        </div>
    </center>
</div>

<script>
    function verifyCode() {
        var code = document.getElementById('googleAuthenticatorCode').value;
        
        if (code.length < 6) {
            alert("Please enter a valid 6-digit code.");
            return;
        }

        fetch("{{ route('account.manage.verify2fa') }}", {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
            },
            body: JSON.stringify({
                code: code
            })
        })
        .then(response => response.json())
        .then(data => {
            if (data.status_code === 200) {
                window.location.href = "{{ route('account.manage.index') }}";
            } else {
                alert(data.message);
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('An error occurred while verifying the code.');
        });
    }
</script>

@endsection
