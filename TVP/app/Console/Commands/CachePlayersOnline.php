<?php

declare(strict_types=1);

namespace App\Console\Commands;

use App\Utils\PlayersOnlineCache;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

class CachePlayersOnline extends Command
{
    /** @var string */
    protected $signature = 'cache:playersOnline';

    /** @var string */
    protected $description = 'Cache current players online as command';

    public function __construct()
    {
        parent::__construct();
    }

    public function handle(): void
    {
        try {
            if (config('multi_world.enabled')) {
                $worlds = config('multi_world.worlds');
                foreach ($worlds as $world) {
                    $worldId = $world['id'];
                    PlayersOnlineCache::cache($worldId);
                }
            } else {
                PlayersOnlineCache::cacheAll();
            }
            $this->info('Players online count has been cached.');
        } catch (\Exception $e) {
            $message = $e->getMessage() . PHP_EOL . PHP_EOL . $e->getTraceAsString();
            $this->error($message);
            Log::error($message);
        }
    }
}
