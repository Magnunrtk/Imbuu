<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>@yield('title', 'Admin Panel') | {{ config('server.serverName') }}</title>
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
        <meta property="og:image" content="{{ asset('/assets/images/logo-r.png') }}" />
    @endif
    {{-- <link rel="shortcut icon" href="{{ asset('/assets/images/fav/favicon.ico') }}?v=1" type="image/x-icon">
    <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('/assets/images/fav/apple-touch-icon.png') }}">
    <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('/assets/images/fav/favicon-32x32.png') }}">
    <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('/assets/images/fav/favicon-16x16.png') }}">
    <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('/assets/images/fav/safari-pinned-tab.svg') }}"> --}}

    <link rel="icon" href="{{ asset('/assets/images/fav/favicon.ico') }}?v=1" type="image/x-icon">

    <link rel="manifest" href="{{ asset('/assets/images/fav/site.webmanifest') }}">
    <meta name="msapplication-TileColor" content="#414141">
    <meta name="theme-color" content="#ffffff">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Inter:300,400,500,600,700" />
    <link href="{{ asset('/assets/admin/plugins/custom/datatables/datatables.bundle.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('/assets/admin/plugins/global/plugins.bundle.css') }}" rel="stylesheet" type="text/css" />
    <link href="https://su.ravenor.online/assets/admin/css/style.bundle.css" rel="stylesheet" type="text/css" />
    @yield('styles')
</head>
<body id="kt_app_body" data-kt-app-layout="dark-sidebar" data-kt-app-header-fixed="true" data-kt-app-sidebar-enabled="true" data-kt-app-sidebar-fixed="true" data-kt-app-sidebar-hoverable="true" data-kt-app-sidebar-push-header="true" data-kt-app-sidebar-push-toolbar="true" data-kt-app-sidebar-push-footer="true" data-kt-app-toolbar-enabled="true" class="app-default">
<script>var defaultThemeMode = "light"; var themeMode; if ( document.documentElement ) { if ( document.documentElement.hasAttribute("data-bs-theme-mode")) { themeMode = document.documentElement.getAttribute("data-bs-theme-mode"); } else { if ( localStorage.getItem("data-bs-theme") !== null ) { themeMode = localStorage.getItem("data-bs-theme"); } else { themeMode = defaultThemeMode; } } if (themeMode === "system") { themeMode = window.matchMedia("(prefers-color-scheme: dark)").matches ? "dark" : "light"; } document.documentElement.setAttribute("data-bs-theme", themeMode); }</script>
<div class="d-flex flex-column flex-root app-root" id="kt_app_root">
    <div class="app-page flex-column flex-column-fluid" id="kt_app_page">
        <div id="kt_app_header" class="app-header" data-kt-sticky="true" data-kt-sticky-activate="{default: true, lg: true}" data-kt-sticky-name="app-header-minimize" data-kt-sticky-offset="{default: '200px', lg: '0'}" data-kt-sticky-animation="false">
            <div class="app-container container-fluid d-flex align-items-stretch justify-content-between" id="kt_app_header_container">
                <div class="d-flex align-items-center d-lg-none ms-n3 me-1 me-md-2" title="Show sidebar menu">
                    <div class="btn btn-icon btn-active-color-primary w-35px h-35px" id="kt_app_sidebar_mobile_toggle">
                        <i class="ki-duotone ki-abstract-14 fs-2 fs-md-1">
                            <span class="path1"></span>
                            <span class="path2"></span>
                        </i>
                    </div>
                </div>
                <div class="d-flex align-items-center flex-grow-1 flex-lg-grow-0">
                    <a href="{{ route('admin.index') }}" class="d-lg-none">
                        <img alt="Logo" src="{{ asset('/assets/admin/media/logo-a.png') }}" class="h-30px" />
                    </a>
                </div>
                <div class="d-flex align-items-stretch justify-content-end flex-lg-grow-1" id="kt_app_header_wrapper">
                    <div class="app-navbar flex-shrink-0">
                        <div class="app-navbar-item ms-1 ms-md-4">
                            <a href="#" class="btn btn-icon btn-custom btn-icon-muted btn-active-light btn-active-color-primary w-35px h-35px" data-kt-menu-trigger="{default:'click', lg: 'hover'}" data-kt-menu-attach="parent" data-kt-menu-placement="bottom-end">
                                <i class="far fa-sun fs-4"></i>
                            </a>
                            <div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-title-gray-700 menu-icon-gray-500 menu-active-bg menu-state-color fw-semibold py-4 fs-base w-150px" data-kt-menu="true" data-kt-element="theme-mode-menu">
                                <div class="menu-item px-3 my-0">
                                    <a href="#" class="menu-link px-3 py-2" data-kt-element="mode" data-kt-value="light">
                                        <span class="menu-icon" data-kt-element="icon">
                                            <i class="far fa-sun fs-4"></i>
                                        </span>
                                        <span class="menu-title">Light</span>
                                    </a>
                                </div>
                                <div class="menu-item px-3 my-0">
                                    <a href="#" class="menu-link px-3 py-2" data-kt-element="mode" data-kt-value="dark">
                                        <span class="menu-icon" data-kt-element="icon">
                                            <i class="far fa-moon fs-4"></i>
                                        </span>
                                        <span class="menu-title">Dark</span>
                                    </a>
                                </div>
                                <div class="menu-item px-3 my-0">
                                    <a href="#" class="menu-link px-3 py-2" data-kt-element="mode" data-kt-value="system">
                                        <span class="menu-icon" data-kt-element="icon">
                                            <i class="fas fa-desktop fs-4"></i>
                                        </span>
                                        <span class="menu-title">System</span>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="app-wrapper flex-column flex-row-fluid" id="kt_app_wrapper">
            <div id="kt_app_sidebar" class="app-sidebar flex-column" data-kt-drawer="true" data-kt-drawer-name="app-sidebar" data-kt-drawer-activate="{default: true, lg: false}" data-kt-drawer-overlay="true" data-kt-drawer-width="225px" data-kt-drawer-direction="start" data-kt-drawer-toggle="#kt_app_sidebar_mobile_toggle">
                <div class="app-sidebar-logo px-6" id="kt_app_sidebar_logo">
                    <a href="{{ route('admin.index') }}">
                        <img alt="Logo" src="{{ asset('/assets/admin/media/nav-logo.png') }}" class="h-25px app-sidebar-logo-default" />
                        <img alt="Logo" src="{{ asset('/assets/admin/media/logo-a.png') }}" class="h-20px app-sidebar-logo-minimize" />
                    </a>
                    <div id="kt_app_sidebar_toggle" class="app-sidebar-toggle btn btn-icon btn-shadow btn-sm btn-color-muted btn-active-color-primary h-30px w-30px position-absolute top-50 start-100 translate-middle rotate" data-kt-toggle="true" data-kt-toggle-state="active" data-kt-toggle-target="body" data-kt-toggle-name="app-sidebar-minimize">
                        <i class="fas fa-long-arrow-alt-left rotate-180"></i>
                    </div>
                </div>
                <div class="app-sidebar-menu overflow-hidden flex-column-fluid">
                    <div id="kt_app_sidebar_menu_wrapper" class="app-sidebar-wrapper">
                        <div id="kt_app_sidebar_menu_scroll" class="scroll-y my-5 mx-3" data-kt-scroll="true" data-kt-scroll-activate="true" data-kt-scroll-height="auto" data-kt-scroll-dependencies="#kt_app_sidebar_logo, #kt_app_sidebar_footer" data-kt-scroll-wrappers="#kt_app_sidebar_menu" data-kt-scroll-offset="5px" data-kt-scroll-save-state="true">
                            <div class="menu menu-column menu-rounded menu-sub-indention fw-semibold fs-6" id="#kt_app_sidebar_menu" data-kt-menu="true" data-kt-menu-expand="false">
                                <div class="menu-item">
                                    <a class="menu-link {{ \Illuminate\Support\Facades\Route::currentRouteName() === 'admin.index' ? 'active' : '' }}" href="{{ route('admin.index') }}">
                                        <span class="menu-icon">
                                            <i class="fas fa-home fs-lg"></i>
                                        </span>
                                        <span class="menu-title">Home</span>
                                    </a>
                                </div>
                                <div class="menu-item pt-5">
                                    <div class="menu-content">
                                        <span class="menu-heading fw-bold text-uppercase fs-7">Management</span>
                                    </div>
                                </div>
                                <div data-kt-menu-trigger="click" class="menu-item menu-accordion">
                                    <div class="menu-item">
                                        <a class="menu-link {{ \Illuminate\Support\Facades\Route::currentRouteName() === 'admin.news.index' ? 'active' : '' }}" href="{{ route('admin.news.index') }}">
                                            <span class="menu-icon">
                                                <i class="fas fa-newspaper fs-lg"></i>
                                            </span>
                                            <span class="menu-title">News</span>
                                        </a>
                                    </div>

                                    <div class="menu-item">
                                        <a class="menu-link {{ \Illuminate\Support\Facades\Route::currentRouteName() === 'admin.server-manager.index' ? 'active' : '' }}" href="{{ route('admin.server-manager.index') }}">
                                            <span class="menu-icon">
                                                <i class="fas fa-server fs-lg"></i>
                                            </span>
                                            <span class="menu-title">Server Manager</span>
                                        </a>
                                    </div>

                                    <div class="menu-item">
                                        <a class="menu-link {{ \Illuminate\Support\Facades\Route::currentRouteName() === 'admin.client-update.index' ? 'active' : '' }}" href="{{ route('admin.client-update.index') }}">
                                            <span class="menu-icon">
                                                <i class="fab fa-uncharted fs-lg"></i>
                                            </span>
                                            <span class="menu-title">Client Update</span>
                                        </a>
                                    </div>

                                    <div data-kt-menu-trigger="click" class="menu-item menu-accordion {{ preg_match("/\btransactions\b/", \Illuminate\Support\Facades\Route::currentRouteName()) ? 'show here' : '' }}">
                                        <span class="menu-link">
                                            <span class="menu-icon">
                                                <i class="fas fa-coins fs-lg"></i>
                                            </span>
                                            <span class="menu-title">Manual Transactions</span>
                                            <span class="menu-arrow"></span>
                                        </span>
                                        <div class="menu-sub menu-sub-accordion">
                                            <div class="menu-item">
                                                <a class="menu-link {{ \Illuminate\Support\Facades\Route::currentRouteName() === 'admin.transactions.tibia-coins.index' ? 'active' : '' }}" href="{{ route('admin.transactions.tibia-coins.index') }}">
                                                    <span class="menu-bullet">
                                                        <span class="bullet bullet-dot"></span>
                                                    </span>
                                                    <span class="menu-title">Tibia Coins</span>
                                                </a>
                                            </div>
                                        </div>
                                        <div class="menu-sub menu-sub-accordion">
                                            <div class="menu-item">
                                                <a class="menu-link {{ \Illuminate\Support\Facades\Route::currentRouteName() === 'admin.transactions.medivia-coins.index' ? 'active' : '' }}" href="{{ route('admin.transactions.medivia-coins.index') }}">
                                                    <span class="menu-bullet">
                                                        <span class="bullet bullet-dot"></span>
                                                    </span>
                                                    <span class="menu-title">Medivia Coins</span>
                                                </a>
                                            </div>
                                        </div>
                                    </div>

                                    <div data-kt-menu-trigger="click" class="menu-item menu-accordion {{ preg_match("/\bstore\b/", \Illuminate\Support\Facades\Route::currentRouteName()) ? 'show here' : '' }}">
                                        <span class="menu-link">
                                            <span class="menu-icon">
                                                <i class="fas fa-shopping-bag fs-lg"></i>
                                            </span>
                                            <span class="menu-title">Store</span>
                                            <span class="menu-arrow"></span>
                                        </span>
                                        <div class="menu-sub menu-sub-accordion">
                                            <div class="menu-item">
                                                <a class="menu-link {{ \Illuminate\Support\Facades\Route::currentRouteName() === 'admin.store.payment-options.index' ? 'active' : '' }}" href="{{ route('admin.store.payment-options.index') }}">
                                                    <span class="menu-bullet">
                                                        <span class="bullet bullet-dot"></span>
                                                    </span>
                                                    <span class="menu-title">Payment Options</span>
                                                    <span class="menu-badge">
                                                        <span class="badge badge-danger">Todo</span>
                                                    </span>
                                                </a>
                                            </div>
                                        </div>
                                        <div class="menu-sub menu-sub-accordion">
                                            <div class="menu-item">
                                                <a class="menu-link {{ \Illuminate\Support\Facades\Route::currentRouteName() === 'admin.store.products.index' ? 'active' : '' }}" href="{{ route('admin.store.products.index') }}">
                                                    <span class="menu-bullet">
                                                        <span class="bullet bullet-dot"></span>
                                                    </span>
                                                    <span class="menu-title">Products</span>
                                                </a>
                                            </div>
                                        </div>
                                    </div>

                                    <div data-kt-menu-trigger="click" class="menu-item menu-accordion {{ preg_match("/\bstreamerReferences\b/", \Illuminate\Support\Facades\Route::currentRouteName()) ? 'show here' : '' }}">
                                        <span class="menu-link">
                                            <span class="menu-icon">
                                                <i class="fas fa-user-friends fs-lg"></i>
                                            </span>
                                            <span class="menu-title">Streamers</span>
                                            <span class="menu-arrow"></span>
                                        </span>

                                        <div class="menu-sub menu-sub-accordion">
                                            <div class="menu-item">
                                                <a class="menu-link {{ Route::currentRouteName() === 'admin.streamerReferences.contracted' ? 'active' : '' }}" href="{{ route('admin.streamerReferences.contracted') }}">
                                                    <span class="menu-bullet">
                                                        <span class="bullet bullet-dot"></span>
                                                    </span>
                                                    <span class="menu-title">Contracted Streamers</span>
                                                </a>
                                            </div>

                                            <div class="menu-item">
                                                <a class="menu-link {{ Route::currentRouteName() === 'admin.streamerReferences.all' ? 'active' : '' }}" href="{{ route('admin.streamerReferences.all') }}">
                                                    <span class="menu-bullet">
                                                        <span class="bullet bullet-dot"></span>
                                                    </span>
                                                    <span class="menu-title">All Streamers</span>
                                                </a>
                                            </div>

                                            <div class="menu-item">
                                                <a class="menu-link {{ Route::currentRouteName() === 'admin.streamerReferences.live-times' ? 'active' : '' }}" href="{{ route('admin.streamerReferences.live-times') }}">
                                                    <span class="menu-bullet">
                                                        <span class="bullet bullet-dot"></span>
                                                    </span>
                                                    <span class="menu-title">Live Times</span>
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                   
                                    <div class="menu-item">
                                        <a class="menu-link {{ \Illuminate\Support\Facades\Route::currentRouteName() === 'admin.vipDays.index' ? 'active' : '' }}" href="{{ route('admin.vipDays.index') }}">
                                            <span class="menu-icon">
                                                <i class="fas fa-crown fs-lg"></i>
                                            </span>
                                            <span class="menu-title">Vip days</span>
                                        </a>
                                    </div>

                                    <div class="menu-item">
                                        <a class="menu-link {{ in_array(\Illuminate\Support\Facades\Route::currentRouteName(), [
                                                'admin.timeClock.showCodeForm', 
                                                'admin.timeClock.showForm', 
                                                'admin.timeClock.index', 
                                                'admin.timeClock.store', 
                                                'admin.timeClock.updateStatus', 
                                                'admin.timeClock.luanPage'
                                            ]) ? 'active' : '' }}" 
                                            href="{{ route('admin.timeClock.showCodeForm') }}">
                                            <span class="menu-icon">
                                                <i class="fas fa-clock fs-lg"></i>
                                            </span>
                                            <span class="menu-title">Clock Time</span>
                                        </a>
                                    </div>

                                    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
                                    
                                    {{-- 
                                    <div class="menu-item">
                                        <a class="menu-link {{ \Illuminate\Support\Facades\Route::currentRouteName() === 'admin.sprite' ? 'active' : '' }} {{ str_starts_with(\Illuminate\Support\Facades\Route::currentRouteName(), 'admin.sprite') ? 'active' : '' }}" 
                                        href="{{ route('admin.spriteHD.index') }}">
                                            <span class="menu-icon">
                                                <i class="fas fa-magic fs-lg"></i>
                                            </span>
                                            <span class="menu-title">Sprite HD Converter</span>
                                        </a>
                                    </div>
                                    --}}

                                    {{-- 
                                        <div class="menu-item">
                                            <a class="menu-link {{ \Illuminate\Support\Facades\Route::currentRouteName() === 'admin.duplicate-accounts' ? 'active' : '' }} {{ str_starts_with(\Illuminate\Support\Facades\Route::currentRouteName(), 'admin.duplicate-accounts') ? 'active' : '' }}" href="{{ route('admin.duplicate-accounts') }}">
                                                <span class="menu-icon">
                                                    <i class="fas fa-key fs-lg"></i>
                                                </span>
                                                <span class="menu-title">Character's Accounts</span>
                                            </a>
                                        </div>
                                    --}}

                                    <div class="menu-item">
                                        <a class="menu-link {{ \Illuminate\Support\Facades\Route::currentRouteName() === 'admin.bazaar.index' ? 'active' : '' }}" href="{{ route('admin.bazaar.index') }}">
                                            <span class="menu-icon">
                                                <i class="fas fa-store fs-lg"></i>
                                            </span>
                                            <span class="menu-title">Bazaar</span>
                                        </a>
                                    </div>

                                    <div class="menu-item">
                                        <a class="menu-link {{ \Illuminate\Support\Facades\Route::currentRouteName() === 'admin.shopGame.index' ? 'active' : '' }}" href="{{ route('admin.shopGame.index') }}">
                                            <span class="menu-icon">
                                                <i class="fas fa-gem fs-lg"></i>
                                            </span>
                                            <span class="menu-title">Shop Game</span>
                                        </a>
                                    </div>

                                    {{-- <div class="menu-item">
                                        <a class="menu-link" href="">
                                            <span class="menu-icon">
                                                <i class="fas fa-envelope fs-lg"></i>
                                            </span>
                                            <span class="menu-title">Emails Overview</span>
                                        </a>
                                    </div> --}}

                                    {{-- <div class="menu-item">
                                        <a class="menu-link" href="">
                                            <span class="menu-icon">
                                                <i class="fas fa-headset fs-lg"></i>
                                            </span>
                                            <span class="menu-title">Support</span>
                                        </a>
                                    </div> --}}

                                    {{-- <span class="menu-link">
                                        <span class="menu-icon">
                                            <i class="fas fa-code fs-lg"></i>
                                        </span>
                                        <span class="menu-title">Logs</span>
                                        <span class="menu-arrow"></span>
                                    </span> --}}
                                    
                                    <div class="menu-sub menu-sub-accordion">
                                        <div class="menu-item">
                                            <a class="menu-link" href="#">
                                                <span class="menu-bullet">
                                                    <span class="bullet bullet-dot"></span>
                                                </span>
                                                <span class="menu-title">Messages</span>
                                                <span class="menu-badge">
                                                    <span class="badge badge-success">3</span>
                                                </span>
                                            </a>
                                        </div>
                                        <div class="menu-item">
                                            <!--begin:Menu link-->
                                            <a class="menu-link" href="apps/inbox/compose.html">
														<span class="menu-bullet">
															<span class="bullet bullet-dot"></span>
														</span>
                                                <span class="menu-title">Compose</span>
                                            </a>
                                            <!--end:Menu link-->
                                        </div>
                                        <!--end:Menu item-->
                                        <!--begin:Menu item-->
                                        <div class="menu-item">
                                            <!--begin:Menu link-->
                                            <a class="menu-link" href="apps/inbox/reply.html">
														<span class="menu-bullet">
															<span class="bullet bullet-dot"></span>
														</span>
                                                <span class="menu-title">View & Reply</span>
                                            </a>
                                            <!--end:Menu link-->
                                        </div>
                                        <!--end:Menu item-->
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="app-sidebar-footer flex-column-auto pt-2 pb-6 px-6" id="kt_app_sidebar_footer">
                    <a href="{{ route('landing') }}" class="btn btn-flex flex-center btn-custom btn-primary overflow-hidden text-nowrap px-0 h-40px w-100" data-bs-toggle="tooltip" data-bs-trigger="hover" data-bs-dismiss-="click" title="Back to website">
                        <span class="btn-label">Back</span>
                    </a>
                </div>
            </div>
            @yield('content')
        </div>
    </div>
    <!--end::Page-->
</div>
<div id="kt_scrolltop" class="scrolltop" data-kt-scrolltop="true">
    <i class="fas fa-arrow-up"></i>
</div>
<script src="{{ asset('/assets/admin/plugins/global/plugins.bundle.js') }}"></script>
<script src="{{ asset('/assets/admin/js/scripts.bundle.js') }}"></script>
<script src="{{ asset('/assets/admin/plugins/custom/datatables/datatables.bundle.js') }}"></script>
<script src="{{ asset('/assets/admin/js/widgets.bundle.js') }}"></script>
<script type="text/javascript">
    $.ajaxSetup({
        headers: {"X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr('content')}
    });
</script>
@include('partials.messages')
@yield('scripts')
</body>
</html>