<?php

declare(strict_types=1);

namespace App\Console\Commands;

use App\Models\WebChangeEmail;
use App\Models\WebChangePassword;
use App\Models\WebLostAccount;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

class ClearPendingConfirmations extends Command
{
    /** @var string */
    protected $signature = 'clear:confirmations';

    /** @var string */
    protected $description = 'Clean all pending confirmations that are older than 24h as command';

    public function __construct()
    {
        parent::__construct();
    }

    public function handle(): void
    {
        try {
            $threshold = now()->subHours(24);
            WebChangePassword::where('created_at', '<', $threshold)->delete();
            WebLostAccount::where('created_at', '<', $threshold)->delete();
            WebChangeEmail::whereConfirmed(false)
                ->where('created_at', '<', $threshold)
                ->whereNotNull('confirmation_key')
                ->delete();
            $this->info('Pending confirmations has been cleared.');
        } catch (\Exception $e) {
            $message = $e->getMessage() . PHP_EOL . PHP_EOL . $e->getTraceAsString();
            $this->error($message);
            Log::error($message);
        }
    }
}