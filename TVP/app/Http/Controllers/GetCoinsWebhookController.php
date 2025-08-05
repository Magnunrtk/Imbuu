<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use MercadoPago\Client\Payment\PaymentClient;
use Illuminate\Support\Facades\DB;
use App\Models\WebAccounts;

class GetCoinsWebhookController extends Controller
{
    public function handleWebhook(Request $request)
    {
        $data = $request->json()->all();
    
        if (isset($data['data']['id'])) {
            $transactionId = intval($data['data']['id']);
        } elseif (isset($data['resource'])) {
            $transactionId = intval($data['resource']);
        } else {
            Log::error('ID da transação não encontrado no webhook.');
            return response()->json(['status' => 'error', 'message' => 'ID da transacao nao encontrado.'], 400);
        }

        // Apagar no Web Order, alterar para paid no order_items e z_ots_communication
        //$transactionId = 90910494301;
        $client = new PaymentClient();
    
        try {
            $payment = $client->get($transactionId);
            $transactionId = strval($transactionId); 
            $externalReference = $payment->external_reference ?? 'Referência externa não disponível';
            $mpPrice = $payment->transaction_amount ?? 0;
        } catch (\Exception $e) {
            //Log::error('Erro ao obter detalhes da transação: ' . $e->getMessage());
            $externalReference = 'Erro ao obter referência externa';   
        }

        $orderItems = DB::table('web_order_histories')
            ->where('session_id', $transactionId)
            ->where('status', 'unpaid') 
            ->select('price', 'coins', 'account_id')
            ->first();


        if ($orderItems  && $payment->status === 'approved') {

            $totalPrice = $orderItems->price;
            $account_id = $orderItems->account_id;

            if(false){

                $dataHora = date('d/m/Y H:i:s');
        
                $content = "
                ```🚨 [Ravenor] Alerta de Fraude Detectada! 🚨

Método: Pix
Data/Hora: $dataHora
Transaction ID: $transactionId
External Reference: $externalReference

❗ Tentativa de fraude detectada no pagamento!

Detalhes da compra:


🚨 Número de Conta: $account_id 🚨

⚠️ Preço esperado: R$ $totalPrice
⚠️ Preço pago no Mercado Pago: R$ $mpPrice

Por favor, revise imediatamente esta transação!```";
    
                $webhook = 'https://discord.com/api/webhooks/1388206256065613854/AN-3MDRKqNAsv8jzuTiufTXa_8zAC-WYw4Dg2AnDmAI7tudfxw0RlZkozF8aizidPb92';
            
                $dataToSend = [
                    'content' => $content
                ];
            
                $options = [
                    'http' => [
                        'method' => 'POST',
                        'header' => 'Content-Type: application/json',
                        'content' => json_encode($dataToSend)
                    ]
                ];
            
                $context = stream_context_create($options);
                file_get_contents($webhook, false, $context);
                die;
            }

            DB::table('web_order_histories')
            ->where('session_id', $transactionId) 
            ->update(['status' => 'paid']);

            DB::table('streamer_references')
            ->where('order_id', $transactionId)
            ->update(['status' => 'paid']);
        
            $dataHora = date('d/m/Y H:i:s');
            $coinsFinal = $orderItems->coins;
            
            $account = WebAccounts::whereAccountId($account_id)->first();

            if($account){
                $account->shop_coins = $account->shop_coins + $coinsFinal;
                $account->save();
            }

            $content = "
            ```[Ravenor] Coins:
            
Método: Pix
Data/Hora: $dataHora
Transaction ID: $transactionId
External Reference: $externalReference
Coins Comprados: $coinsFinal 

Preço Total R$: $totalPrice```";

            $webhook = 'https://discord.com/api/webhooks/1388206256065613854/AN-3MDRKqNAsv8jzuTiufTXa_8zAC-WYw4Dg2AnDmAI7tudfxw0RlZkozF8aizidPb92';
        
            $dataToSend = [
                'content' => $content
            ];
        
            $options = [
                'http' => [
                    'method' => 'POST',
                    'header' => 'Content-Type: application/json',
                    'content' => json_encode($dataToSend)
                ]
            ];
        
            $context = stream_context_create($options);
            file_get_contents($webhook, false, $context);
        } else {

            echo "No unpaid items found for transaction: $transactionId";
        }

        return response()->json(['status' => 'success']);
    }
}
