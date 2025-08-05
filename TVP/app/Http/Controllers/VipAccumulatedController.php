<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\VipAccumulated;
use App\Models\WebAccounts;
use App\Models\Player;
use Illuminate\Support\Facades\Auth;

class VipAccumulatedController extends Controller
{
    public function storeVipAccumulated()
    {
        $userId = Auth::user()->id;
        $days = 3;
        $date = now()->format('Y-m-d H:i:s');

        $webAccount = WebAccounts::where('account_id', $userId)->first();

        if ($webAccount && $webAccount->bonus_recive === null && $webAccount->referred_by !== null) {

            VipAccumulated::create([
                'account_id' => $userId,
                'days' => $days,
                'date' => $date,
            ]);

            $webAccount->bonus_recive = 1;
            $webAccount->save();

            return response()->json(['message' => 'Bonus received!']);
        } else {
            return response()->json(['message' => 'You have already received this bonus.']);
        }
    }

    public function bonusGive(Request $request)
    {

        $name = preg_replace('/[^a-zA-Z\'\s]/', '', $request->input('name'));
        $player = Player::where('name', $name)->first();

        if (!$player) {
            return response()->json(['message' => 'Player not found.']);
        }

        $accountId = $player->account_id;
        $days = 7;
        $date = now()->format('Y-m-d H:i:s');

        $webAccount = WebAccounts::where('account_id', $accountId)->first();
        $userId = Auth::user()->id;

        if($webAccount->referred_by !== $userId){

            return response()->json(['message' => 'You cannot receive something that does not belong to you.']);
        }

        if ($webAccount && $webAccount->bonus_recive == 1) {
            VipAccumulated::create([
                'account_id' => $userId,
                'days' => $days,
                'date' => $date,
            ]);

            $webAccount->bonus_recive = 2;
            $webAccount->save();

            return response()->json(['message' => 'Bonus received!']);
        } else {
            return response()->json(['message' => 'You have already received this bonus.']);
        }
    }
}
