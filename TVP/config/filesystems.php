<?php

declare(strict_types=1);

return [
    'default' => env('FILESYSTEM_DRIVER', 'local'),
    'cloud' => env('FILESYSTEM_CLOUD', 's3'),
    'disks' => [
        
        'local' => [
            'driver' => 'local',
            'root' => storage_path('app'),
            'max_size' => env('UPLOAD_MAX_SIZE', 100 * 1024 * 1024), // 100MB
        ],

        'public' => [
            'driver' => 'local',
            'root' => storage_path('app/public'),
            'url' => env('APP_URL').'/',
            'visibility' => 'public',
        ],
        'guild_logos' => [
            'driver' => 'local',
            'root' => public_path('images/guilds'),
            'url' => env('APP_URL').'/',
            'visibility' => 'public',
        ],
        's3' => [
            'driver' => 's3',
            'key' => env('AWS_ACCESS_KEY_ID'),
            'secret' => env('AWS_SECRET_ACCESS_KEY'),
            'region' => env('AWS_DEFAULT_REGION'),
            'bucket' => env('AWS_BUCKET'),
            'url' => env('AWS_URL'),
            'endpoint' => env('AWS_ENDPOINT'),
        ],

    ],
    'links' => [
        public_path('storage') => storage_path('app/public'),
    ],
];
