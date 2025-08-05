<?php

declare(strict_types=1);

return [
    'launch' => '29/09/2023 18:00:00',
    'showCountDown' => false,
    'worlds' => ['Ravenor'],
    'clientName' => 'ravenor-client',
    'clientVersion' => '3.0',
    'multiworldEnable' => false,
    'freePremium' => false,
    'enableClientDownload' => true,
    'enableGoldenAccount' => false,
    'enablePremiumAccount' => true,
    'enableHighscore' => true,
    'enableGallery' => false,
    'serverName' => 'Ravenor',
    'serverStatusIP' => 'proxy-br02.ravenor.online',
    'serverDomain' => 'ravenor.online',
    'fullServerDomain' => 'http://localhost:8080/',
    'supportEmail' => 'support@ravenor.online',
    'serverSaveTime' => '06:00', // format hh:mm
    'serverTimeZone' => 'GMT-3',
    'backup_storage_path' => '/backup',
    'days_until_email_change' => 2,
    'newsPerPage' => 10,
    'og' => [
        'title' => 'Ravenor 7.4',
        'description' => 'Ravenor Online not just another server with sprites changed to look like 7.4',
        'name' => 'Ravenor Online | Reverse Engineering 7.4 | Brazilian Project Server',
    ],
    'information' => [
        'pz_time_after_attack' => '1 minute',
        'white_skull_time' => '15 minutes',
        'frag_decrease_time' => 10,
        'frag_ban_time' => 30,
        'red_skull_duration' => 30,
        'frags_to_red_skull' => [
            'total' => 4,
            'day' => 7,
            'week' => 15,
            'month' => 30
        ],
        'frags_to_ban' => [
            'total' => 8,
            'day' => 15,
            'week' => 30,
            'month' => 50
        ],
        'rates' => [
            'spawn' => '1',
            'loot'=> '5',
            'skill'=> '4',
            'magic_level' => '2',
            'experience' => [
                [ 'level_from' => 1,   'level_to' => 10,   'stage' => 15 ],
                [ 'level_from' => 11,  'level_to' => 20,   'stage' => 10 ],
                [ 'level_from' => 21,  'level_to' => 40,   'stage' => 8 ],
                [ 'level_from' => 41,  'level_to' => 60,   'stage' => 6 ],
                [ 'level_from' => 61,  'level_to' => 80,   'stage' => 5 ],
                [ 'level_from' => 81,  'level_to' => 110,  'stage' => 4 ],
                [ 'level_from' => 111, 'level_to' => 130,  'stage' => 3 ],
                [ 'level_from' => 131, 'level_to' => 150,  'stage' => 2.5 ],
                [ 'level_from' => 151, 'level_to' => 170,  'stage' => 2 ],
                [ 'level_from' => 171, 'level_to' => 190,  'stage' => 1.5 ],
                [ 'level_from' => 191,                    'stage' => 1.2 ],
            ],
        ],
    ],
    'socials' => [
        'facebook' => 'https://www.facebook.com/ravenor',
        'telegram' => 'https://telegram.ravenor.online/',
        'discord' => 'https://discord.com/invite/auvVv9YQZV',
        'youtube' => '#',
    ]
];
