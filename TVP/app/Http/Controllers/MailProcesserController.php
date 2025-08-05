<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;

class MailProcesserController extends Controller
{
    public function processEmailQueue()
    {
        try {
            // Inicia transação para evitar concorrência
            DB::beginTransaction();

            // Pega até 10 emails pendentes e bloqueia eles para evitar duplicação
            $jobs = DB::table('email_jobs')
                ->where('status', 'pending')
                ->limit(10)
                ->lockForUpdate()
                ->get();

            // Marca como processing
            foreach ($jobs as $job) {
                DB::table('email_jobs')->where('id', $job->id)->update(['status' => 'processing']);
            }

            DB::commit();

            foreach ($jobs as $job) {
                $data = json_decode($job->data, true);

                try {
                    Mail::to($job->to_email)->send(new \App\Mail\CustomEmail(
                        $job->subject,
                        $data['accountName'] ?? '',
                        $data['accountNumber'] ?? '',
                        $data['confirmationLink'] ?? '',
                        'create_account',
                        $data['password'] ?? ''
                    ));

                    DB::table('email_jobs')->where('id', $job->id)->update(['status' => 'sent']);
                } catch (\Exception $e) {
                    Log::error('Erro ao enviar e-mail', [
                        'job_id' => $job->id,
                        'error' => $e->getMessage()
                    ]);
                    DB::table('email_jobs')->where('id', $job->id)->update(['status' => 'failed']);
                }
            }

            return response()->json(['status' => 'ok', 'processed' => count($jobs)]);
        } catch (\Exception $e) {
            DB::rollBack();

            Log::error('Erro ao processar fila de emails', [
                'error' => $e->getMessage()
            ]);

            return response()->json(['status' => 'error', 'message' => 'Erro ao processar fila'], 500);
        }
    }
}
