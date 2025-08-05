<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Models\WebAccounts;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Cookie;

class TellAFriendController extends Controller
{
    public function index(string $referral): RedirectResponse
    {
        $referralAccount = WebAccounts::whereReferral($referral)->first();
        if ($referralAccount) {
            Cookie::queue('referral', $referralAccount->referral, 1440);
        }
        return redirect()->route('account.create.index');
    }
}
