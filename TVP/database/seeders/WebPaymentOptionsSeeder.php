<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Models\WebPaymentOption;
use Illuminate\Database\Seeder;

class WebPaymentOptionsSeeder extends Seeder
{
    public function run(): void
    {
        WebPaymentOption::create(
            [
                'name' => 'Stripe',
                'slug' => 'stripe',
                'processing_time' => 1,
                'information' => "Information:', 'Visa, MasterCard, American Express and other, national credit or debit cards",
            ]
        );
        WebPaymentOption::create(
            [
                'name' => 'PayPal',
                'slug' => 'paypal',
                'processing_time' => 1,
                'active' => false,
            ]
        );
        WebPaymentOption::create(
            [
                'name' => 'Pix',
                'slug' => 'pix',
                'processing_time' => 1,
            ]
        );
        WebPaymentOption::create(
            [
                'name' => 'Tibia Coins',
                'slug' => 'tc',
                'processing_time' => 3,
            ]
        );
        WebPaymentOption::create(
            [
                'name' => 'Medivia Coins',
                'slug' => 'mc',
                'processing_time' => 3,
            ]
        );
    }
}
