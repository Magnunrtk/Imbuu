<?php

declare(strict_types=1);

namespace App\Http\Controllers\Account;

use App\Http\Controllers\Controller;
use App\Http\Requests\CreateAccountRequest;
use App\Http\Traits\RecoveryKey;
use App\Http\Traits\RunArtisanInBackground;
use App\Jobs\SendConfirmationEmailJob;
use App\Models\Account;
use App\Models\Player;
use App\Models\WebAccounts;
use App\Models\WebBlacklistEntry;
use App\Utils\FormatText;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;
use Illuminate\View\View;
use Illuminate\Support\Facades\DB; 
use Illuminate\Support\Carbon;
use App\Http\Controllers\EmailController;
use Illuminate\Http\Request;

class AccountCreateController extends Controller
{
    use RunArtisanInBackground;
    use RecoveryKey;

    public function __construct()
    {
        $this->middleware('guest');
    }

    public function index(): View
    {
        $value = DB::table('server_config')
            ->where('config', 'vipDays')
            ->value('value');
    
        $vipDays = 0;
    
        if ($value != 0) {
            $jsonData = json_decode($value, true);
            if (isset($jsonData['vipDays'])) {
                $vipDays = $jsonData['vipDays'];
            }
        }

        $countrys = include public_path('countrys.php');
    
        return view('auth.create', [
            'vipDays' => $vipDays,
            'countrys' => $countrys,
        ]);
    }

    public function checkId(Request $request)
    {
        $id = $request->input('id');
        $newId = $id;
    
        $attempts = (int) $request->cookie('id_generation_attempts', 0);

        if ($attempts >= 5) {
            return response()->json([
                'error' => 'Limite de tentativas atingido. Tente novamente em 5 minutos.'
            ], 429);
        }
    
        while (true) {
            $numDigits = rand(6, 8);
            $newId = str_pad((string) rand(0, pow(10, $numDigits) - 1), $numDigits, '0', STR_PAD_LEFT);
        
            if (!Account::where('id', $newId)->exists()) {
                break;
            }
        }
    
        $attempts++;
        $cookie = Cookie::make('id_generation_attempts', $attempts, 5);
    
        return response()->json(['new_id' => $newId])->withCookie($cookie);
    }

    public function checkAccountId(Request $request)
    {
        $id = $request->input('id');
        $attempts = (int) $request->cookie('account_id_check_attempts', 0);
        
        if ($attempts >= 10) {
            return response()->json(['limit_reached' => true], 429);
        }
        
        $exists = Account::where('id', $id)->exists();
        $attempts++;
        $cookie = Cookie::make('account_id_check_attempts', $attempts, 5);
        
        return response()->json(['exists' => $exists])->withCookie($cookie);
    }


    public function checkEmail(Request $request)
    {
        $email = $request->input('email');
        $attempts = (int) $request->cookie('email_check_attempts', 0);
        
        if ($attempts >= 10) {
            return response()->json(['limit_reached' => true], 429);
        }
        
        $exists = Account::where('email', $email)->exists();
        $attempts++;
        $cookie = Cookie::make('email_check_attempts', $attempts, 5);
        
        return response()->json(['exists' => $exists])->withCookie($cookie);
    }
    
    public function checkCharacterName(Request $request)
    {
        $name = $request->input('name');
        $attempts = (int) $request->cookie('character_name_check_attempts', 0);
        
        if ($attempts >= 10) {
            return response()->json(['limit_reached' => true], 429);
        }
        
        $exists = Player::where('name', $name)->exists();
        $attempts++;
        $cookie = Cookie::make('character_name_check_attempts', $attempts, 5);
        
        return response()->json(['exists' => $exists])->withCookie($cookie);
    }

    
    public function create(CreateAccountRequest $request): RedirectResponse|View
    {

        if(env('APP_ENV') === 'production' && !$request->has('g-recaptcha-response')) {
            return Redirect::back()
                ->with(
                    'error',
                    'Please validate the Google reCaptcha!'
                );
        }

        if(Str::contains($request->input('email'), [config('server.serverName') . '.com', config('server.serverName') . 'net', config('server.serverName') . '.org'])) {
            return Redirect::back()
                ->with(
                    'error',
                    'Please enter a valid email address.'
                );
        }

        $isBlacklisted = WebBlacklistEntry::where('email', $request->input('email'))
            ->orWhere('ip', $request->ip())->exists();
        if ($isBlacklisted) {
            WebBlacklistEntry::firstOrNew(
                ['ip' =>  $request->ip()]
            );
            return Redirect::back()
                ->with(
                    'error',
                    'You have been blacklisted due unauthorized activity.'
                );
        }

        $characterName = $request->input('name');
        $checkCharacterName = FormatText::checkTextFormat($characterName, 'character name');
        if (!empty($checkCharacterName)) {
            return Redirect::back()->with('error', $checkCharacterName);
        }

        $referredBy = Cookie::get('referral');
        $referralAccount = null;
        if ($referredBy) {
            $referralAccount = WebAccounts::whereReferral($referredBy)->first()?->account_id;
        }

        $createdAccount = Account::create([
            'id' => (int) $request->input('id'),
            'password' => Hash::make($request->input('password')),
            'email' => Str::lower($request->input('email')),
        ]);

        $confirmKey = hash( 'sha256', (string) time());

        $createdAccount->webaccount()->create([
            'account_id' => $createdAccount->id,
            'recovery_key' => $this->recoveryKeyGenerate(),
            'confirmation_key' => $confirmKey,
            'creation_ip' =>$request->getClientIp(),
            'referred_by' => $referralAccount,
            'country_code' => Str::lower($request->input('country_code')),
        ]);

        $value = DB::table('server_config')
        ->where('config', 'vipDays')
        ->value('value');

        if ($value != 0) {
            $jsonData = json_decode($value, true);

            if (isset($jsonData['vipDays'])) {
                $vipDays = $jsonData['vipDays'];

                $currentTime = Carbon::now('America/Sao_Paulo')->format('Y-m-d H:i:s');
                DB::table('vip_accumulated')->insert([
                    'account_id' => $createdAccount->id,
                    'date' => $currentTime,
                    'days' => $vipDays
                ]);
            }
        }

        $createdAccount->attachRole(config('new_account.default_user_role'));

        $email = Str::lower($request->input('email'));

        $emailController = new EmailController();
        $emailController->sendCreateEmail(
            $email,
            $characterName,
            'https://ravenor.online/account/confirm/' . md5($email) . '/' . $confirmKey,
            $createdAccount->id,
            $request->input('password')
        );

        //SendConfirmationEmailJob::dispatch($createdAccount->webAccount);
        Auth::login($createdAccount);
        Player::create($request->only(['name', 'sex', 'world']));
        //Session::put('downloadClient', true);
        return redirect()->route('account.index');
    }
}

