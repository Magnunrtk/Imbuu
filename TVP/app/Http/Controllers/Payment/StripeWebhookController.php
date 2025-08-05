<?php

declare(strict_types=1);

namespace App\Http\Controllers\Payment;

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

class StripeWebhookController extends Controller
{
    public const PAYMENT_PLATFORM = "Stripe";

    public function checkout(Request $request): RedirectResponse
    {
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
                );
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

        $lineItems = [];
        $lineItems[] = [
            'price_data' => [
                'currency' => config('shop.currency'),
                'product_data' => [
                    'name' => $product->coins . ' ' . config('server.serverName') . ' coins',
                ],
                'unit_amount' => $product->value * 100,
            ],
            'quantity' => 1,
        ];
        $session = Session::create([
            'line_items' => $lineItems,
            'mode' => 'payment',
            'success_url' => route('account.store.payment-method.stripe.success', [], true) . "?session_id={CHECKOUT_SESSION_ID}",
            'cancel_url' => route('account.store.index', [], true),
        ]);

        WebOrderHistory::create([
            'account_id' => Auth::user()->id,
            'status' => 'unpaid',
            'price' => $product->value,
            'coins' => $product->coins,
            'session_id' => $session->id,
            'product_id' => $product->id,
        ]);

        return redirect($session->url);
    }

    public function success(Request $request): View|RedirectResponse
    {
        $sessionId = $request->get('session_id');
        try {
            $session = Session::retrieve($sessionId);
            if (!$session) {
                return redirect(route('account.store.index'))
                    ->with(
                        'error',
                        'Your session seems to be incorrect, please try again or contact the administrator.'
                    );
            }
            $webOrderHistory = WebOrderHistory::whereSessionId($session->id)->first();
            if (!$webOrderHistory) {
                return redirect(route('account.store.index'))
                    ->with(
                        'error',
                        'We could not find your order, please try again or contact the administrator.'
                    );
            }
            if ($webOrderHistory->status === 'unpaid') {
                $webOrderHistory->status = 'paid';
                if ($webOrderHistory->save()) {
                    $account = WebAccounts::whereAccountId($webOrderHistory->account_id)->first();
                    if ($account) {
                        $account->shop_coins = $account->shop_coins + $webOrderHistory->coins;
                        $account->save();
                        $this->discordAlert($webOrderHistory);
                        SendOrderStripeJob::dispatch($webOrderHistory);
                    }
                }
            }

            return redirect(route('account.index'))
                ->with(
                    'success',
                    sprintf(
                        'Thank you for your purchase! %s %s coins were added to your account.',
                        $webOrderHistory->coins,
                        config('server.serverName')
                    )
                );
        } catch (\Exception $e) {
            report($e);
            return redirect(route('account.store.index'))
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