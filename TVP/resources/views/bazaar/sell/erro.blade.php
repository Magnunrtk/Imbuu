{{-- 
* @description Char-Bazaar - Venda de personagens
* @author Rickson Kauê
* @date Data de criação 05/12/2023
* @version 1.0
* @copyright (c) Ravenor
* @email ricksonkaue04@gmail.com
--}}

@extends('template.layout')
@section('title', 'Char Bazaar')
@section('submenuItem', 'sellCharacters')
@section('content')
    {!! $formaters->small_box($erro) !!}

    <br>

    <div style="float: right">
        <a href="{{ route('account.bazaar.sell_characters')}}">
            <div class="BigButton" style="background-image:url(/assets/tibiarl/images/buttons/sbutton_red.gif)">
                <div onmouseover="MouseOverBigButton(this);" onmouseout="MouseOutBigButton(this);">
                    <div class="BigButtonOver" style="background-image: url(/assets/tibiarl/images/buttons/sbutton_red_over.gif); visibility: hidden;"></div>
                    <input name="auction_submit" class="BigButtonText" type="button" value="Back / Error">
                </div>
            </div>
        </a>
    </div>
@endsection
