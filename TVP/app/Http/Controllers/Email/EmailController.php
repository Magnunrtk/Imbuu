<?php

declare(strict_types=1);

namespace App\Http\Controllers\Email;

use App\Http\Controllers\Controller;
use App\Http\Traits\RecoveryKey;
use App\Http\Traits\RunArtisanInBackground;
use App\Models\Account;
use App\Models\WebAccounts;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Illuminate\View\View;
use App\Http\Controllers\EmailController as BaseEmailController;

class EmailController extends Controller
{
    use RunArtisanInBackground;
    use RecoveryKey;

    public function index(string $emailHash, string $confirmationKey): View
    {
        $confirmAccount = WebAccounts::whereConfirmationKey($confirmationKey)->first();

        if (!$confirmAccount || !$confirmAccount->account || $emailHash !== md5($confirmAccount->account->email)) {
            return view('email.recovery-key.step-1', [
                'emailHash' => $emailHash,
                'confirmationKey' => $confirmationKey,
                'errorMessage' => 'This confirmation link is invalid or expired. Please request the confirmation email again.',
            ]);
        }

        if(true) { // $confirmAccount && !$confirmAccount->confirmed && $emailHash === md5($confirmAccount->account->email)

            $recoveryKey = $this->recoveryKeyGenerate();
            $confirmAccount->recovery_key = $recoveryKey;

            $confirmAccount->save();
            return view(
                'email.recovery-key.step-1',
                compact(
                    'emailHash',
                    'confirmationKey',
                    'recoveryKey',
                )
            );
        }

        return view(
            'email.recovery-key.step-1',
            compact(
                'emailHash',
                'confirmationKey',
            )
        );
    }

    public function checkRecoveryKey(string $emailHash, string $confirmationKey): View
    {
        $confirmAccount = WebAccounts::whereConfirmationKey($confirmationKey)->first();
        if ($confirmAccount && !$confirmAccount->confirmed && $emailHash === md5($confirmAccount->account->email)) {
            $recoveryKey = $confirmAccount->recovery_key;
            return view(
                'email.recovery-key.step-1',
                compact(
                    'emailHash',
                    'confirmationKey',
                    'recoveryKey',
                )
            );
        }
        return view(
            'email.recovery-key.step-1',
            compact(
                'emailHash',
                'confirmationKey',
            )
        );
    }

    public function confirmRecoveryKey(string $emailHash, string $confirmationKey): RedirectResponse|View
    {
        $confirmAccount = WebAccounts::whereConfirmationKey($confirmationKey)->first();
        if ($confirmAccount) {
            if($emailHash === md5($confirmAccount->account->email)) {
                $recoveryKey = $confirmAccount->recovery_key;
                return view(
                    'email.recovery-key.step-2',
                    compact(
                        'emailHash',
                        'confirmationKey',
                        'recoveryKey'
                    )
                );
            }
        }
        return redirect(route('landing'));
    }

    public function confirmAccount(Request $request): RedirectResponse|View
    {

        $recoveryKey = $request->input('key1') . '-' . $request->input('key2') . '-' . $request->input('key3') . '-' . $request->input('key4');
        if (!$this->validateRecoveryKeyFormat($recoveryKey)) {
            return redirect()->back()
                ->with(
                    'error',
                    'You have entered an incorrect recovery key!'
                );
        }

        $messages = [
            'email.required' => 'Please enter a valid email address.',
            'confirmationKey.required' => 'You have to enter an confirmation key.',
        ];

        $rules = [
            'email' => 'required',
            'confirmationKey' => 'bail|required',
        ];

        $validator = Validator::make($request->all(), $rules, $messages);
        if ($validator->fails()) {
            return redirect()->back()
                ->with(
                    'error',
                    preg_replace('/\s+/', ' ', $validator->errors()->first())
                );
        }

        $emailHash = $request->input('email');
        $confirmationKey = $request->input('confirmationKey');
        $confirmAccount = WebAccounts::whereConfirmationKey($confirmationKey)->first();
        if(is_null($confirmAccount)) {
            return redirect()->back()
                ->with(
                    'error',
                    'Your account could not be found.<br>If you have entered the link manually, please verify that you copied it correctly.'
                );
        }
        if (!$confirmAccount->confirmed && $emailHash === md5($confirmAccount->account->email)) {
            if (Str::lower($confirmAccount->recovery_key) !== Str::lower($recoveryKey)) {
                return redirect()->back()
                    ->with(
                        'error',
                        'You have entered an incorrect recovery key!'
                    );
            }
            if ($confirmAccount) {

                $account = Account::find($confirmAccount->account_id);
                $confirmAccount->confirmed = true;
                $confirmAccount->save();
                $account->detachAllRoles();
                $account->attachRole(config('new_account.confirmed_user_role'));

                $emailController = new BaseEmailController();

                $emailController->sendCompleteConfirmation(
                    $account->email,
                    'x',
                    $confirmAccount->recovery_key,
                    $confirmAccount->account_id,
                );
            }
        }

        return view('email.recovery-key.step-3');
    }
}
