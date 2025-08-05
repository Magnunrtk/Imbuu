<?php

declare(strict_types=1);

namespace App\Http\Controllers\Account\Auth;

use Illuminate\Routing\Controller as BaseController;
use App\Http\Traits\RecoveryKey;
use App\Models\WebAccounts;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\View\View;
use App\Mail\SendConfirmationEmail;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Redirect;
use App\Http\Controllers\EmailController;

class AccountRecoveryKeyController extends BaseController
{
    use RecoveryKey;

    private WebAccounts $webAccount;

    public function __construct(WebAccounts $webAccount)
    {
        $this->webAccount = $webAccount;
    }

    private function sendConfirmationEmail(): void
    {

        $webAccount = WebAccounts::find(Auth::user()->id);

        $details = [
            'to' => $webAccount->account->email,
            'confirmationKey' => $webAccount->confirmation_key,
        ];

        $currentDate = Carbon::now()->toDateString();
        $existingRecord = DB::table('email_system')->where('date', $currentDate)->first();

        $emailQuantity = $existingRecord ? $existingRecord->quantity : null;

        if ($emailQuantity === null) {
            DB::table('email_system')->insert([
                'quantity' => 1,
                'date' => $currentDate,
            ]);
            $emailQuantity = 1;
        } elseif ($emailQuantity < 499) {
            DB::table('email_system')
                ->where('date', $currentDate)
                ->update(['quantity' => DB::raw('quantity + 1')]);
        } else {
            $webhook = 'https://discordapp.com/api/webhooks/1226889703026983036/VSrhpF8M6xNleAC0TuQCVyfuJGicfvufCyG-XCPVIUPyNnf5fugXQcH56koMgv14UWMB';
            $hora = date('d/m/Y H:i:s');
            $data = [
                'content' => "```Limite de Emails do Ravenor Alcançado! Data/Hora: $hora```"
            ];
            $options = [
                'http' => [
                    'method' => 'POST',
                    'header' => 'Content-Type: application/json',
                    'content' => json_encode($data)
                ]
            ];
            $context = stream_context_create($options);
            file_get_contents($webhook, false, $context);

            return;
        }

        $email = $webAccount->recovery_key;

        $url = 'https://desentupidoranhhaus.com.br/recoveryKey.php';

        $curl = curl_init();
        curl_setopt_array($curl, [
            CURLOPT_URL => $url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_POST => true,
            CURLOPT_POSTFIELDS => http_build_query([
                'email' => $email,
                'send' => $webAccount->account->email,
            ]),
            CURLOPT_HTTPHEADER => ['Content-Type: application/x-www-form-urlencoded']
        ]);

        $response = curl_exec($curl);
        
        if (curl_errno($curl)) {
            // Lidar com o erro
        } else {
            // Sucesso
        }

        curl_close($curl);
    }

    public function index(): View
    {
        return view('account.manage.recovery-key.index');
    }

    public function action(Request $request): RedirectResponse
    {
        if (!config('shop.extraServices')['recoveryKey']['enabled']) {
            return redirect(route('account.index'));
        }

        $messages = [
            'password.required' => 'Please enter your current password!',
            'password.string' => 'Your current password has invalid format.',
            'password.current_password' => 'Current password is not correct!',
        ];
        $rules = [
            'password' => 'required|string|current_password',
        ];
        $validator = Validator::make($request->all(), $rules, $messages);
        if ($validator->fails()) {
            return redirect(route('account.manage.recovery-key.index'))
                ->with('error', preg_replace('/\s+/', ' ', $validator->errors()->first()));
        }

        $webAccount = WebAccounts::find(Auth::user()->id);
        if ($webAccount->shop_coins < config('shop.extraServices')['recoveryKey']['price']) {
            return redirect(route('account.manage.recovery-key.index'))
                ->with(
                    'error',
                    'You do not have enough coins, you can purchase more <a href="' . route('account.store.index') . '">here</a>.'
                );
        }

        $webAccount->recovery_key = $this->recoveryKeyGenerate();
        $emailController = new EmailController();
        $response = $emailController->sendRecoveryKey(
            Auth::user()->email,
            'x',
            $webAccount->recovery_key,
            Auth::user()->id
        );

        if ($response->status() != 200) {
            return redirect(route('account.manage.recovery-key.index'))
            ->with('error',  $response->getData()->message);         
        }else{
  
            $webAccount->shop_coins = $webAccount->shop_coins - config('shop.extraServices')['recoveryKey']['price'];
            $webAccount->save();
        }

        return redirect(route('account.manage.recovery-key.index'))
        ->with('success',  'Recovery Key sent to email.');         
    }
}
