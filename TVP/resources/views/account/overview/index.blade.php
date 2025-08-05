@extends('template.layout')
@section('title', 'Account Management')
@section('submenuItem', 'accountmanagement')

@section('content')

    @if(request()->input('messageApi') != null) 

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
                            <td>
                                <b>{!! request()->input('messageApi') !!}</b>
                            </td>
                        </tr>
                        <tr></tr>
                        </tbody>
                    </table>
                </div>
                <div class="BoxFrameHorizontal" style="background-image:url(/assets/tibiarl/images/content/box-frame-horizontal.gif);"></div>
                <div class="BoxFrameEdgeRightBottom" style="background-image:url(/assets/tibiarl/images/content/box-frame-edge.gif);"></div>
                <div class="BoxFrameEdgeLeftBottom" style="background-image:url(/assets/tibiarl/images/content/box-frame-edge.gif);"></div>
            </div>
        </div>

    @else

    <div style="text-align:center">
        <table style="margin-left: auto; margin-right: auto;">
            <tbody>
            <tr>
                <td>
                    <img src="{{ asset('/assets/tibiarl/images/content/headline-bracer-left.gif') }}">
                </td>
                <td style="text-align:center;vertical-align:middle;horizontal-align:center;font-size:17px;font-weight:bold;">Welcome to your account! <br>
                </td>
                <td>
                    <img src="{{ asset('/assets/tibiarl/images/content/headline-bracer-right.gif') }}">
                </td>
            </tr>
            </tbody>
        </table>
        <br>
    </div>
    <div class="TableContainer">
        <div class="CaptionContainer">
            <div class="CaptionInnerContainer">
                <span class="CaptionEdgeLeftTop" style="background-image:url({{ asset('/assets/tibiarl/images/content/box-frame-edge.gif') }});"></span>
                <span class="CaptionEdgeRightTop" style="background-image:url({{ asset('/assets/tibiarl/images/content/box-frame-edge.gif') }});"></span>
                <span class="CaptionBorderTop" style="background-image:url({{ asset('/assets/tibiarl/images/content/table-headline-border.gif') }});"></span>
                <span class="CaptionVerticalLeft" style="background-image:url({{ asset('/assets/tibiarl/images/content/box-frame-vertical.gif') }});"></span>
                <div class="Text">Account Status</div>
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
                        <table style="width:100%;">
                            <tbody>
                            <tr>
                                <td>
                                    <div class="TableContentContainer">
                                        <table class="TableContent" width="100%" style="border:1px solid #faf0d7;">
                                            <tbody>
                                            <tr>
                                                @if(config('server.freePremium'))
                                                    <td>
                                                        <img class="AccountStatusImage" src="{{ asset('/assets/tibiarl/images/account/account-status_blue.gif') }}" alt="gratis premium account">
                                                    </td>
                                                    <td width="100%" valign="middle">
                                                        <span class="BigBoldText">Gratis Premium Account</span>
                                                        <small><br>(Balance of Premium Time: unlimited)</small>
                                                    </td>
                                                @else
                                                <td>
                                                    @if(Auth::user()->premium_ends_at >= time())
                                                    <img class="AccountStatusImage" src="{{ asset('/assets/tibiarl/images/account/account-status_green.gif') }}" alt="free account">
                                                    @else
                                                    <img class="AccountStatusImage" src="{{ asset('/assets/tibiarl/images/account/account-status_red.gif') }}" alt="premium account">
                                                    @endif
                                                </td>
                                                <td width="100%" valign="middle">
                                                    @if(Auth::user()->premium_ends_at >= time())
                                                        <span class="ColorGreen"><span class="BigBoldText">Premium Account</span></span>
                                                        <small><br>Premium Time expires at {{ date('M d Y, H:i:s T', Auth::user()->premium_ends_at) }}<br>(Balance of Premium Time: <span class="green">{{ round((((Auth::user()->premium_ends_at - time())/24)/60)/60) }} days)</span></small>
                                                    @else
                                                        <span class="BigBoldText">Free Account</span>
                                                        <small><br>(Balance of Premium Time: 0 days)</small>
                                                    @endif
                                                </td>
                                                @endif
                                                <td>
                                                    <div style="font-size:1px;height:4px;"></div>

                                                    @role('admin')
                                                        <div class="BigButton" onclick="RedirectToUrl('{{ route('admin.index') }}');" style="background-image:url({{ asset('/assets/tibiarl/images/buttons/sbutton.gif') }})">
                                                            <div onmouseover="MouseOverBigButton(this);" onmouseout="MouseOutBigButton(this);">
                                                                <div class="BigButtonOver" style="background-image:url({{ asset('/assets/tibiarl/images/buttons/sbutton_over.gif') }});"></div>
                                                                <input class="BigButtonText" type="submit" value="Admin Page">
                                                            </div>
                                                        </div>
                                                    @endrole

                                                    <div class="BigButton" onclick="RedirectToUrl('{{ route('account.manage.index') }}');" style="background-image:url({{ asset('/assets/tibiarl/images/buttons/sbutton.gif') }})">
                                                        <div onmouseover="MouseOverBigButton(this);" onmouseout="MouseOutBigButton(this);"><div class="BigButtonOver" style="background-image:url({{ asset('/assets/tibiarl/images/buttons/sbutton_over.gif') }});"></div>
                                                            <input class="BigButtonText" type="submit" value="Manage Account">
                                                        </div>
                                                    </div>


                                                    <div style="font-size:1px;height:4px;"></div>

                                                    {{-- <div class="BigButton" onclick="RedirectToUrl('{{ route('account.store.index') }}');" style="background-image:url({{ asset('/assets/tibiarl/images/buttons/sbutton_green.gif') }})"><div onmouseover="MouseOverBigButton(this);" onmouseout="MouseOutBigButton(this);"><div class="BigButtonOver" style="background-image:url({{ asset('/assets/tibiarl/images/buttons/sbutton_green_over.gif') }});"></div>
                                                            <input class="BigButtonText" type="submit" value="Get Coins">
                                                        </div>
                                                    </div> --}}

                                                    <div class="BigButton" onclick="RedirectToUrl('{{ route('account.store.packages.index') }}');"  style="background-image:url({{ asset('/assets/tibiarl/images/buttons/sbutton_green.gif') }})">
                                                        <div onmouseover="MouseOverBigButton(this);" onmouseout="MouseOutBigButton(this);"><div class="BigButtonOver" style="background-image:url({{ asset('/assets/tibiarl/images/buttons/sbutton_green_over.gif') }});"></div>
                                                            <input class="BigButtonText" type="submit" value="Get Packages">
                                                        </div>
                                                    </div>

                                                    <div style="font-size:1px;height:4px;"></div>
                                                    <div class="BigButton" onclick="RedirectToUrl('{{ route('account.logout') }}');" style="background-image:url({{ asset('/assets/tibiarl/images/buttons/sbutton_red.gif') }})"><div onmouseover="MouseOverBigButton(this);" onmouseout="MouseOutBigButton(this);"><div class="BigButtonOver" style="background-image:url({{ asset('/assets/tibiarl/images/buttons/sbutton_red_over.gif') }});"></div>
                                                            <input class="BigButtonText" type="submit" value="Logout">
                                                        </div>
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
                </td>
            </tr>
            </tbody>
        </table>
    </div>
    <br>
    @include('account.notification.banned')
    <div class="TableContainer">
        <div class="CaptionContainer">
            <div class="CaptionInnerContainer">
                <span class="CaptionEdgeLeftTop" style="background-image:url({{ asset('/assets/tibiarl/images/content/box-frame-edge.gif') }});"></span>
                <span class="CaptionEdgeRightTop" style="background-image:url({{ asset('/assets/tibiarl/images/content/box-frame-edge.gif') }});"></span>
                <span class="CaptionBorderTop" style="background-image:url({{ asset('/assets/tibiarl/images/content/table-headline-border.gif') }});"></span>
                <span class="CaptionVerticalLeft" style="background-image:url({{ asset('/assets/tibiarl/images/content/box-frame-vertical.gif') }});"></span>
                <div class="Text">Download Client</div>
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
                        <table style="width:100%;">
                            <tbody>
                            <tr>
                                <td>
                                    <div class="TableContentContainer">
                                        <table class="TableContent" width="100%" style="border:1px solid #faf0d7;">
                                            <tbody>
                                            <tr>
                                                <td>
                                                    <div style="height: 55px;">
                                                        <div id="DowloadBox" style="position: relative; float:right;">
                                                            <a href="{{ route('download.index') }}">
                                                                <img style="width: 45px; height: 45px; border: 0px; margin-right: 10px;" src="{{ asset('/assets/tibiarl/images/account/download_windows.gif') }}">
                                                            </a>
                                                            <br>
                                                            <a style="position: absolute; bottom: -5px; right: 0px;" href="{{ route('download.index') }}">Download</a>
                                                        </div>
                                                        <span style="position: relative; top: 18px;">Click <a href="{{ route('download.index') }}">here</a> to download the latest {{ config('server.serverName') }} client! </span>
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
                </td>
            </tr>
            </tbody>
        </table>
    </div>
    <br>

    @if($isConfirmed == false)

        @include('account.notification.confirm-email')
        
    @endif

    @include('account.notification.change-email')

    <div class="RowsWithOverEffect">
        <div class="TableContainer">
            <div class="CaptionContainer">
                <div class="CaptionInnerContainer">
                    <span class="CaptionEdgeLeftTop" style="background-image:url({{ asset('/assets/tibiarl/images/content/box-frame-edge.gif') }});"></span>
                    <span class="CaptionEdgeRightTop" style="background-image:url({{ asset('/assets/tibiarl/images/content/box-frame-edge.gif') }});"></span>
                    <span class="CaptionBorderTop" style="background-image:url({{ asset('/assets/tibiarl/images/content/table-headline-border.gif') }});"></span>
                    <span class="CaptionVerticalLeft" style="background-image:url({{ asset('/assets/tibiarl/images/content/box-frame-vertical.gif') }});"></span>
                    <div class="Text">Characters</div>
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
                                        <div class="TableContentContainer">
                                            <table class="TableContent" width="100%" style="border:1px solid #faf0d7;">
                                                <tbody>
                                                <tr class="LabelH">
                                                    <td></td>
                                                    <td style="width:40%;">Name</td>
                                                    <td style="width:120px!important;">World</td>
                                                    <td style="width:90px!important;">Status</td>
                                                    <td style="width:90px!important;">&nbsp;</td>
                                                </tr>

                                                @php
                                                    $player_number_counter = 0;
                                                    $class = '';
                                                @endphp

                                                @foreach(Auth::user()->characters as $character)
                                                    @php
                                                        $player_number_counter++;
                                                        $class = ($player_number_counter % 2 == 0) ? 'Even' : 'Odd';
                                                    @endphp
                                                    <tr id="CharacterRow_{{ $player_number_counter }}"
                                                        onmouseover="InRowWithOverEffect('CharacterRow_{{ $player_number_counter }}', '{{ ($player_number_counter % 2 == 0) ? '#e7d1af' : '#ffedd1' }}');"
                                                        onmouseout="OutRowWithOverEffect('CharacterRow_{{ $player_number_counter }}', '{{ ($player_number_counter % 2 == 0) ? '#d5c0a1' : '#f1e0c6' }}');"
                                                        onclick="FocusCharacter({{ $player_number_counter }}, '{{ urlencode($character->name) }}', 15);"
                                                        class="{{ $class }}" style="font-weight: {{ ($player_number_counter == 1) ? 'bold' : 'normal' }}; background-color: {{ ($player_number_counter % 2 == 0) ? '#d5c0a1' : '#f1e0c6' }};">
                                                        <td style="width:40px;text-align:center;padding:2px;">
                                                            <span id="CharacterNumberOf_{{ $player_number_counter }}">{{ $player_number_counter }}.</span>
                                                        </td>
                                                        <td id="CharacterCell2_{{ $player_number_counter }}">
                                                            <span style="white-space:nowrap;vertical-align:middle;">
                                                                <a href="{{ route('community.view.character.search', ['characterName' => urlencode($character->name)]) }}">
                                                                    <span id="CharacterNameOf_{{ $player_number_counter }}" style="font-size: {{ ($player_number_counter == 1) ? '13' : '10' }}pt;">{{ $character->name }}</span>
                                                                </a>
                                                                <br>
                                                                <span id="CharacterNameOf_{{ $player_number_counter }}"><small>{{ \App\Utils\Vocation::getNameByVocationId($character->vocation) }} - Level {{ $character->level }}</small></span>
                                                            </span>
                                                        </td>
                                                        <td id="CharacterCell2_{{ $player_number_counter }}">
                                                            <span style="white-space:nowrap;">{{ htmlspecialchars(config('server.serverName')) }}</span>
                                                        </td>
                                                        <td id="CharacterCell3_{{ $player_number_counter }}">
                                                            @if (!$character->online)
                                                                &nbsp;
                                                            @else
                                                                <span style="color: green;"><b>online</b></span>
                                                            @endif
                                                        </td>
                                                        <td id="CharacterCell4_{{ $player_number_counter }}" style="text-align:center;">
                                                            <span id="CharacterOptionsOf_{{ $player_number_counter }}" style="display: {{ ($player_number_counter == 1) ? 'block' : 'none' }};">
                                                                {{-- <span style="font-weight:normal;">[<a href="{{ route('account.character.edit.index', [Str::strToUrl($character->name)]) }}">Edit</a>]</span>
                                                                <br>--}}<span style="font-weight:normal;">[ 

                                                                    <form action="{{ route('account.delete.index') }}" method="POST" style="display:inline;">
                                                                        @csrf
                                                                        <input type="hidden" name="characterName" value="{{ $character->name }}">
                                                                        <button type="submit" style="cursor: pointer; border: none; background: none;font-weight:bold; color: #004294">Delete</button>
                                                                    </form>

                                                                ]</span>
                                                            </span>
                                                        </td>
                                                    </tr>
                                                @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <table class="InnerTableButtonRow" cellpadding="0" cellspacing="0">
                                            <tbody>
                                            <tr>
                                                <td></td>
                                                <td align="right" style="padding-right:7px;width:100%;">
                                                    <div class="BigButton" onclick="RedirectToUrl('{{ route('account.character.create.index') }}');" style="background-image:url({{ asset('/assets/tibiarl/images/buttons/sbutton.gif') }})">
                                                        <div onmouseover="MouseOverBigButton(this)" onmouseout="MouseOutBigButton(this)"><div class="BigButtonOver" style="background-image:url({{ asset('/assets/tibiarl/images/buttons/sbutton_over.gif') }})"></div>
                                                            <input class="BigButtonText" type="submit" value="Create Character">
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
    </div>
    <br><br>

    @endif   
@endsection
