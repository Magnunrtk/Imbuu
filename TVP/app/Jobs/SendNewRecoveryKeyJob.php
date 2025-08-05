<?php

declare(strict_types=1);

namespace App\Jobs;

use App\Mail\SendNewRecoveryEmail;
use App\Models\WebAccounts;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Support\Facades\Mail;

class SendNewRecoveryKeyJob implements ShouldQueue
{
    use Dispatchable;
    use InteractsWithQueue;
    use Queueable;
    use SerializesModels;

    public function __construct(
        private readonly WebAccounts $webAccount
    ) {
    }

    public function handle(): void
    {
        $details = [
            'to' => $this->webAccount->account->email,
            'recoveryKey' => $this->webAccount->recovery_key,
        ];
        $email = new SendNewRecoveryEmail($details);
        Mail::to($details['to'])->send($email);
    }
}