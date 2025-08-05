<?php

declare(strict_types=1);

namespace App\Http\Controllers\Account\Auth;

use App\Http\Controllers\Controller;
use App\Models\AccountBan;
use App\Models\WebAccounts;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class AccountUnbanController extends Controller
{
    public function __construct()
    {
        $this->middleware('role:admin | unconfirmeduser | user');
    }

    public function index(): View
    {
        return view('account.manage.unban.index');
    }

    public function action(): RedirectResponse
    {
        if (!config('shop.extraServices')['unban']['enabled']) {
            return redirect(route('account.index'));
        }
        $bannedAccount = AccountBan::find(Auth::user()->id);
        $webAccount = WebAccounts::find(Auth::user()->id);
        if(is_null($bannedAccount)) {
            return redirect(route('account.manage.unban.index'))
                ->with(
                    'error',
                    'Your account is not banned.'
                );
        }
        if ($webAccount->shop_coins < config('shop.extraServices')['unban']['price']) {
            return redirect(route('account.manage.unban.index'))
                ->with(
                    'error',
                    'You do not have enough coins, you can purchase more <a href="' . route('account.store.index') .'">here</a>.'
                );
        }
        $webAccount->shop_coins = $webAccount->shop_coins - config('shop.extraServices')['unban']['price'];
        if ($webAccount->save()) {
            $bannedAccount->delete();
        }
        return redirect(route('account.index'))
            ->with(
                'success',
                'You account has been unbanned.'
            );
    }
}
