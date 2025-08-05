<?php

declare(strict_types=1);

namespace App\Http\Controllers\Account\Auth;

use App\Http\Controllers\Controller;
use App\Jobs\SendRequestChangePasswordJob;
use App\Models\Account;
use App\Models\WebChangePassword;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Illuminate\View\View;
use App\Models\WebAccounts;
use App\Http\Controllers\EmailController;

class AccountChangePasswordController extends Controller
{
    public function __construct()
    {
        $this->middleware('role:admin | unconfirmeduser | user');
    }

    public function index(): View
    {


        // if (WebChangePassword::whereAccountId(Auth::user()->id)->exists()) {
        //     return view('account.manage.change.password.confirm')
        //         ->with('errorMessage', 'An email containing a confirmation link to change your password has already been sent. Please check your email folders including your spam/junk mail filter, or try again later.');
        // }

        return view('account.manage.change.password.index');
    }

    public function method(Request $request): View
    {
        $step = (string) $request->input('step');
        return match ($step) {
            'sendemail' => $this->sendChangePasswordEmail(),
            'enterpasswords' => $this->confirmChangePassword($request),
            'change' => $this->changePassword($request),
        };
    }

    public function sendChangePasswordEmail(): View
    {
        $webChangePassword = WebChangePassword::where('account_id', Auth::user()->id)->first();
        $passwordKey = Str::random(20);
        
        if ($webChangePassword) {

            WebChangePassword::where('account_id', Auth::user()->id)->update([
                'email' => Auth::user()->email,
                'confirmation_key' => $passwordKey,
            ]);

        }else{

            $webChangePassword = WebChangePassword::create([
                'account_id' => Auth::user()->id,
                'email' => Auth::user()->email,
                'confirmation_key' => $passwordKey,
            ]);
        }

        $accountId = $webChangePassword->account_id;
        $emailToSend = $webChangePassword->email;

        $emailController = new EmailController();
    
        $response = $emailController->changePassword(
            $emailToSend,
            'x',
            'https://ravenor.online/account/manage/change/password/confirm/' . $passwordKey,
            $accountId
        );
    
        if ($response->getStatusCode() !== 200) {

            $errorMessage = json_decode($response->getContent(), true)['message'] ?? 'An unexpected error occurred.';
            
            return view('account.manage.change.password.index')
                ->with('errorMessage', $errorMessage);
        }
   
        return view('account.manage.change.password.confirm');
    }

    public function confirmChangePassword(Request $request): View
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
            return view('account.manage.change.password.confirm')
                ->with('errorMessage', preg_replace('/\s+/', ' ', $validator->errors()->first()));
        }
        
        $confirmationKey = (string) $request->input('confirmationKey');
        $webChangePassword = WebChangePassword::whereAccountId(Auth::user()->id)
            ->whereConfirmationKey($confirmationKey)
            ->first();

        if (!$webChangePassword) {
            return view('account.manage.change.password.confirm')
                ->with('errorMessage', 'You have entered an invalid confirmation key!');
        }
        return view('account.manage.change.password.change', compact('confirmationKey'));
    }

    public function changePassword(Request $request): View
    {
        $messages = [
            'password.required' => 'Please enter your current password!',
            'password.string' => 'Your current password has invalid format.',
            'password.current_password' => 'Current password is not correct!',
            'newPassword.required' => 'Please enter a new password!',
            'newPassword.string' => 'Your new password has invalid format.',
            'newPassword.min' => 'The password must have at least :min letters.',
            'newPassword.max' => 'The password cannot have more than :max letters.',
            'newPassword.different' => 'Your new password cannot be same as current password.',
            'newPassword2.required' => 'Please enter the password again!',
            'newPassword2.string' =>  'Your new password has invalid format.',
            'newPassword2.same' =>  'The two passwords do not match!',
            'confirmationKey.required' => 'Please enter a valid confirmation key.',
            'confirmationKey.string' => 'Your confirmation key has invalid format.',
        ];
        $rules = [
            'password' => 'required|string|current_password',
            'newPassword' => 'required|string|min:1|max:30|different:password',
            'newPassword2' => 'required|string|same:newPassword',
            'confirmationKey' => 'required|string',
        ];
        $confirmationKey = (string) $request->input('confirmationKey');
        $validator = Validator::make($request->all(), $rules, $messages);
        if ($validator->fails()) {
            return view('account.manage.change.password.change', compact('confirmationKey'))
                ->with('errorMessage', preg_replace('/\s+/', ' ', $validator->errors()->first()));
        }
        $webChangePassword = WebChangePassword::whereAccountId(Auth::user()->id)
            ->whereConfirmationKey($confirmationKey)
            ->first();
        if (!$webChangePassword) {
            return view('account.manage.change.password.change', compact('confirmationKey'))
                ->with('errorMessage', 'You have entered an invalid confirmation key!');
        }
        Account::find(Auth::user()->id)->update(['password'=> Hash::make($request->newPassword)]);
        $webChangePassword->delete();

        $emailToSend = $webChangePassword->email;
        $emailController = new EmailController();
    
        $response = $emailController->changePasswordComplete(
            $emailToSend,
            'x',
            $request->newPassword,
            Auth::user()->id
        );
    
        if ($response->getStatusCode() !== 200) {
            $errorMessage = json_decode($response->getContent(), true)['message'] ?? 'An unexpected error occurred.';
            return view('account.manage.change.password.index')
                ->with('errorMessage', $errorMessage);
        }

        return view('account.manage.change.password.done');
    }

    public function viewConfirm(string $confirmationKey = null): View
    {
        $webChangePassword = WebChangePassword::whereAccountId(Auth::user()->id)
            ->whereConfirmationKey($confirmationKey)
            ->first();

        if (!$webChangePassword) {
            return view('account.manage.change.password.index', compact('confirmationKey'))
                ->with('errorMessage', 'This confirmation key <b>is expired or does not belong to this account.</b> Please make sure you are logged into the account corresponding to the link received in the email.');
        }

        return view('account.manage.change.password.confirm', compact('confirmationKey'));
    }
}
