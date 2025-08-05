<?php

declare(strict_types=1);

namespace App\Providers;

use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Str;
use IndefiniteArticle\IndefiniteArticle;
use MercadoPago\MercadoPagoConfig;
use Stripe;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
    }

    public function boot(): void
    {
        MercadoPagoConfig::setAccessToken(config('shop.payment_options')['mercado_pago']['access_token']);
        Stripe\Stripe::setApiKey(config('shop.payment_options')['stripe']['secret']);
        Str::macro('strToUrl', function (string $value) {
            return preg_replace('/\s+/', '+', $value);
        });
        Str::macro('urlToStr', function (string $value) {
            return preg_replace('/\+/', ' ', $value);
        });
        Str::macro('strWithArticle', function (string $value) {
            return IndefiniteArticle::a(title_case($value));
        });
        if (env('APP_ENV') === 'production' || env('APP_ENV') === 'staging') {
            URL::forceScheme('https');
        }
        Hash::extend("sha1", function($app)
        {
            return new Sha1Hasher();
        });
        Schema::defaultStringLength(191);
        Paginator::useBootstrap();
    }
}
