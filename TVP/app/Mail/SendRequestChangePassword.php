<?php

declare(strict_types=1);

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class SendRequestChangePassword extends Mailable
{
    use Queueable, SerializesModels;
    public array $mailDetails;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($mailDetails)
    {
        $this->mailDetails = $mailDetails;
    }
    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('email.template.request_change_password')
            ->from('no-reply@ravenor.online', 'Ravenor')
            ->subject('Password Change of Your ' . config('server.serverName') . ' Account')
            ->with('mailDetails', $this->mailDetails);
    }
}