<?php

declare(strict_types=1);

namespace App\Jobs;

use App\Mail\SendConfirmChangeEmailByRecoveryKey;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;

class SendConfirmChangeEmailByRecoveryKeyJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    protected array $details;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(array $details)
    {
        $this->details = $details;
    }

    public function handle(): void
    {
        $email = new SendConfirmChangeEmailByRecoveryKey($this->details);
        Mail::to($this->details['to'])->send($email);
    }
}