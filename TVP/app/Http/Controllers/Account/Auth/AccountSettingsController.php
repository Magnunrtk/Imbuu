<?php

declare(strict_types=1);

namespace App\Http\Controllers\Account\Auth;

use App\Http\Controllers\Controller;
use Illuminate\View\View;

class AccountSettingsController extends Controller
{
    public function __construct()
    {
        $this->middleware('role:admin | unconfirmeduser | user');
    }

    public function index(): View
    {
        return view('account.settings.index');
    }
}
