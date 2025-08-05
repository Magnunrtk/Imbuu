<?php

declare(strict_types=1);

namespace App\Http\Controllers\Email\Auth;

use App\Http\Controllers\Controller;
use App\Http\Traits\RecoveryKey;
use App\Http\Traits\RunArtisanInBackground;
use App\Jobs\SendCancelChangeEmailJob;
use App\Jobs\SendConfirmChangeEmailByRecoveryKeyJob;
use App\Jobs\SendEmailSuccessfullyChangedJob;
use App\Jobs\SendRequestChangeEmailJob;
use App\Models\Account;
use App\Models\WebAccounts;
use App\Models\WebChangeEmail;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Illuminate\View\View;

class AccountChangeEmailController extends Controller
{
    use RunArtisanInBackground;
    use RecoveryKey;

    public function __construct()
    {
        $this->middleware('role:admin | user');
    }

    public function index(): View
    {
        return view('account.manage.change.email.index');
    }

    public function method(Request $request): View
    {
        $method = (integer) $request->input('method');
        return match ($method) {
            1 => $this->changeByEmail($request),
            2 => $this->changeByRecoveryKey($request)
        };
    }

    public function changeByEmail(Request $request): View
    {
        $step = (string) $request->input('step');
        return match ($step) {
            'changeemailrequest' => $this->changeEmailRequest($request),
            default => $this->viewByEmail(),
        };
    }

    public function changeByRecoveryKey(Request $request): View
    {
        $step = (string) $request->input('step');
        return match ($step) {
            'changeemailrequest' => $this->changeRecoveryKeyRequest($request),
            'enterpasswords' => $this->confirmRecoveryKeyChange($request),
            'setpasswordfornewemail' => $this->confirmRecoveryKeyEnterPassword($request),
            default => $this->viewByRecoveryKey(),
        };
    }

    public function viewConfirmRecoveryKey(string $confirmationKey = null): View
    {
        return view('account.manage.change.email.method.recovery-key.confirm', compact('confirmationKey'));
    }

    public function viewByRecoveryKey(): View
    {
        if(Auth::user()->awaitingEmailChange()){
            $webChangeEmail = WebChangeEmail::whereAccountId(Auth::user()->id)->whereConfirmed(false)->first();
            return view('account.manage.change.email.method.recovery-key.index', compact('webChangeEmail'));
        }
        return view('account.manage.change.email.method.recovery-key.index');
    }

    public function changeRecoveryKeyRequest(Request $request): View|RedirectResponse
    {
        $recoveryKey = $request->input('key1') . '-' . $request->input('key2') . '-' . $request->input('key3') . '-' . $request->input('key4');
        if (!$this->validateRecoveryKeyFormat($recoveryKey)) {
            return view('account.manage.change.email.method.recovery-key.index')
                ->with('errorMessage', 'Please enter a valid recovery key.');
        }
        $messages = [
            'email.required' => 'Please enter your new email address!',
            'email.email' => 'The email address is invalid. Please enter another email address!',
            'email.unique' => 'This email is already in use.',
            'email.email_change_active' => 'The email address of this account is already going to be changed. Cancel this request first if you want to assign another email address to your account!',
        ];
        $rules = [
            'email' => 'required|email|unique:accounts|unique:web_change_emails|email_change_active',
        ];
        $validator = Validator::make($request->all(), $rules, $messages);
        if ($validator->fails()) {
            return view('account.manage.change.email.method.recovery-key.index')
                ->with('errorMessage', preg_replace('/\s+/', ' ', $validator->errors()->first()));
        }
        $webAccount = WebAccounts::whereAccountId(Auth::user()->id)->whereRecoveryKey($recoveryKey)->first();
        if (!$webAccount) {
            return view('account.manage.change.email.method.recovery-key.index')
                ->with('errorMessage', 'The recovery key is invalid!');
        }
        $webChangeEmail = WebChangeEmail::create([
            'account_id' => Auth::user()->id,
            'change_date' => Carbon::now()
                ->second(0)
                ->minute(0)
                ->addHour()
                ->addDays(config('server.days_until_email_change')),
            'email' => Str::lower((string)$request->input('email')),
            'old_email' => Auth::user()->email,
            'confirmation_key' => Str::random('20')
        ]);
        $details = [
            'to' => $webChangeEmail->email,
            'confirmationKey' => $webChangeEmail->confirmation_key,
        ];
        SendConfirmChangeEmailByRecoveryKeyJob::dispatch($details);
        return view('account.manage.change.email.method.recovery-key.confirm', compact('webChangeEmail'));
    }


    public function confirmRecoveryKeyChange(Request $request): View
    {
        $messages = [
            'confirmationKey.required' => 'You have entered an invalid confirmation key!',
            'confirmationKey.string' => 'The confirmation key format is invalid.',
        ];
        $rules = [
            'confirmationKey' => 'required|string',
        ];
        $validator = Validator::make($request->all(), $rules, $messages);
        if ($validator->fails()) {
            return view('account.manage.change.email.method.recovery-key.confirm')
                ->with('errorMessage', preg_replace('/\s+/', ' ', $validator->errors()->first()));
        }
        $confirmationKey = (string) $request->input('confirmationKey');
        $webChangeEmail = WebChangeEmail::whereAccountId(Auth::user()->id)
            ->whereConfirmationKey($confirmationKey)
            ->whereConfirmed(false)
            ->first();
        if (!$webChangeEmail) {
            return view('account.manage.change.email.method.recovery-key.confirm')
                ->with('errorMessage', 'You have entered an invalid confirmation key!');
        }
        return view('account.manage.change.email.method.recovery-key.password', compact('confirmationKey'));
    }

    public function confirmRecoveryKeyEnterPassword(Request $request): View
    {
        $messages = [
            'confirmationKey.required' => 'You have entered an invalid confirmation key!',
            'confirmationKey.string' => 'The confirmation key format is invalid.',
            'password.required' => 'Please enter your current password!',
            'password.string' => 'Please enter your current password!',
            'password.current_password' => 'Current password is not correct!',
            'newPassword.required' => 'You need to provide a new password.',
            'newPassword.string' => 'Your new password has invalid format.',
            'newPassword.min' => 'Your new password needs to be at least :min letters.',
            'newPassword.max' => 'Your password cannot have more than :max letters.',
            'newPassword.different' => 'The new password has been already used by you before. Please enter a different new password!',
            'confirmNewPassword.required' => 'You need to confirm your new password.',
            'confirmNewPassword.string' =>  'Your confirm password has invalid format.',
            'confirmNewPassword.same' =>  'The two passwords do not match!',
        ];
        $rules = [
            'confirmationKey' => 'required|string',
            'password' => 'required|string|current_password',
            'newPassword' => 'required|string|min:6|max:12|different:password',
            'confirmNewPassword' => 'required|string|same:newPassword',
        ];
        $confirmationKey = (string) $request->input('confirmationKey');
        $validator = Validator::make($request->all(), $rules, $messages);
        if ($validator->fails()) {
            return view('account.manage.change.email.method.recovery-key.password', compact('confirmationKey'))
                ->with('errorMessage', preg_replace('/\s+/', ' ', $validator->errors()->first()));
        }
        $webChangeEmail = WebChangeEmail::whereAccountId(Auth::user()->id)
            ->whereConfirmationKey($confirmationKey)
            ->whereConfirmed(false)
            ->first();
        if (!$webChangeEmail) {
            return view('account.manage.change.email.method.recovery-key.password', compact('confirmationKey'))
                ->with('errorMessage', 'You have entered an invalid confirmation key!');
        }
        $account = Account::find(Auth::user()->id);
        $account->password = Hash::make($request->input('newPassword'));
        $account->email = $webChangeEmail->email;
        if ($account->save()) {
            $webChangeEmail->delete();
        }
        Auth::logout();
        SendEmailSuccessfullyChangedJob::dispatch(['to' => $webChangeEmail->email]);
        return view('account.manage.change.email.method.recovery-key.done', compact('confirmationKey'));
    }

    public function viewByEmail(): View
    {
        if(Auth::user()->awaitingEmailChange()){
            $webChangeEmail = WebChangeEmail::whereAccountId(Auth::user()->id)
                ->whereConfirmed(false)
                ->whereNotNull('confirmation_key')
                ->first();
            return view('account.manage.change.email.method.email.cancel', compact('webChangeEmail'));
        }
        return view('account.manage.change.email.method.email.index');
    }

    public function changeEmailRequest(Request $request): View|RedirectResponse
    {

        $messages = [
            'email.required' => 'Please enter a valid email address.',
            'email.email' => 'The email address is invalid. Please enter another email address!',
            'email.unique' => 'This email is already in use.',
            'email.email_change_active' => 'The email address of this account is already going to be changed. Cancel this request first if you want to assign another email address to your account!',
            'password.required' => 'The password is required.',
            'password.string' => 'The password format is invalid.',
            'password.current_password' => 'The password you have entered is not correct!',
        ];
        $rules = [
            'email' => 'required|email|unique:accounts|unique:web_change_emails|email_change_active',
            'password' => 'required|string|current_password',
        ];
        $validator = Validator::make($request->all(), $rules, $messages);
   
        if ($validator->fails()) {
            return view('account.manage.change.email.method.email.index')
                ->with('errorMessage', preg_replace('/\s+/', ' ', $validator->errors()->first()));
        }
        
        $webChangeEmail = WebChangeEmail::create([
            'account_id' => Auth::user()->id,
            'change_date' => Carbon::now()
                ->second(0)
                ->minute(0)
                ->addHour()
                ->addDays(config('server.days_until_email_change')),
            'email' => Str::lower((string)$request->input('email')),
            'old_email' => Auth::user()->email,
        ]);

        SendRequestChangeEmailJob::dispatchNow($webChangeEmail);

        return view('account.manage.change.email.method.email.cancel', compact('webChangeEmail'));
    }

    public function cancelChangeEmail(): RedirectResponse
    {
        if(Auth::user()->awaitingEmailChange()) {
            $emailToConfirm = WebChangeEmail::whereAccountId(Auth::user()->id)->whereConfirmed(false)->first();
            $details = [
                'to' => $emailToConfirm->old_email,
            ];
            SendCancelChangeEmailJob::dispatch($details);
            $emailToConfirm->delete();
            return redirect(route('account.manage.index'))
                ->with(
                    'success',
                    'Your request to change the email address of your account has been cancelled. The email address will not be changed.'
                );
        }

        return redirect(route('account.manage.email.change.index'))
            ->with(
                'error',
                'There is no change request to cancel.'
            );
    }
}
