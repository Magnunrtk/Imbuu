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
    @if($number_characters < 1)
        {!! $formaters->small_box('You have no characters to sell') !!}
    @else
    
      {!! $formaters->progressBar([[2, 0], [1, 2], [2, 2], [2, 2]], 2) !!}
      
      <form method="post" action="{{ route('account.bazaar.check_characters.post')}}">
        @csrf
          <div class="TableContainer">
            <div class="CaptionContainer">
              <div class="CaptionInnerContainer"> <span class="CaptionEdgeLeftTop" style="background-image:url(/assets/tibiarl/images/content/box-frame-edge.gif);"></span> <span class="CaptionEdgeRightTop" style="background-image:url(/assets/tibiarl/images/content/box-frame-edge.gif);"></span> <span class="CaptionBorderTop" style="background-image:url(/assets/tibiarl/images/content/table-headline-border.gif);"></span> <span class="CaptionVerticalLeft" style="background-image:url(/assets/tibiarl/images/content/box-frame-vertical.gif);"></span>
                <div class="Text">Select Character (1/4)</div>
                <span class="CaptionVerticalRight" style="background-image:url(/assets/tibiarl/images/content/box-frame-vertical.gif);"></span> <span class="CaptionBorderBottom" style="background-image:url(/assets/tibiarl/images/content/table-headline-border.gif);"></span> <span class="CaptionEdgeLeftBottom" style="background-image:url(/assets/tibiarl/images/content/box-frame-edge.gif);"></span> <span class="CaptionEdgeRightBottom" style="background-image:url(/assets/tibiarl/images/content/box-frame-edge.gif);"></span> </div>
            </div>
            <table class="Table5" cellspacing="0" cellpadding="0">
              <tbody>
                <tr>
                  <td><div class="InnerTableContainer">
                      <table style="width:100%;">
                        <tbody>
                          <tr>
                            <td>
                              <div class="TableContentContainer">
                                <table class="TableContent" style="border:1px solid #faf0d7;" width="100%">
                                  <tbody>
                                    <tr>
                                      <td><table style="float: left; width: 100%; " cellspacing="0" cellpadding="0">
                                          <tbody>
                                            <tr>
                                              <td>
                                                  <table style="float: left; width: 100%; " cellspacing="0" cellpadding="0">
                                                      <tbody>
                                                          <tr>
                                                              <td>
                                                                  <select style="width: 100%;" name="auction_character">
                                                                      @for($i = 0; $i < $number_characters; $i++)
                                                                          <option>{{ $characters_names[$i] }}</option>
                                                                      @endfor
                                                                  </select>
                                                              </td>
                                                          </tr>
                                                      </tbody>
                                                  </table>
                                              </td>
                                            </tr>
                                          </tbody>
                                        </table></td>
                                    </tr>
                                  </tbody>
                                </table>
                              </div>
                              </td>
                          </tr>
                        </tbody>
                      </table>
                    </div></td>
                </tr>
              </tbody>
            </table>
          </div>
          <br>
          <table class="InnerTableButtonRow" cellspacing="0" cellpadding="0">
            <tbody>
              <tr>
                <td>
                  <div style="float: right;">
                    <div class="BigButton" style="background-image:url(/assets/tibiarl/images/buttons/sbutton_green.gif)"><div onmouseover="MouseOverBigButton(this);" onmouseout="MouseOutBigButton(this);"><div class="BigButtonOver" style="background-image: url(&quot;/assets/tibiarl/images/buttons/sbutton_green_over.gif&quot;); visibility: hidden;"></div><input name="auction_submit" class="BigButtonText" type="submit" value="Next"></div></div>
                  </div>                     
                </td> 
              </tr>
            </tbody>
          </table>
      </form>
    @endif
@endsection
