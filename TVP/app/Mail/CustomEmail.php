<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class CustomEmail extends Mailable
{
    use Queueable, SerializesModels;

    public $subject;
    public $playerName;
    public $accountId;
    public $actionLink;
    public $type;
    public $password;

    public function __construct($subject, $accountName, $accountNumber, $actionLink, $type, $password = null)
    {
        $this->subject = $subject;
        $this->playerName = $accountName;
        $this->accountId = $accountNumber;
        $this->actionLink = $actionLink;
        $this->type = $type;
        $this->password = $password;
    }

    public function build()
    {

        switch ($this->type) {
            case 'create_account':
                $view = 'emails.create_account';
                break;
            case 'confirmation':
                $view = 'emails.confirmation';
                break;
            case 'complete_confirmation':
                $view = 'emails.complete_confirmation';
                break;
            case 'password_reset':
                $view = 'emails.password_reset';
                break;
            case 'complete_change_password';
                $view = 'emails.complete_change_password';
                break;
            case 'recovery_key':
                $view = 'emails.recovery_key';
                break;
            case 'aniversario':
                $view = 'emails.aniversario';
                break;
            case 'lost_account_email_reset':
                $view = 'emails.lost_account_email_reset';
                break;
            case 'lost_account_password_reset':
                $view = 'emails.lost_account_password_reset';
                break;
            case 'streamer_register':
                $view = 'emails.streamer_register';
                break;
            case 'streamer_delete':
                $view = 'emails.streamer_delete';
                break;
            default:
                $view = 'emails.generic'; 
        }

        return $this->view($view)
            ->subject($this->subject)
            ->with([
                'accountName' => $this->playerName,
                'accountNumber' => $this->accountId,
                'actionLink' => $this->actionLink,
                'password' => $this->password
            ]);
    }
}
