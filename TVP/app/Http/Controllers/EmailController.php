<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use App\Models\HistoryMail;
use App\Models\EmailSystem;
use Carbon\Carbon;
use App\Http\Controllers\MailController;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\DB;


class EmailController extends Controller
{
    /**
     * Envia um e-mail de confirmação usando a API externa.
     *
     * @param string $email
     * @param string $accountName
     * @param string $confirmationLink
     * @return \Illuminate\Http\JsonResponse
     */

     protected function incrementEmailCountByDomain($email)
     {
         $domain = substr(strrchr($email, "@"), 1);
         $today = Carbon::now()->format('Y-m-d');
 
         $emailRecord = EmailSystem::where('domain', $domain)
             ->where('date', $today)
             ->first();
 
         if ($emailRecord) {
             $emailRecord->increment('quantity');
         } else {
             EmailSystem::create([
                 'quantity' => 1,
                 'domain' => $domain,
                 'date' => $today,
             ]);
         }
    }

    public function sendCreateEmail($email, $accountName, $confirmationLink, $accountNumber, $password)
    {
        try {
            // Insere o job no banco local
            DB::table('email_jobs')->insert([
                'to_email' => $email,
                'subject' => 'Account Creation - Ravenor',
                'data' => json_encode([
                    'accountName' => $accountName,
                    'accountNumber' => $accountNumber,
                    'confirmationLink' => $confirmationLink,
                    'password' => $password,
                ]),
                'status' => 'pending',
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            return true;
        } catch (\Exception $e) {
            Log::error('Erro ao enviar e-mail e disparar processamento', [
                'email' => $email,
                'exception' => $e->getMessage()
            ]);
            return false;
        }
    }

    public function sendConfirmationEmail($email, $accountName, $confirmationLink, $accountNumber)
    {
        try {

            $this->recordEmailHistory($accountNumber);

            DB::table('email_jobs')->insert([
                'to_email' => $email,
                'subject' => 'Account Confirmation - Ravenor',
                'data' => json_encode([
                    'accountName' => $accountName,
                    'accountNumber' => $accountNumber,
                    'confirmationLink' => $confirmationLink,
                ]),
                'status' => 'pending',
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            $this->incrementEmailCountByDomain($email);

            return true;

        } catch (\Exception $e) {
            Log::error('Erro ao enviar e-mail de confirmação de conta', [
                'email' => $email,
                'exception' => $e->getMessage()
            ]);
            return false;
        }
    }

    public function sendCompleteConfirmation($email, $accountName, $recoveryKey, $accountNumber)
    {
        try {
            DB::table('email_jobs')->insert([
                'to_email' => $email,
                'subject' => 'Complete Confirmation - Ravenor',
                'data' => json_encode([
                    'accountName' => $accountName,
                    'accountNumber' => $accountNumber,
                    'recoveryKey' => $recoveryKey,
                    'type' => 'complete_confirmation'
                ]),
                'status' => 'pending',
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            return true;

        } catch (\Exception $e) {
            Log::error('Erro ao gravar e-mail de confirmação completa', [
                'email' => $email,
                'exception' => $e->getMessage()
            ]);

            return false;
        }
    }

    public function lostAccountEmailReset($email, $accountName, $confirmationLink, $accountNumber)
    {
        try {
            DB::table('email_jobs')->insert([
                'to_email' => $email,
                'subject' => 'Email Confirmation & Password Change - Ravenor',
                'data' => json_encode([
                    'accountName' => $accountName,
                    'accountNumber' => $accountNumber,
                    'confirmationLink' => $confirmationLink,
                    'type' => 'lost_account_email_reset'
                ]),
                'status' => 'pending',
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            return true;

        } catch (\Exception $e) {
            Log::error('Erro ao gravar e-mail de redefinição de conta perdida', [
                'email' => $email,
                'exception' => $e->getMessage()
            ]);

            return false;
        }
    }

    public function registerStreamer($email, $accountName, $confirmationLink, $accountNumber)
    {
        try {
            DB::table('email_jobs')->insert([
                'to_email' => $email,
                'subject' => 'Approved in Streamer Program - Ravenor',
                'data' => json_encode([
                    'accountName' => $accountName,
                    'accountNumber' => $accountNumber,
                    'confirmationLink' => $confirmationLink,
                    'type' => 'streamer_register'
                ]),
                'status' => 'pending',
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            return true;

        } catch (\Exception $e) {
            Log::error('Erro ao gravar e-mail de aprovação no programa de streamers', [
                'email' => $email,
                'exception' => $e->getMessage()
            ]);

            return false;
        }
    }

    public function deleteStreamer($email, $accountName, $confirmationLink, $accountNumber)
    {
        try {
            DB::table('email_jobs')->insert([
                'to_email' => $email,
                'subject' => 'Removed From Streamer Program - Ravenor',
                'data' => json_encode([
                    'accountName' => $accountName,
                    'accountNumber' => $accountNumber,
                    'confirmationLink' => $confirmationLink,
                    'type' => 'streamer_delete'
                ]),
                'status' => 'pending',
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            return true;

        } catch (\Exception $e) {
            Log::error('Erro ao gravar e-mail de remoção do programa de streamers', [
                'email' => $email,
                'exception' => $e->getMessage()
            ]);

            return false;
        }
    }

    public function lostAccountPasswordReset($email, $accountName, $confirmationLink, $accountNumber)
    {
        try {
            DB::table('email_jobs')->insert([
                'to_email' => $email,
                'subject' => 'Account Recovery - Ravenor',
                'data' => json_encode([
                    'accountName' => $accountName,
                    'accountNumber' => $accountNumber,
                    'confirmationLink' => $confirmationLink,
                    'type' => 'lost_account_password_reset'
                ]),
                'status' => 'pending',
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            return true;

        } catch (\Exception $e) {
            Log::error('Erro ao gravar e-mail de recuperação de senha', [
                'email' => $email,
                'exception' => $e->getMessage()
            ]);

            return false;
        }
    }

    public function changePassword($email, $accountName, $confirmationLink, $accountNumber)
    {
        try {
            // Mantém o registro do histórico de envio
            $this->recordEmailHistory($accountNumber);

            // Insere o job no banco para envio posterior
            DB::table('email_jobs')->insert([
                'to_email' => $email,
                'subject' => 'Password Change - Ravenor',
                'data' => json_encode([
                    'accountName' => $accountName,
                    'accountNumber' => $accountNumber,
                    'confirmationLink' => $confirmationLink,
                    'type' => 'password_reset',
                ]),
                'status' => 'pending',
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            // Incrementa a contagem por domínio
            $this->incrementEmailCountByDomain($email);

            return true;

        } catch (\Exception $e) {
            Log::error('Erro ao gravar e-mail de redefinição de senha', [
                'email' => $email,
                'exception' => $e->getMessage()
            ]);

            return false;
        }
    }

    public function changePasswordComplete($email, $accountName, $confirmationLink, $accountNumber)
    {
        try {
            // Insere o job no banco para envio posterior
            DB::table('email_jobs')->insert([
                'to_email' => $email,
                'subject' => 'Password Change Complete - Ravenor',
                'data' => json_encode([
                    'accountName' => $accountName,
                    'accountNumber' => $accountNumber,
                    'confirmationLink' => $confirmationLink,
                    'type' => 'complete_change_password',
                ]),
                'status' => 'pending',
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            return true;

        } catch (\Exception $e) {
            Log::error('Erro ao gravar e-mail de redefinição de senha (completa)', [
                'email' => $email,
                'exception' => $e->getMessage()
            ]);

            return false;
        }
    }

    public function sendRecoveryKey($email, $accountName, $recoveryKey, $accountNumber)
    {
        try {
            // Mantém o registro do histórico de envio
            $this->recordEmailHistory($accountNumber);

            // Insere o job no banco para envio posterior
            DB::table('email_jobs')->insert([
                'to_email' => $email,
                'subject' => 'Recovery Key - Ravenor',
                'data' => json_encode([
                    'accountName' => $accountName,
                    'accountNumber' => $accountNumber,
                    'recoveryKey' => $recoveryKey,
                    'type' => 'recovery_key',
                ]),
                'status' => 'pending',
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            // Incrementa a contagem por domínio
            $this->incrementEmailCountByDomain($email);

            return true;

        } catch (\Exception $e) {
            Log::error('Erro ao gravar e-mail com chave de recuperação', [
                'email' => $email,
                'exception' => $e->getMessage()
            ]);

            return false;
        }
    }

    public function recordEmailHistory($accountNumber)
    {
        $today = Carbon::now()->format('Y-m-d');
        $historyRecord = HistoryMail::where('account_id', $accountNumber)
            ->where('date', $today)
            ->first();
    
        if ($historyRecord) {
            if ($historyRecord->turn < 4) {
                $historyRecord->increment('turn');
            } else {

                throw new \Exception('Email sending limit reached for today.');
            }
        } else {

            try {
                HistoryMail::create([
                    'account_id' => $accountNumber,
                    'date' => $today,
                    'turn' => 1,
                ]);
            } catch (\Exception $e) {

                throw new \Exception('Failed to create email history record.');
            }
        }
    }
    
}
