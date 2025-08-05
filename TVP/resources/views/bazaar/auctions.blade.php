{{-- 
* @description Char-Bazaar - Venda de personagens
* @author Rickson Kauê
* @date Data de criação 05/12/2023
* @version 1.0
* @copyright (c) Ravenor
* @email ricksonkaue04@gmail.com
--}}

@extends('template.layout')
@section('title', 'My Auctions')
@section('submenuItem', 'myAuctions')
@section('content')

{{-- {!! $formaters->small_box("

<h3>🤔 Understanding how the auction works</h3>

<h4>🚫 Lowest bids:</h4>
<p style='font-weight:normal'>You cannot bid lower than the current minimum bid. Bids often increase based on competing offers.</p>

<h4>💡 Standard operation:</h4>
<p style='font-weight:normal'>The next bid must exceed the current bid by at least one unit.</p>

<h4>👀 Did a character that was on sale disappear from the account?</h4>
<p style='font-weight:normal'>Buyer and seller can complete the transaction. The coins will be delivered to the seller and the character to the buyer. This means that there is no need for both of you to click on confirmation. After confirmation, the transaction is complete and will no longer be available for approval.</p>

<h4>⌛ Auction duration:</h4>
<p style='font-weight:normal'>The minimum duration is one day. Pay attention to the number of days you enter, as the operation will only be completed at the end of the established end date.</p>

<h4>😵 I click on receive and nothing happens, the operation is not complete, what should I do?</h4>
<p style='font-weight:normal'>Communication failure. Open a ticket on Discord and notify the administration.</p>

<h4>👻 Can my character disappear in the process?</h4>
<p style='font-weight:normal'>No.</p>

<h4>🎭 Can I benefit from any bazaar failures?</h4>
<p style='font-weight:normal'>No. The history is not yet open to the public, but there is a record of all operations being carried out.
</p>

<h4>🤝 Don't hesitate to contact support; We are here to help.</h4>

") !!} --}}

<br>

<div class="SmallBox">
  <div class="MessageContainer">
    <div class="BoxFrameHorizontal" style="background-image:url(/assets/tibiarl/images/content/box-frame-horizontal.gif);"></div>
    <div class="BoxFrameEdgeLeftTop" style="background-image:url(/assets/tibiarl/images/content/box-frame-edge.gif);"></div>
    <div class="BoxFrameEdgeRightTop" style="background-image:url(/assets/tibiarl/images/content/box-frame-edge.gif);"></div>
    <div class="Message">
      <div class="BoxFrameVerticalLeft" style="background-image:url(/assets/tibiarl/images/content/box-frame-vertical.gif);"></div>
      <div class="BoxFrameVerticalRight" style="background-image:url(/assets/tibiarl/images/content/box-frame-vertical.gif);"></div>
      <table class="HintBox">
        <tbody>
          <tr>
            <td><div style="float: right;"></div>
              <p>Here you find <b>your character auctions</b> that:</p>
              <ul>
                <li>are currently running</li>
                <li>were recently cancelled</li>
                <li>receive a purchased character</li>
                <li>receive coins from the sold character</li>
                <li>yours binds</li>
              </ul>

              <p><b>Direct Sale Tax:</b> When you sell a character directly, a tax is applied based on the character's level. The tax rates are as follows:</p>
              <ul>
                  <li><b>Levels 1-25:</b> 75 Coins</li>
                  <li><b>Levels 26-50:</b> 100 Coins</li>
                  <li><b>Levels 51-75:</b> 125 Coins</li>
                  <li><b>Levels 76-100:</b> 150 Coins</li>
                  <li><b>Levels 101-125:</b> 200 Coins</li>
                  <li><b>Levels 126-150:</b> 250 Coins</li>
              </ul>
              <p>The tax amount is deducted from the buyer proceeds.</p>

              <p>Values ​​in binds already have the <b>12% rate deducted tax</b><br><b>Your Ravenor Coins: {{ $playerData['coins'] }}</b></p>
            </td>
          </tr>
        </tbody>
      </table>
    </div>
    <div class="BoxFrameHorizontal" style="background-image:url(/assets/tibiarl/images/content/box-frame-horizontal.gif);"></div>
    <div class="BoxFrameEdgeRightBottom" style="background-image:url(/assets/tibiarl/images/content/box-frame-edge.gif);"></div>
    <div class="BoxFrameEdgeLeftBottom" style="background-image:url(/assets/tibiarl/images/content/box-frame-edge.gif);"></div>
  </div>
</div>
<br>
<div class="TableContainer">
  <div class="CaptionContainer">
    <div class="CaptionInnerContainer"><span class="CaptionEdgeLeftTop" style="background-image:url(/assets/tibiarl/images/content/box-frame-edge.gif);"></span> <span class="CaptionEdgeRightTop" style="background-image:url(/assets/tibiarl/images/content/box-frame-edge.gif);"></span> <span class="CaptionBorderTop" style="background-image:url(/assets/tibiarl/images/content/table-headline-border.gif);"></span> <span class="CaptionVerticalLeft" style="background-image:url(/assets/tibiarl/images/content/box-frame-vertical.gif);"></span>
      <div class="Text">Get character / Recive Coins</div>
      <span class="CaptionVerticalRight" style="background-image:url(/assets/tibiarl/images/content/box-frame-vertical.gif);"></span> <span class="CaptionBorderBottom" style="background-image:url(/assets/tibiarl/images/content/table-headline-border.gif);"></span> <span class="CaptionEdgeLeftBottom" style="background-image:url(/assets/tibiarl/images/content/box-frame-edge.gif);"></span> <span class="CaptionEdgeRightBottom" style="background-image:url(/assets/tibiarl/images/content/box-frame-edge.gif);"></span> </div>
  </div>
  <table class="Table3" cellpadding="0" cellspacing="0">
    <tbody>
      <tr>
        <td><div class="InnerTableContainer">
            <table style="width:100%;">
              <tbody>
                <tr>
                  <td><div class="TableContentContainer">
                      <table class="TableContent" width="100%" style="border:1px solid #faf0d7;">
                        <tbody id="allBlock">
                          <tr class="Odd">
                            <td class="LabelV">Name</td>
                            <td class="LabelV">Start</td>
                            <td class="LabelV">End</td>
                            <td class="LabelV">Seller Recive</td>
                            <td class="LabelV">Status</td>
                            <td class="LabelV">Action</td>
                          </tr>

                          @if(empty($playerData['actionData'][0]))
                            <tr class="Even">
                              <td>N/a</td>
                              <td>N/a</td>
                              <td>N/a</td>
                              <td>N/a</td>
                              <td>N/a</td>
                              <td>N/a</td>
                            </tr>
                          @endif
                          
                          @php 
                            $backgroundClass = "Odd"; 
                            $cont = 0;
                            $processedNames = [];
                          @endphp

                          @foreach ($playerData['sellerData'] as $auction)

                              @php
                                $processedNames[] = $auction->name;
                              @endphp
                      
                              @if($auction->status == 4)
                                <tr id="block{{ $cont }}" class="{{ $backgroundClass == "Odd" ? "Even" : "Odd" }}">
                                    <td>{{ $auction->name }}</td>
                                    <td>{{ $auction->date_start }}</td>
                                    <td>{{ $auction->date_end }}</td>
                                    <td>
                                      @if($auction->bid_price == null)
                                        0
                                      @else

                                        @php 
                                          $characterLevel = $auction->level;
                                          
                                          $tax = 75;

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

                                        @endphp

                                        {{ ceil($auction->bid_price) - $tax }}
                                        
                                      @endif
                                    </td>
                                    <td>
                                      @if($auction->bid_price == null)
                                        Failed
                                      @else
                                        Complete
                                      @endif
                                    </td>
                                    <td>
                                      <div class="BigButton" style="background-image:url(/assets/tibiarl/images/buttons/sbutton_green.gif)" onclick="sendAction('{{ $auction->hash }}', 'block{{ $cont }}')">
                                        <div onmouseover="this.childNodes[1].style.visibility = 'visible';" onmouseout="this.childNodes[1].style.visibility = 'hidden';">
                                            <div class="BigButtonOver" style="background-image: url(/assets/tibiarl/images/buttons/sbutton_green_over.gif); visibility: hidden;">
                                            </div>
                                            <input name="auction_confirm" class="BigButtonText" type="submit" value="Recive">
                                        </div>
                                      </div>
                                    </td>
                                </tr>
                              @else
                                <tr id="block{{ $cont }}" class="{{ $backgroundClass == "Odd" ? "Even" : "Odd" }}">
                                    <td>{{ $auction->name }}</td>
                                    <td>{{ $auction->date_start }}</td>
                                    <td>{{ $auction->date_end }}</td>
                                    <td>
                                      @if($auction->bid_price == null)
                                        0
                                      @else
                                        {{ ceil($auction->bid_price - ($auction->bid_price * 0.12)) }}
                                      @endif
                                    </td>
                                    <td>
                                      @if($auction->bid_price == null)
                                        Failed
                                      @else
                                        Complete
                                      @endif
                                    </td>
                                    <td>
                                      <div class="BigButton" style="background-image:url(/assets/tibiarl/images/buttons/sbutton_green.gif)" onclick="sendAction('{{ $auction->hash }}', 'block{{ $cont }}')">
                                        <div onmouseover="this.childNodes[1].style.visibility = 'visible';" onmouseout="this.childNodes[1].style.visibility = 'hidden';">
                                            <div class="BigButtonOver" style="background-image: url(/assets/tibiarl/images/buttons/sbutton_green_over.gif); visibility: hidden;">
                                            </div>
                                            <input name="auction_confirm" class="BigButtonText" type="submit" value="Recive">
                                        </div>
                                      </div>
                                    </td>
                                </tr>
                              @endif

                              @php 
                                $backgroundClass == "Odd" ? $backgroundClass="Even" : $backgroundClass="Odd"; 
                                $cont++;
                              @endphp
                          @endforeach
                          
                          @foreach ($playerData['actionData'] as $auction)

                            @if(in_array($auction->name, $processedNames))
                              @continue
                            @endif
          
                          @if($auction->status == 4)
                            <tr id="block{{ $cont }}" class="{{ $backgroundClass == "Odd" ? "Even" : "Odd" }}">
                                <td>{{ $auction->name }}</td>
                                <td>{{ $auction->date_start }}</td>
                                <td>{{ $auction->date_end }}</td>
                                <td>
                                  @if($auction->bid_price == null)
                                    0
                                  @else

                                    @php 
                                      $characterLevel = $auction->level;
                                      
                                      $tax = 75;

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

                                    @endphp

                                    {{ ceil($auction->bid_price) - $tax }}
                                    
                                  @endif
                                </td>
                                <td>
                                  @if($auction->bid_price == null)
                                    Failed
                                  @else
                                    Complete
                                  @endif
                                </td>
                                <td>
                                  <div class="BigButton" style="background-image:url(/assets/tibiarl/images/buttons/sbutton_green.gif)" onclick="sendAction('{{ $auction->hash }}', 'block{{ $cont }}')">
                                    <div onmouseover="this.childNodes[1].style.visibility = 'visible';" onmouseout="this.childNodes[1].style.visibility = 'hidden';">
                                        <div class="BigButtonOver" style="background-image: url(/assets/tibiarl/images/buttons/sbutton_green_over.gif); visibility: hidden;">
                                        </div>
                                        <input name="auction_confirm" class="BigButtonText" type="submit" value="Recive">
                                    </div>
                                  </div>
                                </td>
                            </tr>
                          @else
                            <tr id="block{{ $cont }}" class="{{ $backgroundClass == "Odd" ? "Even" : "Odd" }}">
                                <td>{{ $auction->name }}</td>
                                <td>{{ $auction->date_start }}</td>
                                <td>{{ $auction->date_end }}</td>
                                <td>
                                  @if($auction->bid_price == null)
                                    0
                                  @else
                                    {{ ceil($auction->bid_price - ($auction->bid_price * 0.12)) }}
                                  @endif
                                </td>
                                <td>
                                  @if($auction->bid_price == null)
                                    Failed
                                  @else
                                    Complete
                                  @endif
                                </td>
                                <td>
                                  <div class="BigButton" style="background-image:url(/assets/tibiarl/images/buttons/sbutton_green.gif)" onclick="sendAction('{{ $auction->hash }}', 'block{{ $cont }}')">
                                    <div onmouseover="this.childNodes[1].style.visibility = 'visible';" onmouseout="this.childNodes[1].style.visibility = 'hidden';">
                                        <div class="BigButtonOver" style="background-image: url(/assets/tibiarl/images/buttons/sbutton_green_over.gif); visibility: hidden;">
                                        </div>
                                        <input name="auction_confirm" class="BigButtonText" type="submit" value="Recive">
                                    </div>
                                  </div>
                                </td>
                            </tr>
                          @endif

                          @php 
                            $backgroundClass == "Odd" ? $backgroundClass="Even" : $backgroundClass="Odd"; 
                            $cont++;
                          @endphp
                      @endforeach     

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
      <div class="Text">Character in progress to sale</div>
      <span class="CaptionVerticalRight" style="background-image:url(/assets/tibiarl/images/content/box-frame-vertical.gif);"></span> <span class="CaptionBorderBottom" style="background-image:url(/assets/tibiarl/images/content/table-headline-border.gif);"></span> <span class="CaptionEdgeLeftBottom" style="background-image:url(/assets/tibiarl/images/content/box-frame-edge.gif);"></span> <span class="CaptionEdgeRightBottom" style="background-image:url(/assets/tibiarl/images/content/box-frame-edge.gif);"></span> </div>
  </div>
  <table class="Table3" cellpadding="0" cellspacing="0">
    <tbody>
      <tr>
        <td><div class="InnerTableContainer">
            <table style="width:100%;">
              <tbody>
                <tr>
                  <td><div class="TableContentContainer">
                      <table class="TableContent" width="100%" style="border:1px solid #faf0d7;">
                        <tbody>
                            <tr class="Odd">
                                <td class="LabelV">Name</td>
                                <td class="LabelV">Start</td>
                                <td class="LabelV">Seller receives</td>
                                <td class="LabelV">Initial Price</td>
                                <td class="LabelV">Direct Sale</td>
                            </tr>

                            @if(empty($playerData['charactersData'][0]))
                              <tr class="Even">
                                <td>N/a</td>
                                <td>N/a</td>
                                <td>N/a</td>
                                <td>N/a</td>
                                <td>N/a</td>
                                <td>N/a</td>
                              </tr>
                            @endif
                            
                            @php $backgroundClass = "Odd"; @endphp
                            @foreach ($playerData['charactersData'] as $auction)

                                @if($auction->bid_price)
                                  @continue
                                @endif

                                <tr class="{{ $backgroundClass == "Odd" ? "Even" : "Odd" }}">
                                    <td>{{ $auction->name }}</td>
                                    <td>{{ $auction->date_start }}</td>

                                    @if($auction->bid_price == null)                                       
                                      <td>
                                        <div class="BigButton" style="background-image:url(/assets/tibiarl/images/buttons/sbutton_green.gif)" onclick="
                                        
                                          var grandparent = this.parentNode.parentNode;
                                          grandparent.innerHTML = '<td>N/a</td><td>N/a</td><td>N/a</td><td>N/a</td><td>N/a</td>';
                                          sendAction('{{ $auction->hash }}', 'x');
                                        
                                        ">
                                          <div onmouseover="this.childNodes[1].style.visibility = 'visible';" onmouseout="this.childNodes[1].style.visibility = 'hidden';">
                                              <div class="BigButtonOver" style="background-image: url(/assets/tibiarl/images/buttons/sbutton_green_over.gif); visibility: hidden;">
                                              </div>
                                              <input name="auction_confirm" class="BigButtonText" type="submit" value="Recive">
                                          </div>
                                        </div>
                                      </td>
                                    @else
                                      <td>No offers</td>
                                    @endif

                                    <td>
                                      @if($auction->status == 4)
                                        @php 
                                          $characterLevel = $auction->level;
                                          
                                          $tax = 75;

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

                                          echo $auction->price + $tax;

                                        @endphp
                                      @else
                                          {{ $auction->price }}
                                      @endif

                                    </td>

                                    <td>
                                      @if($auction->status == 4)
                                        <input type="text" value="{{ $auction->hash }}" id="auctionCode" hidden>
                                        <div class="BigButton" style="background-image:url(/assets/tibiarl/images/buttons/sbutton_green.gif)" onclick="copyToClipboard()">
                                            <div onmouseover="this.childNodes[1].style.visibility = 'visible';" onmouseout="this.childNodes[1].style.visibility = 'hidden';">
                                                <div class="BigButtonOver" style="background-image: url(/assets/tibiarl/images/buttons/sbutton_green_over.gif); visibility: hidden;">
                                                </div>
                                                <input name="copy" class="BigButtonText" type="button" value="Copy">
                                            </div>
                                        </div>                                  
                                      @else
                                        N/a
                                      @endif
                                    </td>
                                </tr>
                                
                                @php $backgroundClass == "Odd" ? $backgroundClass="Even" : $backgroundClass="Odd"; @endphp
                            @endforeach     
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
      <div class="Text">Yours bids</div>
      <span class="CaptionVerticalRight" style="background-image:url(/assets/tibiarl/images/content/box-frame-vertical.gif);"></span> <span class="CaptionBorderBottom" style="background-image:url(/assets/tibiarl/images/content/table-headline-border.gif);"></span> <span class="CaptionEdgeLeftBottom" style="background-image:url(/assets/tibiarl/images/content/box-frame-edge.gif);"></span> <span class="CaptionEdgeRightBottom" style="background-image:url(/assets/tibiarl/images/content/box-frame-edge.gif);"></span> </div>
  </div>

  <table class="Table3" cellpadding="0" cellspacing="0">
    <tbody>
      <tr>
        <td><div class="InnerTableContainer">
            <table style="width:100%;">
              <tbody>
                <tr>
                  <td><div class="TableContentContainer">
                      <table class="TableContent" width="100%" style="border:1px solid #faf0d7;">
                        <tbody>
                            <tr class="Odd">
                                <td class="LabelV">Name</td>
                                <td class="LabelV">Start</td>
                                <td class="LabelV">End</td>
                                <td class="LabelV">Current Bid</td>
                                <td class="LabelV">Initial Price</td>
                            </tr>

                            @if(empty($playerData['bidData'][0]))
                              <tr class="Even">
                                <td>N/a</td>
                                <td>N/a</td>
                                <td>N/a</td>
                                <td>N/a</td>
                                <td>N/a</td>
                              </tr>
                            @endif
                            
                            @php $backgroundClass = "Odd"; @endphp
                            @foreach ($playerData['bidData'] as $auction)

                                @if ($auction->status != 4)
                                  <tr class="{{ $backgroundClass == "Odd" ? "Even" : "Odd" }}">
                                      <td>{{ $auction->name }}</td>
                                      <td>{{ $auction->date_start }}</td>
                                      <td>{{ $auction->date_end }}</td>
                                      <td>{{ ceil($auction->bid_price - ($auction->bid_price * 0.12)) }}</td>
                                      <td>{{ $auction->price }}</td>
                                  </tr>
                                @endif

                                @php $backgroundClass == "Odd" ? $backgroundClass="Even" : $backgroundClass="Odd"; @endphp
                            @endforeach     
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

<script>

    function sendAction(hash, object) {
      
      function getBaseUrl() {
        const currentURL = window.location.href;
        const match = currentURL.match(/^https?:\/\/[^/]+/);
        return match ? match[0] : currentURL;
      }

      const baseUrl = getBaseUrl();
      const additionalPath = '/account/bazaar/orders';
      const fullURL = baseUrl + additionalPath;

      const data = { hash: hash };
      const token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

      fetch(fullURL, {
        method: 'POST',
        headers: {
          'Content-Type': 'application/json',
          'X-CSRF-TOKEN': token,
        },
        body: JSON.stringify(data),
      })
      .then(response => {
        if (!response.ok) {
          throw new Error('Network response was not ok ' + response.statusText);
        }
        return response.text(); 
      })
      .then(text => {
        console.log('Success:', text); 
      })
      .catch(error => {
        console.error('There was a problem with the fetch operation:', error);
      });
    
    function checkAllElements(){

      clearColumn = document.getElementById(object); 
      clearColumn.style.display = "none";

      let i = 0;
      let allHidden = true;

      while (true) {
        const elementId = 'block' + i;
        const element = document.getElementById(elementId);

        if (element !== null) {
          if (element.style.display !== 'none') {
            allHidden = false;
            break;
          }
          i++;
        } else {

          break;
        }
      }

      if(allHidden){
        tableBlock = document.getElementById("allBlock");
        tableBlock.innerHTML = `
          <tr class="Odd">
            <td class="LabelV">Name</td>
            <td class="LabelV">Start</td>
            <td class="LabelV">End</td>
            <td class="LabelV">Bid</td>
            <td class="LabelV">Status</td>
            <td class="LabelV">Action</td>
          </tr>
          <tr class="Even">
            <td>N/a</td>
            <td>N/a</td>
            <td>N/a</td>
            <td>N/a</td>
            <td>N/a</td>
            <td>N/a</td>
          </tr>
      `;
    }
  }

  checkAllElements();  
  
  }

  function copyToClipboard() {
      const auctionCode = document.getElementById('auctionCode');
      const tempInput = document.createElement('input');
      document.body.appendChild(tempInput);
      tempInput.value = auctionCode.value;
      tempInput.select();
      document.execCommand('copy');
      document.body.removeChild(tempInput);
      alert('Direct selling code copied:: ' + auctionCode.value);
  }

</script>

@endsection
