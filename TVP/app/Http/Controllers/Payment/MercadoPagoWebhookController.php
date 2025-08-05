<?php

declare(strict_types=1);

namespace App\Http\Controllers\Payment;

use App\Http\Controllers\Controller;
use App\Models\WebOrderHistory;
use App\Models\WebShopProduct;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Illuminate\View\View;
use Illuminate\Http\Request;
use MercadoPago\Client\Payment\PaymentClient;
use MercadoPago\Exceptions\MPApiException;
use Illuminate\Support\Facades\DB;

class MercadoPagoWebhookController extends Controller
{
    public function checkout(Request $request): View|RedirectResponse
    {

        $couponCodeRaw = $request->input('coupon_code');
        $couponCode = preg_replace('/[^a-zA-Z0-9 ]/', '', $couponCodeRaw ?? '');
        $discountPercentage = 0;
        $streamerUrl = null; 
    
        if (!empty($couponCode)) {
            
            $streamer = DB::table('streamers')->where('coupon_code', $couponCode)->first();

            if (!$streamer) {
                return back()->with('error', 'Coupon does not exist.');
            }

            $discountConfig = DB::table('server_config')
                ->where('config', 'coupon_discount')
                ->first();

            if ($discountConfig) {
                $discountPercentage = (float) $discountConfig->value;
            }

            $streamerUrl = $streamer;
        }

        $accountId = Auth::user()->id;

        $messages = [
            'pmid.required' => 'Please select a payment option.',
            'product_id.required' => 'Please select a product.',
            'acceptTermsAndAgreement.accepted' => 'You have to accept the terms before placing an order.',
        ];

        $rules = [
            'pmid' => 'bail|required',
            'product_id' => 'bail|required',
            'acceptTermsAndAgreement' => 'accepted',
        ];

        $validator = Validator::make($request->all(), $rules, $messages);

        if ($validator->fails()) {
            return redirect()
                ->route('account.store.index')
                ->with(
                    'error',
                    preg_replace('/\s+/', ' ', $validator->errors()->first())
                )
                ->withInput();
        }

        $product = WebShopProduct::whereId((int) $request->input('product_id'))->wherePaymentOptionId((int) $request->input('pmid'))->whereActive(true)->first();

        if (!$product) {
            return redirect()
                ->route('account.store.index')
                ->with(
                    'error',
                    'Selected product does not exists..'
                );
        }



        $totalPrice = $oldPrice = $product->value;
        $discountAmount = ($totalPrice * $discountPercentage) / 100;
        $totalPrice = $totalPrice - $discountAmount;

        $client = new PaymentClient();
        $notifyUrl = "http://pagamento.ravenor.online/api/payment-webhookMP";

        try {
            $request = [
                "transaction_amount" => (float) $totalPrice,
                "payment_method_id" => 'pix',
                "external_reference" => (string) Auth::user()->id,
                "additional_info" => [
                    "items" => [
                        [
                            "id" => (int) $product->id,
                            "quantity" => (int) $product->coins,
                            "unit_price" => (float) $product->value
                        ]
                    ]
                ],
                "notification_url" => $notifyUrl,
                "payer" => [
                    "email" => (string) Auth::user()->email,
                ]
            ];

            $payment = $client->create($request);
            $response = $payment->getResponse()->getContent()['point_of_interaction']['transaction_data'];
            $sessionId = $payment->id;

            $webOrderHistory = WebOrderHistory::firstOrCreate(
                ['session_id' => $payment->id],
                [
                    'account_id' => (int) $payment->external_reference,
                    'status' => 'unpaid',
                    'price' => (float) $totalPrice,
                    'coins' => (int) $product->coins,
                    'product_id' => $product->id,
                    'email' => Auth::user()->email,
                ]
            );
            $webOrderHistory->save();

            if($discountPercentage != 0){

                $streamerId = $streamer->id;
                if($streamerId){
    
                    DB::table('streamer_references')->insert([
                        'streamer_id' => $streamerId,
                        'account_id' => $accountId,
                        'order_id' => $payment->id,
                        'status' => 'pending',
                        'created_at' => now(), 
                    ]);
                }
            }

            return view(
                'store.payment.pix',
                compact(
                    'webOrderHistory',
                    'sessionId',
                    'response',
                    'couponCode',
                    'discountPercentage',
                    'streamerUrl',
                    'oldPrice',
                    'totalPrice'
                )
            );
        } catch (MPApiException|\Exception $e) {
            $apiResponse = json_encode($e->getApiResponse()->getContent());

            // Parse the response
            $responseContent = json_decode($apiResponse, true);
        
            // Check for the specific error code
            if (isset($responseContent['cause'][0]['code']) && $responseContent['cause'][0]['code'] == 4390) {
                $customErrorMessage = 'The "Mercado Pago" platform does not accept this type of email.';
            } else {
                $customErrorMessage = "An error occurred while processing. Open a Ticket in Discord.";
            }
        
            // Log the API response with the custom message
            Log::error('MercadoPago API Response: ' . $apiResponse);

            return redirect()
                ->route('account.store.index')
                ->with('error', $customErrorMessage);
        }
    }

    public function success(): RedirectResponse
    {
        return redirect(route('account.index'))
            ->with(
                'success',
                'Thank you for your purchase! Coins were added to your account.',
            );
    }
}