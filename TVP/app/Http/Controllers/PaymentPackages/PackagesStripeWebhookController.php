<?php

declare(strict_types=1);

namespace App\Http\Controllers\PaymentPackages;

use App\Http\Controllers\Controller;
use App\Jobs\SendOrderStripeJob;
use App\Models\WebAccounts;
use App\Models\WebOrderHistory;
use App\Models\WebShopProduct;
use Carbon\Carbon;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\View\View;
use Spatie\DiscordAlerts\Facades\DiscordAlert;
use Stripe\Checkout\Session;
use Stripe;
use App\Models\Player;
use Illuminate\Support\Facades\DB;

class PackagesStripeWebhookController extends Controller
{
    public const PAYMENT_PLATFORM = "Stripe";

    public function checkout(Request $request): RedirectResponse
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

        $characterId = $player->id;
        $bronze = intval($request->input('bronze'));
        $silver = intval($request->input('silver'));
        $gold = intval($request->input('gold'));

        if ($bronze === 0 && $silver === 0 && $gold === 0) {
            return $this->selectProduct($request)->with('errorMessage', 'The value of bronze, silver, and gold cannot all be zero.');
        }

        if ($bronze < 0 || $bronze > 10 || $silver < 0 || $silver > 10 || $gold < 0 || $gold > 10) {
            return $this->selectProduct($request)->with('errorMessage', 'The value of bronze, silver, and gold must be between 1 and 10.');
        }

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
                ->route('account.store.packages.index')
                ->with(
                    'error',
                    preg_replace('/\s+/', ' ', $validator->errors()->first())
                );
        }

        $product = WebShopProduct::whereId((int) $request->input('product_id'))->wherePaymentOptionId((int) $request->input('pmid'))->whereActive(true)->first();

        if (!$product) {
            return redirect()
                ->route('account.store.packages.index')
                ->with(
                    'error',
                    'Selected product does not exists..'
                );
        }
        
        $totalPrice = ($bronze * 23) + ($silver * 37) + ($gold * 58);
        $discountAmount = ($totalPrice * $discountPercentage) / 100;
        $totalPrice = $totalPrice - $discountAmount;

        $lineItems = [];
        $lineItems[] = [
            'price_data' => [
                'currency' => config('shop.currency'),
                'product_data' => [
                    'name' => 'Ravenor Packages',
                ],
                'unit_amount' => $totalPrice * 100,
            ],
            'quantity' => 1,
        ];

        $session = Session::create([
            'line_items' => $lineItems,
            'mode' => 'payment',
            'success_url' => route('account.store.packages.payment-method.stripe.success', [], true) . "?session_id={CHECKOUT_SESSION_ID}",
            'cancel_url' => route('account.store.packages.index', [], true),
        ]);

        DB::table('order_items')->Insert( 
            [
                'order_id' => $session->id,
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

        if($discountPercentage != 0){

            $streamerId = $streamer->id;

            if($streamerId){

                DB::table('streamer_references')->insert([
                    'streamer_id' => $streamerId,
                    'account_id' => $accountId,
                    'order_id' => $session->id,
                    'status' => 'pending',
                    'created_at' => now(), 
                ]);
            }
        }

        return redirect($session->url);
    }

    public function success(Request $request): View|RedirectResponse
    {

        $sessionId = $request->get('session_id');
        
        try {

            $session = Session::retrieve($sessionId);
            if (!$session) {
                return redirect(route('account.store.packages.index'))
                    ->with(
                        'error',
                        'Your session seems to be incorrect, please try again or contact the administrator.'
                    );
            }

            $webOrderHistory = DB::table('order_items')
            ->where('order_id', $session->id)
            ->first();

            if (!$webOrderHistory) {
                return redirect(route('account.packages.index'))
                    ->with(
                        'error',
                        'We could not find your order, please try again or contact the administrator.'
                    );
            }

            if ($webOrderHistory->status === 'unpaid') {
                              
                $orderItems = DB::table('order_items')
                ->where('order_id', $sessionId)
                ->select('bronze', 'silver', 'gold', 'player_id', 'account_id')
                ->first();

                $bronzePrice = 30;
                $silverPrice = 52;
                $goldPrice = 78;
        
                $totalPrice = ($orderItems->bronze * $bronzePrice) +
                                ($orderItems->silver * $silverPrice) +
                                ($orderItems->gold * $goldPrice);

                $playerName = DB::table('players')
                ->where('id', $orderItems->player_id)
                ->value('name');

                DB::table('order_items')
                ->where('order_id', $sessionId) 
                ->update(['status' => 'paid']); 

                DB::table('streamer_references')
                    ->where('order_id', $sessionId)
                    ->update(['status' => 'paid']);

                $dataHora = date('d/m/Y H:i:s');
        
                $content = "
                ```[Ravenor] Nova doação!
    
Método: Stripe
Data/Hora: $dataHora
Transaction ID: $sessionId
Número da Conta: $orderItems->account_id

Detalhes da compra:
Bronze: {$orderItems->bronze} x $bronzePrice = " . ($orderItems->bronze * $bronzePrice) . "
Silver: {$orderItems->silver} x $silverPrice = " . ($orderItems->silver * $silverPrice) . "
Gold: {$orderItems->gold} x $goldPrice = " . ($orderItems->gold * $goldPrice) . "

Nome do Personagem: $playerName

Valor da compra USD$: $totalPrice```";
        
                $webhook = 'https://discord.com/api/webhooks/1298245757136015410/2LuBpE7ZMoPtYan9DU7Qn29QHn14o955-FPcsTMrgb0U-f3yfzAkFySEIOSwWwwR_VKb';
            
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

            }

            return redirect(route('account.index'))
                ->with(
                    'success',
                    sprintf(
                        'Thank you for your purchase!',
                        '',
                        config('server.serverName')
                    )
                );

        } catch (\Exception $e) {
            
            var_dump($e);

            die;

            report($e);

            return redirect(route('account.store.packages.index'))
                ->with(
                    'error',
                    'It seems like something went wrong while processing.'
                );
        }
    }

    static private function discordAlert(WebOrderHistory $order): void
    {

        $webhook = 'https://discord.com/api/webhooks/1256253387947773964/Ba47o6HC9gSDDryrhZmhUI_shlHR2HgMmyEMlGslKLB2mwaZjeB0y0pwiXivLRquDamh';
        $dataHora = date('d/m/Y H:i:s');
        $price = number_format((float) $order->price, $order->product->decimals, ',', '');

        $data = [

            'content' =>("    
```[Ravenor] Nova doação Stripe!

Account: $order->account_id

Price US$: $price

Ravenor Coins: $order->coins

Data/Hora: $dataHora 
```")];

        $options = [
            'http' => [
                'method' => 'POST',
                'header' => 'Content-Type: application/json',
                'content' => json_encode($data)
            ]
        ];

        $context = stream_context_create($options);
        $result = file_get_contents($webhook, false, $context);

        // DiscordAlert::to('donations')->message(
        //     sprintf(
        //         "```[%s] New Payment!\n\nPlatform: %s\n\nTransaction ID: %s\n\nAccount: %s\n\nPrice %s: %s\n\n%s Coins: %s\n\nDate/Hour: %s```",
        //         config('server.serverName'),
        //         self::PAYMENT_PLATFORM,
        //         $order->session_id,
        //         $order->account_id,
        //         !is_null($order->product->prefix) ? $order->product->prefix : $order->product->suffix,
        //         number_format((float) $order->price, $order->product->decimals, ','),
        //         config('server.serverName'),
        //         $order->coins,
        //         Carbon::parse($order->created_at)->format('d/m/Y H:i:s')
        //     )
        // );
    }
}