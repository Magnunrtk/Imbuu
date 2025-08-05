<?php

declare(strict_types=1);

namespace App\Console\Commands;

use App\Utils\HighscoreLists;
use App\Utils\World;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

class CacheHighscoreLists extends Command
{
    /** @var string */
    protected $signature = 'cache:highscore';

    /** @var string */
    protected $description = 'Cache all highscore lists as command';

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
                    HighscoreLists::cacheAllHighscores($worldId);
                    HighscoreLists::cacheFilteredHighscores($worldId);
                }
            } else {
                HighscoreLists::cacheAllHighscores(World::getCurrentWorld()['id']);
                HighscoreLists::cacheFilteredHighscores(World::getCurrentWorld()['id']);
            }
            $this->info('Highscore lists has been cached.');
        } catch (\Exception $e) {
            $message = $e->getMessage() . PHP_EOL . PHP_EOL . $e->getTraceAsString();
            $this->error($message);
            Log::error($message);
        }
    }
}