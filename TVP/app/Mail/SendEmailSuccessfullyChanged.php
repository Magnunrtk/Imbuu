<?php

declare(strict_types=1);

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class SendEmailSuccessfullyChanged extends Mailable
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
        return $this->view('email.template.email_successfully_changed')
            ->from('no-reply@ravenor.online', 'Ravenor')
            ->subject('Email Address Successfully Changed')
            ->with('mailDetails', $this->mailDetails);
    }
}