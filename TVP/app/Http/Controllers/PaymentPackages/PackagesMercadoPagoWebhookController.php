<?php

declare(strict_types=1);

namespace App\Http\Controllers\PaymentPackages;

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
use Carbon\Carbon;
use App\Models\Player;

class PackagesMercadoPagoWebhookController extends Controller
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
        $playerNames = Player::where('account_id', $accountId)
                     ->pluck('name')
                     ->toArray();

        $characterName = $request->input('character_name');

        if (!preg_match('/^[a-zA-Z\s\']+$/', $characterName)) {
            return $this->selectProduct($request)->with('errorMessage', 'Character name can only contain letters, spaces, and apostrophes.');
        }
                
        if (!in_array($characterName, $playerNames)) {
            return $this->selectProduct($request)->with('errorMessage', 'Character name does not exist.');
        }

        $player = Player::where('account_id', $accountId)
        ->where('name', $characterName)
        ->first();

        if (!$player) {
            return $this->selectProduct($request)->with('errorMessage', 'Character not found.');
        }
    
        $characterId = $player->id; 

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

        $bronze = intval($request->input('bronze'));
        $silver = intval($request->input('silver'));
        $gold = intval($request->input('gold'));

        if ($bronze === 0 && $silver === 0 && $gold === 0) {
            return $this->selectProduct($request)->with('errorMessage', 'The value of bronze, silver, and gold cannot all be zero.');
        }

        if ($bronze < 0 || $bronze > 10 || $silver < 0 || $silver > 10 || $gold < 0 || $gold > 10) {
            return $this->selectProduct($request)->with('errorMessage', 'The value of bronze, silver, and gold must be between 1 and 10.');
        }

        $validator = Validator::make($request->all(), $rules, $messages);

        if ($validator->fails()) {
            return redirect()
                ->route('account.store.packages.index')
                ->with('error', preg_replace('/\s+/', ' ', $validator->errors()->first()))
                ->withInput();
        }

        $product = WebShopProduct::whereId((int) $request->input('product_id'))
            ->wherePaymentOptionId((int) $request->input('pmid'))
            ->whereActive(true)
            ->first();

        if (!$product) {
            return redirect()
                ->route('account.store.packages.index')
                ->with('error', 'Selected product does not exist.');
        }

        $totalPrice = $oldPrice = ($bronze * 130) + ($silver * 210) + ($gold * 330);
        $discountAmount = ($totalPrice * $discountPercentage) / 100;
        $totalPrice = $totalPrice - $discountAmount;

        $accountId = Auth::user()->id;
        
        $client = new PaymentClient();
        $notifyUrl = "http://pagamento.ravenor.online/api/payment-webhook";

        $requestData = [
            "transaction_amount" => (float) $totalPrice,
            "payment_method_id" => 'pix',
            "external_reference" => $accountId,
            "additional_info" => [
                "items" => [
                    [
                        "id" => (int) $product->id,
                        "quantity" => (int) $product->coins,
                        "unit_price" => (float) $totalPrice
                    ]
                ]
            ],
            "notification_url" => $notifyUrl,
            "payer" => [
                "email" => (string) Auth::user()->email,
            ]
        ];

        try {
            $payment = $client->create($requestData);
            $response = $payment->getResponse()->getContent()['point_of_interaction']['transaction_data'];
            $sessionId = $payment->id;

            DB::table('order_items')->Insert( 
                [
                    'order_id' => $payment->id,
                    'bronze' => $bronze,
                    'silver' => $silver,
                    'gold' => $gold,
                    'total_price' => $totalPrice,
                    'status' => 'unpaid',
                    'created_at' => now(),
                    'updated_at' => now(),
                    'account_id' => $accountId,
                    'player_id'=> $characterId 
                ]
            );

            $webOrderHistory = new WebOrderHistory([
                'session_id' => $payment->id,
                'account_id' => (int) $payment->external_reference,
                'status' => 'unpaid',
                'price' => (float) $totalPrice,
                'coins' => (int) $product->coins,
                'product_id' => $product->id,
                'email' => Auth::user()->email,
            ]);

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
            
        } catch (MPApiException|\Exception $e) {

            $apiResponse = json_encode($e->getApiResponse()->getContent());
            $responseContent = json_decode($apiResponse, true);

            if (isset($responseContent['cause'][0]['code']) && $responseContent['cause'][0]['code'] == 4390) {
                $customErrorMessage = 'The "Mercado Pago" platform does not accept this type of email.';
            } else {
                $customErrorMessage = "An error occurred while processing. Open a Ticket in Discord.";
            }
            Log::error('MercadoPago API Response: ' . $apiResponse);
            return redirect()
                ->route('account.store.packages.index')
                ->with('error', $customErrorMessage);
        }

        return view(
            'store.packages.payment.pix',
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
    }

    public function success(): RedirectResponse
    {
        return redirect(route('account.index'))
            ->with(
                'success',
                'Thank you for your purchase! Coins were added to your account.',
            );
    }

    public function selectProduct(Request $request): View
    {
        $messages = [
            'acceptTerms.required' => 'You have to agree to the terms in order to get coins!',
            'pmid.required' => 'Please select a payment option.',
            'pmid.exists' => 'Selected a payment option does not exists.',
        ];
        $rules = [
            'acceptTerms' => 'required',
            'pmid' => 'required|exists:web_payment_options,id',
        ];
        $validator = Validator::make($request->all(), $rules, $messages);
        if ($validator->fails()) {
            return $this->selectPayment($request)->with('errorMessage', preg_replace('/\s+/', ' ', $validator->errors()->first()));
        }
        $paymentId = $request->input('pmid');

        return view(
            'store.packages.select_packages',
            compact(
                'paymentId'
            )
        );
    }

}
