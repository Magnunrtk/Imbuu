<?php

declare(strict_types=1);

namespace App\Http\Controllers\Account;

use App\Http\Controllers\Controller;
use App\Http\Requests\ResetPasswordRequest;
use App\Models\WebLostAccount;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;

class ResetPasswordController extends Controller
{
    public function index(): View
    {
        return view('auth.new-password');
    }

    public function resetPassword(ResetPasswordRequest $request): RedirectResponse
    {
        $acceptNewPassword = (string) $request->has('acceptNewPassword');
        if (!$acceptNewPassword) {
            return Redirect::route('account.reset.password.index')
                ->with(
                    'error',
                    'Please confirm that you want to get a new password.'
                );
        }
        $email = (string) $request->input('email');
        $confirmationKey = (string) $request->input('confirmationKey');
        $lostAccount = WebLostAccount::whereConfirmationKey($confirmationKey)->whereEmail($email)->first();
        if(is_null($lostAccount) || $lostAccount->created_at <= Carbon::now()->subDay()) {
            return Redirect::route('account.reset.password.index')
                ->with(
                    'error',
                    'You have either entered an incorrect confirmation key or no password change has been submitted for this account.'
                );
        }
        return Redirect::route('account.reset.password.new.index')->with(
            [
            'email' => $lostAccount->email,
            'confirmationKey' => $lostAccount->confirmation_key
            ]
        );
    }
}
