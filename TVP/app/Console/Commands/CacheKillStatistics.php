<?php

declare(strict_types=1);

namespace App\Console\Commands;

use App\Http\Controllers\KillStatisticsController;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

class CacheKillStatistics extends Command
{
    /** @var string */
    protected $signature = 'cache:statistics';

    /** @var string */
    protected $description = 'Cache kill statistics as command';

    public function __construct()
    {
        parent::__construct();
    }

    public function handle(): void
    {
        try {
            KillStatisticsController::cacheStatistics();
            $this->info('Kill statistics has been cached.');
        } catch (\Exception $e) {
            $message = $e->getMessage() . PHP_EOL . PHP_EOL . $e->getTraceAsString();
            $this->error($message);
            Log::error($message);
        }
    }
}