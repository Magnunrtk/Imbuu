<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Models\WebManualTransaction;
use App\Models\WebShopProduct;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\View\View;
use Illuminate\Support\Facades\DB;
use App\Models\Player;

class StoreController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(): View
    {
        return view('store.terms');
    }

    public function action(Request $request): View|RedirectResponse
    {
        return match ($request->input('action')) {
            'terms' => $this->selectPayment($request),
            'payment' => $this->selectProduct($request),
            'product' => $this->confirmOrder($request),
            default => redirect(route('account.store.index'))
                ->with(
                    'error',
                    'An error has been occurred while processing.'
                ),
        };
    }

    private function selectPayment(Request $request): View
    {
        $messages = [
            'acceptTerms.required' => 'You have to agree to the terms in order to get coins!',
        ];
        $rules = [
            'acceptTerms' => 'required',
        ];
        $validator = Validator::make($request->all(), $rules, $messages);
        if ($validator->fails()) {
            return $this->index()->with('errorMessage', preg_replace('/\s+/', ' ', $validator->errors()->first()));
        }

        return view('store.select_payment');
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
            'store.select_product',
            compact(
                'paymentId'
            )
        );
    }

    private function confirmOrder(Request $request): View
    {
        $messages = [
            'acceptTerms.required' => 'You have to agree to the terms in order to get coins!',
            'pmid.required' => 'Please select a payment option.',
            'product_id.required' => 'Please select a product.',
        ];
        $rules = [
            'acceptTerms' => 'required',
            'pmid' => 'required',
            'product_id' => 'required',
        ];
        $validator = Validator::make($request->all(), $rules, $messages);
        if ($validator->fails()) {
            return $this->selectProduct($request)->with('errorMessage', preg_replace('/\s+/', ' ', $validator->errors()->first()));
        }
        $product = WebShopProduct::whereId((int) $request->input('product_id'))
            ->wherePaymentOptionId((int) $request->input('pmid'))
            ->first();
        if (!$product) {
            return $this->selectPayment($request)->with('errorMessage', 'Selected product does not exists.');
        }

        $paymentMethod = $product->payment;

        $discountConfig = DB::table('server_config')
        ->where('config', 'coupon_discount')
        ->value('value');
        
        $accountId = Auth::user()->id;
        $playerNames = Player::where('account_id', $accountId)
                     ->pluck('name')
                     ->toArray();
    
        $coupons = DB::table('streamers')->pluck('coupon_code'); 

        return view(
            'store.confirm.' . $paymentMethod->slug,
            compact(
                'paymentMethod',
                'product',
                'discountConfig', 
                'coupons',
                'playerNames', 
            )
        );
    }

    public function list(): View
    {
        return view('store.list');
    }

    public function cancel(): RedirectResponse
    {
        $transaction = WebManualTransaction::whereAccountId(Auth::user()->id)->whereStatus(0)->first();
        if ($transaction) {
            $transaction->delete();
            return redirect(route('account.store.index'))
                ->with(
                    'success',
                    'Your pending transaction has been cancelled.',
                );
        }

        return redirect(route('account.store.index'))
            ->with(
                'error',
                'There is no pending transaction to cancel.',
            );
    }
}
