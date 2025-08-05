@extends('template.layout')
@section('title', 'Premium features')
@section('submenuItem', 'premiumfeatures')
@section('content')
<h2>Why Should You Make Your Account Premium?</h2>
<p>{{ config('server.serverName') }} is free, and players are welcome to play free of charge for as long as they like. However, if you enjoy {{ config('server.serverName') }}, you may consider to take the game further by buying Premium Time. As a Premium player you will have additional abilities and advantages inside and outside the game. Buy Premium Time today to make {{ config('server.serverName') }} even more fun!</p>
<center>
    <div class="BigButton" onclick="RedirectToUrl('{{ route('account.store.index') }}');" style="background-image:url({{ asset('/assets/tibiarl/images/buttons/sbutton_green.gif') }})">
        <div onmouseover="MouseOverBigButton(this);" onmouseout="MouseOutBigButton(this);"><div class="BigButtonOver" style="background-image:url({{ asset('/assets/tibiarl/images/buttons/sbutton_green_over.gif') }});"></div>
            <input class="BigButtonText" type="submit" value="Get Premium">
        </div>
    </div>
</center>
<p style="margin-top: 20px; margin-bottom: 20px;">The following benefits are available to Premium players:</p>
<div class="TableContainer">
    <div class="CaptionContainer">
        <div class="CaptionInnerContainer">
            <span class="CaptionEdgeLeftTop" style="background-image:url({{ asset('/assets/tibiarl/images/content/box-frame-edge.gif') }});"></span>
            <span class="CaptionEdgeRightTop" style="background-image:url({{ asset('/assets/tibiarl/images/content/box-frame-edge.gif') }});"></span>
            <span class="CaptionBorderTop" style="background-image:url({{ asset('/assets/tibiarl/images/content/table-headline-border.gif') }});"></span>
            <span class="CaptionVerticalLeft" style="background-image:url({{ asset('/assets/tibiarl/images/content/box-frame-vertical.gif') }});"></span>
            <div class="Text">{{ config('server.serverName') }} Features</div>
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
                    <table style="width:100%;" id="PremiumFeaturesBox">
                        <tbody>
                        <tr>
                            <td>
                                <div class="TableContentContainer">
                                    <table class="TableContent" width="100%" style="border:1px solid #faf0d7;">
                                        <tbody>
                                        <tr class="LabelV">
                                            <th>Benefit</th>
                                            <th style="text-align: center;">Premium Details</th>
                                            <th style="text-align: center;">Free</th>
                                            <th style="text-align: center;">Premium</th>
                                        </tr>
                                        <tr class="Even">
                                            <td style="font-weight: bold;">Instant travelling</td>
                                            <td style="text-align: center;"><span style="position: relative; top: 3px; margin-left: 5px;"><span class="HelperDivIndicator" onmouseover="ActivateHelperDiv($(this), 'Use instant travel system', 'No matter where you are heading, travel via the {{ config('server.serverName') }}n transport system and you will always be there in a jiffy! Boats, magic carpets, steamships, astral bridges, elemental shrines - travelling has never been that convenient.', '');" onmouseout="$('#HelperDivContainer').hide();"><img src="{{ asset('/assets/tibiarl/images/premiumfeatures/PremiumIcon-Travel.png') }}"></span></span></td>
                                            <td style="text-align: center;"><img src="{{ asset('/assets/tibiarl/images/premiumfeatures/icon_no.png') }}"></td>
                                            <td style="text-align: center;"><img src="{{ asset('/assets/tibiarl/images/premiumfeatures/icon_yes.png') }}"></td>
                                        </tr>
                                        <tr class="Odd">
                                            <td style="font-weight: bold;">Areas</td>
                                            <td style="text-align: center;"><span style="position: relative; top: 3px; margin-left: 5px;"><span class="HelperDivIndicator" onmouseover="ActivateHelperDiv($(this), 'Access Premium areas', 'Discover new mysterious places, visit distant continents full of exotic creatures and explore the whole world of {{ config('server.serverName') }}. Exciting adventures await you!', '');" onmouseout="$('#HelperDivContainer').hide();"><img src="{{ asset('/assets/tibiarl/images/premiumfeatures/PremiumIcon-NewAreas.png') }}"></span></span></td>
                                            <td style="text-align: center;">5 areas and cities</td>
                                            <td style="text-align: center;">8+ areas and cities</td>
                                        </tr>
                                        <tr class="Even">
                                            <td style="font-weight: bold;">Spells</td>
                                            <td style="text-align: center;"><span style="position: relative; top: 3px; margin-left: 5px;"><span class="HelperDivIndicator" onmouseover="ActivateHelperDiv($(this), 'Cast all powerful spells', 'Harness the full magical potential of your vocation! Cast powerful attack, support, and healing spells, and summon mighty creatures to vanquish the enemy.', '');" onmouseout="$('#HelperDivContainer').hide();"><img src="{{ asset('/assets/tibiarl/images/premiumfeatures/PremiumIcon-Spells.png') }}"></span></span></td>
                                            <td style="text-align: center;">55</td>
                                            <td style="text-align: center;">139+</td>
                                        </tr>
                                        <tr class="Odd">
                                            <td style="font-weight: bold;">Guild leadership</td>
                                            <td style="text-align: center;"><span style="position: relative; top: 3px; margin-left: 5px;"><span class="HelperDivIndicator" onmouseover="ActivateHelperDiv($(this), 'Create and lead powerful guilds', 'You have what it takes to be a leader? Found your own guild, recruit followers and rent one of the impressive guildhalls. Bring like-minded players together under your banner and form strong bonds of friendship and camaraderie.', '');" onmouseout="$('#HelperDivContainer').hide();"><img src="{{ asset('/assets/tibiarl/images/premiumfeatures/PremiumIcon-Guild.png') }}"></span></span></td>
                                            <td style="text-align: center;"><img src="{{ asset('/assets/tibiarl/images/premiumfeatures/icon_no.png') }}"></td>
                                            <td style="text-align: center;"><img src="{{ asset('/assets/tibiarl/images/premiumfeatures/icon_yes.png') }}"></td>
                                        </tr>
                                        <tr class="Even">
                                            <td style="font-weight: bold;">House ownership</td>
                                            <td style="text-align: center;"><span style="position: relative; top: 3px; margin-left: 5px;"><span class="HelperDivIndicator" onmouseover="ActivateHelperDiv($(this), 'Own and decorate houses', 'Enjoy the exclusive ability to rent a house where you can regenerate and also train your skills while sleeping in your bed. Make yourself at home and choose from the vast assortment of furniture and decorations, put your treasures on display, and invite your friends over.', '');" onmouseout="$('#HelperDivContainer').hide();"><img src="{{ asset('/assets/tibiarl/images/premiumfeatures/PremiumIcon-House.png') }}"></span></span></td>
                                            <td style="text-align: center;"><img src="{{ asset('/assets/tibiarl/images/premiumfeatures/icon_no.png') }}"></td>
                                            <td style="text-align: center;"><img style="border:0px;" src="{{ asset('/assets/tibiarl/images/premiumfeatures/icon_yes.png') }}"> 850+ houses</td>
                                        </tr>
                                        <tr class="Odd">
                                            <td style="font-weight: bold;">Outfits</td>
                                            <td style="text-align: center;"><span style="position: relative; top: 3px; margin-left: 5px;"><span class="HelperDivIndicator" onmouseover="ActivateHelperDiv($(this), 'Wear Premium outfits', 'Dress up and wear one of the popular outfits that are exclusively available to Premium players.', '');" onmouseout="$('#HelperDivContainer').hide();"><img src="{{ asset('/assets/tibiarl/images/premiumfeatures/PremiumIcon-Outfit.png') }}"></span></span></td>
                                            <td style="text-align: center;">4 + 20 unlockable</td>
                                            <td style="text-align: center;">11 + 17 unlockable</td>
                                        </tr>
                                        <tr class="Even">
                                            <td style="font-weight: bold;">Depot space</td>
                                            <td style="text-align: center;"><span style="position: relative; top: 3px; margin-left: 5px;"><span class="HelperDivIndicator" onmouseover="ActivateHelperDiv($(this), 'Store up to 15,000 items in your depot', 'Store up to 15,000 items instead of only 2,000 in your depot chest which you can access from every city depot!', '');" onmouseout="$('#HelperDivContainer').hide();"><img src="{{ asset('/assets/tibiarl/images/premiumfeatures/PremiumIcon-Depot.png') }}"></span></span></td>
                                            <td style="text-align: center;">1000</td>
                                            <td style="text-align: center;">2000</td>
                                        </tr>
                                        <tr class="Odd">
                                            <td style="font-weight: bold;">VIP list entries</td>
                                            <td style="text-align: center;"><span style="position: relative; top: 3px; margin-left: 5px;"><span class="HelperDivIndicator" onmouseover="ActivateHelperDiv($(this), 'Add up to 100 players to your VIP list', 'Add up to 100 characters instead of only 20 to your VIP list to find out which of your friends or enemies are online.', '');" onmouseout="$('#HelperDivContainer').hide();"><img src="{{ asset('/assets/tibiarl/images/premiumfeatures/PremiumIcon-VIP.png') }}"></span></span></td>
                                            <td style="text-align: center;">20</td>
                                            <td style="text-align: center;">100</td>
                                        </tr>
                                        <tr class="Odd">
                                            <td style="font-weight: bold;">Idle Player (AFK)</td>
                                            <td style="text-align: center;"><span style="position: relative; top: 3px; margin-left: 5px;"><span class="HelperDivIndicator" onmouseover="ActivateHelperDiv($(this), 'Upgrade to Premium and enjoy uninterrupted gameplay for an extended 30 minutes. Dive deeper into the adventure without any interruptions.', 'Upgrade to Premium and enjoy uninterrupted gameplay for an extended 30 minutes. Dive deeper into the adventure without any interruptions.', '');" onmouseout="$('#HelperDivContainer').hide();"><img src="{{ asset('/assets/tibiarl/images/premiumfeatures/PremiumIcon-VIP.png') }}"></span></span></td>
                                            <td style="text-align: center;">15 minutes</td>
                                            <td style="text-align: center;">30 Minutes</td>
                                        </tr>
                                        <tr class="Even">
                                            <td style="font-weight: bold;">Online Regen</td>
                                            <td style="text-align: center;"><span style="position: relative; top: 3px; margin-left: 5px;"><span class="HelperDivIndicator" onmouseover="ActivateHelperDiv($(this), 'Elevate your performance with Premium! Get your energy refilled every 2400 seconds, ensuring you\'re always at the top of your game.', 'Elevate your performance with Premium! Get your energy refilled every 2400 seconds, ensuring you\'re always at the top of your game.', '');" onmouseout="$('#HelperDivContainer').hide();"><img src="{{ asset('/assets/tibiarl/images/premiumfeatures/PremiumIcon-VIP.png') }}"></span></span></td>
                                            <td style="text-align: center;">1200 seconds</td>
                                            <td style="text-align: center;">2400 seconds</td>
                                        </tr>
                                        <tr class="Odd">
                                            <td style="font-weight: bold;">Bed Regen</td>
                                            <td style="text-align: center;"><span style="position: relative; top: 3px; margin-left: 5px;"><span class="HelperDivIndicator" onmouseover="ActivateHelperDiv($(this), 'Experience the ultimate rejuvenation with Premium! Unlock 200 minutes of restorative bed regeneration, ensuring you wake up fully charged and ready for anything.', 'Experience the ultimate rejuvenation with Premium! Unlock 200 minutes of restorative bed regeneration, ensuring you wake up fully charged and ready for anything.', '');" onmouseout="$('#HelperDivContainer').hide();"><img src="{{ asset('/assets/tibiarl/images/premiumfeatures/PremiumIcon-House.png') }}"></span></span></td>
                                            <td style="text-align: center;"><img src="{{ asset('/assets/tibiarl/images/premiumfeatures/icon_no.png') }}"></td>
                                            <td style="text-align: center;">200 minutes</td>
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
                                            <td id="PremiumFeatureListNote">Please note this is not an exhaustive list. Other benefits are sure to follow, but it is also possible that existing ones are changed or even removed in future.</td>
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
@endsection