<?php

declare(strict_types=1);

namespace App\Http;

use App\Http\Middleware\AccountPlayer;
use App\Http\Middleware\Authenticate;
use App\Http\Middleware\CheckForMaintenanceMode;
use App\Http\Middleware\ClearViewCache;
use App\Http\Middleware\EncryptCookies;
use App\Http\Middleware\Guild;
use App\Http\Middleware\GuildRank;
use App\Http\Middleware\House;
use App\Http\Middleware\OrderHistoryEmail;
use App\Http\Middleware\Player;
use App\Http\Middleware\RedirectIfAuthenticated;
use App\Http\Middleware\TrimStrings;
use App\Http\Middleware\TrustProxies;
use App\Http\Middleware\VerifyCsrfToken;
use App\Http\Middleware\World;
use Fruitcake\Cors\HandleCors;
use Illuminate\Auth\Middleware\AuthenticateWithBasicAuth;
use Illuminate\Auth\Middleware\Authorize;
use Illuminate\Auth\Middleware\EnsureEmailIsVerified;
use Illuminate\Auth\Middleware\RequirePassword;
use Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse;
use Illuminate\Foundation\Http\Kernel as HttpKernel;
use Illuminate\Foundation\Http\Middleware\ConvertEmptyStringsToNull;
use Illuminate\Foundation\Http\Middleware\ValidatePostSize;
use Illuminate\Http\Middleware\SetCacheHeaders;
use Illuminate\Routing\Middleware\SubstituteBindings;
use Illuminate\Routing\Middleware\ThrottleRequests;
use Illuminate\Routing\Middleware\ValidateSignature;
use Illuminate\Session\Middleware\AuthenticateSession;
use Illuminate\Session\Middleware\StartSession;
use Illuminate\View\Middleware\ShareErrorsFromSession;
use jeremykenedy\LaravelRoles\App\Http\Middleware\VerifyLevel;
use jeremykenedy\LaravelRoles\App\Http\Middleware\VerifyPermission;
use jeremykenedy\LaravelRoles\App\Http\Middleware\VerifyRole;

class Kernel extends HttpKernel
{
    /** @var array */
    protected $middleware = [
        HandleCors::class,
        TrustProxies::class,
        CheckForMaintenanceMode::class,
        ValidatePostSize::class,
        TrimStrings::class,
        ConvertEmptyStringsToNull::class,
    ];

    /** @var array */
    protected $middlewareGroups = [
        'web' => [
            EncryptCookies::class,
            AddQueuedCookiesToResponse::class,
            StartSession::class,
            ShareErrorsFromSession::class,
            VerifyCsrfToken::class,
            SubstituteBindings::class,
            ClearViewCache::class,
        ],
        'api' => [
            'throttle:2000,1',
            'bindings',
        ],
    ];

    /** @var array */
    protected $routeMiddleware = [
        'auth' => Authenticate::class,
        'auth.basic' => AuthenticateWithBasicAuth::class,
        'bindings' => SubstituteBindings::class,
        'cache.headers' => SetCacheHeaders::class,
        'can' => Authorize::class,
        'guest' => RedirectIfAuthenticated::class,
        'password.confirm' => RequirePassword::class,
        'signed' => ValidateSignature::class,
        'throttle' => ThrottleRequests::class,
        'verified' => EnsureEmailIsVerified::class,
        'role' => VerifyRole::class,
        'permission' => VerifyPermission::class,
        'level' => VerifyLevel::class,
        'guild' => Guild::class,
        'guild_rank' => GuildRank::class,
        'player' => Player::class,
        'house' => House::class,
        'accountPlayer' => AccountPlayer::class,
        'world' => World::class,
        'orderHistoryEmail' => OrderHistoryEmail::class,
        'streamer.auth' => \App\Http\Middleware\StreamerAuthMiddleware::class,
    ];

    /** @var array */
    protected $middlewarePriority = [
        StartSession::class,
        ShareErrorsFromSession::class,
        Authenticate::class,
        ThrottleRequests::class,
        AuthenticateSession::class,
        SubstituteBindings::class,
        Authorize::class,
    ];
}
