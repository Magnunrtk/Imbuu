<?php

declare(strict_types=1);

namespace App\Jobs;

use App\Mail\SendRequestChangeEmail;
use App\Models\WebChangeEmail;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Support\Facades\Mail;

class SendRequestChangeEmailJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private WebChangeEmail $webChangeEmail;

    public function __construct(WebChangeEmail $webChangeEmail)
    {
        $this->webChangeEmail = $webChangeEmail;
    }

    public function handle(): void
    {
        $details = [
            'to' => $this->webChangeEmail->old_email,
            'changeEmail' => $this->webChangeEmail->email,
            'changeDate' => $this->webChangeEmail->change_date,
        ];

        $email = new SendRequestChangeEmail($details);
        Mail::to($details['to'])->send($email);
    }
}