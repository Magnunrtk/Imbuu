<?php

declare(strict_types=1);

namespace App\Http\Controllers\Account\Auth;

use App\Http\Controllers\Controller;
use App\Models\WebPremiumHistory;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class AccountPremiumHistoryController extends Controller
{
    public function __construct()
    {
        $this->middleware('role:admin | unconfirmeduser | user');
    }

    public function index(string $page = null): RedirectResponse|View
    {
        $entriesPerPage = 10;
        $totalPages = (int) ceil(
            (WebPremiumHistory::whereAccountId(Auth::user()->id)
                ->orderBy('created_at', 'desc')
                ->count()) / $entriesPerPage);
        if(!is_null($page) && $totalPages <= 0) {
            return redirect()->route('account.history.premium.index');
        }
        $page = (int) $page;
        $currentPage = ($page >= 1) ? $page : 1;
        $skip = ($currentPage === 1) ? 0 : ($currentPage - 1) * $entriesPerPage;
        $premiumHistories = WebPremiumHistory::whereAccountId(Auth::user()->id)
            ->orderBy('created_at', 'desc')
            ->skip($skip)
            ->take($entriesPerPage)
            ->get();
        if($totalPages > 1 && $page > $totalPages) {
            return redirect()->route('account.history.premium.index');
        }
        return view(
            'account.history.premium.index',
            compact
            (
                'premiumHistories',
                'totalPages',
                'currentPage',
            )
        );
    }
}
