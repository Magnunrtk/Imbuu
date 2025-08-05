<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\WebAccounts;
use App\Models\WebOrderHistory;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use MercadoPago\Client\Payment\PaymentClient;
use MercadoPago\Exceptions\MPApiException;
use Spatie\DiscordAlerts\Facades\DiscordAlert;

class MercadoPagoApiController extends Controller
{
    public const PAYMENT_PLATFORM = "Mercado Pago";

    public function notify(Request $request): JsonResponse
    {
        $paymentId = $request->has('id') ? (int) $request->get('id') : null;

    
        if ($paymentId === null) {
            return response()->json([
                'success' => false,
                'message' => 'Payment ID not provided in the request.',
            ]);
        }

        $payment = new PaymentClient();
        try {
            $payment = $payment->get($paymentId);
            $paymentItem = $payment->getResponse()->getContent()['additional_info']['items'][0];
            $webOrderHistory = WebOrderHistory::firstOrCreate(
                ['session_id' => $payment->id],
                [
                    'account_id' => (int) $payment->external_reference,
                    'status' => 'unpaid',
                    'price' => (float) $paymentItem['unit_price'],
                    'coins' => (int) $paymentItem['quantity'],
                ]
            );

            if($payment->status === 'approved') {
                if (
                    config('shop.payment_options')['mercado_pago']['strict_currency_check']
                    && Str::lower($payment->currency_id) !== Str::lower(config('shop.payment_options')['mercado_pago']['currency'])
                ) {
                    return response()->json(
                        [
                            'success' => true,
                            'message' => 'Order has wrong currency.'
                        ]
                    );
                }

                if($webOrderHistory->status === 'unpaid') { 
                    $webOrderHistory->status = 'paid';
                    $webOrderHistory->email = $payment->payer->email;

                    if ($webOrderHistory->save()) {
                        $account = WebAccounts::whereAccountId($webOrderHistory->account_id)->first();

                        if($account){
                            $account->shop_coins = $account->shop_coins + $webOrderHistory->coins;
                            $account->save();
                            $this->discordAlert($webOrderHistory);
                            die;
                        }
                    }
                }

                return response()->json(
                    [
                        'success' => true,
                        'message' => 'Order has been approved.'
                    ]
                );

            }
            return response()->json(
                [
                    'success' => false,
                    'message' => 'Order status is not approved.'
                ]
            );
        } catch (MPApiException|\Exception $e) {
            Log::error('MercadoPago API Response: ' . json_encode($e->getApiResponse()->getContent()));
        }
        return response()->json(
            [
                'success' => false,
                'message' => 'An error has been occurred while processing.'
            ]
        );
    }

    static private function discordAlert(WebOrderHistory $order): void
    {

        $webhook = 'https://discord.com/api/webhooks/1089853383470485535/D1cgpL1Fe-u89AO5tXw9ApArqPZbf3nlV8HYce0U2bSlwTG9ZcX75u8nwMvfsk1-ECAr';

        $message = sprintf(
            "```[%s] Novo pagamento!\n\nPlataforma: %s\n\nID da transação: %s\n\nConta: %s\n\nPreço %s: %s\n\n%s Moedas: %s\n\nData/Hora: %s```",
            config('server.serverName'),
            self::PAYMENT_PLATFORM,
            $order->session_id,
            $order->account_id,
            !is_null($order->product->prefix) ? $order->product->prefix : $order->product->suffix,
            number_format((float) $order->price, $order->product->decimals, ','),
            config('server.serverName'),
            $order->coins,
            Carbon::parse($order->created_at)->format('d/m/Y H:i:s')
        );

        $data = [
            'content' => $message
        ];

        $options = [
            'http' => [
                'method' => 'POST',
                'header' => 'Content-Type: application/json',
                'content' => json_encode($data)
            ]
        ];

        $context = stream_context_create($options);
        $result = file_get_contents($webhook, false, $context);
    }

    public function status(Request $request): JsonResponse
    {
        $messages = [
            'session_id.required' => 'invalid payment id',
            'session_id.exists' => 'payment id does not exists',
        ];
        $rules = [
            'session_id' => 'required|exists:web_order_histories,session_id',
        ];
        $validator = Validator::make($request->all(), $rules, $messages);
        if ($validator->fails()) {
            return response()->json(
                [
                    'success' => false,
                    'message' => preg_replace('/\s+/', ' ', $validator->errors()->first())
                ]
            );
        }
        $webOrderHistory = WebOrderHistory::whereSessionId($request->get('session_id'))->first();
        return response()->json(
            [
                'success' => ($webOrderHistory->status === 'paid'),
            ]
        );
    }
}