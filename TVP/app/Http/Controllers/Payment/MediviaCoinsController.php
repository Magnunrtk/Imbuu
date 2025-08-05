<?php

declare(strict_types=1);

namespace App\Http\Controllers\Payment;

use App\Http\Controllers\Controller;
use App\Models\WebManualTransaction;
use App\Models\WebShopProduct;
use Carbon\Carbon;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Spatie\DiscordAlerts\Facades\DiscordAlert;

class MediviaCoinsController extends Controller
{
    public function checkout(Request $request): RedirectResponse
    {
        $messages = [
            'pmid.required' => 'Please select a payment option.',
            'characterName.required' => 'Invalid character name.',
            'characterName.regex' => 'Invalid character name.',
            'server.required' => 'Invalid server selected.',
            'server.in' => 'Selected server does not exists.',
            'acceptTermsAndAgreement.accepted' => 'You have to accept the terms before placing an order.',
            'product_id.required' => 'Please select a product.',
        ];
        $rules = [
            'characterName' => 'bail|required|regex:/^[A-Za-z-]+$/',
            'pmid' => 'bail|required',
            'product_id' => 'bail|required',
            'server' => 'bail|required|in:0,1,2',
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

        if (WebManualTransaction::whereAccountId(Auth::user()->id)->whereStatus(0)->exists()) {
            return redirect()
                ->route('account.store.index')
                ->with(
                    'error',
                    'There is a pending transaction already.'
                );
        }

        $server_number = intval($request->input('server'));
        $server = config('shop.payment_options')['medivia_coins']['characters'][$server_number];

        $product = WebShopProduct::whereId((int) $request->input('product_id'))->wherePaymentOptionId((int) $request->input('pmid'))->whereActive(true)->first();
        if (!$product) {
            return redirect()
                ->route('account.store.index')
                ->with(
                    'error',
                    'Selected product does not exists..'
                );
        }

        $transaction = WebManualTransaction::create([
            'account_id' => Auth::user()->id,
            'external_name' => $request->input('characterName'),
            'receiver_name' => $server['receiver_name'],
            'price' => $product->value,
            'coins' => $product->coins,
            'server_name' => $server['server'],
            'payment_option_id' => $product->payment_option_id,
            'product_id' => $product->id,
        ]);

        $this->discordAlert($transaction);

        return redirect(route('account.index'))
            ->with(
                'success',
                'Thank you for your purchase! Coins will be added to your account as soon as the transaction has been confirmed.',
            );
    }

    public static function getCityByName(string $serverName): string
    {
        if (isset(config('shop.payment_options')['medivia_coins']['server'])) {
            foreach (config('shop.payment_options')['medivia_coins']['server'] as $server) {
                if ($server['name'] === $serverName) {
                    return $server['city'];
                }
            }
        }

        return 'undefined';
    }

    static private function discordAlert(WebManualTransaction $transaction): void
    {
        $webhook = 'https://discord.com/api/webhooks/1122978739404415088/F4HMeDca0mW1fB7lSl2Yl7M-fqB13UgudDLV8AtXBkwnqyZDE0AFxsMI1eATqEHM9433';
        $dataHora = date('d/m/Y H:i:s');

        $data = [

                'content' =>("    
```[Ravenor] Nova doação Medivia Coins!

Account: $transaction->account_id

Server: $transaction->server_name

Medivia Character: $transaction->external_name

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

        // DiscordAlert::to('mc_donation')->message(
        //     sprintf('```[%s] New %s awaiting approval!\n\nAccount: %s\n\n%s: %s\n\nServer: %s\n\nMedivia Character: %s\n\n%s Coins: %s\n\nDate/Hour: %s```',
        //         config('server.serverName'),
        //         $transaction->payment->name,
        //         $transaction->account_id,
        //         $transaction->payment->name,
        //         number_format((float) $transaction->price, $transaction->product->decimals, ','),
        //         $transaction->server_name,
        //         $transaction->external_name,
        //         config('server.serverName'),
        //         $transaction->coins,
        //         Carbon::parse($transaction->created_at)->format('d/m/Y H:i:s')
        //     )
        // );
    }
}
