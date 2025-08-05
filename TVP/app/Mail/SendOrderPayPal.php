<?php

declare(strict_types=1);

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class SendOrderPayPal extends Mailable
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
        return $this->view('email.template.order_paypal_complete')
            ->from('no-reply@ravenor.online', 'Ravenor')
            ->subject('Your order '. $this->mailDetails['order_item_id'] .' at ' . config('server.serverName'))
            ->with('mailDetails', $this->mailDetails);
    }
}