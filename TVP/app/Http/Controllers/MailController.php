<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Mail\CustomEmail;
use Illuminate\Support\Facades\Log;

class MailController extends Controller
{
    /**
     * Envia um e-mail customizado usando o mailable CustomEmail.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function sendCustomEmailInternal(
        $to,
        $subject,
        $accountName,
        $accountNumber,
        $actionLink,
        $type,
        $password = null
    ) {
        try {
            Mail::to($to)->send(new CustomEmail(
                $subject,
                $accountName,
                $accountNumber,
                $actionLink,
                $type,
                $password
            ));

            Log::info('Email enviado com sucesso (interno)', [
                'to' => $to,
                'subject' => $subject,
                'type' => $type,
            ]);

            return true;
        } catch (\Exception $e) {
            Log::error('Erro ao enviar email (interno)', [
                'to' => $to,
                'subject' => $subject,
                'exception' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ]);

            return false;
        }
    }
}
