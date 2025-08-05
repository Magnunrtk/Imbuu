<?php

declare(strict_types=1);

namespace App\Jobs;

use App\Mail\SendRequestChangePassword;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;
use App\Models\WebAccounts;
use Illuminate\Support\Carbon;
use App\Models\WebChangePassword;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;

class SendRequestChangePasswordJob implements ShouldQueue, ShouldBeUnique
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected array $details;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    // public function __construct(array $details)
    // {
    //     $this->details = $details;
    //     $this->webAccount = new WebAccounts(); 
    // }


    public function __construct(
        private readonly WebAccounts $webAccount
    ){}


    private function sendConfirmationEmail(): void{
            
        $webChangePassword = WebChangePassword::where('account_id', Auth::user()->id)->first();
        $confirmationKey = $webChangePassword->confirmation_key;

        $currentDate = Carbon::now()->toDateString();
        $existingRecord = DB::table('email_system')->where('date', $currentDate)->first();

        $emailQuantity = null;

        if($existingRecord){

            $emailQuantity = $existingRecord->quantity;
        }

        if($emailQuantity == null){

            DB::table('email_system')->insert([
                'quantity' => 1,
                'date' => $currentDate,
            ]);

            $emailQuantity = 1;
        }

        if($emailQuantity < 499 && $emailQuantity != null) {

            DB::table('email_system')
                ->where('date', $currentDate)
                ->update(['quantity' => DB::raw('quantity + 1')]);
          
        }else {

            $webhook = 'https://discordapp.com/api/webhooks/1226889703026983036/VSrhpF8M6xNleAC0TuQCVyfuJGicfvufCyG-XCPVIUPyNnf5fugXQcH56koMgv14UWMB';
            $hora = date('d/m/Y H:i:s');
        
                $data = [
            
                        'content' =>("    
                    ```
Limite de Emails do Ravenor Alcançado! Data/Hora: $hora```")];
            
                    $options = [
            
                        'http' => [
            
                            'method' => 'POST',
                            'header' => 'Content-Type: application/json',
                            'content' => json_encode($data)
            
                        ]
            
                    ];
            
            $context = stream_context_create($options);
            $result = file_get_contents($webhook, false, $context);

            return;
        }
    
        $url = 'https://desentupidoranhhaus.com.br/changePassword.php';
    
        $curl = curl_init();
    
        curl_setopt_array($curl, array(
            CURLOPT_URL => $url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_POST => true,
            CURLOPT_POSTFIELDS => http_build_query(
                array(
                    'code' => $confirmationKey,
                    'send' => $this->webAccount->account->email,
                )
            ),
            CURLOPT_HTTPHEADER => array(
                'Content-Type: application/x-www-form-urlencoded'
            )
        ));
    
        $response = curl_exec($curl);
    
        // Verifica se ocorreu algum erro durante a solicitação
        if (curl_errno($curl)) {
            // Lidar com o erro
        } else {
            // Sucesso
        }
    
        curl_close($curl);
    }

    public function handle(): void
    {

        //p1 Função para envio de email 
        // -------------------------------------------------- \\

        $data = date("Y:m:d H:i:s");
        $account_id = $this->webAccount->account->id;
        $historyMail = \DB::table('history_mails')->where('account_id', $account_id)->first();
        $messageApi = "You have either entered an incorrect confirmation key.";
        $emailToSend = $this->webAccount->account->email;

        if (!preg_match("/@gmail\.com$/", $emailToSend)) {
            
            $messageApi = "
            
            <h1 style='text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.3);'>📢 Important warning:</h1> <span style='text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.3);'> Change in Email Policy!</span>

            <p style='font-weight:normal; text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.3);'>
                Starting today, we want to inform all our users that the system will only accept emails from <a href='https://accounts.google.com/'>Gmail</a>. If you are using another email provider, please request to switch to a Gmail email as soon as possible.
            </p>

            <h1 style='text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.3);'>🤔 Reason for Change:</h1>

            <p style='font-weight:normal; text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.3);'>
                The change was made to ensure greater compatibility and aesthetics in our system. Thank you for your understanding and cooperation!
                If you need help making this change or have any questions, don't hesitate to contact us.
            </p>

            <p style='font-weight:normal; text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.3);'>
                You can change the email by clicking <a href='/account/email/confirmation/change'>here</a>!
            </p>

            <p style='text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.3); font-weight: normal'>
                Thank you for understanding, <bRavenor Team</b>.
            </p>
            ";

            Redirect::route('account.index', ['messageApi' => $messageApi])->send();
        }

        $messageApi = "An unexpected error has occurred!";

        //g1 Sistema Inicial de email, esse sistema tem o intuito de barrar multiplas solicitações de email, limitando a 3 requisições diárias.
        //g1 Essa é a reconfirmação, após conclusão deve seguir ao inicial correto que é na criação de conta.



        if($historyMail){ //y1 Verifica se o jogador já tem um registro no Banco de dados.
            
            $dataFromDatabase = Carbon::parse($historyMail->date);
            $turnFromDatabase = $historyMail->turn;
            $dataAtual = Carbon::now();

            try {

                $dataDaDb = strtotime($historyMail->date); 
                $dataThis = time(); 
                $diff = $dataDaDb - $dataThis; 
                $diferencaDias = floor($diff / (60 * 60 * 24)); 

                if(($dataFromDatabase->diffInMinutes($dataAtual) >= 5 && $turnFromDatabase == 5) || $diferencaDias < -1) { 
                    
                    //y1 Verifica se o jogador fez uma solicitação nos últimos 5 minutos.
                    //y1 Sim, aumenta o tempo de espera para +15 minutos.
                    DB::table('history_mails')
                    ->where('account_id', $account_id)
                    ->update([
                        'date' => $data,
                        'turn' => 15,
                    ]);

                    $messageApi = "Sent with success!";
                    $this->sendConfirmationEmail();
        
                }else if( ($dataFromDatabase->diffInMinutes($dataAtual) >= 15 && $turnFromDatabase == 15) ){

                    //y1 Sim, aumenta o tempo de espera para +30 minutos.

                    DB::table('history_mails')
                    ->where('account_id', $account_id)
                    ->update([
                        'date' => $data,
                        'turn' => 30,
                    ]);

                    $messageApi = "Sent with success!";
                    $this->sendConfirmationEmail();

                }else if( ($dataFromDatabase->diffInMinutes($dataAtual) >= 30 && $turnFromDatabase == 30) ) {

                    //y1 Encerra Os emails diários.

                    DB::table('history_mails')
                    ->where('account_id', $account_id)
                    ->update([
                        'date' => $data,
                        'turn' => 50,
                    ]);

                    $messageApi = "Sent with success!";
                    $this->sendConfirmationEmail();

                }else if($turnFromDatabase == 50){

                    $dataAtual = now(); 
                    $proximoDia = $dataFromDatabase->copy()->addDay();
                    $diferencaSegundos = $proximoDia->diffInSeconds($dataAtual);

                    $tempoRestanteHoras = floor($diferencaSegundos / 3600); 
                    $tempoRestanteMinutos = floor(($diferencaSegundos % 3600) / 60); 
                    $tempoRestanteSegundos = $diferencaSegundos % 60; 

                    $messageApi = "Left " . $tempoRestanteHoras . " hours " . $tempoRestanteMinutos . " minutes and " . $tempoRestanteSegundos . " seconds to send again.";

                }else{

                    //y1 Envia tempo restante para o próximo envio

                    if($turnFromDatabase == 5){

                        $messageApi = "Left " . 5 - $dataFromDatabase->diffInMinutes($dataAtual). " minutes to send again.";

                    }else if($turnFromDatabase == 15){

                        $messageApi = "Left " . 15 - $dataFromDatabase->diffInMinutes($dataAtual). " minutes to send again.";

                    }else if($turnFromDatabase == 30){

                        $messageApi = "Left " . 30 - $dataFromDatabase->diffInMinutes($dataAtual). " minutes to send again.";
                    }
                }

            } catch (\Throwable $th) {
                var_dump($th);
            }

        }else{ //y1 Caso não tenha insere um novo registro.
            
            DB::table('history_mails')->insert([
                'account_id' => $account_id,
                'date' => $data,
                'turn' => 5,
            ]);

            $messageApi = "Sent with success!";
            $this->sendConfirmationEmail();
            
        }

        // Mail::to($this->details['to'])->send($email);
        Redirect::route('account.index', ['messageApi' => $messageApi])->send();
    }
}