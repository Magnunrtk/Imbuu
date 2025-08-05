<?php

declare(strict_types=1);

namespace App\Http\Controllers\Account\Auth;

use App\Http\Controllers\Controller;
use App\Http\Controllers\EmailController;

use App\Http\Requests\AccountChangeEmailRequest;
use App\Http\Traits\RunArtisanInBackground;

use App\Jobs\SendConfirmationEmailJob;
use App\Models\Account;
use App\Models\WebAccounts;
use App\Models\Player;

use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Illuminate\View\View;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use Illuminate\Support\Facades\Validator;

use PragmaRX\Google2FA\Google2FA;
use chillerlan\QRCode\QRCode;
use chillerlan\QRCode\QROptions;
use Illuminate\Support\Facades\Cache;

class LoginController extends Controller
{
    use RunArtisanInBackground;
    

    public function __construct()
    {
        $this->middleware('role:admin | unconfirmeduser | user');
    }

    public function index(): View
    {
        $user = Auth::user();

        $isConfirmed = (bool) WebAccounts::where('account_id', $user->id)->value('confirmed') ?? false;
        $hasSecurityQuestions = DB::table('security_questions')->where('account_id', $user->id)->exists();

        return view('account.overview.index', compact('isConfirmed', 'hasSecurityQuestions'));
    }

    public function manage(): View
    {
        $user = Auth::user();
        $isConfirmed = (bool) Account::where('id', $user->id)->value('google2fa_secret') ?? false;
        $hasSecurityQuestions = DB::table('security_questions')->where('account_id', $user->id)->exists();

        return view('account.manage.index', compact('isConfirmed', 'hasSecurityQuestions'));
    }

    public function generateQRCode(Request $request)
    {
        $user = $request->user();
        $account = WebAccounts::where('account_id', $user->id)->first();

        if (!$account->confirmed) {
            return back()->with('error', 'Your account is not confirmed. Please confirm your account before enabling Two-Step Verification.');
        }

        $google2fa = new Google2FA();
    
        $secret = Cache::get("google2fa_secret_{$user->id}");
    
        if (!$secret) {
            $secret = $google2fa->generateSecretKey();
            Cache::put("google2fa_secret_{$user->id}", $secret, now()->addMinutes(30));
        }
    
        $qrCodeUrl = $google2fa->getQRCodeUrl(
            "Ravenor", 
            $user->email, 
            $secret
        );
    
        $options = new QROptions([
            'outputType' => QRCode::OUTPUT_IMAGE_PNG,
            'eccLevel'   => QRCode::ECC_L,
            'scale'      => 5,
        ]);

        $qrCodeData = (new QRCode($options))->render($qrCodeUrl);

        return view('account.manage.googleAuth.index', [
            'qrCodeImageUrl' => $qrCodeData
        ]);
    }

    public function verify2FACode(Request $request)
    {
        $user = $request->user();
        $google2fa = new Google2FA();
        $inputCode = $request->code;
    
        $secret = Cache::get("google2fa_secret_{$user->id}");
    
        if (!$secret) {
            return response()->json([
                'message' => 'Secret not found. Please try again.',
                'status_code' => 400
            ], 400);
        }
    
        $attempts = Cache::get("google2fa_attempts_{$user->id}", 0);
    
        if ($attempts >= 10) {
            return response()->json([
                'message' => 'You have exceeded the number of attempts. Please try again in 5 minutes.',
                'status_code' => 429
            ], 429);
        }
    
        $isValid = $google2fa->verifyKey($secret, $inputCode);
    
        if ($isValid) {

            $user->google2fa_secret = $secret;
            $user->save();
    
            Cache::forget("google2fa_secret_{$user->id}");
            Cache::forget("google2fa_attempts_{$user->id}");
    
            return response()->json([
                'message' => '2FA successfully verified!',
                'status_code' => 200
            ], 200);
        }
    
        Cache::increment("google2fa_attempts_{$user->id}");
    
        if ($attempts == 0) {
            Cache::put("google2fa_attempts_{$user->id}", 1, now()->addMinutes(5));
        }
    
        return response()->json([
            'message' => 'Invalid code. Please try again.',
            'status_code' => 400
        ], 400);
    }

    public function resendConfirmationEmail(): RedirectResponse|View
    {
        
        $webAccount = WebAccounts::find(Auth::user()->id);
        $emailSelect = Auth::user()->email;
        $highestLevelPlayer = Player::where('account_id', $webAccount->account_id)
        ->orderBy('level')
        ->first();

        $emailController = new EmailController();
        $emailController->sendConfirmationEmail(
            $emailSelect,
            $highestLevelPlayer->name,
            'https://ravenor.online/account/confirm/' . md5($emailSelect) . '/' . $webAccount->confirmation_key,
            $webAccount->account_id
        );

        return view('account.overview.email.resent');
    }

    public function changeConfirmationEmail(): View
    {

        /** @var \jeremykenedy\LaravelRoles\Traits\HasRoleAndPermission $user */
        $user = Auth::user();

        if($user->hasRole('unconfirmeduser')) {

            return view('account.overview.email.change.index', ['accountVerify' => false]);
        }else{

            return view('account.overview.email.change.index', ['accountVerify' => true]);
        }
    }

    public function changeConfirmationEmailAction(Request $request)
    {

        /** @var \jeremykenedy\LaravelRoles\Traits\HasRoleAndPermission $user */
        $user = Auth::user();
        $emailSelect = $request->input('email');

        $emailSelect = trim(strval($emailSelect)); // Remove espaços em branco

        $validator = Validator::make(['email' => $emailSelect], [
            'email' => [
                'required',
                'email',
                'regex:/^[\w\.-]+@[\w\.-]+\.\w+$/', // Regex para validar o formato do e-mail
            ],
        ], [
            'email.required' => 'Please enter a valid email address.',
            'email.email' => 'Please enter a valid email address.',
            'email.regex' => 'Please enter a valid email address format.',
        ]);
        
        if ($validator->fails()) {
            return redirect(route('account.email.confirmation.change.index'))
                ->with('error', $validator->errors()->first());
        }   

        if($user->hasRole('unconfirmeduser')) {

            $webAccount = WebAccounts::find(Auth::user()->id);
            $account = Account::find(Auth::id());
    
            $emailExists = DB::table('accounts')->where('email', $emailSelect)->exists();
            
            if($emailExists){
    
                return redirect(route('account.email.confirmation.change.index'))
                ->with(
                    'error',
                    'This email is already being used.'
                );
            } 
    
            if ($webAccount) {
    
                $account->email = Str::lower($emailSelect);
                $account->save();
                return view('account.overview.email.change.action', compact('account'));
            }

        }else{

            $rk = $request->input('rkBlock1') . "-" . $request->input('rkBlock2') . "-" . $request->input('rkBlock3') . "-" . $request->input('rkBlock4');
    
            $webAccount = WebAccounts::find(Auth::user()->id);
            $recoveryKey = $webAccount->recovery_key;
    
            $account = Account::find(Auth::id());
    
            $emailExists = DB::table('accounts')->where('email', $emailSelect)->exists();
            
            if ($emailExists) {
    
                return redirect(route('account.email.confirmation.change.index'))
                ->with(
                    'error',
                    'This email is already being used.'
                );
            } 
    
            if ($webAccount && $webAccount->recovery_key == $rk) {
    
                $account->email = Str::lower($emailSelect);
                $account->save();
                return view('account.overview.email.change.action', compact('account'));
    
            }else{
    
                return redirect(route('account.email.confirmation.change.index'))
                ->with(
                    'error',
                    'Incorrect recovery key!'
                );
            }
        }
    }

    public function logout(): RedirectResponse
    {
        Auth::logout();
        return redirect()->back();
    }
}
