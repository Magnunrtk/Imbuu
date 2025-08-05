<?php

declare(strict_types=1);

namespace App\Http\Traits;

use App\Models\WebAccounts;
use App\Models\WebOrderHistory;

trait Referral
{
    public function addCoinsToReferral(WebAccounts $account, int $purchasedCoins): void
    {
        if (is_null($account->referred_by)) {
            return;
        }
        $referredAccount = WebAccounts::whereAccountId($account->referred_by)->first();
        if ($referredAccount) {
            $referredCoins = ceil($purchasedCoins * ($referredAccount->referral_bonus / 100));
            $referredAccount->shop_coins += $referredCoins;
            $referredAccount->save();
            WebOrderHistory::create([
                'account_id' => $referredAccount->account_id,
                'status' => 'referral',
                'price' => 0.00,
                'coins' => $referredCoins,
                'session_id' => $account->account_id,
            ]);
        }
    }
}