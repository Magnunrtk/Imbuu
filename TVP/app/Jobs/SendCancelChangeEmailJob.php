<?php

declare(strict_types=1);

namespace App\Jobs;

use App\Mail\SendCancelChangeEmail;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Support\Facades\Mail;

class SendCancelChangeEmailJob implements ShouldQueue
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
        $email = new SendCancelChangeEmail($this->details);

        Mail::to($this->details['to'])->send($email);
    }
}