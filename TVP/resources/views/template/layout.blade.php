<html>
<head>
    <meta charset="utf-8">
    <title>@yield('title', 'Latest News') | {{ config('server.serverName') }}</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta http-equiv="content-language" content="en">
    <meta name="description" content="{{ config('server.og.description') }}"/>
    <meta name="keywords" content="tibia, open tibia, ots, tibia 7.4, tibia 7.72, oldschool, authentic, real tibia, server, classic tibia" />
    @hasSection('metaTag')
        @yield('metaTag')
    @else
        <meta property="og:locale" content="en_US" />
        <meta property="og:type" content="article" />
        <meta property="og:title" content="@yield('title') | {{ config('server.serverName') }}" />
        <meta property="og:description" content="{{ config('server.og.description') }}" />
        <meta property="og:url" content="{{ config('server.fullServerDomain') }}" />
        <meta property="og:site_name" content="{{ config('server.og.name') }}" />
        <meta property="og:image" content="{{ asset('/assets/images/icon.png') }}" />
    @endif

    <!--ICON-->
    <link rel="icon" href="{{ asset('/assets/images/fav/favicon.ico') }}?v=1" type="image/x-icon">

    {{-- <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('/assets/images/fav/apple-touch-icon.png') }}">
    <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('/assets/images/fav/favicon-32x32.png') }}">
    <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('/assets/images/fav/favicon-16x16.png') }}">
    <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('/assets/images/fav/safari-pinned-tab.svg') }}">
    <link rel="manifest" href="{{ asset('/assets/images/fav/site.webmanifest') }}">
    <meta name="msapplication-TileColor" content="#414141">
    <meta name="theme-color" content="#ffffff"> --}}

    <!--CSS'S-->
    <link href="{{ asset('/assets/tibiarl/css/basic_d.css') }}?v=<?php echo time(); ?>" rel="stylesheet" type="text/css">
    <link href="{{ asset('/assets/tibiarl/css/news.css') }}" rel="stylesheet" type="text/css">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Chakra+Petch&family=Source+Code+Pro:ital,wght@0,200..900;1,200..900&display=swap" rel="stylesheet">

    @yield('styles')
    <!--JS-->
    <script type="text/javascript" src="{{ asset('/assets/tibiarl/js/jquery.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('/assets/tibiarl/js/generic.js') }}"></script>
    @yield('preScripts')
    <script type="text/javascript">
        var loginStatus = 0;

        @if(Auth::check())
        loginStatus = 'true';
        @else
        loginStatus = 'false';
        @endif
        var JS_DIR_IMAGES=0;
        var activeSubmenuItem='@yield('submenuItem')';
        JS_DIR_IMAGES='{{ asset('/assets/tibiarl/images/') }}/';
        var JS_DIR_ACCOUNT=0;
        JS_DIR_ACCOUNT='{{ route('account.index') }}';
        var g_FormName='';
        var g_FormField='';
        var g_Deactivated=false;
    </script>
    <script type="text/javascript">
        if(top.location !== window.location) {
            top.location = self.location;
        }
    </script>
    @if(config('server.showCountDown'))
    @php
        $countDownDate = \Carbon\Carbon::createFromFormat('d/m/Y H:i:s', config('server.launch'))->getPreciseTimestamp(3);
        $now = \Carbon\Carbon::now()->getPreciseTimestamp(3);
    @endphp
    <script>
        let now = parseInt("{{ $now }}");
        let x = 0;
        function updateCountDown() {
            let countDownDate = parseInt("{{ $countDownDate }}");
            let distance = countDownDate - now;
            let days = Math.floor(distance / (1000 * 60 * 60 * 24));
            let hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
            let minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
            let seconds = Math.floor((distance % (1000 * 60)) / 1000);

            if (days >= 0) {
                document.getElementById("countdown-days").innerHTML = days.toString();
            }
            if (hours >= 0) {
                document.getElementById("countdown-hours").innerHTML = hours.toString();
            }
            if (minutes >= 0) {
                document.getElementById("countdown-minutes").innerHTML = minutes.toString();
            }
            if (seconds >= 0) {
                document.getElementById("countdown-seconds").innerHTML = seconds.toString();
            }
            if (distance < 0) {
                document.getElementById("countdown-active").style.display = 'none';
                document.getElementById("countdown-reached").style.display = 'block';
                clearInterval(x);
            }
            now += 1000;
        }
        $(document).ready(function () {
            updateCountDown();
            x = setInterval(function() {
                updateCountDown();
            }, 1000);
        });
    </script>
    @endif
    <script type="text/javascript" src="{{ asset('/assets/tibiarl/initialize.js') }}?v=a2"></script>
</head>


<style>
    .Submenu{
        padding: 4px !important; 
        margin-left: 1.5px !important
    }
</style>

<!-- Google Tag Manager -->
<script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
'https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
})(window,document,'script','dataLayer','GTM-MVFX3V6J');</script>
<!-- End Google Tag Manager -->

<body onbeforeunload="SaveMenu();" onunload="SaveMenu();" style="background-image:url({{ asset('/assets/tibiarl/images/header/clean.png') }}?v=1);
  background-attachment: fixed;
  background-repeat: repeat;
  background-size: cover" data-twttr-rendered="true">

    <!-- Google Tag Manager (noscript) -->
    <noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-MVFX3V6J"
    height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
    <!-- End Google Tag Manager (noscript) -->

<div id="MainHelper1">
    <div id="MainHelper2">
        <div id="ArtworkHelper">
            <div id="Bodycontainer">
                <div id="ContentRow">
                    <div id="MenuColumn">

                        <div id="LeftArtwork">
                            <a href="{{ route('landing') }}">
                                <img id="TibiaLogoArtworkTop" src="{{ asset('/assets/tibiarl/images/header/ravenor-logo-artwork-top.png') }}" alt="logoartwork">
                            </a>
                            <span id="LogoLink" class="text-center">Version 7.4</span>
                        </div>
                        <div id="Loginbox">
                            <div id="LoginTop" style="background-image:url({{ asset('/assets/tibiarl/images/general/box-top.png') }})"></div>
                            <div id="BorderLeft" class="LoginBorder" style="background-image:url({{ asset('/assets/tibiarl/images/general/chain.gif') }})"></div>
                            <div id="LoginButtonContainer" style="background-image:url({{ asset('/assets/tibiarl/images/loginbox/loginbox-textfield-background.gif') }})">
                                <div id="PlayNowContainer" @if(Auth::check()) onclick="window.location.href='{{ route('account.index') }}'" @else onclick="window.location.href='{{ route('account.login.index') }}'" @endif><div class="MediumButtonBackground" style="background-image:url({{ asset('/assets/tibiarl/images/buttons/mediumbutton.gif') }})" onmouseover="MouseOverMediumButton(this);" onmouseout="MouseOutMediumButton(this);"><div class="MediumButtonOver" style="background-image: url({{ asset('/assets/tibiarl/images/buttons/mediumbutton-over.gif') }}); visibility: hidden;" onmouseover="MouseOverMediumButton(this);" onmouseout="MouseOutMediumButton(this);"></div><input class="MediumButtonText" type="image" name="Play Now" alt="Play Now" src="{{ asset('/assets/tibiarl/images/buttons/mediumbutton_playnow.png') }}"></div></div>
                            </div>
                            <div class="Loginstatus" style="background-image:url({{ asset('/assets/tibiarl/images/loginbox/loginbox-textfield-background.gif') }})">
                                <div id="LoginstatusText" onclick="LoginstatusTextAction(this);" onmouseover="MouseOverLoginBoxText(this);" onmouseout="MouseOutLoginBoxText(this);"><div id="LoginstatusText_1" class="LoginstatusText" style="background-image: url({{ asset('/assets/tibiarl/images/loginbox/loginbox-font-create-account.gif') }}); visibility: visible;"></div><div id="LoginstatusText_2" class="LoginstatusText" style="background-image: url({{ asset('/assets/tibiarl/images/loginbox/loginbox-font-create-account-over.gif') }}); visibility: hidden;"></div></div>
                            </div>
                            <div id="BorderRight" class="LoginBorder" style="background-image:url({{ asset('/assets/tibiarl/images/general/chain.gif') }})"></div>
                            <div id="LoginBottom" class="Loginstatus" style="background-image:url({{ asset('/assets/tibiarl/images/general/box-bottomGray.gif') }})"></div>
                        </div>
                        <div class="SmallMenuBox" id="DownloadBox">
                            <div class="SmallBoxTop" style="background-image:url({{ asset('/assets/tibiarl/images/general/box-top.png') }})"></div>
                            <div class="SmallBoxBorder" style="background-image:url({{ asset('/assets/tibiarl/images/general/chain.gif') }})"></div>
                            <div class="SmallBoxButtonContainer" style="background-image:url({{ asset('/assets/tibiarl/images/loginbox/loginbox-textfield-background.gif') }})">
                                <a href="{{ route('download.index') }}">
                                    <div id="PlayNowContainer">
                                        <div class="MediumButtonBackground" style="background-image:url({{ asset('/assets/tibiarl/images/buttons/mediumbutton.gif') }})" onmouseover="MouseOverBigButton(this);" onmouseout="MouseOutBigButton(this);"><div class="MediumButtonOver" style="background-image: url({{ asset('/assets/tibiarl/images/buttons/mediumbutton-over.gif') }}); visibility: hidden;"></div><input class="MediumButtonText" type="image" name="Download" alt="Download" src="{{ asset('/assets/tibiarl/images/buttons/mediumbutton_download.png') }}"></div>
                                    </div>
                                </a>
                            </div>
                            <div class="SmallBoxBorder BorderRight" style="background-image:url({{ asset('/assets/tibiarl/images/general/chain.gif') }});"></div>
                            <div class="Loginstatus SmallBoxBottom" style="background-image:url({{ asset('/assets/tibiarl/images/general/box-bottomGray.gif') }});"></div>
                        </div>
                        <div id="Menu">
                            <div id="MenuTop" style="background-image:url({{ asset('/assets/tibiarl/images/general/box-top.png') }});"></div>
                            <div id="news" class="menuitem">
                                <span onclick="MenuItemAction('news')">
                                    <div class="MenuButton" style="background-image:url({{ asset('/assets/tibiarl/images/menu/button-background.gif') }});">
                                        <div onmouseover="MouseOverMenuItem(this);" onmouseout="MouseOutMenuItem(this);"><div class="Button" style="background-image:url({{ asset('/assets/tibiarl/images/menu/button-background-over.gif') }});"></div>
                                        <span id="news_Lights" class="Lights">
                                            <div class="light_lu" style="background-image:url({{ asset('/assets/tibiarl/images/menu/green-light.gif') }});"></div>
                                            <div class="light_ld" style="background-image:url({{ asset('/assets/tibiarl/images/menu/green-light.gif') }});"></div>
                                            <div class="light_ru" style="background-image:url({{ asset('/assets/tibiarl/images/menu/green-light.gif') }});"></div>
                                        </span>
                                        <div id="news_Icon" class="Icon" style="background-image:url({{ asset('/itemsBack/trombeta.gif') }});"></div>
                                        {{-- <div id="news_Icon" class="Icon" style="background-image:url({{ asset('/assets/tibiarl/images/menu/icon-news.gif') }});"></div> --}}
                                        <div id="news_Label" class="Label" style="background-image:url({{ asset('/assets/tibiarl/images/menu/label-news.gif') }});"></div>
                                        <div id="news_Extend" class="Extend" style="background-image: url({{ asset('/assets/tibiarl/images/general/minus.gif') }});"></div>
                                    </div>
                                </div>
                            </span>
                                <div id="news_Submenu" class="Submenu">
                                    <a href="{{ route('landing') }}">
                                        <div id="submenu_latestnews" class="Submenuitem" onmouseover="MouseOverSubmenuItem(this)" onmouseout="MouseOutSubmenuItem(this)">
                                            <div class="LeftChain" style="background-image:url({{ asset('/assets/tibiarl/images/general/chain.gif') }});"></div>
                                            <div id="ActiveSubmenuItemIcon_latestnews" class="ActiveSubmenuItemIcon" style="background-image: url({{ asset('/assets/tibiarl/images/menu/icon-activesubmenu.gif') }});"></div>
                                            <div id="ActiveSubmenuItemLabel_latestnews" class="SubmenuitemLabel" translate="no">Latest News</div>
                                            <div class="RightChain" style="background-image:url({{ asset('/assets/tibiarl/images/general/chain.gif') }});"></div>
                                        </div>
                                    </a>
                                    <a href="{{ route('archive') }}">
                                        <div id="submenu_archive" class="Submenuitem" onmouseover="MouseOverSubmenuItem(this)" onmouseout="MouseOutSubmenuItem(this)">
                                            <div class="LeftChain" style="background-image:url({{ asset('/assets/tibiarl/images/general/chain.gif') }});"></div>
                                            <div id="ActiveSubmenuItemIcon_archive" class="ActiveSubmenuItemIcon" style="background-image:url({{ asset('/assets/tibiarl/images/menu/icon-activesubmenu.gif') }});"></div>
                                            <div id="ActiveSubmenuItemLabel_archive" class="SubmenuitemLabel" translate="no">News Archive</div>
                                            <div class="RightChain" style="background-image:url({{ asset('/assets/tibiarl/images/general/chain.gif') }});"></div>
                                        </div>
                                    </a>
                                </div>
                            </div>

                            <div id="wiki" class="menuitem">
                                <span onclick="MenuItemAction('wiki')">
                                    <div class="MenuButton" style="background-image:url({{ asset('/assets/tibiarl/images/menu/button-background.gif') }});">
                                        <div onmouseover="MouseOverMenuItem(this);" onmouseout="MouseOutMenuItem(this);"><div class="Button" style="background-image:url({{ asset('/assets/tibiarl/images/menu/button-background-over.gif') }});"></div>
                                            <span id="wiki_Lights" class="Lights">
                                                <div class="light_lu" style="background-image:url({{ asset('/assets/tibiarl/images/menu/green-light.gif') }});"></div>
                                                <div class="light_ld" style="background-image:url({{ asset('/assets/tibiarl/images/menu/green-light.gif') }});"></div>
                                                <div class="light_ru" style="background-image:url({{ asset('/assets/tibiarl/images/menu/green-light.gif') }});"></div>
                                            </span>
                                            <div id="wiki_Icon" class="Icon" style="background-image:url({{ asset('/itemsBack/library.gif') }});"></div>
                                                <div style="position: absolute; z-index: 9; top: 5; left: 74.5;">
                                                    <img id="wiki_ContentBoxHeadline" class="Title" src="/assets/tibiarl/headline/index.php?txt= Wiki" alt="Wiki Title" style="width: 280px; filter: brightness(0.9) drop-shadow(0px 0px 1px rgba(0, 0, 0, 0.5));">
                                                </div>
                                            <div id="wiki_Extend" class="Extend" style="background-image: url({{ asset('/assets/tibiarl/images/general/plus.gif') }});"></div>
                                        </div>
                                    </div>
                                </span>
                                <div id="wiki_Submenu" class="Submenu">
                                    <a href="{{ route('about.creatures') }}">
                                        <div id="submenu_creatures" class="Submenuitem" onmouseover="MouseOverSubmenuItem(this)" onmouseout="MouseOutSubmenuItem(this)">
                                            <div class="LeftChain" style="background-image:url({{ asset('/assets/tibiarl/images/general/chain.gif') }});"></div>
                                            <div id="ActiveSubmenuItemIcon_creatures" class="ActiveSubmenuItemIcon" style="background-image:url({{ asset('/assets/tibiarl/images/menu/icon-activesubmenu.gif') }});"></div>
                                            <div id="ActiveSubmenuItemLabel_creatures" class="SubmenuitemLabel" translate="no">Creatures</div>
                                            <div class="RightChain" style="background-image:url({{ asset('/assets/tibiarl/images/general/chain.gif') }});"></div>
                                        </div>
                                    </a>
                                    <a href="{{ route('about.items') }}">
                                        <div id="submenu_items" class="Submenuitem" onmouseover="MouseOverSubmenuItem(this)" onmouseout="MouseOutSubmenuItem(this)">
                                            <div class="LeftChain" style="background-image:url({{ asset('/assets/tibiarl/images/general/chain.gif') }});"></div>
                                            <div id="ActiveSubmenuItemIcon_items" class="ActiveSubmenuItemIcon" style="background-image:url({{ asset('/assets/tibiarl/images/menu/icon-activesubmenu.gif') }});"></div>
                                            <div id="ActiveSubmenuItemLabel_items" class="SubmenuitemLabel" translate="no">Items</div>
                                            <div class="RightChain" style="background-image:url({{ asset('/assets/tibiarl/images/general/chain.gif') }});"></div>
                                        </div>
                                    </a>
                                    <a href="{{ route('about.map') }}">
                                        <div id="submenu_map" class="Submenuitem" onmouseover="MouseOverSubmenuItem(this)" onmouseout="MouseOutSubmenuItem(this)">
                                            <div class="LeftChain" style="background-image:url({{ asset('/assets/tibiarl/images/general/chain.gif') }});"></div>
                                            <div id="ActiveSubmenuItemIcon_map" class="ActiveSubmenuItemIcon" style="background-image:url({{ asset('/assets/tibiarl/images/menu/icon-activesubmenu.gif') }});"></div>
                                            <div id="ActiveSubmenuItemLabel_map" class="SubmenuitemLabel" translate="no">World Map</div>
                                            <div class="RightChain" style="background-image:url({{ asset('/assets/tibiarl/images/general/chain.gif') }});"></div>
                                        </div>
                                    </a>
                                    <a href="{{ route('library.spells.index') }}">
                                        <div id="submenu_spells" class="Submenuitem" onmouseover="MouseOverSubmenuItem(this)" onmouseout="MouseOutSubmenuItem(this)">
                                            <div class="LeftChain" style="background-image:url({{ asset('/assets/tibiarl/images/general/chain.gif') }});"></div>
                                            <div id="ActiveSubmenuItemIcon_spells" class="ActiveSubmenuItemIcon" style="background-image:url({{ asset('/assets/tibiarl/images/menu/icon-activesubmenu.gif') }});"></div>
                                            <div id="ActiveSubmenuItemLabel_spells" class="SubmenuitemLabel" translate="no">Spells</div>
                                            <div class="RightChain" style="background-image:url({{ asset('/assets/tibiarl/images/general/chain.gif') }});"></div>
                                        </div>
                                    </a>
                                    <a href="{{ route('about.npcs') }}">
                                        <div id="submenu_npcs" class="Submenuitem" onmouseover="MouseOverSubmenuItem(this)" onmouseout="MouseOutSubmenuItem(this)">
                                            <div class="LeftChain" style="background-image:url({{ asset('/assets/tibiarl/images/general/chain.gif') }});"></div>
                                            <div id="ActiveSubmenuItemIcon_npcs" class="ActiveSubmenuItemIcon" style="background-image:url({{ asset('/assets/tibiarl/images/menu/icon-activesubmenu.gif') }});"></div>
                                            <div id="ActiveSubmenuItemLabel_npcs" class="SubmenuitemLabel" translate="no">NPCs</div>
                                            <div class="RightChain" style="background-image:url({{ asset('/assets/tibiarl/images/general/chain.gif') }});"></div>
                                        </div>
                                    </a>
                                    <a href="{{ route('about.charms') }}">
                                        <div id="submenu_charms" class="Submenuitem" onmouseover="MouseOverSubmenuItem(this)" onmouseout="MouseOutSubmenuItem(this)">
                                            <div class="LeftChain" style="background-image:url({{ asset('/assets/tibiarl/images/general/chain.gif') }});"></div>
                                            <div id="ActiveSubmenuItemIcon_charms" class="ActiveSubmenuItemIcon" style="background-image:url({{ asset('/assets/tibiarl/images/menu/icon-activesubmenu.gif') }});"></div>
                                            <div id="ActiveSubmenuItemLabel_charms" class="SubmenuitemLabel" translate="no">Charms</div>
                                            <div class="RightChain" style="background-image:url({{ asset('/assets/tibiarl/images/general/chain.gif') }});"></div>
                                        </div>
                                    </a>
                                    <a href="{{ route('about.statGuide') }}">
                                        <div id="submenu_statGuide" class="Submenuitem" onmouseover="MouseOverSubmenuItem(this)" onmouseout="MouseOutSubmenuItem(this)">
                                            <div class="LeftChain" style="background-image:url({{ asset('/assets/tibiarl/images/general/chain.gif') }});"></div>
                                            <div id="ActiveSubmenuItemIcon_statGuide" class="ActiveSubmenuItemIcon" style="background-image:url({{ asset('/assets/tibiarl/images/menu/icon-activesubmenu.gif') }});"></div>
                                            <div id="ActiveSubmenuItemLabel_statGuide" class="SubmenuitemLabel" translate="no">Stat Guide</div>
                                            <div class="RightChain" style="background-image:url({{ asset('/assets/tibiarl/images/general/chain.gif') }});"></div>
                                        </div>
                                    </a>
                                    <a href="{{ route('about.marketOffline') }}">
                                        <div id="submenu_marketOffline" class="Submenuitem" onmouseover="MouseOverSubmenuItem(this)" onmouseout="MouseOutSubmenuItem(this)">
                                            <div class="LeftChain" style="background-image:url({{ asset('/assets/tibiarl/images/general/chain.gif') }});"></div>
                                            <div id="ActiveSubmenuItemIcon_marketOffline" class="ActiveSubmenuItemIcon" style="background-image:url({{ asset('/assets/tibiarl/images/menu/icon-activesubmenu.gif') }});"></div>
                                            <div id="ActiveSubmenuItemLabel_marketOffline" class="SubmenuitemLabel" translate="no">Market Offline</div>
                                            <div class="RightChain" style="background-image:url({{ asset('/assets/tibiarl/images/general/chain.gif') }});"></div>
                                        </div>
                                    </a>
                                    <a href="{{ route('about.rarityUpgrade') }}">
                                        <div id="submenu_rarityUpgrade" class="Submenuitem" onmouseover="MouseOverSubmenuItem(this)" onmouseout="MouseOutSubmenuItem(this)">
                                            <div class="LeftChain" style="background-image:url({{ asset('/assets/tibiarl/images/general/chain.gif') }});"></div>
                                            <div id="ActiveSubmenuItemIcon_rarityUpgrade" class="ActiveSubmenuItemIcon" style="background-image:url({{ asset('/assets/tibiarl/images/menu/icon-activesubmenu.gif') }});"></div>
                                            <div id="ActiveSubmenuItemLabel_rarityUpgrade" class="SubmenuitemLabel" translate="no">Rarity Upgrade</div>
                                            <div class="RightChain" style="background-image:url({{ asset('/assets/tibiarl/images/general/chain.gif') }});"></div>
                                        </div>
                                    </a>
                                    <a href="{{ route('library.shared-experience') }}">
                                        <div id="submenu_sharedexperience" class="Submenuitem" onmouseover="MouseOverSubmenuItem(this)" onmouseout="MouseOutSubmenuItem(this)">
                                            <div class="LeftChain" style="background-image:url({{ asset('/assets/tibiarl/images/general/chain.gif') }});"></div>
                                            <div id="ActiveSubmenuItemIcon_sharedexperience" class="ActiveSubmenuItemIcon" style="background-image:url({{ asset('/assets/tibiarl/images/menu/icon-activesubmenu.gif') }});"></div>
                                            <div id="ActiveSubmenuItemLabel_sharedexperience" class="SubmenuitemLabel" translate="no">Shared Experience</div>
                                            <div class="RightChain" style="background-image:url({{ asset('/assets/tibiarl/images/general/chain.gif') }});"></div>
                                        </div>
                                    </a>
                                </div>
                            </div>

                            <div id="library" class="menuitem">
                                <span onclick="MenuItemAction('library')">
                                    <div class="MenuButton" style="background-image:url({{ asset('/assets/tibiarl/images/menu/button-background.gif') }});">
                                        <div onmouseover="MouseOverMenuItem(this);" onmouseout="MouseOutMenuItem(this);"><div class="Button" style="background-image:url({{ asset('/assets/tibiarl/images/menu/button-background-over.gif') }});"></div>
                                            <span id="library_Lights" class="Lights">
                                                <div class="light_lu" style="background-image:url({{ asset('/assets/tibiarl/images/menu/green-light.gif') }});"></div>
                                                <div class="light_ld" style="background-image:url({{ asset('/assets/tibiarl/images/menu/green-light.gif') }});"></div>
                                                <div class="light_ru" style="background-image:url({{ asset('/assets/tibiarl/images/menu/green-light.gif') }});"></div>
                                            </span>
                                            <div id="library_Icon" class="Icon" style="background-image:url({{ asset('/assets/tibiarl/images/menu/icon-library.gif') }});"></div>
                                            <div id="library_Label" class="Label" style="background-image:url({{ asset('/assets/tibiarl/images/menu/label-library.gif') }});"></div>
                                            <div id="library_Extend" class="Extend" style="background-image: url({{ asset('/assets/tibiarl/images/general/plus.gif') }});"></div>
                                        </div>
                                    </div>
                                </span>
                                <div id="library_Submenu" class="Submenu">
                                    <a href="{{ route('about.game') }}">
                                        <div id="submenu_about" class="Submenuitem" onmouseover="MouseOverSubmenuItem(this)" onmouseout="MouseOutSubmenuItem(this)">
                                            <div class="LeftChain" style="background-image:url({{ asset('/assets/tibiarl/images/general/chain.gif') }});"></div>
                                            <div id="ActiveSubmenuItemIcon_about" class="ActiveSubmenuItemIcon" style="background-image:url({{ asset('/assets/tibiarl/images/menu/icon-activesubmenu.gif') }});"></div>
                                            <div id="ActiveSubmenuItemLabel_about" class="SubmenuitemLabel" translate="no">What is {{ config('server.serverName') }}?</div>
                                            <div class="RightChain" style="background-image:url({{ asset('/assets/tibiarl/images/general/chain.gif') }});"></div>
                                        </div>
                                    </a>

                                    <a href="{{ route('about.game') }}">
                                        <div id="submenu_about" class="Submenuitem" onmouseover="MouseOverSubmenuItem(this)" onmouseout="MouseOutSubmenuItem(this)">
                                            <div class="LeftChain" style="background-image:url({{ asset('/assets/tibiarl/images/general/chain.gif') }});"></div>
                                            <div id="ActiveSubmenuItemIcon_about" class="ActiveSubmenuItemIcon" style="background-image:url({{ asset('/assets/tibiarl/images/menu/icon-activesubmenu.gif') }});"></div>
                                            <div id="ActiveSubmenuItemLabel_about" class="SubmenuitemLabel" translate="no">FAQ</div>
                                            <div class="RightChain" style="background-image:url({{ asset('/assets/tibiarl/images/general/chain.gif') }});"></div>
                                        </div>
                                    </a>

                                    <a href="{{ route('about.game-features') }}">
                                        <div id="submenu_features" class="Submenuitem" onmouseover="MouseOverSubmenuItem(this)" onmouseout="MouseOutSubmenuItem(this)">
                                            <div class="LeftChain" style="background-image:url({{ asset('/assets/tibiarl/images/general/chain.gif') }});"></div>
                                            <div id="ActiveSubmenuItemIcon_features" class="ActiveSubmenuItemIcon" style="background-image:url({{ asset('/assets/tibiarl/images/menu/icon-activesubmenu.gif') }});"></div>
                                            <div id="ActiveSubmenuItemLabel_features" class="SubmenuitemLabel" translate="no">Game Features</div>
                                            <div class="RightChain" style="background-image:url({{ asset('/assets/tibiarl/images/general/chain.gif') }});"></div>
                                        </div>
                                    </a>
                                    @if(config('server.enablePremiumAccount'))
                                    <a href="{{ route('about.premium-features') }}">
                                        <div id="submenu_premiumfeatures" class="Submenuitem" onmouseover="MouseOverSubmenuItem(this)" onmouseout="MouseOutSubmenuItem(this)">
                                            <div class="LeftChain" style="background-image:url({{ asset('/assets/tibiarl/images/general/chain.gif') }});"></div>
                                            <div id="ActiveSubmenuItemIcon_premiumfeatures" class="ActiveSubmenuItemIcon" style="background-image:url({{ asset('/assets/tibiarl/images/menu/icon-activesubmenu.gif') }});"></div>
                                            <div id="ActiveSubmenuItemLabel_premiumfeatures" class="SubmenuitemLabel" translate="no">Premium Features</div>
                                            <div class="RightChain" style="background-image:url({{ asset('/assets/tibiarl/images/general/chain.gif') }});"></div>
                                        </div>
                                    </a>
                                    @endif
                                </div>
                            </div>

                            <div id="community" class="menuitem">
                                <span onclick="MenuItemAction('community')">
                                    <div class="MenuButton" style="background-image:url({{ asset('/assets/tibiarl/images/menu/button-background.gif') }});">
                                        <div onmouseover="MouseOverMenuItem(this);" onmouseout="MouseOutMenuItem(this);"><div class="Button" style="background-image:url({{ asset('/assets/tibiarl/images/menu/button-background-over.gif') }});"></div>
                                        <span id="community_Lights" class="Lights">
                                            <div class="light_lu" style="background-image:url({{ asset('/assets/tibiarl/images/menu/green-light.gif') }});"></div>
                                            <div class="light_ld" style="background-image:url({{ asset('/assets/tibiarl/images/menu/green-light.gif') }});"></div>
                                            <div class="light_ru" style="background-image:url({{ asset('/assets/tibiarl/images/menu/green-light.gif') }});"></div>
                                        </span>
                                        <div id="community_Icon" class="Icon" style="background-image:url({{ asset('/assets/tibiarl/images/menu/icon-community.gif') }});"></div>
                                        <div id="community_Label" class="Label" style="background-image:url({{ asset('/assets/tibiarl/images/menu/label-community.gif') }});"></div>
                                        <div id="community_Extend" class="Extend" style="background-image: url({{ asset('/assets/tibiarl/images/general/plus.gif') }});"></div>
                                        </div>
                                    </div>
                                </span>
                                <div id="community_Submenu" class="Submenu">
                                    <a href="{{ route('community.view.character.searchView') }}">
                                        <div id="submenu_characters" class="Submenuitem" onmouseover="MouseOverSubmenuItem(this)" onmouseout="MouseOutSubmenuItem(this)">
                                            <div class="LeftChain" style="background-image:url({{ asset('/assets/tibiarl/images/general/chain.gif') }});"></div>
                                            <div id="ActiveSubmenuItemIcon_characters" class="ActiveSubmenuItemIcon" style="background-image:url({{ asset('/assets/tibiarl/images/menu/icon-activesubmenu.gif') }});"></div>
                                            <div id="ActiveSubmenuItemLabel_characters" class="SubmenuitemLabel" translate="no">Characters</div>
                                            <div class="RightChain" style="background-image:url({{ asset('/assets/tibiarl/images/general/chain.gif') }});"></div>
                                        </div>
                                    </a>
                                    <a href="{{ route('community.players-online.index') }}">
                                        <div id="submenu_whoisonline" class="Submenuitem" onmouseover="MouseOverSubmenuItem(this)" onmouseout="MouseOutSubmenuItem(this)">
                                            <div class="LeftChain" style="background-image:url({{ asset('/assets/tibiarl/images/general/chain.gif') }});"></div>
                                            <div id="ActiveSubmenuItemIcon_whoisonline" class="ActiveSubmenuItemIcon" style="background-image:url({{ asset('/assets/tibiarl/images/menu/icon-activesubmenu.gif') }});"></div>
                                            <div id="ActiveSubmenuItemLabel_whoisonline" class="SubmenuitemLabel" translate="no">Who is online</div>
                                            <div class="RightChain" style="background-image:url({{ asset('/assets/tibiarl/images/general/chain.gif') }});"></div>
                                        </div>
                                    </a>
                                    @if (config('server.enableHighscore'))
                                    <a href="{{ route('community.highscores.index') }}">
                                        <div id="submenu_highscores" class="Submenuitem" onmouseover="MouseOverSubmenuItem(this)" onmouseout="MouseOutSubmenuItem(this)">
                                            <div class="LeftChain" style="background-image:url({{ asset('/assets/tibiarl/images/general/chain.gif') }});"></div>
                                            <div id="ActiveSubmenuItemIcon_highscores" class="ActiveSubmenuItemIcon" style="background-image:url({{ asset('/assets/tibiarl/images/menu/icon-activesubmenu.gif') }});"></div>
                                            <div id="ActiveSubmenuItemLabel_highscores" class="SubmenuitemLabel" translate="no">Highscores</div>
                                            <div class="RightChain" style="background-image:url({{ asset('/assets/tibiarl/images/general/chain.gif') }});"></div>
                                        </div>
                                    </a>
                                    @endif
                                    <a href="{{ route('community.kill-statistics.index') }}">
                                        <div id="submenu_killstatistics" class="Submenuitem" onmouseover="MouseOverSubmenuItem(this)" onmouseout="MouseOutSubmenuItem(this)">
                                            <div class="LeftChain" style="background-image:url({{ asset('/assets/tibiarl/images/general/chain.gif') }});"></div>
                                            <div id="ActiveSubmenuItemIcon_killstatistics" class="ActiveSubmenuItemIcon" style="background-image:url({{ asset('/assets/tibiarl/images/menu/icon-activesubmenu.gif') }});"></div>
                                            <div id="ActiveSubmenuItemLabel_killstatistics" class="SubmenuitemLabel" translate="no">Kill Statistics</div>
                                            <div class="RightChain" style="background-image:url({{ asset('/assets/tibiarl/images/general/chain.gif') }});"></div>
                                        </div>
                                    </a>
                                    <a href="{{ route('community.powergamers.index') }}">
                                        <div id="submenu_powergamers" class="Submenuitem" onmouseover="MouseOverSubmenuItem(this)" onmouseout="MouseOutSubmenuItem(this)">
                                            <div class="LeftChain" style="background-image:url({{ asset('/assets/tibiarl/images/general/chain.gif') }});"></div>
                                            <div id="ActiveSubmenuItemIcon_powergamers" class="ActiveSubmenuItemIcon" style="background-image:url({{ asset('/assets/tibiarl/images/menu/icon-activesubmenu.gif') }});"></div>
                                            <div id="ActiveSubmenuItemLabel_powergamers" class="SubmenuitemLabel" translate="no">PowerGamers</div>
                                            <div class="RightChain" style="background-image:url({{ asset('/assets/tibiarl/images/general/chain.gif') }});"></div>
                                        </div>
                                    </a>
                                    <a href="{{ route('community.last-bans.index') }}">
                                        <div id="submenu_lastbans" class="Submenuitem" onmouseover="MouseOverSubmenuItem(this)" onmouseout="MouseOutSubmenuItem(this)">
                                            <div class="LeftChain" style="background-image:url({{ asset('/assets/tibiarl/images/general/chain.gif') }});"></div>
                                            <div id="ActiveSubmenuItemIcon_lastbans" class="ActiveSubmenuItemIcon" style="background-image:url({{ asset('/assets/tibiarl/images/menu/icon-activesubmenu.gif') }});"></div>
                                            <div id="ActiveSubmenuItemLabel_lastbans" class="SubmenuitemLabel" translate="no">Last Bans</div>
                                            <div class="RightChain" style="background-image:url({{ asset('/assets/tibiarl/images/general/chain.gif') }});"></div>
                                        </div>
                                    </a>
                                    <a href="{{ route('community.houses.index') }}">
                                        <div id="submenu_houses" class="Submenuitem" onmouseover="MouseOverSubmenuItem(this)" onmouseout="MouseOutSubmenuItem(this)">
                                            <div class="LeftChain" style="background-image:url({{ asset('/assets/tibiarl/images/general/chain.gif') }});"></div>
                                            <div id="ActiveSubmenuItemIcon_houses" class="ActiveSubmenuItemIcon" style="background-image:url({{ asset('/assets/tibiarl/images/menu/icon-activesubmenu.gif') }});"></div>
                                            <div id="ActiveSubmenuItemLabel_houses" class="SubmenuitemLabel" translate="no">Houses</div>
                                            <div class="RightChain" style="background-image:url({{ asset('/assets/tibiarl/images/general/chain.gif') }});"></div>
                                        </div>
                                    </a>
                                    <a href="{{ route('community.guilds.index') }}">
                                        <div id="submenu_guilds" class="Submenuitem" onmouseover="MouseOverSubmenuItem(this)" onmouseout="MouseOutSubmenuItem(this)">
                                            <div id="ActiveSubmenuItemIcon_guilds" class="LeftChain" style="background-image:url({{ asset('/assets/tibiarl/images/general/chain.gif') }});"></div>
                                            <div id="ActiveSubmenuItemIcon_guilds" class="ActiveSubmenuItemIcon" style="background-image:url({{ asset('/assets/tibiarl/images/menu/icon-activesubmenu.gif') }});"></div>
                                            <div id="ActiveSubmenuItemLabel_guilds" class="SubmenuitemLabel" translate="no">Guilds</div>
                                            <div class="RightChain" style="background-image:url({{ asset('/assets/tibiarl/images/general/chain.gif') }});"></div>
                                        </div>
                                    </a>
                                    <a href="{{ route('community.latest-deaths.index') }}">
                                        <div id="submenu_latestdeath" class="Submenuitem" onmouseover="MouseOverSubmenuItem(this)" onmouseout="MouseOutSubmenuItem(this)">
                                            <div class="LeftChain" style="background-image:url({{ asset('/assets/tibiarl/images/general/chain.gif') }});"></div>
                                            <div id="ActiveSubmenuItemIcon_latestdeath" class="ActiveSubmenuItemIcon" style="background-image:url({{ asset('/assets/tibiarl/images/menu/icon-activesubmenu.gif') }});"></div>
                                            <div id="ActiveSubmenuItemLabel_latestdeath" class="SubmenuitemLabel" translate="no">Latest Death</div>
                                            <div class="RightChain" style="background-image:url({{ asset('/assets/tibiarl/images/general/chain.gif') }});"></div>
                                        </div>
                                    </a>
                                    <a href="{{ route('community.streamers.index') }}">
                                        <div id="submenu_streamers" class="Submenuitem" onmouseover="MouseOverSubmenuItem(this)" onmouseout="MouseOutSubmenuItem(this)">
                                            <div class="LeftChain" style="background-image:url({{ asset('/assets/tibiarl/images/general/chain.gif') }});"></div>
                                            <div id="ActiveSubmenuItemIcon_streamers" class="ActiveSubmenuItemIcon" style="background-image:url({{ asset('/assets/tibiarl/images/menu/icon-activesubmenu.gif') }});"></div>
                                            <div id="ActiveSubmenuItemLabel_streamers" class="SubmenuitemLabel" translate="no">Streamers</div>
                                            <div class="RightChain" style="background-image:url({{ asset('/assets/tibiarl/images/general/chain.gif') }});"></div>
                                        </div>
                                    </a>
                                </div>
                            </div>
                            <div id="account" class="menuitem">
                                <span onclick="MenuItemAction('account')">
                                    <div class="MenuButton" style="background-image:url({{ asset('/assets/tibiarl/images/menu/button-background.gif') }});">
                                        <div onmouseover="MouseOverMenuItem(this);" onmouseout="MouseOutMenuItem(this);"><div class="Button" style="background-image:url({{ asset('/assets/tibiarl/images/menu/button-background-over.gif') }});"></div>
                                        <span id="account_Lights" class="Lights">
                                            <div class="light_lu" style="background-image:url({{ asset('/assets/tibiarl/images/menu/green-light.gif') }});"></div>
                                            <div class="light_ld" style="background-image:url({{ asset('/assets/tibiarl/images/menu/green-light.gif') }});"></div>
                                            <div class="light_ru" style="background-image:url({{ asset('/assets/tibiarl/images/menu/green-light.gif') }});"></div>
                                        </span>
                                            <div id="library_Icon" class="Icon" style="background-image:url({{ asset('/itemsBack/chaveiro.gif') }});"></div>
                                            {{-- <div id="account_Icon" class="Icon" style="background-image:url({{ asset('/assets/tibiarl/images/menu/icon-account.gif') }});"></div> --}}
                                            <div id="account_Label" class="Label" style="background-image:url({{ asset('/assets/tibiarl/images/menu/label-account.gif') }});"></div>
                                            <div id="account_Extend" class="Extend" style="background-image: url({{ asset('/assets/tibiarl/images/general/plus.gif') }});"></div>
                                        </div>
                                    </div>
                                </span>
                                <div id="account_Submenu" class="Submenu">
                                    <a href="{{ route('account.index') }}">
                                        <div id="submenu_accountmanagement" class="Submenuitem" onmouseover="MouseOverSubmenuItem(this)" onmouseout="MouseOutSubmenuItem(this)">
                                            <div class="LeftChain" style="background-image:url({{ asset('/assets/tibiarl/images/general/chain.gif') }});"></div>
                                            <div id="ActiveSubmenuItemIcon_accountmanagement" class="ActiveSubmenuItemIcon" style="background-image:url({{ asset('/assets/tibiarl/images/menu/icon-activesubmenu.gif') }});"></div>
                                            <div id="ActiveSubmenuItemLabel_accountmanagement" class="SubmenuitemLabel" translate="no">Account Management</div>
                                            <div class="RightChain" style="background-image:url({{ asset('/assets/tibiarl/images/general/chain.gif') }});"></div>
                                        </div>
                                    </a>
                                    <a href="{{ route('account.create.index') }}">
                                        <div id="submenu_createaccount" class="Submenuitem" onmouseover="MouseOverSubmenuItem(this)" onmouseout="MouseOutSubmenuItem(this)">
                                            <div class="LeftChain" style="background-image:url({{ asset('/assets/tibiarl/images/general/chain.gif') }});"></div>
                                            <div id="ActiveSubmenuItemIcon_createaccount" class="ActiveSubmenuItemIcon" style="background-image:url({{ asset('/assets/tibiarl/images/menu/icon-activesubmenu.gif') }});"></div>
                                            <div id="ActiveSubmenuItemLabel_createaccount" class="SubmenuitemLabel" translate="no">Create Account</div>
                                            <div class="RightChain" style="background-image:url({{ asset('/assets/tibiarl/images/general/chain.gif') }});"></div>
                                        </div>
                                    </a>
                                    <a href="{{ route('download.index') }}">
                                        <div id="submenu_download" class="Submenuitem" onmouseover="MouseOverSubmenuItem(this)" onmouseout="MouseOutSubmenuItem(this)">
                                            <div class="LeftChain" style="background-image:url({{ asset('/assets/tibiarl/images/general/chain.gif') }});"></div>
                                            <div id="ActiveSubmenuItemIcon_download" class="ActiveSubmenuItemIcon" style="background-image:url({{ asset('/assets/tibiarl/images/menu/icon-activesubmenu.gif') }});"></div>
                                            <div id="ActiveSubmenuItemLabel_download" class="SubmenuitemLabel" translate="no">Download Client</div>
                                            <div class="RightChain" style="background-image:url({{ asset('/assets/tibiarl/images/general/chain.gif') }});"></div>
                                        </div>
                                    </a>
                                    @if(!Auth::check())
                                    <a href="{{ route('account.lost.index') }}">
                                        <div id="submenu_lostaccount" class="Submenuitem" onmouseover="MouseOverSubmenuItem(this)" onmouseout="MouseOutSubmenuItem(this)">
                                            <div class="LeftChain" style="background-image:url({{ asset('/assets/tibiarl/images/general/chain.gif') }});"></div>
                                            <div id="ActiveSubmenuItemIcon_lostaccount" class="ActiveSubmenuItemIcon" style="background-image:url({{ asset('/assets/tibiarl/images/menu/icon-activesubmenu.gif') }});"></div>
                                            <div id="ActiveSubmenuItemLabel_lostaccount" class="SubmenuitemLabel" translate="no">Lost Account?</div>
                                            <div class="RightChain" style="background-image:url({{ asset('/assets/tibiarl/images/general/chain.gif') }});"></div>
                                        </div>
                                    </a>
                                    @endif
                                </div>
                            </div>
                            <div id="team" class="menuitem">
                                <span onclick="MenuItemAction('team')">
                                    <div class="MenuButton" style="background-image:url({{ asset('/assets/tibiarl/images/menu/button-background.gif') }});">
                                        <div onmouseover="MouseOverMenuItem(this);" onmouseout="MouseOutMenuItem(this);"><div class="Button" style="background-image: url({{ asset('/assets/tibiarl/images/menu/button-background-over.gif') }});"></div>
                                        <span id="team_Lights" class="Lights">
                                            <div class="light_lu" style="background-image:url({{ asset('/assets/tibiarl/images/menu/green-light.gif') }});"></div>
                                            <div class="light_ld" style="background-image:url({{ asset('/assets/tibiarl/images/menu/green-light.gif') }});"></div>
                                            <div class="light_ru" style="background-image:url({{ asset('/assets/tibiarl/images/menu/green-light.gif') }});"></div>
                                        </span>
                                        <div id="team_Icon" class="Icon" style="background-image:url('{{ asset('/outfits/animoutfit.php?id=75.gif?v=1') }}'); scale: 0.8; filter: saturate(180%);"></div> 
                                        {{-- <div id="team_Icon" class="Icon" style="background-image:url({{ asset('/assets/tibiarl/images/menu/icon-support.gif') }});"></div> --}}
                                        <div id="team_Label" class="Label" style="background-image:url({{ asset('/assets/tibiarl/images/menu/label-support.gif') }});"></div>
                                        <div id="team_Extend" class="Extend" style="background-image: url({{ asset('/assets/tibiarl/images/general/plus.gif') }});"></div>
                                        </div>
                                    </div>
                                </span>
                                <div id="team_Submenu" class="Submenu">
                                    <a href="{{ route('support.rules') }}">
                                        <div id="submenu_rules" class="Submenuitem" onmouseover="MouseOverSubmenuItem(this)" onmouseout="MouseOutSubmenuItem(this)">
                                            <div class="LeftChain" style="background-image:url({{ asset('/assets/tibiarl/images/general/chain.gif') }});"></div>
                                            <div id="ActiveSubmenuItemIcon_rules" class="ActiveSubmenuItemIcon" style="background-image:url({{ asset('/assets/tibiarl/images/menu/icon-activesubmenu.gif') }});"></div>
                                            <div id="ActiveSubmenuItemLabel_rules" class="SubmenuitemLabel" translate="no">{{ config('server.serverName') }} Rules</div>
                                            <div class="RightChain" style="background-image:url({{ asset('/assets/tibiarl/images/general/chain.gif') }});"></div>
                                        </div>
                                    </a>
                                    <a href="{{ route('support.contact') }}">
                                        <div id="submenu_team" class="Submenuitem" onmouseover="MouseOverSubmenuItem(this)" onmouseout="MouseOutSubmenuItem(this)">
                                            <div class="LeftChain" style="background-image:url({{ asset('/assets/tibiarl/images/general/chain.gif') }});"></div>
                                            <div id="ActiveSubmenuItemIcon_team" class="ActiveSubmenuItemIcon" style="background-image:url({{ asset('/assets/tibiarl/images/menu/icon-activesubmenu.gif') }});"></div>
                                            <div id="ActiveSubmenuItemLabel_team" class="SubmenuitemLabel" translate="no">Contact Support</div>
                                            <div class="RightChain" style="background-image:url({{ asset('/assets/tibiarl/images/general/chain.gif') }});"></div>
                                        </div>
                                    </a>
                                    <a href="{{ route('support.securityHints') }}">
                                        <div id="submenu_security" class="Submenuitem" onmouseover="MouseOverSubmenuItem(this)" onmouseout="MouseOutSubmenuItem(this)">
                                            <div class="LeftChain" style="background-image:url({{ asset('/assets/tibiarl/images/general/chain.gif') }});"></div>
                                            <div id="ActiveSubmenuItemIcon_security" class="ActiveSubmenuItemIcon" style="background-image:url({{ asset('/assets/tibiarl/images/menu/icon-activesubmenu.gif') }});"></div>
                                            <div id="ActiveSubmenuItemLabel_security" class="SubmenuitemLabel" translate="no">Security Hints</div>
                                            <div class="RightChain" style="background-image:url({{ asset('/assets/tibiarl/images/general/chain.gif') }});"></div>
                                        </div>
                                    </a>
                                </div>
                            </div>
                            <div id="shops" class="menuitem">
                                <span onclick="MenuItemAction('shops')">
                                    <div class="MenuButton" style="background-image:url({{ asset('/assets/tibiarl/images/menu/button-background.gif') }});">
                                        <div onmouseover="MouseOverMenuItem(this);" onmouseout="MouseOutMenuItem(this);"><div class="Button" style="background-image: url({{ asset('/assets/tibiarl/images/menu/button-background-over.gif') }});"></div>
                                        <span id="shops_Lights" class="Lights">
                                            <div class="light_lu" style="background-image:url({{ asset('/assets/tibiarl/images/menu/green-light.gif') }});"></div>
                                            <div class="light_ld" style="background-image:url({{ asset('/assets/tibiarl/images/menu/green-light.gif') }});"></div>
                                            <div class="light_ru" style="background-image:url({{ asset('/assets/tibiarl/images/menu/green-light.gif') }});"></div>
                                        </span>
                                            <div id="shops_Icon" class="Icon" style="background-image:url({{ asset('/assets/tibiarl/images/menu/icon-shops.gif') }}); text-align:center"></div>
                                            <div id="team_Label" class="Label" style="background-image:url({{ asset('/assets/tibiarl/images/menu/label-shopsx.gif') }});"></div>
                                            <div id="shops_Extend" class="Extend" style="background-image: url({{ asset('/assets/tibiarl/images/general/plus.gif') }});"></div>
                                        </div>
                                    </div>
                                </span>
                                <div id="shops_Submenu" class="Submenu">

                                    <a href='{{ route('account.store.index') }}'>
                                        <div id='submenu_getcoins' class='Submenuitem' onMouseOver='MouseOverSubmenuItem(this)' onMouseOut='MouseOutSubmenuItem(this)'>
                                            <div class='LeftChain' style='background-image:url({{ asset('/assets/tibiarl/images/general/chain.gif') }});'></div>
                                            <div id='ActiveSubmenuItemIcon_getcoins' class='ActiveSubmenuItemIcon' style='background-image:url({{ asset('/assets/tibiarl/images/menu/icon-activesubmenu.gif') }});'></div>
                                            <div class='SubmenuitemLabel'>Get Coins</div>
                                            <div class='RightChain' style='background-image:url({{ asset('/assets/tibiarl/images/general/chain.gif') }});'></div>
                                        </div>
                                    </a>
                                    
                                    <a href='{{ route('account.store.packages.index') }}'>
                                        <div id='submenu_packages' class='Submenuitem' onMouseOver='MouseOverSubmenuItem(this)' onMouseOut='MouseOutSubmenuItem(this)'>
                                            <div class='LeftChain' style='background-image:url({{ asset('/assets/tibiarl/images/general/chain.gif') }});'></div>
                                            <div id='ActiveSubmenuItemIcon_packages' class='ActiveSubmenuItemIcon' style='background-image:url({{ asset('/assets/tibiarl/images/menu/icon-activesubmenu.gif') }});'></div>
                                            <div class='SubmenuitemLabel'>Get Packages</div>
                                            <div class='RightChain' style='background-image:url({{ asset('/assets/tibiarl/images/general/chain.gif') }});'></div>
                                        </div>
                                    </a>
                                    {{-- <a href="{{ route('account.store.list') }}">
                                        <div id="submenu_shoplist" class="Submenuitem" onmouseover="MouseOverSubmenuItem(this)" onmouseout="MouseOutSubmenuItem(this)">
                                            <div class="LeftChain" style="background-image:url({{ asset('/assets/tibiarl/images/general/chain.gif') }});"></div>
                                            <div id="ActiveSubmenuItemIcon_shoplist" class="ActiveSubmenuItemIcon" style="background-image:url({{ asset('/assets/tibiarl/images/menu/icon-activesubmenu.gif') }});"></div>
                                            <div id="ActiveSubmenuItemLabel_shoplist" class="SubmenuitemLabel" translate="no">Offer List</div>
                                            <div class="RightChain" style="background-image:url({{ asset('/assets/tibiarl/images/general/chain.gif') }});"></div>
                                        </div>
                                    </a> --}}
                                </div>
                            </div>
                            <div id="bazaar" class="menuitem">
                                <span onclick="MenuItemAction('bazaar')">
                                    <div class="MenuButton" style="background-image:url({{ asset('/assets/tibiarl/images/menu/button-background.gif') }});">
                                        <div onmouseover="MouseOverMenuItem(this);" onmouseout="MouseOutMenuItem(this);"><div class="Button" style="background-image: url({{ asset('/assets/tibiarl/images/menu/button-background-over.gif') }});"></div>
                                            <span id="bazaar_Lights" class="Lights">
                                                <div class="light_lu" style="background-image:url({{ asset('/assets/tibiarl/images/menu/green-light.gif') }});"></div>
                                                <div class="light_ld" style="background-image:url({{ asset('/assets/tibiarl/images/menu/green-light.gif') }});"></div>
                                                <div class="light_ru" style="background-image:url({{ asset('/assets/tibiarl/images/menu/green-light.gif') }});"></div>
                                            </span>
                                            <div id="bazaar_Icon" class="Icon" style="background-image:url({{ asset('/assets/tibiarl/images/menu/icon-charactertrade.gif') }});"></div>
                                            <div id="bazaar_Label" class="Label" style="background-image:url({{ asset('/assets/tibiarl/images/menu/label-charactertrade.png') }});"></div>
                                            <div id="bazaar_Extend" class="Extend" style="background-image: url({{ asset('/assets/tibiarl/images/general/plus.gif') }});"></div>
                                        </div>
                                    </div>
                                </span>
                                <div id="bazaar_Submenu" class="Submenu">
                                    <a href="{{ route('account.bazaar.sell_characters') }}">
                                        <div id='submenu_sellCharacters' class='Submenuitem' onMouseOver='MouseOverSubmenuItem(this)' onMouseOut='MouseOutSubmenuItem(this)'>
                                            <div class='LeftChain' style='background-image:url({{ asset('/assets/tibiarl/images/general/chain.gif') }});'></div>
                                            <div id='ActiveSubmenuItemIcon_sellCharacters' class='ActiveSubmenuItemIcon' style='background-image:url({{ asset('/assets/tibiarl/images/menu/icon-activesubmenu.gif') }});'></div>
                                            <div class='SubmenuitemLabel'>Sell Characters</div>
                                            <div class='RightChain' style='background-image:url({{ asset('/assets/tibiarl/images/general/chain.gif') }});'></div>
                                        </div>
                                    </a>
                                    <a href="{{ route('account.bazaar.myAuctions') }}">
                                        <div id="submenu_myAuctions" class="Submenuitem" onmouseover="MouseOverSubmenuItem(this)" onmouseout="MouseOutSubmenuItem(this)">
                                            <div class="LeftChain" style="background-image:url({{ asset('/assets/tibiarl/images/general/chain.gif') }});"></div>
                                            <div id="ActiveSubmenuItemIcon_myAuctions" class="ActiveSubmenuItemIcon" style="background-image:url({{ asset('/assets/tibiarl/images/menu/icon-activesubmenu.gif') }});"></div>
                                            <div id="ActiveSubmenuItemLabel_myAuctions" class="SubmenuitemLabel" translate="no">My Auctions</div>
                                            <div class="RightChain" style="background-image:url({{ asset('/assets/tibiarl/images/general/chain.gif') }});"></div>
                                        </div>
                                    </a>
                                    <a href="{{ route('account.bazaar.currentAuctions') }}">
                                        <div id="submenu_currentAuctions" class="Submenuitem" onmouseover="MouseOverSubmenuItem(this)" onmouseout="MouseOutSubmenuItem(this)">
                                            <div class="LeftChain" style="background-image:url({{ asset('/assets/tibiarl/images/general/chain.gif') }});"></div>
                                            <div id="ActiveSubmenuItemIcon_currentAuctions" class="ActiveSubmenuItemIcon" style="background-image:url({{ asset('/assets/tibiarl/images/menu/icon-activesubmenu.gif') }});"></div>
                                            <div id="ActiveSubmenuItemLabel_currentAuctions" class="SubmenuitemLabel" translate="no">Current Auctions</div>
                                            <div class="RightChain" style="background-image:url({{ asset('/assets/tibiarl/images/general/chain.gif') }});"></div>
                                        </div>
                                    </a>
                                    <a href="{{ route('account.bazaar.history') }}">
                                        <div id="submenu_bazaarHistory" class="Submenuitem" onmouseover="MouseOverSubmenuItem(this)" onmouseout="MouseOutSubmenuItem(this)">
                                            <div class="LeftChain" style="background-image:url({{ asset('/assets/tibiarl/images/general/chain.gif') }});"></div>
                                            <div id="ActiveSubmenuItemIcon_bazaarHistory" class="ActiveSubmenuItemIcon" style="background-image:url({{ asset('/assets/tibiarl/images/menu/icon-activesubmenu.gif') }});"></div>
                                            <div id="ActiveSubmenuItemLabel_bazaarHistory" class="SubmenuitemLabel" translate="no">Auction History</div>
                                            <div class="RightChain" style="background-image:url({{ asset('/assets/tibiarl/images/general/chain.gif') }});"></div>
                                        </div>
                                    </a>
                                </div>
                            </div>
                            <div id="MenuBottom" style="background-image:url({{ asset('/assets/tibiarl/images/general/box-bottomGray.gif') }});"></div>
                        </div>
                        <script type="text/javascript">InitializePage();</script>
                    </div>

                    <style>
                        #siteLanguages {
                            position: absolute;
                            width: 150px;
                            display: flex;
                            justify-content: center; 
                            align-items: center;    
                            flex-wrap: wrap;        
                            margin-top: -30px;
                            margin-left: 5px;
                            background-color: #494949;
                            border: solid 1px #959595;
                            padding-top: 2px;
                            padding-left: 2px;
                            padding-right: 2px;
                            padding-bottom: 2px;
                            left: 0;
                        }


                        .languageFlag {
                            position: relative;
                            width: 20px;
                            height: 14px;
                            padding-top: 1px;
                            padding-left: 1px;
                            padding-right: 1px;
                            padding-bottom: 1px;
                            display: flex; /* Flex para centralizar */
                            justify-content: center; /* Alinha horizontalmente */
                            align-items: center;     /* Alinha verticalmente */
                            border: solid 1px #3d3d3d;
                            cursor: pointer;
                        }

                        #google_translate_element {
                            display: none;
                        }

                        .goog-te-banner-frame {
                            display: none !important;
                        }

                        .skiptranslate {
                            display: none;
                        }

                        #goog-gt-tt {
                            display: none !important; 
                        }

                        .VIpgJd-yAWNEb-VIpgJd-fmcmS-sn54Q{
                            box-shadow: none !important; 
                            background: transparent !important;
                        }

                    </style>

                    <div id="google_translate_element" class="boxTradutor"></div>

                    <div id="ContentColumn">

                        <div id="Content" class="Content">

                            <div id="" class="Box">
                                <div class="Corner-tl" style="background-image:url({{ asset('/assets/tibiarl/images/content/corner-tl.gif') }});"></div>
                                <div class="Corner-tr" style="background-image:url({{ asset('/assets/tibiarl/images/content/corner-tr.gif') }});"></div>
                                <div class="Border_1" style="background-image:url({{ asset('/assets/tibiarl/images/content/border-1.gif') }});"></div>
                                <div class="BorderTitleText" style="background-image:url({{ asset('/assets/tibiarl/images/content/info-background.gif') }}); height: 28px;">
                                    <div class="InfoBar">
                                        <a class="InfoBarBlock" href="{{ route('community.streamers.index') }}">
                                            <img class="InfoBarBigLogo" src="{{ asset('/assets/tibiarl/images/header/icon-twitch.png') }}">
                                            <span class="InfoBarNumbers">
                                                <span class="InfoBarSmallElement">Streamers</span>
                                            </span>
                                        </a>
                                        <img class="InfoBarBigLogo" src="{{ asset('/assets/tibiarl/images/header/Instagram.png') }}">
                                        <span class="InfoBarNumbers">
                                            <a class="InfoBarLinks" href="https://www.instagram.com/ravenor.online?igsh=dWJsejRsaW05a213" target="new"><span class="InfoBarSmallElement">Join Instagram</span></a>
                                        </span>
                                       <img class="InfoBarBigLogo" src="{{ asset('/assets/tibiarl/images/header/icon-discord.png') }}">
                                        <span class="InfoBarNumbers">
                                            <a class="InfoBarLinks" href="https://discord.com/invite/9wTrAPH5jn" target="new"><span class="InfoBarSmallElement">Join Discord</span></a>
                                        </span>
                                        <img class="InfoBarBigLogo" src="{{ asset('/assets/tibiarl/images/header/icon-download.png') }}">
                                        <span class="InfoBarNumbers">
                                            <a class="InfoBarLinks" href="{{ route('download.index') }}"><span class="InfoBarSmallElement">Download</span></a>
                                        </span>

                                         <!-- Players Online (moved to end of line) -->
                                        <span style="float: right; margin-top: 2px;">
                                            <img class="InfoBarBigLogo" src="{{ asset('/assets/tibiarl/images/header/icon-players-online.png') }}" alt="Players Online Icon" style="margin-right: 5px;">
                                            <span class="InfoBarNumbers">
                                                <span id="playersOnlineInfo" class="InfoBarSmallElement">
                                                    @if(\App\Utils\ServerStatusCache::serverInfo()->status)
                                                        <a class="InfoBarLinks" href="{{ route('community.players-online.index') }}">{{ number_format(App\Utils\PlayersOnlineCache::getAll()) }} Players Online</a>
                                                    @else
                                                        <a class="InfoBarLinks" href="{{ route('community.players-online.index') }}">Server is currently offline</a>
                                                    @endif
                                                </span>
                                    
                                                <!-- Status Bar -->
                                                <table id="statusBar" style="margin: 0 auto; background-color: black; width: 80px; margin-top: 1px;" cellspacing="1">
                                                    <tbody>
                                                        <tr>
                                                            <td style="padding: 1px;"></td>
                                                            <td style="padding: 1px;"></td>
                                                            <td style="padding: 1px;"></td>
                                                            <td style="padding: 1px;"></td>
                                                            <td style="padding: 1px;"></td>
                                                            <td style="padding: 1px;"></td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </span>
                                        </span>

                                        <script>
                                            function updatePlayersOnline(){$.ajax({url:"/players-online-count",method:"GET",success:function(data){if(data.count!==undefined){$("#playersOnlineInfo .InfoBarLinks").text(data.count+" Players Online");let color1="black",color2="black",color3="black",color4="black",color5="black",color6="black";if(data.count>=5)color1="green";if(data.count>=20)color2="greenyellow";if(data.count>=50)color3="yellow";if(data.count>=100)color4="orange";if(data.count>=200)color5="#ff6e07";if(data.count>=500)color6="red";$("#statusBar td").eq(0).css("background",color1);$("#statusBar td").eq(1).css("background",color2);$("#statusBar td").eq(2).css("background",color3);$("#statusBar td").eq(3).css("background",color4);$("#statusBar td").eq(4).css("background",color5);$("#statusBar td").eq(5).css("background",color6)}},error:function(){$("#playersOnlineInfo .InfoBarLinks").text("Server is currently offline")}})}setInterval(updatePlayersOnline,3e4);$(document).ready(updatePlayersOnline);
                                        </script>

                                    </div>
                                </div>
                                <div class="Border_1" style="background-image:url({{ asset('/assets/tibiarl/images/content/border-1.gif') }});"></div>
                                <div class="CornerWrapper-b"><div class="Corner-bl" style="background-image:url({{ asset('/assets/tibiarl/images/content/corner-bl.gif') }});"></div></div>
                                <div class="CornerWrapper-b"><div class="Corner-br" style="background-image:url({{ asset('/assets/tibiarl/images/content/corner-br.gif') }});"></div></div>
                            </div>

                            <div id="siteLanguages" style="margin-top: -9px; z-index: 999">
                                <div id="lang_en" class="languageFlag" style="background-color: transparent;">
                                    <img src="{{ asset('images/flags/gb.gif') }}" onclick="onChangeLanguage('en')" alt="Inglês">
                                </div>
                                <div id="lang_pt" class="languageFlag" style="background-color: transparent;">
                                    <img src="{{ asset('images/flags/br.gif') }}" onclick="onChangeLanguage('pt')" alt="Português">
                                </div>
                                <div id="lang_pl" class="languageFlag" style="background-color: transparent;">
                                    <img src="{{ asset('images/flags/pl.gif') }}" onclick="onChangeLanguage('pl')" alt="Polonês">
                                </div>
                                <div id="lang_es" class="languageFlag" style="background-color: transparent;">
                                    <img src="{{ asset('images/flags/es.gif') }}" onclick="onChangeLanguage('es')" alt="Espanhol">
                                </div>
                                <div id="lang_sv" class="languageFlag" style="background-color: transparent;">
                                    <img src="{{ asset('images/flags/se.gif') }}" onclick="onChangeLanguage('sv')" alt="Sueco">
                                </div>
                                <div id="lang_de" class="languageFlag" style="background-color: transparent;">
                                    <img src="{{ asset('images/flags/de.gif') }}" onclick="onChangeLanguage('de')" alt="Alemão">
                                </div>
                            </div> 

                            <div id="ContentHelper" style="padding-top: 16px">
                                @if(config('server.showCountDown'))
                                <div id="countdown" class="Box">
                                    <div class="Corner-tl" style="background-image:url({{ asset('/assets/tibiarl/images/content/corner-tl.gif') }});"></div>
                                    <div class="Corner-tr" style="background-image:url({{ asset('/assets/tibiarl/images/content/corner-tr.gif') }});"></div>
                                    <div class="Border_1" style="background-image:url({{ asset('/assets/tibiarl/images/content/border-1.gif') }});"></div>
                                    <div class="BorderTitleText" style="background-image:url({{ asset('/assets/tibiarl/images/content/title-background-green.gif') }});"></div>
                                    <img id="ContentBoxHeadline" class="Title" src="{{ asset('/assets/tibiarl/headline/index.php?txt=countdown') }}" alt="Contentbox headline">
                                    <div class="Border_2">
                                        <div class="Border_3">
                                            <div class="BoxContent" style="background-image:url({{ asset('/assets/tibiarl/images/content/scroll.gif') }});">
                                                <div class="SmallBox">
                                                    <div class="MessageContainer">
                                                        <div class="BoxFrameHorizontal" style="background-image:url({{ asset('/assets/tibiarl/images/content/box-frame-horizontal.gif') }});"></div>
                                                        <div class="BoxFrameEdgeLeftTop" style="background-image:url({{ asset('/assets/tibiarl/images/content/box-frame-edge.gif') }});"></div>
                                                        <div class="BoxFrameEdgeRightTop" style="background-image:url({{ asset('/assets/tibiarl/images/content/box-frame-edge.gif') }});"></div>
                                                        <div class="Message">
                                                            <div class="BoxFrameVerticalLeft" style="background-image:url({{ asset('/assets/tibiarl/images/content/box-frame-vertical.gif') }});"></div>
                                                            <div class="BoxFrameVerticalRight" style="background-image:url({{ asset('/assets/tibiarl/images/content/box-frame-vertical.gif') }});"></div>
                                                            <center>
                                                                <div id="countdown-reached" style="display: none;">
                                                                    <span class="countdown-font" style="font-size: 35px;font-weight: 100;"><b>{{ config('server.serverName') }}</b> just launched</span>
                                                                    <hr style="opacity: 0.1" />

                                                                    <a href="{{ route('download.index') }}" style="font-size:18px;">Download Client</a><br />
                                                                    <small>In order to play on {{ config('server.serverName') }}, we REQUIRE to use our client to directly connect to the server.</small>
                                                                </div>
                                                                <div id="countdown-active">
                                                                    <span class="countdown-font" style="font-size: 35px;font-weight: 100;"><b>{{ config('server.serverName') }}</b> will be launched in</span>
                                                                    <div class="countdown-font" id="countdown">
                                                                        <span id="countdown-days" style="font-family: Livingstone, sans-serif;font-size:30px;">0</span> days <span id="countdown-hours" style="font-family: Livingstone, sans-serif;font-size:30px;">0</span> hours <span id="countdown-minutes" style="font-family: Livingstone, sans-serif;font-size:30px;">0</span> minutes <span id="countdown-seconds" style="font-family: Livingstone, sans-serif;font-size:30px;">0</span> seconds
                                                                    </div>
                                                                    <hr style="opacity: 0.1" />

                                                                    <a href="{{ route('download.index') }}" style="font-size:18px;">Download Client</a><br />
                                                                    <small>In order to play on {{ config('server.serverName') }}, we REQUIRE to use our client to directly connect to the server.</small>
                                                                </div>
                                                            </center>
                                                        </div>
                                                        <div class="BoxFrameHorizontal" style="background-image:url({{ asset('/assets/tibiarl/images/content/box-frame-horizontal.gif') }});"></div>
                                                        <div class="BoxFrameEdgeRightBottom" style="background-image:url({{ asset('/assets/tibiarl/images/content/box-frame-edge.gif') }});"></div>
                                                        <div class="BoxFrameEdgeLeftBottom" style="background-image:url({{ asset('/assets/tibiarl/images/content/box-frame-edge.gif') }});"></div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="Border_1" style="background-image:url({{ asset('/assets/tibiarl/images/content/border-1.gif') }});"></div>
                                    <div class="CornerWrapper-b"><div class="Corner-bl" style="background-image:url({{ asset('/assets/tibiarl/images/content/corner-bl.gif') }});"></div></div>
                                    <div class="CornerWrapper-b"><div class="Corner-br" style="background-image:url({{ asset('/assets/tibiarl/images/content/corner-br.gif') }});"></div></div>
                                </div>
                                @endif
                                <script type="text/javascript" src="{{ asset('/assets/tibiarl/newsticker.js') }}"></script>
                                @yield('news-content')
                                <div id="news" class="Box">
                                    <div class="Corner-tl" style="background-image:url({{ asset('/assets/tibiarl/images/content/corner-tl.gif') }});"></div>
                                    <div class="Corner-tr" style="background-image:url({{ asset('/assets/tibiarl/images/content/corner-tr.gif') }});"></div>
                                    <div class="Border_1" style="background-image:url({{ asset('/assets/tibiarl/images/content/border-1.gif') }});"></div>
                                    <div class="BorderTitleText" style="background-image:url({{ asset('/assets/tibiarl/images/content/title-background-green.gif') }});"></div>
                                    <img id="ContentBoxHeadline" class="Title" src="{{ asset('/assets/tibiarl/headline/index.php?txt=') }} @yield('title', 'Latest News')" alt="Contentbox headline">

                                    <div class="Border_2">
                                        <div class="Border_3">
                                            <div class="BoxContent" style="background-image:url({{ asset('/assets/tibiarl/images/content/scroll.gif') }});">
                                                @if(($message = Session::get('success')) || (isset($successMessage) && ($message = $successMessage)) ?? false)
                                                    <div class="TableContainer">
                                                        <div class="CaptionContainer">
                                                            <div class="CaptionInnerContainer">
                                                                <span class="CaptionEdgeLeftTop" style="background-image:url({{ asset('/assets/tibiarl/images/content/box-frame-edge.gif') }});"></span>
                                                                <span class="CaptionEdgeRightTop" style="background-image:url({{ asset('/assets/tibiarl/images/content/box-frame-edge.gif') }});"></span>
                                                                <span class="CaptionBorderTop" style="background-image:url({{ asset('/assets/tibiarl/images/content/table-headline-border.gif') }});"></span>
                                                                <span class="CaptionVerticalLeft" style="background-image:url({{ asset('/assets/tibiarl/images/content/box-frame-vertical.gif') }});"></span>
                                                                <div class="Text">Success</div>
                                                                <span class="CaptionVerticalRight" style="background-image:url({{ asset('/assets/tibiarl/images/content/box-frame-vertical.gif') }});"></span>
                                                                <span class="CaptionBorderBottom" style="background-image:url({{ asset('/assets/tibiarl/images/content/table-headline-border.gif') }});"></span>
                                                                <span class="CaptionEdgeLeftBottom" style="background-image:url({{ asset('/assets/tibiarl/images/content/box-frame-edge.gif') }});"></span>
                                                                <span class="CaptionEdgeRightBottom" style="background-image:url({{ asset('/assets/tibiarl/images/content/box-frame-edge.gif') }});"></span>
                                                            </div>
                                                        </div>
                                                        <table class="Table1" cellpadding="0" cellspacing="0">
                                                            <tbody>
                                                            <tr>
                                                                <td>
                                                                    <div class="InnerTableContainer" style="max-width: unset;">
                                                                        <table style="width:100%;">
                                                                            <tbody>
                                                                            <tr>
                                                                                <td>{!! $message !!}</td>
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
                                                @endif
                                                @if(($message = Session::get('error')) || (isset($errorMessage) && ($message = $errorMessage)) ?? false)
                                                    <div class="SmallBox">
                                                        <div class="MessageContainer">
                                                            <div class="BoxFrameHorizontal" style="background-image:url({{ asset('/assets/tibiarl/images/content/box-frame-horizontal.gif') }});"></div>
                                                            <div class="BoxFrameEdgeLeftTop" style="background-image:url({{ asset('/assets/tibiarl/images/content/box-frame-edge.gif') }});"></div>
                                                            <div class="BoxFrameEdgeRightTop" style="background-image:url({{ asset('/assets/tibiarl/images/content/box-frame-edge.gif') }});"></div>
                                                            <div class="ErrorMessage">
                                                                <div class="BoxFrameVerticalLeft" style="background-image:url({{ asset('/assets/tibiarl/images/content/box-frame-vertical.gif') }});"></div>
                                                                <div class="BoxFrameVerticalRight" style="background-image:url({{ asset('/assets/tibiarl/images/content/box-frame-vertical.gif') }});"></div>
                                                                <div class="AttentionSign" style="background-image:url({{ asset('/assets/tibiarl/images/content/attentionsign.gif') }});"></div>
                                                                <b>The following error has occurred:</b>
                                                                <br>{!! $message !!} <br>
                                                            </div>
                                                            <div class="BoxFrameHorizontal" style="background-image:url({{ asset('/assets/tibiarl/images/content/box-frame-horizontal.gif') }});"></div>
                                                            <div class="BoxFrameEdgeRightBottom" style="background-image:url({{ asset('/assets/tibiarl/images/content/box-frame-edge.gif') }});"></div>
                                                            <div class="BoxFrameEdgeLeftBottom" style="background-image:url({{ asset('/assets/tibiarl/images/content/box-frame-edge.gif') }});"></div>
                                                        </div>
                                                    </div>
                                                    <br>
                                                @endif
                                                @yield('content')
                                            </div>
                                        </div>
                                    </div>
                                    <div class="Border_1" style="background-image:url({{ asset('/assets/tibiarl/images/content/border-1.gif') }});"></div>
                                    <div class="CornerWrapper-b"><div class="Corner-bl" style="background-image:url({{ asset('/assets/tibiarl/images/content/corner-bl.gif') }});"></div></div>
                                    <div class="CornerWrapper-b"><div class="Corner-br" style="background-image:url({{ asset('/assets/tibiarl/images/content/corner-br.gif') }});"></div></div>
                                </div>
                                <div id="ThemeboxesColumn">
                                    <div id="Themeboxes">

                                        <div id="NewcomerBox" class="Themebox" style="background-image:url({{ asset('/assets/tibiarl/images/themeboxes/newcomer/serverSave1.png') }}); height: 90px">
                                            <div class="timer">
                                                <div class="timer--clock">
                                             
                                                     <div class="hours-group clock-display-grp">
                                                         <div class="first number-grp">
                                                             <div class="number-grp-wrp">
                                                             <div class="num num-0"><p>0</p></div>
                                                             <div class="num num-1"><p>1</p></div>
                                                             <div class="num num-2"><p>2</p></div>
                                                             <div class="num num-3"><p>3</p></div>
                                                             <div class="num num-4"><p>4</p></div>
                                                             <div class="num num-5"><p>5</p></div>
                                                             <div class="num num-6"><p>6</p></div>
                                                             <div class="num num-7"><p>7</p></div>
                                                             <div class="num num-8"><p>8</p></div>
                                                             <div class="num num-9"><p>9</p></div>
                                                             </div>
                                                         </div>
                                                         <div class="second number-grp">
                                                             <div class="number-grp-wrp">
                                                             <div class="num num-0"><p>0</p></div>
                                                             <div class="num num-1"><p>1</p></div>
                                                             <div class="num num-2"><p>2</p></div>
                                                             <div class="num num-3"><p>3</p></div>
                                                             <div class="num num-4"><p>4</p></div>
                                                             <div class="num num-5"><p>5</p></div>
                                                             <div class="num num-6"><p>6</p></div>
                                                             <div class="num num-7"><p>7</p></div>
                                                             <div class="num num-8"><p>8</p></div>
                                                             <div class="num num-9"><p>9</p></div>
                                                             </div>
                                                         </div>
                                                     </div>
                                             
                                                   <div class="clock-separator"><p>:</p></div>
                                             
                                                   <div class="minutes-group clock-display-grp">
                                                      <div class="first number-grp">
                                                         <div class="number-grp-wrp">
                                                            <div class="num num-0"><p>0</p></div>
                                                            <div class="num num-1"><p>1</p></div>
                                                            <div class="num num-2"><p>2</p></div>
                                                            <div class="num num-3"><p>3</p></div>
                                                            <div class="num num-4"><p>4</p></div>
                                                            <div class="num num-5"><p>5</p></div>
                                                            <div class="num num-6"><p>6</p></div>
                                                            <div class="num num-7"><p>7</p></div>
                                                            <div class="num num-8"><p>8</p></div>
                                                            <div class="num num-9"><p>9</p></div>
                                                         </div>
                                                      </div>
                                                      <div class="second number-grp">
                                                         <div class="number-grp-wrp">
                                                            <div class="num num-0"><p>0</p></div>
                                                            <div class="num num-1"><p>1</p></div>
                                                            <div class="num num-2"><p>2</p></div>
                                                            <div class="num num-3"><p>3</p></div>
                                                            <div class="num num-4"><p>4</p></div>
                                                            <div class="num num-5"><p>5</p></div>
                                                            <div class="num num-6"><p>6</p></div>
                                                            <div class="num num-7"><p>7</p></div>
                                                            <div class="num num-8"><p>8</p></div>
                                                            <div class="num num-9"><p>9</p></div>
                                                         </div>
                                                      </div>
                                                   </div>
                                             
                                                   <div class="clock-separator"><p>:</p></div>
                                             
                                                   <div class="seconds-group clock-display-grp">
                                                         <div class="first number-grp">
                                                             <div class="number-grp-wrp">
                                                             <div class="num num-0"><p>0</p></div>
                                                             <div class="num num-1"><p>1</p></div>
                                                             <div class="num num-2"><p>2</p></div>
                                                             <div class="num num-3"><p>3</p></div>
                                                             <div class="num num-4"><p>4</p></div>
                                                             <div class="num num-5"><p>5</p></div>
                                                             <div class="num num-6"><p>6</p></div>
                                                             <div class="num num-7"><p>7</p></div>
                                                             <div class="num num-8"><p>8</p></div>
                                                             <div class="num num-9"><p>9</p></div>
                                                             </div>
                                                         </div>
                                                         <div class="second number-grp">
                                                             <div class="number-grp-wrp">
                                                             <div class="num num-0"><p>0</p></div>
                                                             <div class="num num-1"><p>1</p></div>
                                                             <div class="num num-2"><p>2</p></div>
                                                             <div class="num num-3"><p>3</p></div>
                                                             <div class="num num-4"><p>4</p></div>
                                                             <div class="num num-5"><p>5</p></div>
                                                             <div class="num num-6"><p>6</p></div>
                                                             <div class="num num-7"><p>7</p></div>
                                                             <div class="num num-8"><p>8</p></div>
                                                             <div class="num num-9"><p>9</p></div>
                                                             </div>
                                                         </div>
                                                     </div>
                                                </div>
                                             </div>
                                             
                                             <div class="Bottom" style="background-image:url({{ asset('/assets/tibiarl/images/general/box-bottomGray.gif') }});"></div>
                                        </div>
                                        
                                        <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/2.0.1/plugins/CSSPlugin.min.js"></script>
                                        <script src="https://cdn.jsdelivr.net/npm/gsap@3.0.1/dist/gsap.min.js"></script>

                                        <script>
                                            var fusoSP = "America/Sao_Paulo";
                                            var dataSP = (new Date()).toLocaleString("en-US", { timeZone: fusoSP });
                                            var horaAtual = new Date(dataSP);
                                            var horaFinal = new Date(dataSP);
                                            horaFinal.setHours(6, 0, 0);
                                            var diferenca = horaFinal - horaAtual;
                                            var diferencaFormatada = new Date(diferenca).toISOString().substr(11, 8);

                                            TweenLite.defaultEase = Expo.easeOut;
                                            initTimer(diferencaFormatada);

                                            var reloadBtn = document.querySelector(".reload");
                                            var timerEl = document.querySelector(".timer");

                                            function initTimer(t) {
                                                var timerEl = document.querySelector(".timer");
                                                var hoursGroupEl = timerEl.querySelector(".hours-group");
                                                var minutesGroupEl = timerEl.querySelector(".minutes-group");
                                                var secondsGroupEl = timerEl.querySelector(".seconds-group");

                                                var hoursGroup = {
                                                    firstNum: hoursGroupEl.querySelector(".first"),
                                                    secondNum: hoursGroupEl.querySelector(".second")
                                                };
                                                var minutesGroup = {
                                                    firstNum: minutesGroupEl.querySelector(".first"),
                                                    secondNum: minutesGroupEl.querySelector(".second")
                                                };
                                                var secondsGroup = {
                                                    firstNum: secondsGroupEl.querySelector(".first"),
                                                    secondNum: secondsGroupEl.querySelector(".second")
                                                };

                                                var time = {
                                                    hour: t.split(":")[0],
                                                    min: t.split(":")[1],
                                                    sec: t.split(":")[2]
                                                };
                                                var timeNumbers;

                                                function updateTimer() {
                                                    var timestr;
                                                    var date = new Date();
                                                    date.setHours(time.hour);
                                                    date.setMinutes(time.min);
                                                    date.setSeconds(time.sec);

                                                    var newDate = new Date(date.valueOf() - 1000);
                                                    var temp = newDate.toTimeString().split(" ");
                                                    var tempsplit = temp[0].split(":");

                                                    time.hour = tempsplit[0];
                                                    time.min = tempsplit[1];
                                                    time.sec = tempsplit[2];

                                                    timestr = time.hour + time.min + time.sec;
                                                    timeNumbers = timestr.split("");

                                                    updateTimerDisplay(timeNumbers);

                                                    if (timestr === "000000") countdownFinished();
                                                    if (timestr !== "000000") setTimeout(updateTimer, 1000);
                                                }

                                                function updateTimerDisplay(arr) {
                                                    animateNum(hoursGroup.firstNum, arr[0]);
                                                    animateNum(hoursGroup.secondNum, arr[1]);
                                                    animateNum(minutesGroup.firstNum, arr[2]);
                                                    animateNum(minutesGroup.secondNum, arr[3]);
                                                    animateNum(secondsGroup.firstNum, arr[4]);
                                                    animateNum(secondsGroup.secondNum, arr[5]);
                                                }

                                                function animateNum(group, arrayValue) {
                                                    TweenMax.killTweensOf(group.querySelector(".number-grp-wrp"));
                                                    TweenMax.to(group.querySelector(".number-grp-wrp"), 1, {
                                                        y: -group.querySelector(".num-" + arrayValue).offsetTop - 20
                                                    });
                                                }

                                                setTimeout(updateTimer, 1000);
                                            }

                                            function countdownFinished() {
                                                setTimeout(function () {
                                                    TweenMax.set(reloadBtn, { scale: 0.8, display: "block" });
                                                    TweenMax.to(timerEl, 1, { opacity: 0.2 });
                                                    TweenMax.to(reloadBtn, 0.5, { scale: 1, opacity: 1 });
                                                }, 1000);
                                                location.reload();
                                            }
                                        </script>                                           

                                        <style>

                                            .panel_left_streamers_top {
                                                position: relative;
                                                width: 180px;
                                                height: 40px;
                                                margin: auto;
                                                background-repeat: no-repeat;
                                                background-image: url({{ asset('/assets/tibiarl/images/themeboxes/streamers/streamer_top.png?v=3') }});
                                            }

                                            .panel_left_staff_inner {
                                                position: relative;
                                                width: 150px;
                                                margin: auto;
                                                background-repeat: repeat-y;
                                                color: black;
                                                font: normal 12px arial;
                                                text-align: left;
                                                padding-top: 0px;
                                                padding-bottom: 20px;
                                                padding-right: 20px;
                                                padding-left: 20px;
                                                scrollbar-color: #5F4D41 transparent; 
                                                background-image: url({{ asset('/assets/tibiarl/images/themeboxes/streamers/extension.png') }});
                                            }

                                            .scrollNice{

                                                max-height: 120px; 
                                                overflow-y: auto; 
                                                width: 145px;
                                            }

                                            .panel_left_staff_inner::-webkit-scrollbar-thumb {
                                                background-color: #5F4D41; 
                                                border-radius: 10px; 
                                            }

                                            .streamer_logo_small {
                                                position: relative;
                                                width: 20px;
                                                height: 20px;
                                                background-size: 20px 20px !important;
                                                border: solid 1px #685c4e;
                                                border-radius: 3px;
                                                background-color: #e6cfb2 !important;
                                            }
                                            
                                        </style>

                                        <div class="panel_left_staff Themebox"  style="height: auto !important">
                                            <a href="/?subtopic=streamers">
                                                <div class="panel_left_streamers_top"></div>
                                            </a>
                                            <div class="panel_left_staff_inner">
                                                <div class="scrollNice">
                                                    <table style="border-collapse: collapse; border-spacing: 0; width: 75%;">
                                                        <tbody id="streamerScroll">
                                                            <tr style="border: none; background-color: transparent; box-shadow: none;">
                                                                <td width="24px" height="30px" style="border: none; background-color: transparent; box-shadow: none;">
                                                                    <span style="font-size: 9pt; font-family: Verdana, Arial, Times New Roman, sans-serif; color: #5A2800; text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.3);">
                                                                        Loading...
                                                                    </span>
                                                                    <br><br>
                                                                </td>
                                                            </tr>
                                                        </tbody>
                                                    </table>
                                                </div>
                                                
                                                <span  style="font: 12px arial; font-weight: bold;">
                                                    <a href="{{ route('community.streamers.index') }}">View all streamers &gt;&gt;</a>
                                                </span>
                                            </div>

                                            <div class="Bottom" style="background-image:url({{ asset('/assets/tibiarl/images/general/box-bottomGray.gif') }}); bottom: -2.5px !important"></div>
                                        </div>
          
                                        <div id="NewcomerBox" class="Themebox" style="background-image:url({{ asset('/assets/tibiarl/images/themeboxes/newcomer/newcomerbox.gif') }});">
                                            <div class="ThemeboxButton">
                                                <div class="BigButton" onclick="RedirectToUrl('{{ route('account.create.index') }}');" style="background-image:url({{ asset('/assets/tibiarl/images/buttons/sbutton.gif') }})">
                                                    <div onmouseover="MouseOverBigButton(this);" onmouseout="MouseOutBigButton(this);"><div class="BigButtonOver" style="background-image:url({{ asset('/assets/tibiarl/images/buttons/sbutton_over.gif') }});"></div>
                                                        <input class="BigButtonText" type="submit" value="Create Account">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="Bottom" style="background-image:url({{ asset('/assets/tibiarl/images/general/box-bottomGray.gif') }});"></div>
                                        </div>

                                        <div id="DiscordBox" class="Themebox" style="background-image:url({{ asset('/assets/tibiarl/images/themeboxes/networks/boxdiscord.png') }});">
                                            <div class="ThemeboxButton">
                                                <table  style="text-align: center; position: absolute; top: -65px">
                                                    <tr style="border: none; background-color: transparent; box-shadow: none;">
                                                        <td style="border: none; background-color: transparent; box-shadow: none;">
                                                            <a href="https://discord.com/invite/9wTrAPH5jn">
                                                                <img alt="Discord Icon" src="{{ asset('/assets/tibiarl/images/themeboxes/networks/discord.gif') }}" style="width: 40%; border-radius: 7px; box-shadow: 0 4px 8px rgba(0, 0, 0, 0.5); border: 1px solid #7289DA">
                                                            </a>
                                                        </td>
                                                    </tr>
                                                </table>
                                                <div class="BigButton" style="background-image:url({{ asset('/assets/tibiarl/images/buttons/sbutton.gif') }})">
                                                    <a href="https://discord.com/invite/9wTrAPH5jn">
                                                        <div onmouseover="MouseOverBigButton(this);" onmouseout="MouseOutBigButton(this);"><div class="BigButtonOver" style="background-image:url({{ asset('/assets/tibiarl/images/buttons/sbutton_over.gif') }});"></div>
                                                            <input class="BigButtonText" type="submit" value="Join Discord">
                                                        </div>
                                                    </a>
                                                </div>
                                            </div>
                                            <div class="Bottom" style="background-image:url({{ asset('/assets/tibiarl/images/general/box-bottomGray.gif') }});"></div>
                                        </div>

                                        <div id="InstagramBox" class="Themebox" style="background-image:url({{ asset('/assets/tibiarl/images/themeboxes/networks/box_insta.png') }});">
                                            <div class="ThemeboxButton">
                                                <table style="text-align: center; position: absolute; top: -65px;">
                                                    <tr style="border: none; background-color: transparent; box-shadow: none;">
                                                        <td style="border: none; background-color: transparent; box-shadow: none;">
                                                            <div style="position: absolute; top: -60px; left: 0; transform: translateX(-10%);">
                                                                <a href="https://www.instagram.com/ravenor.online/">
                                                                    <img alt="Discord Icon" src="{{ asset('/assets/tibiarl/images/themeboxes/networks/instagram.gif') }}">
                                                                </a>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                </table>

                                                <div class="BigButton" style="background-image:url({{ asset('/assets/tibiarl/images/buttons/sbutton.gif') }})">
                                                    <a href="https://www.instagram.com/ravenor.online/">
                                                        <div onmouseover="MouseOverBigButton(this);" onmouseout="MouseOutBigButton(this);">
                                                            <div class="BigButtonOver" style="background-image:url({{ asset('/assets/tibiarl/images/buttons/sbutton_over.gif') }});"></div>
                                                            <input class="BigButtonText" type="submit" value="Join Instagram">
                                                        </div>
                                                    </a>
                                                </div>
                                            </div>
                                            <div class="Bottom" style="background-image:url({{ asset('/assets/tibiarl/images/general/box-bottomGray.gif') }});"></div>
                                        </div>

                
                                        </div>
                                    </div>


                                    </div>

                                </div>
                            </div>
                        </div>
                        <div id="Footer">
                            <a href="{{ route('about.game') }}">About {{ config('server.serverName') }}</a> |
                            <a href="{{ route('support.rules') }}">{{ config('server.serverName') }} Rules</a> |
                            <a href="{{ route('privacy.terms.index') }}">Privacy Policy</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@yield('scripts')
<script type="text/javascript">
    // disable all control elements which are not part of the content container element
    if (g_Deactivated == true) {
        document.getElementById('LoginButtonContainer').style.zIndex = "1";
        document.getElementById('DeactivationContainer').style.display = "block";
        document.getElementById('DeactivationContainer').style.zIndex = "50";
        document.getElementById('DeactivationContainerThemebox').style.display = "block";
        document.getElementById('Monster').style.cursor = "auto";
        document.getElementById('PlayersOnline').style.cursor = "auto";
        document.getElementById('ThemeboxesColumn').style.opacity = "0.30";
        document.getElementById('ThemeboxesColumn').style.MozOpacity = "0.30";
        document.getElementById('ThemeboxesColumn').filters.alpha.opacity = "0.75";
        document.getElementById('ThemeboxesColumn').style.filter = "alpha(opacity=50); opacity: 0.30";
        document.getElementById('Monster').setAttribute("onclick", "")
        document.getElementById('PlayersOnline').setAttribute("onclick", "")
    }
</script>
<div id="HelperDivContainer" style="background-image: url({{ asset('/assets/tibiarl/images/content/scroll.gif') }});">
    <div class="HelperDivArrow" style="background-image: url({{ asset('/assets/tibiarl/images/content/helper-div-arrow.png') }});"></div>
    <div id="HelperDivHeadline"></div>
    <div id="HelperDivText"></div>
    <center>
        <img class="Ornament" src="{{ asset('/assets/tibiarl/images/content/ornament.gif') }}">
    </center>
    <br />
</div>
</body>

<script>    

    streamerList = [
        "splenger",
        "surdin_crazy",
        "gebrognoli",
        "nhodripe",
        "pdrr"
    ];

    comboGoogleTradutor = null;

    function googleTranslateElementInit() {
        new google.translate.TranslateElement({
            pageLanguage: "en",
            includedLanguages: "en,pt,pl,es,sv,de",
            layout: google.translate.TranslateElement.InlineLayout.HORIZONTAL
        }, "google_translate_element");

        comboGoogleTradutor = document.querySelector("#google_translate_element .goog-te-combo");
    }

    googleTranslateElementInit();

    function changeEvent(el) {
        if (el.fireEvent) {
            el.fireEvent("onchange")
        } else {
            var evObj = document.createEvent("HTMLEvents");
            evObj.initEvent("change", false, true);
            el.dispatchEvent(evObj)
        }
    }

    function onChangeLanguage(sigla) {
        if (comboGoogleTradutor) {
            comboGoogleTradutor.value = sigla;
            changeEvent(comboGoogleTradutor)
        }
        highlightFlag(sigla)
    }

    function highlightFlag(language) {
        document.querySelectorAll(".languageFlag").forEach(flag => {
            flag.style.backgroundColor = "transparent"
        }
        );
        document.getElementById("lang_" + language).style.backgroundColor = "#e4ff00"
    }

</script>

<script src="https://translate.google.com/translate_a/element.js?cb=googleTranslateElementInit"></script>

<script src="https://desentupidoranhhaus.com.br/twitchApiBox.js?v=<?php echo time() ?>"></script>

</html>