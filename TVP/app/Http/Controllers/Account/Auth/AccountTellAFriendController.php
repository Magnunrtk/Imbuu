<?php

declare(strict_types=1);

namespace App\Http\Controllers\Account\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\CreateReferralRequest;
use App\Models\WebAccounts;
use App\Utils\FormatText;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Str;
use Illuminate\View\View;
use Illuminate\Support\Facades\DB;

class AccountTellAFriendController extends Controller
{
    public function __construct()
    {
        $this->middleware('role:admin | unconfirmeduser | user');
    }

    public function index(): View
    {
        $userId = Auth::user()->id;

        $referredAccounts = DB::table('web_accounts')
                            ->where('account_id', $userId)
                            ->pluck('referred_by');

        if($referredAccounts[0] != null){

            $invitedAccounts = DB::table('web_accounts')
            ->whereIn('account_id', $referredAccounts)
            ->pluck('referral');

            $existsPaidOrder = DB::table('web_order_histories')
            ->where('account_id', $userId)
            ->where('status', 'paid')
            ->exists();

            $existingRecord = DB::table('store_history')
            ->where('account_id', $userId)
            ->where('description', 'Premium Scroll 30 Days')
            ->first();

            $bonusRecive = DB::table('web_accounts')
            ->where('account_id', $userId)
            ->pluck('bonus_recive');

            if($bonusRecive[0] == null){

                $bonusRecive = null;
            }

            return view('account.manage.tell-a-friend.index', compact('invitedAccounts', 'existsPaidOrder', 'existingRecord', 'bonusRecive'));

        }else{

            $invitedAccounts = null;

            return view('account.manage.tell-a-friend.index', compact('invitedAccounts'));
        }
    }

    public function statistics(): View
    {
        $invitedAccounts = WebAccounts::whereReferredBy(Auth::user()->id)->get();    

        return view('account.manage.tell-a-friend.statistics', compact('invitedAccounts'));
    }

    public function create(CreateReferralRequest $createReferralRequest): RedirectResponse
    {
        $referralName = $createReferralRequest->input('name');
        $checkReferralName = FormatText::checkTextFormat($referralName, 'referral name');
        if (!empty($checkReferralName)) {
            return Redirect::back()->with('error', $checkReferralName);
        }
        $webAccount = WebAccounts::find(Auth::user()->id);
        if (!is_null($webAccount->referral)) {
            return Redirect::back()->with('error', 'You already set a referral name.');
        }
        $webAccount->referral = Str::lower($referralName);
        $webAccount->save();
        return Redirect::back()->with('success', 'Your invite link is now ready.');
    }
}
