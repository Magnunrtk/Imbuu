@extends('template.layout')
@section('title', 'Offer List')
@section('submenuItem', 'shoplist')
@section('content')
    <table class="TableContent" width="100%" style="border:1px solid #faf0d7;">
        <tbody>
        <tr>
            <td class="NewsTableContainer">
                <p><img class="NewsImageLinkThumbnail" src="{{ asset('/assets/tibiarl/images/store/client-store.png') }}" hspace="10" vspace="10" width="171" height="182" align="right" onclick="ImageInNewWindow('{{ asset('/assets/tibiarl/images/store/client-store.png') }}');"><img src="{{ asset('/assets/tibiarl/images/letters/letter_martel_T.gif') }}" border="0" align="bottom">o locate the store in the client, you can click on the button located on the top navigator bar. You can buy coins on the website in order to purchase items and services from the store.</p>
                <center>
                    <div class="BigButton" onclick="RedirectToUrl('{{ route('account.store.index') }}');" style="background-image:url({{ asset('/assets/tibiarl/images/buttons/sbutton_green.gif') }})">
                        <div onmouseover="MouseOverBigButton(this);" onmouseout="MouseOutBigButton(this);"><div class="BigButtonOver" style="background-image:url({{ asset('/assets/tibiarl/images/buttons/sbutton_green_over.gif') }});"></div>
                            <input class="BigButtonText" type="submit" value="Buy Coins">
                        </div>
                    </div>
                </center>
            </td>
        </tr>
        </tbody>
    </table>

@endsection