@extends('template.layout')
@section('title', 'Account Management')
@section('submenuItem', 'accountmanagement')
@section('content')

    {{-- 
    <div class="SmallBox">
        <div class="MessageContainer">
            <div class="BoxFrameHorizontal" style="background-image:url({{ asset('/assets/tibiarl/images/content/box-frame-horizontal.gif') }});"></div>
            <div class="BoxFrameEdgeLeftTop" style="background-image:url({{ asset('/assets/tibiarl/images/content/box-frame-edge.gif') }});"></div>
            <div class="BoxFrameEdgeRightTop" style="background-image:url({{ asset('/assets/tibiarl/images/content/box-frame-edge.gif') }});"></div>
            <div class="Message">
                <div class="BoxFrameVerticalLeft" style="background-image:url({{ asset('/assets/tibiarl/images/content/box-frame-vertical.gif') }});"></div>
                <div class="BoxFrameVerticalRight" style="background-image:url({{ asset('/assets/tibiarl/images/content/box-frame-vertical.gif') }});"></div>
                <div class="NavigationBarContainer">
                    <div class="NavigationBarButtons">

                        <div class="BigButton" onclick="RedirectToUrl('{{ route('account.store.index') }}');" style="background-image:url({{ asset('/assets/tibiarl/images/buttons/sbutton_green.gif') }})"><div onmouseover="MouseOverBigButton(this);" onmouseout="MouseOutBigButton(this);"><div class="BigButtonOver" style="background-image:url({{ asset('/assets/tibiarl/images/buttons/sbutton_green_over.gif') }});"></div>
                                <input class="BigButtonText" type="submit" value="Get Coins">
                            </div>
                        </div> 
                        
                        <div class="NavigationBarButtonSpacer"></div>
                        <div class="BigButton" onclick="RedirectToUrl('{{ route('account.index') }}');" style="background-image:url({{ asset('/assets/tibiarl/images/buttons/sbutton.gif') }})">
                            <div onmouseover="MouseOverBigButton(this);" onmouseout="MouseOutBigButton(this);"><div class="BigButtonOver" style="background-image:url({{ asset('/assets/tibiarl/images/buttons/sbutton_over.gif') }});"></div>
                                <input class="BigButtonText" type="submit" value="Overview">
                            </div>
                        </div>
                    </div>
                    <div class="NavigationBarLinkList">
                        <nobr>[<a onclick="ScrollToAnchor('General+Information');">General Information</a>]</nobr>
                        <nobr>[<a onclick="ScrollToAnchor('Tell-A-Friend');">Tell-A-Friend</a>]</nobr> 
                        <nobr>[<a onclick="ScrollToAnchor('Products+Available');">Products Available</a>]</nobr>
                    </div>
                </div>
            </div>
            <div class="BoxFrameHorizontal" style="background-image:url({{ asset('/assets/tibiarl/images/content/box-frame-horizontal.gif') }});"></div>
            <div class="BoxFrameEdgeRightBottom" style="background-image:url({{ asset('/assets/tibiarl/images/content/box-frame-edge.gif') }});"></div>
            <div class="BoxFrameEdgeLeftBottom" style="background-image:url({{ asset('/assets/tibiarl/images/content/box-frame-edge.gif') }});"></div>
        </div>
    </div> --}}
    
    <br>
    <a name="General+Information"></a>
    <div class="TopButtonContainer">
        <a name="General+Information"></a>
        <div class="TopButton"><a name="Tell-A-Friend"></a><a href="#top"><img style="border: 0px;" src="{{ asset('/assets/tibiarl/images/content/back-to-top.gif') }}"></a></div>
    </div>
    <div class="TableContainer">
        <div class="CaptionContainer">
            <div class="CaptionInnerContainer">
                <span class="CaptionEdgeLeftTop" style="background-image:url({{ asset('/assets/tibiarl/images/content/box-frame-edge.gif') }});"></span>
                <span class="CaptionEdgeRightTop" style="background-image:url({{ asset('/assets/tibiarl/images/content/box-frame-edge.gif') }});"></span>
                <span class="CaptionBorderTop" style="background-image:url({{ asset('/assets/tibiarl/images/content/table-headline-border.gif') }});"></span>
                <span class="CaptionVerticalLeft" style="background-image:url({{ asset('/assets/tibiarl/images/content/box-frame-vertical.gif') }});"></span>
                <div class="Text">General Information</div>
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
                        <table style="width:100%;">
                            <tbody>
                            <tr>
                                <td>
                                    <div class="TableContentAndRightShadow">
                                        <div class="TableContentContainer">
                                            <table class="TableContent" width="100%">
                                                <tbody>
                                                    @php $rowClass = 'Even'; @endphp
                                                    <tr class="{{ $rowClass }}">
                                                        <td class="LabelV">Account Name:</td>
                                                        <td style="width:90%;">{{ Auth::user()->id }}</td>
                                                    </tr>
                                                    @php $rowClass = ($rowClass === 'Odd') ? 'Even' : 'Odd'; @endphp
                                                    
                                                    <tr class="{{ $rowClass }}">
                                                        <td class="LabelV">Email Address:</td>
                                                        <td style="width:90%;">{{ Auth::user()->email }}</td>
                                                    </tr>
                                                    @php $rowClass = ($rowClass === 'Odd') ? 'Even' : 'Odd'; @endphp
                                                    
                                                    <tr class="{{ $rowClass }}">
                                                        <td class="LabelV">Created:</td>
                                                        <td>{{ date('M d Y, H:i:s T', strtotime(Auth::user()->webaccount->created_at)) }}</td>
                                                    </tr>
                                                    @php $rowClass = ($rowClass === 'Odd') ? 'Even' : 'Odd'; @endphp
                                                    
                                                    <tr class="{{ $rowClass }}">
                                                        <td class="LabelV">Last Login:</td>
                                                        <td>{{ date('M d Y, H:i:s T', strtotime(Auth::user()->webaccount->updated_at)) }}</td>
                                                    </tr>
                                                    @php $rowClass = ($rowClass === 'Odd') ? 'Even' : 'Odd'; @endphp
                                                    
                                                    <tr class="{{ $rowClass }}">
                                                        <td class="LabelV">Account Status:</td>
                                                        <td>
                                                            @if(Auth::user()->premium_ends_at >= time())
                                                                <span style="color: #00bf00; font-weight: 700">Premium Account</span>
                                                            @else
                                                                <span class="red"><b>Free Account</b></span>
                                                            @endif
                                                        </td>
                                                    </tr>
                                                    @php $rowClass = ($rowClass === 'Odd') ? 'Even' : 'Odd'; @endphp
                                                    
                                                    <tr class="{{ $rowClass }}">
                                                        <td class="LabelV">{{ config('server.serverName') }} Coins:</td>
                                                        <td>
                                                            {{ Auth::user()->webaccount->shop_coins }} | <a href="{{ route('account.store.index') }}"> Buy more coins </a>
                                                        </td>
                                                    </tr>
                                                    @php $rowClass = ($rowClass === 'Odd') ? 'Even' : 'Odd'; @endphp
                                                    
                                                    <tr class="{{ $rowClass }}">
                                                        <td class="LabelV">Registered:</td>
                                                        <td>
                                                            @role('unconfirmeduser') <span class="red"><b>No</b></span> @endrole 
                                                            @role('admin|user') <span style="color: #00bf00; font-weight: 700">Yes</span> | 
                                                            <a href="{{ route('account.manage.recovery-key.index') }}"> Buy new Recovery Key</a> @endrole
                                                        </td>
                                                    </tr>
                                                    @php $rowClass = ($rowClass === 'Odd') ? 'Even' : 'Odd'; @endphp
                                                    
                                                    <tr class="{{ $rowClass }}">
                                                        <td class="LabelV">Two-Step Verification:</td>
                                                        <td> 
                                                            @if($isConfirmed) 
                                                                <span style="color: #00bf00; font-weight: 700">Yes</span> 
                                                            @else 
                                                                <span style="color: #bf0000; font-weight: 700">No</span> | 
                                                                <a href="{{ route('account.manage.2fa.register') }}">Enable Two-Step Verification</a>
                                                            @endif
                                                        </td>
                                                    </tr>

                                                    @php $rowClass = ($rowClass === 'Odd') ? 'Even' : 'Odd'; @endphp
                                                    <tr class="{{ $rowClass }}">
                                                        <td class="LabelV">Security Questions:</td>
                                                        <td>
                                                            @if($hasSecurityQuestions) 
                                                                <span style="color: #00bf00; font-weight: 700">Yes</span>
                                                            @else
                                                                <span style="color: #bf0000; font-weight: 700">No</span> |
                                                                <a href="{{ route('account.manage.security-questions.register') }}">Set Security Questions</a>
                                                            @endif
                                                        </td>
                                                    </tr>

                                                    @php $rowClass = ($rowClass === 'Odd') ? 'Even' : 'Odd'; @endphp
                                                    
                                                    <tr class="{{ $rowClass }}">
                                                        <td class="LabelV">Change Name:</td>
                                                        <td>
                                                            <select id="characterSelect" class="custom-select">
                                                                @foreach(Auth::user()->characters as $character)
                                                                    <option value="{{ Str::strToUrl($character->name) }}">{{ $character->name }}</option>
                                                                @endforeach
                                                            </select> | 
                                                            <a id="dynamicLink" class="dynamic-link" 
                                                               href="{{ route('account.character.edit.index', [Str::strToUrl(Auth::user()->characters->first()->name)]) }}">Buy new name</a>
                                                        </td>
                                                    </tr>                                                    
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">


                                    <table class="InnerTableButtonRow" cellpadding="0" cellspacing="0">
                                        <tbody>
                                        <tr>
                                            <td>
                                                <div class="BigButton" onclick="RedirectToUrl('{{ route('account.manage.change.password.index') }}');" style="background-image:url({{ asset('/assets/tibiarl/images/buttons/sbutton.gif') }})">
                                                    <div onmouseover="MouseOverBigButton(this);" onmouseout="MouseOutBigButton(this);"><div class="BigButtonOver" style="background-image:url({{ asset('/assets/tibiarl/images/buttons/sbutton_over.gif') }});"></div>
                                                        <button class="BigButtonText" type="button">
                                                            <i class="fas fa-key"></i> Change Password
                                                        </button>
                                                    </div>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="BigButton" onclick="RedirectToUrl('{{ route('account.index') }}');" style="background-image:url({{ asset('/assets/tibiarl/images/buttons/sbutton.gif') }})">
                                                    <div onmouseover="MouseOverBigButton(this);" onmouseout="MouseOutBigButton(this);"><div class="BigButtonOver" style="background-image:url({{ asset('/assets/tibiarl/images/buttons/sbutton_over.gif') }});"></div>
                                                        <button class="BigButtonText" type="button">
                                                            <i class="fas fa-home"></i> Overview
                                                        </button>
                                                    </div>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="BigButton" onclick="RedirectToUrl('{{ route('account.manage.purchase.history') }}');" style="background-image:url({{ asset('/assets/tibiarl/images/buttons/sbutton.gif') }})">
                                                    <div onmouseover="MouseOverBigButton(this);" onmouseout="MouseOutBigButton(this);"><div class="BigButtonOver" style="background-image:url({{ asset('/assets/tibiarl/images/buttons/sbutton_over.gif') }});"></div>
                                                        <button class="BigButtonText" type="button">
                                                            <i class="fas fa-receipt"></i> Purchase History
                                                        </button>
                                                    </div>
                                                </div>
                                            </td>

                                            @role('admin|user')
                                            <td>
                                                <div class="BigButton" onclick="RedirectToUrl('/account/email/confirmation/change');" style="background-image:url({{ asset('/assets/tibiarl/images/buttons/sbutton.gif') }})">
                                                    <div onmouseover="MouseOverBigButton(this);" onmouseout="MouseOutBigButton(this);"><div class="BigButtonOver" style="background-image: url({{ asset('/assets/tibiarl/images/buttons/sbutton_over.gif') }}); visibility: hidden;"></div>
                                                        <button class="BigButtonText" type="button">
                                                            <i class="fas fa-envelope"></i> Change Email
                                                        </button>
                                                    </div>
                                                </div>
                                            </td>
                                            @endrole
                                            <td>
                                                <div class="BigButton" style="background-image:url({{ asset('/assets/tibiarl/images/buttons/sbutton.gif') }})">
                                                    <div onmouseover="MouseOverBigButton(this);" onmouseout="MouseOutBigButton(this);"><div class="BigButtonOver" style="background-image:url({{ asset('/assets/tibiarl/images/buttons/sbutton_over.gif') }});"></div>
                                                        <button class="BigButtonText" type="button">
                                                            <i class="fas fa-user-slash"></i> Terminate Account
                                                        </button>
                                                    </div>
                                                </div>
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
            </tbody>
        </table>
    </div>
    <br>
    <a name="Tell-A-Friend"></a>

    {{-- 

    <div class="TopButtonContainer">
        <a name="Tell-A-Friend"></a>
        <div class="TopButton"><a name="Tell-A-Friend"></a><a href="#top"><img style="border: 0px;" src="{{ asset('/assets/tibiarl/images/content/back-to-top.gif') }}"></a></div>
    </div>

    <div class="TableContainer">
        <div class="CaptionContainer">
            <div class="CaptionInnerContainer">
                <span class="CaptionEdgeLeftTop" style="background-image:url({{ asset('/assets/tibiarl/images/content/box-frame-edge.gif') }});"></span>
                <span class="CaptionEdgeRightTop" style="background-image:url({{ asset('/assets/tibiarl/images/content/box-frame-edge.gif') }});"></span>
                <span class="CaptionBorderTop" style="background-image:url({{ asset('/assets/tibiarl/images/content/table-headline-border.gif') }});"></span>
                <span class="CaptionVerticalLeft" style="background-image:url({{ asset('/assets/tibiarl/images/content/box-frame-vertical.gif') }});"></span>
                <div class="Text">Tell-A-Friend</div>
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
                    <div class="TableScrollbarWrapper" style="width: unset;">
                        <div class="TableScrollbarContainer"> </div>
                    </div>
                    <div class="InnerTableContainer" style="max-width: unset;">
                        <table style="width:100%;">
                            <tbody>
                            <tr>
                                <td>
                                    <div class="TableContentContainer">
                                        <table class="TableContent" width="100%" style="border:1px solid #faf0d7;">
                                            <tbody>
                                            <tr>
                                                <td>
                                                    <div style="float:right;">
                                                        <div class="BigButton" onclick="RedirectToUrl('{{ route('account.manage.tell-a-friend.index') }}');" style="background-image:url({{ asset('/assets/tibiarl/images/buttons/sbutton.gif') }})"><div onmouseover="MouseOverBigButton(this);" onmouseout="MouseOutBigButton(this);"><div class="BigButtonOver" style="background-image:url({{ asset('/assets/tibiarl/images/buttons/sbutton_over.gif') }});"></div>
                                                                <input class="BigButtonText" type="submit" value="Tell-A-Friend">
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <b>Invite New Friends!</b><br>Invite your friends to join you in {{ config('server.serverName') }} and earn a reward!<br><br><b>Bring Back a Buddy!</b><br>Are you missing a retired {{ config('server.serverName') }} buddy from the good old days? Would you like your friend to come back and join the fight on your side once more?
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
    </div> --}}

    <br>
    
    <a name="Products+Available"></a>
    <div class="TopButtonContainer">
        <a name="Products+Available"></a>
        <div class="TopButton"><a name="Tell-A-Friend"></a><a href="#top"><img style="border: 0px;" src="{{ asset('/assets/tibiarl/images/content/back-to-top.gif') }}"></a></div>
    </div>
    <div class="TableContainer">
        <div class="CaptionContainer">
            <div class="CaptionInnerContainer">
                <span class="CaptionEdgeLeftTop" style="background-image:url({{ asset('/assets/tibiarl/images/content/box-frame-edge.gif') }});"></span>
                <span class="CaptionEdgeRightTop" style="background-image:url({{ asset('/assets/tibiarl/images/content/box-frame-edge.gif') }});"></span>
                <span class="CaptionBorderTop" style="background-image:url({{ asset('/assets/tibiarl/images/content/table-headline-border.gif') }});"></span>
                <span class="CaptionVerticalLeft" style="background-image:url({{ asset('/assets/tibiarl/images/content/box-frame-vertical.gif') }});"></span>
                <div class="Text">Products Available</div>
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
                    <div class="TableScrollbarWrapper" style="width: unset;">
                        <div class="TableScrollbarContainer"> </div>
                    </div>
                    <div class="InnerTableContainer" style="max-width: unset;">
                        <table style="width:100%;">
                            <tbody>
                            <tr>
                                <td>
                                    <div class="TableContentContainer">
                                        <table class="TableContent" width="100%" style="border:1px solid #faf0d7;">
                                            <tbody>
                                                <tr>
                                                    <td>
                                                        <span style="display: flex; align-items: center; gap: 10px; position: relative; top: 3px; margin-left: 5px;">

                                                            <b>{{ config('server.serverName') }} Coins</b>

                                                            <a href="#" target="_blank">
                                                                <span class="HelperDivIndicator" onmouseover="ActivateHelperDiv($(this), 'ServerName Coins', 'ServerName Coins are ServerName\'s currency to purchase exclusive products in the Store.<br /><br />They can be used right after the purchase to buy all products offered for ServerName Coins in the Store, e.g. mounts, outfits, Premium Time, boosts or decoration items.<br /><br />', '', '{{ config('server.serverName') }}');" onmouseout="$('#HelperDivContainer').hide();">
                                                                    <img style="border:0px;" src="{{ asset('/assets/tibiarl/images/mmorpg/info.gif') }}">
                                                                </span>
                                                            </a>

                                                            {{-- <div class="BigButton" onclick="RedirectToUrl('{{ route('account.store.index') }}');"  style="background-image:url({{ asset('/assets/tibiarl/images/buttons/sbutton.gif') }})">
                                                                <div onmouseover="MouseOverBigButton(this);" onmouseout="MouseOutBigButton(this);"><div class="BigButtonOver" style="background-image:url({{ asset('/assets/tibiarl/images/buttons/sbutton_over.gif') }});"></div>
                                                                    <input class="BigButtonText" type="submit" value="Get Coins">
                                                                </div>
                                                            </div> --}}

                                                            <div class="BigButton" onclick="RedirectToUrl('{{ route('account.store.packages.index') }}');"  style="background-image:url({{ asset('/assets/tibiarl/images/buttons/sbutton.gif') }})">
                                                                <div onmouseover="MouseOverBigButton(this);" onmouseout="MouseOutBigButton(this);"><div class="BigButtonOver" style="background-image:url({{ asset('/assets/tibiarl/images/buttons/sbutton_over.gif') }});"></div>
                                                                    <button class="BigButtonText" type="button">
                                                                        <i class="fas fa-gift"></i> Get Packages
                                                                    </button>
                                                                </div>
                                                            </div>
                                                        
                                                        </span>

                                                        <br>Get {{ config('server.serverName') }} Coins to shop exclusive products in the Store, including Character Name Change and much more.
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

    <a name="Products+Available"></a>
    <div class="TopButtonContainer">
        <a name="Products+Available"></a>
        <div class="TopButton"><a name="Tell-A-Friend"></a><a href="#top"><img style="border: 0px;" src="{{ asset('/assets/tibiarl/images/content/back-to-top.gif') }}"></a></div>
    </div>
    <div class="TableContainer">
        <div class="CaptionContainer">
            <div class="CaptionInnerContainer">
                <span class="CaptionEdgeLeftTop" style="background-image:url({{ asset('/assets/tibiarl/images/content/box-frame-edge.gif') }});"></span>
                <span class="CaptionEdgeRightTop" style="background-image:url({{ asset('/assets/tibiarl/images/content/box-frame-edge.gif') }});"></span>
                <span class="CaptionBorderTop" style="background-image:url({{ asset('/assets/tibiarl/images/content/table-headline-border.gif') }});"></span>
                <span class="CaptionVerticalLeft" style="background-image:url({{ asset('/assets/tibiarl/images/content/box-frame-vertical.gif') }});"></span>
                <div class="Text">Streamer Partnership</div>
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
                    <div class="TableScrollbarWrapper" style="width: unset;">
                        <div class="TableScrollbarContainer"> </div>
                    </div>
                    <div class="InnerTableContainer" style="max-width: unset;">
                        <table style="width:100%;">
                            <tbody>
                            <tr>
                                <td>
                                    <div class="TableContentContainer">
                                        <table class="TableContent" width="100%" style="border:1px solid #faf0d7;">
                                            <tbody>
                                                <tr>
                                                    <td>
                                                        <span style="display: flex; align-items: center; gap: 10px; position: relative; top: 3px; margin-left: 5px;">
                                                            <b>Ravenor Streamers</b>
                                                        
                                                            <a href="#" target="_blank">
                                                                <span class="HelperDivIndicator" 
                                                                    onmouseover="ActivateHelperDiv($(this), 'Ravenor Streamers Program', 'The Ravenor Streamers Program offers exclusive rewards, special event access, and a chance to grow within the community.<br /><br />Once approved, you will receive a unique code to log in to the Streamer Dashboard and manage your activities.', '', 'Ravenor');" 
                                                                    onmouseout="$('#HelperDivContainer').hide();">
                                                                    <img style="border:0px;" src="{{ asset('/assets/tibiarl/images/mmorpg/info.gif') }}">
                                                                </span>
                                                            </a>

                                                            <div class="BigButton" onclick="RedirectToUrl('{{ route('account.manage.streamer.login') }}');"  style="background-image:url({{ asset('/assets/tibiarl/images/buttons/sbutton.gif') }})">
                                                                <div onmouseover="MouseOverBigButton(this);" onmouseout="MouseOutBigButton(this);"><div class="BigButtonOver" style="background-image:url({{ asset('/assets/tibiarl/images/buttons/sbutton_over.gif') }});"></div>
                                                                    <button class="BigButtonText" type="button">
                                                                        <i class="fas fa-video"></i> Streamer Painel
                                                                    </button>
                                                                </div>
                                                            </div>
                                                    
                                                        </span>
                                                        
                                                        <br>Log in to your <strong>Streamer Dashboard</strong> to track your performance, receive rewards, and enjoy the program benefits!                                                        
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

    <style>
        .custom-select {
            width: 150px;
            font-size: 14px;
            color: #333;
            background-color: #fff;
            border: 1px solid #ccc;
            border-radius: 4px;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
        }

        .custom-select:focus {
            outline: none;
            border-color: #007bff;
        }
    </style>

    <script>
        document.addEventListener('DOMContentLoaded', (event) => {
            const selectElement = document.getElementById('characterSelect');
            const dynamicLink = document.getElementById('dynamicLink');

            selectElement.addEventListener('change', function() {
                const selectedCharacter = this.value;
                const slug = selectedCharacter.toLowerCase().replace(/ /g, '-');
                const route = `{{ url('/account/character/edit') }}/${slug}`;
                dynamicLink.href = route;
            });
        });
    </script>

@endsection
