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
use App\Models\Player;
use Illuminate\Support\Facades\DB;

class Packagescontroller extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(): View
    {
        return view('store.packages.index');
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

        return view('store.packages.select_payment');
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

        return view('store.packages.select_packages', compact('paymentId'));

        // return view(
        //     'store.select_product',
        //     compact(
        //         'paymentId'
        //     )
        // );
    }

    private function confirmOrder(Request $request): View
    {
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
            'acceptTerms.required' => 'You have to agree to the terms in order to get coins!',
            'pmid.required' => 'Please select a payment option.',
        ];

        $rules = [
            'acceptTerms' => 'required',
            'pmid' => 'required',
        ];

        $validator = Validator::make($request->all(), $rules, $messages);
        if ($validator->fails()) {
            return $this->selectProduct($request)->with('errorMessage', preg_replace('/\s+/', ' ', $validator->errors()->first()));
        }

        if($request->input('pmid') == 3 || $request->input('pmid') == 1){

            $productId = 6;
        }

        $product = WebShopProduct::whereId((int) $productId)
            ->wherePaymentOptionId(3)
            ->first();
          
        if (!$product) {
            return $this->selectProduct($request)->with('errorMessage', 'Selected product does not exists.');
        }

        $paymentMethod = $product->payment;

        $accountId = Auth::user()->id;
        $playerNames = Player::where('account_id', $accountId)
                     ->pluck('name')
                     ->toArray();

        if($request->input('pmid') == 1){

            $paymentMethod->slug = "stripe";
        }

        $discountConfig = DB::table('server_config')
        ->where('config', 'coupon_discount')
        ->value('value'); 
    
        $coupons = DB::table('streamers')->pluck('coupon_code'); 
        
        return view(
            'store.packages.confirm.' . $paymentMethod->slug,
            compact(
                'paymentMethod',
                'playerNames',
                'product',
                'bronze',
                'silver',
                'gold',
                'discountConfig', 
                'coupons' 
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
