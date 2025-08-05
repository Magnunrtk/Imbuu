{{-- 
* @description Char-Bazaar - Venda de personagens
* @author Rickson Kauê
* @date Data de criação 05/12/2023
* @version 1.0
* @copyright (c) Ravenor
* @email ricksonkaue04@gmail.com
--}}

@extends('template.layout')
@section('title', 'Current Auctions')
@section('submenuItem', 'currentAuctions')
@section('content')

<div class="TableContainer">
    <div class="CaptionContainer">
      <div class="CaptionInnerContainer"> <span class="CaptionEdgeLeftTop" style="background-image:url(/assets/tibiarl/images/content/box-frame-edge.gif);"></span> <span class="CaptionEdgeRightTop" style="background-image:url(/assets/tibiarl/images/content/box-frame-edge.gif);"></span> <span class="CaptionBorderTop" style="background-image:url(/assets/tibiarl/images/content/table-headline-border.gif);"></span> <span class="CaptionVerticalLeft" style="background-image:url(/assets/tibiarl/images/content/box-frame-vertical.gif);"></span>
        <div class="Text">Current Auctions</div>
        <span class="CaptionVerticalRight" style="background-image:url(/assets/tibiarl/images/content/box-frame-vertical.gif);"></span> <span class="CaptionBorderBottom" style="background-image:url(/assets/tibiarl/images/content/table-headline-border.gif);"></span> <span class="CaptionEdgeLeftBottom" style="background-image:url(/assets/tibiarl/images/content/box-frame-edge.gif);"></span> <span class="CaptionEdgeRightBottom" style="background-image:url(/assets/tibiarl/images/content/box-frame-edge.gif);"></span> </div>
    </div>
    <table class="Table3" cellspacing="0" cellpadding="0">
      <tbody>
        <tr>
          <td><div class="InnerTableContainer">
              <table style="width:100%;">
                <tbody>
                    @foreach ($charactersData as $character)

                        @php 
                            if($actionCode == 4){

                                $tax = 75;
                                $characterLevel = $character->level;

                                if ($characterLevel >= 126) {
                                    $tax = 250;
                                } elseif ($characterLevel >= 101) {
                                    $tax = 200;
                                } elseif ($characterLevel >= 76) {
                                    $tax = 150;
                                } elseif ($characterLevel >= 51) {
                                    $tax = 125;
                                } elseif ($characterLevel >= 26) {
                                    $tax = 100;
                                }

                                $_POST["maxBid"] = $price + $tax;
                            }

                        @endphp

                        <tr>
                        <td><div class="TableContentContainer">
                            <table class="TableContent" style="border:1px solid #faf0d7;" width="100%">
                                <tbody>
                                    <tr>
                                        <td>
                                            <div class="Auction">
                                                <div class="AuctionHeader">

                                                    <div class="AuctionLinks">
                                                        <div style="float:right; cursor:pointer" onclick="statusForm()">
                                                            <img title="show auction details" src="/assets/tibiarl/images/content/button-details-idle.png">
                                                        </div>
                                                    </div>

                                                    <div class="AuctionCharacterName" onclick="statusForm()">
                                                        <a>{{ $character->name }}</a>
                                                    </div>

                                                    @if(in_array($character->id, $playerIds))
                                                        <b style="color:red"> Your character</b> | 
                                                    @endif

                                                    Level: {{ $character->level }} | Vocation: {{ $vocations[$character->vocation] }} | Sex: {{ $character->sex == 0 ? "Female" : "Male" }} <br> 
                                                </div>

                                                <div class="AuctionBody">
                                                    <div class="AuctionBodyBlock AuctionDisplay AuctionOutfit">
                                                        <img class="AuctionOutfitImage" src="/outfits/animoutfit.php?id={{ $character->looktype }}&amp;addons={{ $character->lookaddons }}&amp;head={{ $character->lookhead }}&amp;body={{ $character->lookbody }}&amp;legs={{ $character->looklegs }}&amp;feet={{ $character->lookfeet }}"
                                                        >
                                                    </div>

                                                    <div class="AuctionBodyBlock AuctionDisplay-equipment" style="padding: 0.5%; width: 119px; height:113px">
                                                        <div class="CVIcon CVIconObject" style="margin-left: 4%"><img src="/images/items/no_necklace.gif" width="32" height="32" border="0" alt=" no_necklace"></div>
                                                        <div class="CVIcon CVIconObject"><img src="/images/items/no_helmet.gif" width="32" height="32" border="0" alt=" no_helmet"></div>
                                                        <div class="CVIcon CVIconObject"><img src="/images/items/no_backpack.gif" width="32" height="32" border="0" alt=" no_backpack"></div>
                                                        <div class="CVIcon CVIconObject" style="margin-left: 4%"><img src="/images/items/no_handright.gif" width="32" height="32" border="0" alt=" no_handright"></div>
                                                        <div class="CVIcon CVIconObject"><img src="/images/items/no_armor.gif" width="32" height="32" border="0" alt=" no_armor"></div>
                                                        <div class="CVIcon CVIconObject"><img src="/images/items/no_handleft.gif" width="32" height="32" border="0" alt=" no_handleft"></div>
                                                        <div class="CVIcon CVIconObject" style="margin-left: 4%"><img src="/images/items/no_ring.gif" width="32" height="32" border="0" alt=" no_ring"></div>
                                                        <div class="CVIcon CVIconObject"><img src="/images/items/no_legs.gif" width="32" height="32" border="0" alt=" no_legs"></div>
                                                        <div class="CVIcon CVIconObject"><img src="/images/items/no_ammo.gif" width="32" height="32" border="0" alt=" no_ammo"></div>
                                                    </div>

                    
                                                    <div class="AuctionBodyBlock ShortAuctionData" style="padding:1.5%">
                                                        <div class="ShortAuctionDataLabel">Auction Start:</div>
                                                        <br>
                                                        <div> {{ date('M d Y, H:s:i', strtotime($character->date_start)) }}</div>
                                                        <div class="ShortAuctionDataLabel">Auction End:</div>
                                                        <br>
                                                        <div> {{ date('M d Y, H:s:i', strtotime($character->date_end)) }}</div>
                                                        <div class="ShortAuctionDataBidRow">
                                                            <div class="ShortAuctionDataLabel">Current Bid:</div>
                                                            <br>
                                                            <div>{{ $character->price }} Ravenor Coins

                                                                <img src="/assets/tibiarl/images/account/icon-tibiacointrusted.png" class="VSCCoinImages" title="Transferable Tibia Coins">
                                                            </div>
                                                        </div>
                                                            
                                                    </div>

                                                </div>
                                    </div></td>
                                </tr>
                            </tbody>
                            </table>
                        </div></td>
                    </tr>
                  @endforeach
                </tbody>
            </table>
          </div></td>
      </tr>
    </tbody>
  </table>
</div>

<br>
<div class="CharacterDetailsBlock">
<div class="TableContainer">
    <div class="CaptionContainer">
        <div class="CaptionInnerContainer"> <span class="CaptionEdgeLeftTop" style="background-image:url(/assets/tibiarl/images/content/box-frame-edge.gif);"></span> <span class="CaptionEdgeRightTop" style="background-image:url(/assets/tibiarl/images/content/box-frame-edge.gif);"></span> <span class="CaptionBorderTop" style="background-image:url(/assets/tibiarl/images/content/table-headline-border.gif);"></span> <span class="CaptionVerticalLeft" style="background-image:url(/assets/tibiarl/images/content/box-frame-vertical.gif);"></span>
        <div class="Text">Confirm Bid For Auction</div>
        <span class="CaptionVerticalRight" style="background-image:url(/assets/tibiarl/images/content/box-frame-vertical.gif);"></span> <span class="CaptionBorderBottom" style="background-image:url(/assets/tibiarl/images/content/table-headline-border.gif);"></span> <span class="CaptionEdgeLeftBottom" style="background-image:url(/assets/tibiarl/images/content/box-frame-edge.gif);"></span> <span class="CaptionEdgeRightBottom" style="background-image:url(/assets/tibiarl/images/content/box-frame-edge.gif);"></span> </div>
    </div>
    <table class="Table1" cellspacing="0" cellpadding="0">
      <tbody>
        <tr>
          <td><div class="InnerTableContainer">
              <table style="width:100%;">
                <tbody>
                  <tr>
                    <td><br>Do you really want to bid the following amount for the character listed below:</td>
                  </tr>
                  
                    <tr><td><div style="padding:1%"></div></td></tr>

                    @if($actionCode == 4)
                        <tr>
                            <td><b>Tax: </b>{{ $tax }} Ravenor Coins.</td>
                        </tr>
                    @else                      
                        <tr>
                            <td><b>Your Bid: </b>{{ $_POST["maxBid"] }} Ravenor Coins.</td>
                        </tr> 
                    @endif
                    
                    <tr>
                        <td style="font-weight:normal;"><b>Your Ravenor Coins:</b> {{ $shopCoins }}.</td>
                    </tr>
                  <tr>
                    <td>

                        {{-- <br>If you confirm this bid, <b>50 Ravenor Coins</b> will be subtracted from your account's balance. 
                        This value does not return if a higher bid is given. --}}

                        @if($actionCode != 4)
                            <br><br>If someone is submitting a <b>higher bid</b>, the <b>only the value of {{  $_POST["maxBid"] }} will be returned</b> to your account.
                        @endif
                        
                        {{-- <br><br><b>Your balance after this operation will be {{ $shopCoins - $_POST["maxBid"] - 50 }}.</b> --}}

                        <br><br><b>Your balance after this operation will be {{ $shopCoins - $_POST["maxBid"] }}.</b>

                    </td>
                  </tr>

                  <tr><td><div style="padding:1%"></div></td></tr>

                </tbody>
              </table>
            </div></td>
        </tr>
      </tbody>
    </table>
  </div>
</div>
<br>

<table class="InnerTableButtonRow" cellspacing="0" cellpadding="0">
    <tbody>
        <tr>
            <td>
                <form id="resetForm" method="post"  action="{{ route('account.bazaar.finishBid') }}" onsubmit="return confirmSubmit('no');">
                    @csrf
                    <input type="text" name="selectCharacter" value="{{ $character->name }}" hidden>
                    <input type="text" name="maxBid" value="{{ $_POST["maxBid"] }}" hidden>
                    <div style="float: left;">
                        <a href="{{ route('account.bazaar.currentAuctions')}}">
                            <div class="BigButton" style="background-image:url(/assets/tibiarl/images/buttons/sbutton.gif)"><div onmouseover="MouseOverBigButton(this);" onmouseout="MouseOutBigButton(this);"><div class="BigButtonOver" style="background-image: url(/assets/tibiarl/images/buttons/sbutton_over.gif); visibility: hidden;"></div><input class="BigButtonText" type="button" value="Back"></div></div>
                        </a>
                    </div>
                    <div style="float: right;" onclick="confirmSubmit('yes')">
                        <div class="BigButton" style="background-image:url(/assets/tibiarl/images/buttons/sbutton_green.gif)"><div onmouseover="MouseOverBigButton(this);" onmouseout="MouseOutBigButton(this);"><div class="BigButtonOver" style="background-image: url(/assets/tibiarl/images/buttons/sbutton_green_over.gif); visibility: hidden;"></div><input name="auction_submit" class="BigButtonText" type="submit" value="Confirm"></div></div>
                    </div>

                </form>

                <div style="float: right; margin-right: 10px">
                    <form method="post" action="{{ route('account.bazaar.statusAuction')}}">
                        @csrf
                        <input type="text" name="characterName" value="{{ $character->name }}" hidden>
                        <div class="BigButton" style="background-image:url(/assets/tibiarl/images/buttons/sbutton_red.gif)"><div onmouseover="MouseOverBigButton(this);" onmouseout="MouseOutBigButton(this);"><div class="BigButtonOver" style="background-image: url(/assets/tibiarl/images/buttons/sbutton_red_over.gif); visibility: hidden;"></div><input id="sendForm" name="auction_submit" class="BigButtonText" type="submit" value="Char Status"></div></div>
                    </form>
                </div>
            </td>
        </tr>
    </tbody>
</table>

@if(in_array($character->id, $playerIds))
    <script>
        old_select = null;

        function confirmSubmit(x){

            if(x == "yes"){

                var userConfirmation = confirm('Are you sure you want to apply it to your own character?');
                old_select = userConfirmation;
            }else{

                return old_select;
            }

        }
    </script>
@else
    <script> function confirmSubmit(x){ return true;} </script>
@endif

<script>
    function statusForm(){
        buttonForm = document.getElementById("sendForm").click();
    }
</script>

@endsection
