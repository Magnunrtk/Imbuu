<?php

declare(strict_types=1);

namespace App\Http\Controllers\Account;

use App\Http\Controllers\Controller;
use App\Http\Requests\ResetPasswordRequest;
use App\Models\Account;
use App\Models\WebLostAccount;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Illuminate\View\View;

class NewPasswordController extends Controller
{
    public function index(): RedirectResponse|View
    {
        $email = (string) Session::get('email');
        $confirmationKey = (string) Session::get('confirmationKey');
        $lostAccount = WebLostAccount::whereConfirmationKey($confirmationKey)->whereEmail($email)->first();
        if(is_null($lostAccount) || $lostAccount->created_at <= Carbon::now()->subDay()) {
            return redirect(route('account.reset.password.index'))
                ->with(
                    'error',
                    'You have either entered an incorrect confirmation key or no password change has been submitted for this account.'
                );
        }
        return view('auth.new-password', compact('lostAccount'));
    }

    public function setNewPassword(ResetPasswordRequest $request): RedirectResponse
    {
        $email = (string) $request->input('email');
        $confirmationKey = (string) $request->input('confirmationKey');
        $lostAccount = WebLostAccount::whereConfirmationKey($confirmationKey)->whereEmail($email)->first();
        if(is_null($lostAccount) || $lostAccount->created_at <= Carbon::now()->subDay()) {
            return redirect(route('account.reset.password.index'))
                ->with(
                    'error',
                    'You have either entered an incorrect confirmation key or no password change has been submitted for this account.'
                );
        }
        $account = Account::find($lostAccount->account_id);
        $account->password = Hash::make($request->input('password'));
        $account->save();
        $lostAccount->delete();

        return redirect(route('account.login.index'))
            ->with(
                'success',
                sprintf(
                    'You have successfully changed your password. You can now use your new password to log into your %s account.',
                    config('server.serverName')
                ),
            );
    }
}
