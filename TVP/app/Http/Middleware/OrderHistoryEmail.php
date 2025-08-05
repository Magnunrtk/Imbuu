<?php

declare(strict_types=1);

namespace App\Http\Middleware;

use App\Models\WebOrderHistory;
use Closure;
use Illuminate\Http\RedirectResponse;

class OrderHistoryEmail
{
    /**
     * @param  \Illuminate\Http\Request $request
     * @param  \Closure $next
     * @return Closure|RedirectResponse
     */
    public function handle($request, Closure $next)
    {
        $emailAddress = str_replace('+', ' ', $request->route('emailAddress'));
        $orderHistory = WebOrderHistory::whereRaw('LOWER(`email`) LIKE ? ',[trim(strtolower($emailAddress))])->first();
        if (is_null($orderHistory)) {
            return redirect()->route('admin.payments.paypal.searchView')
                ->with(
                    'error',
                    sprintf('Email <b>%s</b> does not exist.', htmlspecialchars($emailAddress, ENT_QUOTES))
                );
        }
        if (strcmp($emailAddress, $orderHistory->email) !== 0) {
            return redirect()->route(
                'admin.payments.paypal.search',
                str_replace(' ', '+', $orderHistory->email)
            );
        }
        $request->orderHistory = $orderHistory;
        return $next($request);
    }
}
