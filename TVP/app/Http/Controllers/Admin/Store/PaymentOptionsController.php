<?php

declare(strict_types=1);

namespace App\Http\Controllers\Admin\Store;

use App\Http\Controllers\Controller;
use Illuminate\View\View;

class PaymentOptionsController extends Controller
{
    public function __construct()
    {
        $this->middleware('role:admin');
    }

    public function index(): View
    {
        return view(
            'admin.store.payment-options.index'
        );
    }
}
