<?php

declare(strict_types=1);

namespace App\Console\Commands;

use App\Utils\ServerStatusCache;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

class CacheServerStatus extends Command
{
    /** @var string */
    protected $signature = 'cache:status';

    /** @var string */
    protected $description = 'Cache current server status as command';

    public function __construct()
    {
        parent::__construct();
    }

    public function handle(): void
    {
        try {
            ServerStatusCache::cache();
            $this->info('Server status has been cached.');
        } catch (\Exception $e) {
            $message = $e->getMessage() . PHP_EOL . PHP_EOL . $e->getTraceAsString();
            $this->error($message);
            Log::error($message);
        }
    }
}
