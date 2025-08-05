<?php

return [
    'webhook_urls' => [
        'donations' => 'https://discord.com/api/webhooks/1089853383470485535/D1cgpL1Fe-u89AO5tXw9ApArqPZbf3nlV8HYce0U2bSlwTG9ZcX75u8nwMvfsk1-ECAr',
        'tc_donation' => 'https://discord.com/api/webhooks/1103033201506664500/OtEZBwLns8ldqP2PxVfgnYovAXVM1RCr83znIKcaBoie6rQLoRAX9IBtb7JC6cKPvcqw',
        'mc_donation' => 'https://discord.com/api/webhooks/1122978739404415088/F4HMeDca0mW1fB7lSl2Yl7M-fqB13UgudDLV8AtXBkwnqyZDE0AFxsMI1eATqEHM9433',
    ],
    'job' => Spatie\DiscordAlerts\Jobs\SendToDiscordChannelJob::class,
];
