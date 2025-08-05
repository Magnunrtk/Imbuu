<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Models\WebPaymentOption;
use App\Models\WebShopProduct;
use Illuminate\Database\Seeder;

class WebShopProductsSeeder extends Seeder
{
    public function run(): void
    {
        $stripePm = WebPaymentOption::whereSlug('stripe')->first();
        $paypalPm = WebPaymentOption::whereSlug('paypal')->first();
        $pixPm = WebPaymentOption::whereSlug('pix')->first();
        $tcPm = WebPaymentOption::whereSlug('tc')->first();
        $mcPm = WebPaymentOption::whereSlug('mc')->first();

        WebShopProduct::create(
            [
                'image' => 'serviceid_1.png',
                'value' => 8,
                'coins' => 100,
                'prefix' => 'US$',
                'payment_option_id' => $stripePm->id,
                'decimals' => 2,
            ]
        );
        WebShopProduct::create(
            [
                'image' => 'serviceid_2.png',
                'value' => 20,
                'coins' => 260,
                'prefix' => 'US$',
                'payment_option_id' => $stripePm->id,
                'decimals' => 2,
            ]
        );
        WebShopProduct::create(
            [
                'image' => 'serviceid_3.png',
                'value' => 44,
                'coins' => 583,
                'prefix' => 'US$',
                'payment_option_id' => $stripePm->id,
                'decimals' => 2,
            ]
        );
        WebShopProduct::create(
            [
                'image' => 'serviceid_4.png',
                'value' => 68,
                'coins' => 935,
                'prefix' => 'US$',
                'payment_option_id' => $stripePm->id,
                'decimals' => 2,
            ]
        );
        WebShopProduct::create(
            [
                'image' => 'serviceid_5.png',
                'value' => 120,
                'coins' => 1710,
                'prefix' => 'US$',
                'payment_option_id' => $stripePm->id,
                'decimals' => 2,
            ]
        );
        WebShopProduct::create(
            [
                'image' => 'serviceid_1.png',
                'value' => 40,
                'coins' => 100,
                'prefix' => 'R$',
                'payment_option_id' => $pixPm->id,
                'decimals' => 2,
            ]
        );
        WebShopProduct::create(
            [
                'image' => 'serviceid_2.png',
                'value' => 100,
                'coins' => 260,
                'prefix' => 'R$',
                'payment_option_id' => $pixPm->id,
                'decimals' => 2,
            ]
        );
        WebShopProduct::create(
            [
                'image' => 'serviceid_3.png',
                'value' => 220,
                'coins' => 583,
                'prefix' => 'R$',
                'payment_option_id' => $pixPm->id,
                'decimals' => 2,
            ]
        );
        WebShopProduct::create(
            [
                'image' => 'serviceid_4.png',
                'value' => 340,
                'coins' => 935,
                'prefix' => 'R$',
                'payment_option_id' => $pixPm->id,
                'decimals' => 2,
            ]
        );
        WebShopProduct::create(
            [
                'image' => 'serviceid_5.png',
                'value' => 600,
                'coins' => 1710,
                'prefix' => 'R$',
                'payment_option_id' => $pixPm->id,
                'decimals' => 2,
            ]
        );
        WebShopProduct::create(
            [
                'image' => 'serviceid_1.png',
                'value' => 250,
                'coins' => 100,
                'suffix' => 'Tibia Coins',
                'payment_option_id' => $tcPm->id,
                'decimals' => 0,
            ]
        );
        WebShopProduct::create(
            [
                'image' => 'serviceid_2.png',
                'value' => 500,
                'coins' => 200,
                'suffix' => 'Tibia Coins',
                'payment_option_id' => $tcPm->id,
                'decimals' => 0,
            ]
        );
        WebShopProduct::create(
            [
                'image' => 'serviceid_3.png',
                'value' => 750,
                'coins' => 300,
                'suffix' => 'Tibia Coins',
                'payment_option_id' => $tcPm->id,
                'decimals' => 0,
            ]
        );
        WebShopProduct::create(
            [
                'image' => 'serviceid_4.png',
                'value' => 1000,
                'coins' => 400,
                'suffix' => 'Tibia Coins',
                'payment_option_id' => $tcPm->id,
                'decimals' => 0,
            ]
        );
        WebShopProduct::create(
            [
                'image' => 'serviceid_5.png',
                'value' => 1500,
                'coins' => 600,
                'suffix' => 'Tibia Coins',
                'payment_option_id' => $tcPm->id,
                'decimals' => 0,
            ]
        );
        WebShopProduct::create(
            [
                'image' => 'serviceid_1.png',
                'value' => 150,
                'coins' => 100,
                'suffix' => 'Medivia Coins',
                'payment_option_id' => $mcPm->id,
                'decimals' => 0,
            ]
        );
        WebShopProduct::create(
            [
                'image' => 'serviceid_2.png',
                'value' => 300,
                'coins' => 200,
                'suffix' => 'Medivia Coins',
                'payment_option_id' => $mcPm->id,
                'decimals' => 0,
            ]
        );
        WebShopProduct::create(
            [
                'image' => 'serviceid_3.png',
                'value' => 450,
                'coins' => 300,
                'suffix' => 'Medivia Coins',
                'payment_option_id' => $mcPm->id,
                'decimals' => 0,
            ]
        );
        WebShopProduct::create(
            [
                'image' => 'serviceid_4.png',
                'value' => 600,
                'coins' => 400,
                'suffix' => 'Medivia Coins',
                'payment_option_id' => $mcPm->id,
                'decimals' => 0,
            ]
        );
        WebShopProduct::create(
            [
                'image' => 'serviceid_5.png',
                'value' => 900,
                'coins' => 600,
                'suffix' => 'Medivia Coins',
                'payment_option_id' => $mcPm->id,
                'decimals' => 0,
            ]
        );
    }
}
