<?php

declare(strict_types=1);

return [
    'enabled' => true,
    'purchaseUnbanAvailable' => false,
    'extraServices' => [
        'recoveryKey' => [
            'enabled' => true,
            'price' => 250,
        ],
        'unban' => [
            'enabled' => false,
            'price' => 100,
        ]
    ],
    'unbanCoinPrice' => 100,
    'currency' => 'USD',
    'payment_methods' => ['stripe', 'pix', 'tc', 'mc'],
    'payment_options' => [
        'stripe' => [
            'key' => env('STRIPE_LIVE_MODE', true) ? env('STRIPE_LIVE_KEY', '') : env('STRIPE_DEV_KEY', ''),
            'secret' => env('STRIPE_LIVE_MODE', true) ? env('STRIPE_LIVE_SECRET', '') : env('STRIPE_DEV_SECRET', ''),
        ],
        'paypal' => [
            'mode'    => env('PAYPAL_MODE', 'sandbox'), // Can only be 'sandbox' Or 'live'. If empty or invalid, 'live' will be used.
            'sandbox' => [
                'client_id'         => env('PAYPAL_SANDBOX_CLIENT_ID', ''),
                'client_secret'     => env('PAYPAL_SANDBOX_CLIENT_SECRET', ''),
                'app_id'            => '',
            ],
            'live' => [
                'client_id'         => env('PAYPAL_LIVE_CLIENT_ID', ''),
                'client_secret'     => env('PAYPAL_LIVE_CLIENT_SECRET', ''),
                'app_id'            => env('PAYPAL_LIVE_APP_ID', ''),
            ],

            'payment_action' => env('PAYPAL_PAYMENT_ACTION', 'Sale'), // Can only be 'Sale', 'Authorization' or 'Order'
            'currency'       => env('PAYPAL_CURRENCY', 'EUR'),
            'notify_url'     => env('PAYPAL_NOTIFY_URL', ''), // Change this accordingly for your application.
            'locale'         => env('PAYPAL_LOCALE', 'en_US'), // force gateway language  i.e. it_IT, es_ES, en_US ... (for express checkout only)
            'validate_ssl'   => env('PAYPAL_VALIDATE_SSL', true), // Validate SSL when creating api client.
        ],
        'mercado_pago' => [
            'currency' => 'BRL',
            'access_token' => env('MP_ACCESS_TOKEN', ''),
            'strict_currency_check' => env('MP_CURRENCY_CHECK', true), // check if the received currency is the same as "currency"
        ],
        'tibia_coins' => [
            'receiver_name' => 'Sos Ravenor',
        ],

        'medivia_coins' => [
            'server_list' => ['Legacy', 'Destiny', 'Odyssey'],
            'characters' => [
                [
                    'server' => 'Legacy',
                    'receiver_name' => 'Ravenor on Legacy',
                    'city' => 'Eschen',
                ],
                [
                    'server' => 'Destiny',
                    'receiver_name' => 'Ravenor on Destiny',
                    'city' => 'Eschen',
                ],
                [
                    'server' => 'Odyssey',
                    'receiver_name' => 'Ravenor on Odyssey',
                    'city' => 'Eschen',
                ],
            ],
        ]
    ]
];
