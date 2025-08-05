<?php

declare(strict_types=1);

namespace App\Services;

use App\Mail\SendConfirmationEmail;
use App\Models\WebAccounts;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Mail;

class EmailConfirmationService
{
    public function sendConfirmationEmail(WebAccounts $webAccount): void
    {
        $details = [
            'to' => $webAccount->account->email,
            'confirmationKey' => $webAccount->confirmation_key,
        ];

        $email = new SendConfirmationEmail($details);
        Mail::to($details['to'])->send($email);

        $webAccount->next_resend = Carbon::now()->addSeconds(300);
        $webAccount->confirmations_count = $webAccount->confirmations_count + 1;
        $webAccount->save();
    }
}
