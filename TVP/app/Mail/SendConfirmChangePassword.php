<?php

declare(strict_types=1);

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class SendConfirmChangePassword extends Mailable
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
        return $this->view('email.template.confirm_change_password')
            ->from('no-reply@ravenor.online', 'Ravenor')
            ->subject('Confirmation Key for New ' . config('server.serverName') . ' Password')
            ->with('mailDetails', $this->mailDetails);
    }
}