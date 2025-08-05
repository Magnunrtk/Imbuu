<?php

declare(strict_types=1);

namespace App\Console\Commands;

use App\Utils\TopPlayersCache;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

class CacheTopPlayers extends Command
{
    /** @var string */
    protected $signature = 'cache:powergamers';

    /** @var string */
    protected $description = 'Cache top 5 players as command';

    public function __construct()
    {
        parent::__construct();
    }

    public function handle(): void
    {
        try {
            TopPlayersCache::cache();
            $this->info('Powergamers has been cached.');
        } catch (\Exception $e) {
            $message = $e->getMessage() . PHP_EOL . PHP_EOL . $e->getTraceAsString();
            $this->error($message);
            Log::error($message);
        }
    }
}
