<?php

declare(strict_types=1);

namespace App\Console\Commands;

use App\Models\WebLostAccount;
use Illuminate\Console\Command;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Log;

class CleanLostPasswordTable extends Command
{
    protected $signature = 'clean:lost:password';

    protected $description = 'Clean lost password requests from web_lost_password table.';

    public function __construct()
    {
        parent::__construct();
    }

    public function handle(): void
    {
        try {
            $lostPassword = WebLostAccount::where('created_at', '<=', Carbon::now()->subDay())->get();
            foreach ($lostPassword as $password) {
                $password->delete();
            }
            $this->info('All lost password requests older than 2 days has been deleted.');
        } catch (\Exception $e) {
            $message = $e->getMessage() . PHP_EOL . PHP_EOL . $e->getTraceAsString();
            $this->error($message);
            Log::error($message);
        }
    }
}