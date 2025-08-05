<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class PurchaseHistoryController extends Controller
{
    public function index()
    {
        $accountId = Auth::user()->id;
        // $accountId = 79010111;

        $gamePurchases = DB::table('store_history')
            ->where('account_id', $accountId)
            ->select(
                'id as tx_id',
                'description',
                DB::raw('CAST(coin_amount AS SIGNED) as coin_amount'),
                'time',
                DB::raw("'In-Game' as origin")
            );

        $webPurchases = DB::table('web_order_histories')
            ->where('account_id', $accountId)
            ->where('status', 'paid')
            ->select(
                'id as tx_id',
                DB::raw("'Donation' as description"),
                DB::raw('coins as coin_amount'),
                DB::raw('updated_at as time'),
                DB::raw("'Web Get Coins' as origin")
            );

        $all = $gamePurchases->unionAll($webPurchases)->get();

        $normalized = $all->map(function($p) {
            $p->parsed_time = is_numeric($p->time)
                ? (int) $p->time
                : strtotime($p->time);
            return $p;
        });

        $chronological = $normalized->sort(function($a, $b) {
            if ($a->parsed_time === $b->parsed_time) {
                return $a->tx_id <=> $b->tx_id;
            }
            return $a->parsed_time <=> $b->parsed_time;
        })->values();

        $balance = 0;
        foreach ($chronological as $tx) {
            $balance += $tx->coin_amount;
            $tx->balance_after = $balance;
        }

        $forDisplay = $chronological->sort(function($a, $b) {
            if ($a->parsed_time === $b->parsed_time) {
                return $b->tx_id <=> $a->tx_id;
            }
            return $b->parsed_time <=> $a->parsed_time;
        })->values();

        $currentBalance = DB::table('web_accounts')
            ->where('account_id', $accountId)
            ->value('shop_coins') ?? 0;

        return view('account.manage.purchase-history', [
            'gamePurchases'  => $forDisplay,
            'currentBalance' => $currentBalance,
        ]);
    }
}
