<?php

declare(strict_types=1);

namespace App\Http\Controllers\Payment;

use App\Http\Controllers\Controller;
use App\Jobs\SendOrderPayPalJob;
use App\Models\WebAccounts;
use App\Models\WebOrderHistory;
use App\Models\WebShopProduct;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Srmklive\PayPal\Services\PayPal as PayPalClient;
use Illuminate\Http\Request;

class PayPalWebhookController extends Controller
{
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

        $provider = new PayPalClient;
        $provider->setApiCredentials(config('shop.payment_options')['paypal']);
        $paypalToken = $provider->getAccessToken();
        $response = $provider->createOrder([
            "intent" => "CAPTURE",
            "application_context" => [
                "return_url" => route('account.store.payment-method.paypal.success'),
                "cancel_url" => route('account.store.index'),
            ],
            "purchase_units" => [
                0 => [
                    "amount" => [
                        "currency_code" => config('shop.currency'),
                        "value" => $product->value
                    ]
                ]
            ]
        ]);
        if (isset($response['id']) && $response['id'] != null) {
            foreach ($response['links'] as $links) {
                if ($links['rel'] == 'approve') {
                    WebOrderHistory::create([
                        'account_id' => Auth::user()->id,
                        'status' => 'unpaid',
                        'price' => $product->value,
                        'coins' => $product->coins,
                        'session_id' => $response['id'],
                        'product_id' => $product->id,
                    ]);
                    return redirect()->away($links['href']);
                }
            }
            return redirect()
                ->route('account.store.index')
                ->with('error', 'An error occurred while processing. Your bank account was not charged.');
        } else {
            return redirect()
                ->route('account.store.payment-method.paypal.success')
                ->with('error', $response['message'] ?? 'An error occurred while processing.');
        }
    }

    public function success(Request $request): RedirectResponse
    {
        $provider = new PayPalClient;
        $provider->setApiCredentials(config('shop.payment_options')['paypal']);
        $provider->getAccessToken();
        $response = $provider->capturePaymentOrder($request['token']);
        if (isset($response['status']) && $response['status'] == 'COMPLETED') {
            $webOrderHistory = WebOrderHistory::whereSessionId($response['id'])->first();
            if (!$webOrderHistory) {
                return redirect(route('account.store.index'))
                    ->with(
                        'error',
                        'We could not find your order, please try again or contact the administrator.'
                    );
            }
            if ($webOrderHistory->status === 'unpaid') {
                $webOrderHistory->status = 'paid';
                $webOrderHistory->email = $response['payer']['email_address'];
                if ($webOrderHistory->save()) {
                    $account = WebAccounts::whereAccountId($webOrderHistory->account_id)->first();
                    if ($account) {
                        $account->shop_coins = $account->shop_coins + $webOrderHistory->coins;
                        $account->save();
                        SendOrderPayPalJob::dispatch($webOrderHistory);
                    }
                }
            }
            return redirect(route('account.index'))
                ->with(
                    'success',
                    'Thank you for your purchase! Coins were added to your account.',
                );
        } else {
            return redirect(route('account.store.index'))
                ->with(
                    'error',
                    $response['message'] ?? 'Something went wrong.'
                );
        }
    }
}