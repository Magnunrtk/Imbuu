<?php

declare(strict_types=1);

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class SearchPaymentController extends Controller
{
    public function __construct()
    {
        $this->middleware('role:admin');
    }

    public function searchView(): View
    {
        return view('admin.payments.index');
    }

    public function search(Request $request): View
    {
        $orderHistory = $request->orderHistory;
        return view('admin.payments.search', compact('orderHistory'));
    }

    public function searchPost(Request $request): RedirectResponse
    {
        $searchEmail = (string) $request->input('searchEmail');
        return redirect()->route('admin.payments.paypal.search', $searchEmail);
    }
}
