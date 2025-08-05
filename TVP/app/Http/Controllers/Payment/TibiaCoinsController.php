<?php

declare(strict_types=1);

namespace App\Http\Controllers\Payment;

use App\Http\Controllers\Controller;
use App\Models\WebManualTransaction;
use App\Models\WebShopProduct;
use App\Utils\TibiaData;
use Carbon\Carbon;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Spatie\DiscordAlerts\Facades\DiscordAlert;

class TibiaCoinsController extends Controller
{
    public function checkout(Request $request): RedirectResponse
    {
        $messages = [
            'pmid.required' => 'Please select a payment option.',
            'characterName.required' => 'Invalid character name.',
            'characterName.regex' => 'Invalid character name.',
            'acceptTermsAndAgreement.accepted' => 'You have to accept the terms before confirming your order.',
            'product_id.required' => 'Please select a product.',
        ];
        $rules = [
            'characterName' => 'bail|required|regex:/^[A-Za-z-]+$/',
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

        if (!TibiaData::characterExists($request->input('characterName'))) {
            return redirect()
                ->route('account.store.index')
                ->with(
                    'error',
                    'A character with this name does not exists at Tibia.com'
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
            'receiver_name' => config('shop.payment_options')['tibia_coins']['receiver_name'],
            'price' => $product->value,
            'coins' => $product->coins,
            'payment_option_id' => $product->payment_option_id,
            'product_id' => $product->id,
        ]);

        $webhook = 'https://discord.com/api/webhooks/1103033201506664500/OtEZBwLns8ldqP2PxVfgnYovAXVM1RCr83znIKcaBoie6rQLoRAX9IBtb7JC6cKPvcqw';


        $dataHora = date('d/m/Y H:i:s');
        
        $userId = Auth::user()->id;
        $charName = $request->input('characterName');

        $data = [

                'content' =>("    
```[Ravenor] Nova doação Tibia Coins!

Account: $userId

Tibia Coins: $product->value

Tibia Character: $charName

Ravenor Coins: $product->coins

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
        
        //$this->discordAlert($transaction);
        return redirect(route('account.index'))
            ->with(
                'success',
                'Thank you for your purchase! Coins will be added to your account as soon as the transaction has been confirmed.',
            );
    }

    static private function discordAlert(WebManualTransaction $transaction): void
    {
        DiscordAlert::to('tc_donation')->message(
            sprintf('```[%s] New %s awaiting approval!\n\nAccount: %s\n\n%s: %s\n\nTibia Character: %s\n\n%s Coins: %s\n\nDate/Hour: %s```',
                config('server.serverName'),
                $transaction->payment->name,
                $transaction->account_id,
                $transaction->payment->name,
                number_format((float) $transaction->price, $transaction->product->decimals, ','),
                $transaction->external_name,
                config('server.serverName'),
                $transaction->coins,
                Carbon::parse($transaction->created_at)->format('d/m/Y H:i:s')
            )
        );
    }
}