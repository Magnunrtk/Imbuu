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

@if($charactersData->count() === 0)
    {!! $formaters->small_box('There are no characters for sale yet.') !!}
@else

<div class="TableContainer">
    <div class="CaptionContainer">
      <div class="CaptionInnerContainer"> <span class="CaptionEdgeLeftTop" style="background-image:url(/assets/tibiarl/images/content/box-frame-edge.gif);"></span> <span class="CaptionEdgeRightTop" style="background-image:url(/assets/tibiarl/images/content/box-frame-edge.gif);"></span> <span class="CaptionBorderTop" style="background-image:url(/assets/tibiarl/images/content/table-headline-border.gif);"></span> <span class="CaptionVerticalLeft" style="background-image:url(/assets/tibiarl/images/content/box-frame-vertical.gif);"></span>
        <div class="Text">Direct Sale</div>
        <span class="CaptionVerticalRight" style="background-image:url(/assets/tibiarl/images/content/box-frame-vertical.gif);"></span> <span class="CaptionBorderBottom" style="background-image:url(/assets/tibiarl/images/content/table-headline-border.gif);"></span> <span class="CaptionEdgeLeftBottom" style="background-image:url(/assets/tibiarl/images/content/box-frame-edge.gif);"></span> <span class="CaptionEdgeRightBottom" style="background-image:url(/assets/tibiarl/images/content/box-frame-edge.gif);"></span> </div>
    </div>
    <table class="Table3" cellspacing="0" cellpadding="0">
      <tbody>
        <tr>		  
            <td><div class="InnerTableContainer">
              <table style="width:100%;">
                <tbody>
                  <tr>
                    <td><div class="TableContentContainer">
                        <table class="TableContent" style="border:1px solid #faf0d7;" width="100%">
                          <tbody>
                            <tr>
                                <td style="font-weight:bold;">Direct Sale Code:</td>
                                <td>
                                    <form action="{{ route("account.bazaar.bidAuction") }}" method="post">
                                        @csrf
                                        <div style="display: flex; align-content: center; gap: 10px">
                                            <input name="directCode" type="text" required>
                                            <div class="BigButton" style="background-image:url(/assets/tibiarl/images/buttons/sbutton.gif)"><div onmouseover="MouseOverBigButton(this);" onmouseout="MouseOutBigButton(this);"><div class="BigButtonOver" style="background-image: url(/assets/tibiarl/images/buttons/sbutton_over.gif); visibility: hidden;"></div><input class="BigButtonText" type="submit" value="Send"></div></div>
                                            <input name="action" value="4" type="number" hidden>
                                        </div>  
                                    </form>
                                </td>
                            </tr>
                          </tbody>
                        </table>
                      </div></td>
                  </tr>
                </tbody>
              </table>
            </div></td>
        </tr> 
      </tbody>
    </table>
</div>

<br>

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
                    @php $cont = 0; @endphp
                    @foreach( $charactersData as $character)
                        @if ($character->status == 4)
                            @php continue; @endphp
                        @endif
                        <tr>
                        <td><div class="TableContentContainer">
                            <table class="TableContent" style="border:1px solid #faf0d7;" width="100%">
                                <tbody>
                                    <tr>
                                        <td>
                                            <div class="Auction">
                                                <div class="AuctionHeader">

                                                    <div class="AuctionLinks" onclick="sendForm({{ $cont }})">
                                                        <div style="float:right; cursor:pointer">
                                                            <img title="show auction details" src="/assets/tibiarl/images/content/button-details-idle.png">
                                                        </div>
                                                    </div>

                                                    <div class="AuctionCharacterName" onclick="sendForm({{ $cont }})">
                                                        <a> {{ $character->name }} </a>
                                                    </div>

                                                    @if($character->account_old == $accountId)
                                                        <b style="color:red"> Your character</b> | 
                                                    @endif

                                                    Level: {{ $character->level }} | Vocation: {{ $vocations[$character->vocation] }} | Sex: {{ $character->sex == 0 ? "Female" : "Male" }} <br> 
                                                </div>

                                                <div class="AuctionBody">

                                                    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.css"/>
                                                    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick-theme.css"/>
                                                    <style>
                                                        .AuctionOutfit {
                                                            position: relative;
                                                            width: 100px;
                                                            margin: 0 auto;
                                                            margin-top: -26px;
                                                        }
                                                        .AuctionOutfitImage {
                                                            width: 100;
                                                            height: 100;
                                                        }

                                                        
                                                        .slick-prev,
                                                        .slick-next {
                                                            line-height: 1; 
                                                            background-color: #3498db; 
                                                            color: #fff; 
                                                            border-radius: 50%; 
                                                            z-index: 1; 
                                                            transition: background-color 0.3s ease; 
                                                        }

                                                        .slick-prev{

                                                            left: 0;
                                                            top: 70%;
                                                        }

                                                        
                                                        .slick-next{

                                                            right: 0;
                                                            top: 70%
                                                        }


                                                        .slick-prev::before,
                                                        .slick-next::before {
                                                            color: #3498db;
                                                            background-color: #ffffff; 
                                                            border-radius: 100%
                                                        }

                                                        .slick-prev:hover,
                                                        .slick-next:hover {
                                                            background-color: #ff0000; 
                                                        }

                                                        .slick-dots li{
                                                            font-size: 10px;
                                                            margin: 0 2px; 
                                                            width: 10px;
                                                        }
                                                                                                        
                                                    </style>
                                                                                                        
                                                    <div class="AuctionBodyBlock AuctionDisplay">
                                                        <div class="AuctionOutfit">
                                                            @if (!empty($outifitsData[$character->player_id]))
                                                                @foreach ($outifitsData[$character->player_id] as $outfit)
                                                                    <div>
                                                                        <img style="width:100px; height: 100px; margin-left: -25px" src="/outfits/animoutfit.php?id={{ $outfit['look_type'] }}&addons={{ $outfit['addons'] }}&head={{ $character->lookhead }}&body={{ $character->lookbody }}&legs={{ $character->looklegs }}&feet={{ $character->lookfeet }}" alt="Character Outfit">
                                                                    </div>
                                                                @endforeach
                                                            @else
                                                                <div>
                                                                    <img class="AuctionOutfitImage" style="margin-left: -25px" src="/outfits/animoutfit.php?id={{ $character->looktype }}&addons={{ $character->lookaddons }}&head={{ $character->lookhead }}&body={{ $character->lookbody }}&legs={{ $character->looklegs }}&feet={{ $character->lookfeet }}" alt="Character Outfit">
                                                                </div>
                                                            @endif
                                                        </div>
                                                    </div>
                                                    
                                                    <!-- jQuery -->
                                                    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
                                                    <!-- Slick JS -->
                                                    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.min.js"></script>
                                                    <script type="text/javascript">
                                                        $(document).ready(function(){
                                                            $('.AuctionOutfit').slick({
                                                                dots: true,
                                                                infinite: true,
                                                                speed: 300,
                                                                slidesToShow: 1,
                                                                slidesToScroll: 1,
                                                                prevArrow: '<button type="button" class="slick-prev">Previous</button>',
                                                                nextArrow: '<button type="button" class="slick-next">Next</button>',
                                                            });
                                                        });
                                                    </script>                                                                                                        

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
                                                        @if (date('M d Y, H:i:s', strtotime($character->date_end)) !== 'Jan 01 1970, 01:00:00')
                                                            <div>{{ date('M d Y, H:i:s', strtotime($character->date_end)) }}</div>
                                                        @else
                                                            <div>It still doesn't have time to expire.</div>
                                                        @endif

                                                        <div class="ShortAuctionDataBidRow">
                                                            <div class="ShortAuctionDataLabel">Current Bid:</div>
                                                            <br>
                                                            <div>
                                                                {{ $character->bid_price > 0 ? $character->bid_price : $character->price }}
                                                                Ravenor Coins

                                                                <img src="/assets/tibiarl/images/account/icon-tibiacointrusted.png" class="VSCCoinImages" title="Transferable Tibia Coins">
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="AuctionBodyBlock CurrentBid">
                                                        <div class="Container">
                                                            <table style="margin-left: -4px">
                                                                <tbody>
                                                                    <tr>
                                                                        <td class="chbid">                                                            
                                                                            <div class="MyMaxBidLabel">My Bid Limit</div>
                                                                        </td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td class="chbid">
                                                                            <form action="{{ route("account.bazaar.bidAuction") }}" method="post">
                                                                                @csrf
                                                                            <input type="hidden" name="selectCharacter" value="{{ $character->name }}">

                                                                            @if($character->bid_price > 1)
                                                                                <input class="MyMaxBidInput" type="number" name="maxBid" min="{{ $character->bid_price+1 }}">
                                                                            @else
                                                                                <input class="MyMaxBidInput" type="number" name="maxBid" min="{{ $character->price+1 }}">
                                                                            @endif
                                                                        </td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td class="chbid">                                                            
                                                                            <div class="BigButton" style="background-image:url(/assets/tibiarl/images/buttons/sbutton_green.gif)">
                                                                                <div onmouseover="MouseOverBigButton(this);" onmouseout="MouseOutBigButton(this);">
                                                                                    <div class="BigButtonOver" style="background-image: url(/assets/tibiarl/images/buttons/sbutton_green_over.gif); visibility: hidden;">
                                                                                    </div>
                                                                                    <input name="auction_confirm" class="BigButtonText" type="submit" value="Bid On Auction">
                                                                                </div>
                                                                            </div>
                                                                            </form>
                                                                        </td>
                                                                    </tr>
                                                                </tbody>
                                                            </table>

                                                            <form method="post" action="{{ route('account.bazaar.statusAuction')}}">
                                                                @csrf
                                                                <input type="text" name="characterName" value="{{ $character->name }}" hidden>
                                                                <button id="sendForm{{ $cont }}" type="submit" hidden></button>
                                                            </form>
                                                            @php $cont++; @endphp
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

<script>
    function sendForm(x){

        buttonForm = document.getElementById(`sendForm${x}`).click();
    }
</script>

@endif
@endsection
