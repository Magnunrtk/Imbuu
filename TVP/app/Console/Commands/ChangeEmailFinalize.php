<?php

declare(strict_types=1);

namespace App\Console\Commands;

use App\Models\Account;
use App\Models\WebChangeEmail;
use Illuminate\Console\Command;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Log;

class ChangeEmailFinalize extends Command
{
    protected $signature = 'email:change:finalize';

    protected $description = 'Finalize all open email change requests.';

    public function __construct()
    {
        parent::__construct();
    }

    public function handle(): void
    {
        try {
            $emailsToChange = WebChangeEmail::where('change_date', '<=', Carbon::now()->format('Y-m-d H:i'))
                ->whereConfirmed(false)
                ->whereNotNull('confirmation_key')
                ->get();
            foreach ($emailsToChange as $email) {
                $userAccount = Account::find($email->account_id);
                $userAccount->email = $email->email;
                $userAccount->save();
                $email->confirmed = true;
                $email->save();
            }
            $this->info('All requested open due change emails has been changed.');
        } catch (\Exception $e) {
            $message = $e->getMessage() . PHP_EOL . PHP_EOL . $e->getTraceAsString();
            $this->error($message);
            Log::error($message);
        }
    }
}