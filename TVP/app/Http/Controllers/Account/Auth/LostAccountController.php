<?php

declare(strict_types=1);

namespace App\Http\Controllers\Account\Auth;

use App\Http\Controllers\Controller;
use App\Http\Controllers\EmailController;

use App\Http\Requests\LostAccountRequest;

use App\Http\Traits\RecoveryKey;
use App\Http\Traits\RunArtisanInBackground;

use App\Jobs\SendConfirmChangeEmailJob;
use App\Jobs\SendConfirmChangePasswordJob;
use App\Jobs\SendEmailSuccessfullyChangedJob;
use App\Jobs\SendPasswordSuccessfullyChangedJob;

use App\Models\Account;
use App\Models\Player;
use App\Models\WebAccounts;
use App\Models\WebLostAccount;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Illuminate\View\View;


use PragmaRX\Google2FA\Google2FA;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;

class LostAccountController extends Controller
{
    use RunArtisanInBackground;
    use RecoveryKey;

    public function index(): View
    {
        return view('lost-account.index');
    }

    public function action(LostAccountRequest $request): RedirectResponse|View
    {
        $emailOrChar = preg_replace("/[^a-zA-Z0-9\s@.']/u", '', (string) $request->input('email_or_char'));
        $step = preg_replace('/[^a-zA-Z0-9\s]/', '', (string) $request->input('step'));
        $type = preg_replace('/[^a-zA-Z0-9\s]/', '', (string) $request->input('type'));

        if(filter_var($emailOrChar, FILTER_VALIDATE_EMAIL)) {
            $lostAccount = Account::whereEmail($emailOrChar)->first();
            if (is_null($lostAccount)) {
                return redirect(route('account.lost.index'))
                    ->with(
                        'error',
                        sprintf('Email address <b>%s</b> does not exist. Please make sure to enter the email address correctly. Note that email addresses may be deleted automatically if they have not been used for a long time.', $emailOrChar)
                    );
            }
        } else {
            $lostAccount = Player::whereName($emailOrChar)->first();
            if (is_null($lostAccount)) {
                return redirect(route('account.lost.index'))
                    ->with(
                        'error',
                        sprintf('Character name <b>%s</b> does not exist. Please make sure to enter the character name correctly. Note that character names may be deleted automatically if they have not been used for a long time.', $emailOrChar)
                    );
            }
        }
        if (!$lostAccount->webaccount->confirmed) {
            return redirect(route('account.lost.index'))
                ->with(
                    'error',
                    "You cannot use the lost account interface as long as your account is not confirmed. If you don't remember the password to confirm it, the account is lost."
                );
        }

        if ($type === '2fa') {
            $step = '2faVerify';
        }elseif($type == "questions"){

            $step = "questionsVerify";
        }

        return match ($step) {
            'email' => $this->emailRequest($emailOrChar, $lostAccount, "email2"),
            'email2' => $this->emailAction($request, $emailOrChar, $lostAccount, "email"),
            'checkemail' => $this->emailCheck($request, $emailOrChar, $lostAccount),
            '2fa' => $this->emailRequest($emailOrChar, $lostAccount, "2faVerify"),
            '2faVerify' => $this->emailAction($request, $emailOrChar, $lostAccount, "2fa"),
            'checkTwoAuth' => $this->twoAuthCheck($request, $emailOrChar, $lostAccount),
            'questions' => $this->emailRequest($emailOrChar, $lostAccount, "2questions"),
            '2questions' => $this->emailAction($request, $emailOrChar, $lostAccount, "questions"),
            'questionsVerify' => $this->verifySecurityQuestions($request, $emailOrChar, $lostAccount),
            'key' => $this->keyRequest($emailOrChar, $lostAccount),
            'hacked' => $this->hacked($emailOrChar, $lostAccount),
            'password' => $this->password($emailOrChar, $lostAccount),
            'provider' => $this->provider($emailOrChar, $lostAccount),
            'sendconfirmation' => $this->sendEmailConfirmation($request, $emailOrChar, $lostAccount),
            default => view(
                'lost-account.select-problem',
                compact(
                    'emailOrChar',
                    'lostAccount',
                )
            ),
        };
    }

    public function keyRequest(string $emailOrChar, Model $lostAccount): View
    {
        return view(
            'lost-account.key',
            compact(
                'emailOrChar',
                'lostAccount',
            )
        );
    }

    public function emailRequest(string $emailOrChar, Model $lostAccount, $type): View
    {
        return view('lost-account.email.index',
            compact(
                'emailOrChar',
                'lostAccount',
                'type'
            )
        );
    }

    public function emailAction(Request $request, string $emailOrChar, Model $lostAccount, $type): RedirectResponse|View
    {
        $messages = [
            'email.required' => 'Please enter a valid email address.',
            'email.email' => 'Please enter a valid email address.',
            'email.unique' => 'This email is already in use.',
        ];
        $rules = [
            'email' => 'required|email|unique:accounts',
        ];

        $validator = Validator::make($request->all(), $rules, $messages);

        if ($validator->fails()) {
            return view(
                'lost-account.email.index',
                compact(
                    'emailOrChar',
                    'lostAccount',
                    'type'
                )
            )->with('errorMessage', preg_replace('/\s+/', ' ', $validator->errors()->first()));
        }

        $newEmail = $request->input('email');
        $finder = $request->input('finder');

        if($type == "2fa"){

            if (filter_var($finder, FILTER_VALIDATE_EMAIL)) {
                $account = Account::where('email', $finder)->first();

                if (!$account) {
                    return back()->with('error', 'Email not found.');
                }

            } else {
                $player = Player::where('name', $finder)->first();

                if (!$player) {
                    return back()->with('error', 'Character not found.');
                }

                $account = Account::find($player->account_id);
            }

            if (!$account) {
                return back()->with('error', 'Account not found.');
            }

            if (empty($account->google2fa_secret)) {
                return back()->with('error', 'Two-Factor Authentication is not registered for this account.');
            }

            return view('lost-account.twoAuth.check',
                compact(
                    'emailOrChar',
                    'lostAccount',
                    'newEmail',
                )
            );

        }elseif($type == "questions"){

            if (filter_var($finder, FILTER_VALIDATE_EMAIL)) {
                $account = Account::where('email', $finder)->first();

                if (!$account) {
                    return back()->with('error', 'Email not found.');
                }

            } else {
                $player = Player::where('name', $finder)->first();

                if (!$player) {
                    return back()->with('error', 'Character not found.');
                }

                $account = Account::find($player->account_id);
            }

            if (!$account) {
                return back()->with('error', 'Account not found.');
            }

            $hasSecurityQuestions = DB::table('security_questions')
                ->where('account_id', $account->id)
                ->exists();

            if (!$hasSecurityQuestions) {
                return back()->with('error', 'Security questions are not registered for this account.');
            }

            $securityData = DB::table('security_questions')->where('account_id', $account->id)->first();

            $questionIndexes = [
                'question_1' => $securityData->question_1,
                'question_2' => $securityData->question_2,
                'question_3' => $securityData->question_3,
            ];

            $questions = config('security.questions');

            return view('lost-account.twoAuth.questionsCheck',
                compact(
                    'emailOrChar',
                    'lostAccount',
                    'newEmail',
                    'questions',
                    'questionIndexes',
                )
            );

        }else{

            return view('lost-account.email.check',
                compact(
                    'emailOrChar',
                    'lostAccount',
                    'newEmail',
                )
            );
        }
    }

    public function twoAuthCheck(Request $request, string $emailOrChar, Model $lostAccount): RedirectResponse|View
    {

        $inputCode = $request->input('auth_code');
        $finder = $request->input('finder');

        $google2fa = new Google2FA();

        if (filter_var($finder, FILTER_VALIDATE_EMAIL)) {
            $account = Account::where('email', $finder)->first();

            if (!$account) {
                return back()->with('error', 'Email not found.');
            }

        } else {
            $player = Player::where('name', $finder)->first();

            if (!$player) {
                return back()->with('error', 'Character not found.');
            }

            $account = Account::find($player->account_id);
        }

        if (!$account) {
            return back()->with('error', 'Account not found.');
        }

        $attemptsKey = "twoauth_attempts_{$account->id}";
        $attempts = Cache::get($attemptsKey, 0);

        if ($attempts >= 5) {
            return back()->with('error', 'Too many attempts. Please wait 5 minutes before trying again.');
        }

        $isValid = $google2fa->verifyKey($account->google2fa_secret, $inputCode);

        if (!$isValid) {
            return back()->with('error', 'Invalid authentication code.');
        }

        $messages = [
            'email.required' => 'Please enter a valid email address.',
            'email.email' => 'Please enter a valid email address.',
            'email.unique' => 'The new email address is already assigned to an account. Please enter another email address.',
        ];

        $rules = [
            'email' => 'required|email|unique:accounts',
        ];

        $validator = Validator::make($request->all(), $rules, $messages);
        if ($validator->fails()) {
            return redirect()->back()->with(
                'error',
                preg_replace('/\s+/', ' ', $validator->errors()->first())
            );
        }

        $accountId = ($lostAccount instanceof Account) ? $lostAccount->id : $lostAccount->account_id;

        if (WebLostAccount::whereAccountId($accountId)->exists()) {
            return view(
                'lost-account.email.reset',
                compact('emailOrChar', 'lostAccount')
            )->with('errorMessage', 'A request to change the email address has already been submitted. If you have not received the email yet, it is possible that it did not reach you for some reason. Please make sure your email\'s spam filter is not blocking our mail as spam. Please also make sure that your mailbox is not full. You can use the Lost Account Interface again after approximately two days have passed to request the change of your email address of your account.');
        }

        $webLostPassword = WebLostAccount::create([
            'account_id' => $accountId,
            'confirmation_key' => Str::random(20),
            'email' => Str::lower((string)$request->input('email')),
        ]);

        // Envia o e-mail de confirmação
        $emailController = new EmailController();
        $emailController->lostAccountEmailReset(
            $webLostPassword->email,
            $webLostPassword->confirmation_key,
            'https://ravenor.online/account/lost/confirm/' . $webLostPassword->confirmation_key,
            $accountId
        );

        return view(
            'lost-account.email.reset',
            compact('emailOrChar', 'lostAccount')
        )->with('recoverSuccess', true);
    }

    public function verifySecurityQuestions(Request $request, string $emailOrChar, Model $lostAccount): RedirectResponse|View
    {
        $finder = $request->input('finder');
        $finder = (string) $finder;
        $finder = preg_replace("/[^a-zA-Z0-9\s@.']/u", '', $finder);

        if (filter_var($finder, FILTER_VALIDATE_EMAIL)) {
            $account = Account::where('email', $finder)->first();
        } else {
            $player = Player::where('name', $finder)->first();
            if (!$player) {
                return back()->with('error', 'Character not found.');
            }
            $account = Account::find($player->account_id);
        }

        if (!$account) {
            return back()->with('error', 'Account not found.');
        }

        $attemptsKey = "security_questions_attempts_{$account->id}";
        $attempts = Cache::get($attemptsKey, 0);

        if ($attempts >= 5) {
            return back()->with('error', 'Too many failed attempts. Please wait 5 minutes before trying again.');
        }

        // Recupera perguntas e respostas salvas
        $security = DB::table('security_questions')->where('account_id', $account->id)->first();
        if (!$security) {
            return back()->with('error', 'No security questions found for this account.');
        }

        // Verifica se as respostas batem
        $correct =
            strtolower(trim($security->answer_1)) === strtolower(trim($request->input('answer_1'))) &&
            strtolower(trim($security->answer_2)) === strtolower(trim($request->input('answer_2'))) &&
            strtolower(trim($security->answer_3)) === strtolower(trim($request->input('answer_3')));

        if (!$correct) {
            Cache::put($attemptsKey, $attempts + 1, now()->addMinutes(5));
            return back()->with('error', 'One or more answers are incorrect.');
        }

        // Valida email novo
        $validator = Validator::make($request->all(), [
            'email' => 'required|email|unique:accounts,email',
        ], [
            'email.required' => 'Please enter a valid email address.',
            'email.email' => 'Please enter a valid email address.',
            'email.unique' => 'This email is already in use.',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->with('error', $validator->errors()->first());
        }

        $accountId = ($lostAccount instanceof Account) ? $lostAccount->id : $lostAccount->account_id;

        if (WebLostAccount::whereAccountId($accountId)->exists()) {
            return view('lost-account.email.reset',
                compact('emailOrChar', 'lostAccount')
            )->with('errorMessage', 'A request to change the email address has already been submitted. Please wait ~2 days to try again.');
        }

        // Cria solicitação
        $webLostPassword = WebLostAccount::create([
            'account_id' => $accountId,
            'confirmation_key' => Str::random(20),
            'email' => Str::lower($request->input('email')),
        ]);

        // Envia e-mail de confirmação
        (new EmailController())->lostAccountEmailReset(
            $webLostPassword->email,
            $webLostPassword->confirmation_key,
            'https://ravenor.online/account/lost/confirm/' . $webLostPassword->confirmation_key,
            $accountId
        );

        return view('lost-account.email.reset',
            compact('emailOrChar', 'lostAccount')
        )->with('recoverSuccess', true);
    }

    public function emailCheck(Request $request, string $emailOrChar, Model $lostAccount): RedirectResponse|View
    {

        $recoveryKey = $request->input('key1') . '-' . $request->input('key2') . '-' . $request->input('key3') . '-' . $request->input('key4');
        if (!$this->validateRecoveryKeyFormat($recoveryKey)) {
            return redirect()->back()
                ->with(
                    'error',
                    'Please enter a valid recovery key.'
                );
        }

        $messages = [
            'email.required' => 'Please enter a valid email address.',
            'email.email' => 'Please enter a valid email address.',
            'email.unique' => 'The new email address is already assigned to an account. Please enter another email address.',
        ];

        $rules = [
            'email' => 'required|email|unique:accounts',
        ];

        $validator = Validator::make($request->all(), $rules, $messages);
        if ($validator->fails()) {
            return redirect()->back()
                ->with(
                    'error',
                    preg_replace('/\s+/', ' ', $validator->errors()->first())
                );
        }

        $accountId = ($lostAccount instanceof Account) ? $lostAccount->id : $lostAccount->account_id;
        if(WebLostAccount::whereAccountId($accountId)->exists()) {
            return view(
                'lost-account.email.reset',
                compact(
                    'emailOrChar',
                    'lostAccount',
                )
            )->with('errorMessage', 'A request to change the email address has already been submitted. If you have not received the email yet, it is possible that it did not reach you for some reason. Please make sure your email\'s spam filter is not blocking our mail as spam. Please also make sure that your mailbox is not full. You can use the Lost Account Interface again after approximately two days have passed to request the change of your email address of your account.');
        }

        $webAccountToRecover = WebAccounts::whereAccountId($accountId)
            ->whereRecoveryKey($recoveryKey)
            ->whereConfirmed(true)
            ->first();

        if (!$webAccountToRecover) {
            return redirect()->back()
                ->with(
                    'error',
                    'You have entered an incorrect recovery key!'
                );
        }

        $webLostPassword = WebLostAccount::create([
            'account_id' => $accountId,
            'confirmation_key' => Str::random('20'),
            'email' => Str::lower((string)$request->input('email')),
        ]);

        $details = [
            'to' => $webLostPassword->email,
            'confirmationKey' => $webLostPassword->confirmation_key,
        ];
        
        $emailController = new EmailController();
        $emailController->lostAccountEmailReset(
            $webLostPassword->email,
            $webLostPassword->confirmation_key,
            'https://ravenor.online/account/lost/confirm/' . $webLostPassword->confirmation_key,
            $accountId
        );

        return view('lost-account.email.reset',
            compact(
                'emailOrChar',
                'lostAccount',
            )
        )->with('recoverSuccess', true);
    }

    public function confirmEmail(string $confirmationKey = null): View
    {
        return view('lost-account.email.reset', compact('confirmationKey'));
    }

    public function confirmAction(Request $request): RedirectResponse|View
    {
        $step = (string) $request->input('step');
        return match ($step) {
            'setemailandpasswordconfirm' => $this->confirmChangeEmailAndPasswordForm($request),
            'setemailandpasswordperform' => $this->setNewEmailAndPassword($request),
            default => $this->confirmNewEmailAndPasswordAction($request),
        };
    }

    public function confirmChangeEmailAndPasswordForm(Request $request): View
    {
        $confirmation = $request->input('confirmation');
        $email = $request->input('email');
        $confirmationKey = $request->input('confirmationKey');
        return view(
            'lost-account.email.reset',
            compact(
                'confirmationKey',
                'email',
                'confirmation'
            )
        );
    }

    public function confirmNewEmailAndPasswordAction(Request $request): RedirectResponse|View
    {
        $messages = [
            'confirmation.accepted' => 'Please confirm that you want to change your email address and choose a new password.',
            'confirmationKey.required' => 'Please enter a valid confirmation key.',
            'confirmationKey.string' => 'Your confirmation key has invalid format.',
            'email.required' => 'Please enter a valid email address.',
            'email.unique' => 'This email is already in use.',
            'email.email' => 'Please enter a valid email address.',
            'email.exists' => 'No email change request to the email address <b>:input</b> submitted.'
        ];
        $rules = [
            'confirmation' => 'accepted',
            'confirmationKey' => 'required|string',
            'email' => 'bail|required|string|email|unique:accounts,email|exists:web_lost_account,email',
        ];
        $validator = Validator::make($request->all(), $rules, $messages);
        $email = (string) $request->input('email');
        $confirmationKey = (string) $request->input('confirmationKey');
        if ($validator->fails()) {
            return view('lost-account.email.reset', compact('email', 'confirmationKey'))
                ->with('errorMessage', preg_replace('/\s+/', ' ', $validator->errors()->first()));
        }
        $lostAccount = WebLostAccount::whereConfirmationKey($confirmationKey)->whereEmail($email)->first();
        if(is_null($lostAccount) || $lostAccount->created_at <= Carbon::now()->subDay()) {
            return Redirect::route('account.lost.confirm.index')
                ->with(
                    'error',
                    'You have either entered an incorrect confirmation key or no password change has been submitted for this account.'
                );
        }
        return view('lost-account.email.new', compact('email', 'confirmationKey'));
    }

    public function setNewEmailAndPassword(Request $request): RedirectResponse|View
    {
        $email = (string) $request->input('email');
        $confirmationKey = (string) $request->input('confirmationKey');
        $messages = [
            'newPassword.required' => 'You need to provide a new password.',
            'newPassword.different' => 'Your new password cannot be same as current password.',
            'newPassword.string' => 'Your new password has invalid format.',
            'newPassword.min' => 'Your new password needs to be at least :min letters.',
            'newPassword.max' => 'Your password cannot have more than :max letters.',
            'newPassword2.required' => 'You need to confirm your new password.',
            'newPassword2.string' =>  'Your confirm password has invalid format.',
            'newPassword2.same' =>  'The two passwords do not match!',
            'confirmation.accepted' => 'Please confirm that you want to change your email address and choose a new password.',
            'confirmationKey.required' => 'Please enter a valid confirmation key.',
            'confirmationKey.string' => 'Your confirmation key has invalid format.',
            'email.required' => 'Please enter a valid email address.',
            'email.unique' => 'This email is already in use.',
            'email.email' => 'Please enter a valid email address.',
            'email.exists' => 'No email change request to the email address <b>:input</b> submitted.'
        ];
        $rules = [
            'confirmation' => 'accepted',
            'confirmationKey' => 'required|string',
            'email' => 'bail|required|string|email|unique:accounts,email|exists:web_lost_account,email',
            'newPassword' => 'required|string|min:1|max:30|different:current_password',
            'newPassword2' => 'required|string|same:newPassword',
        ];
        $validator = Validator::make($request->all(), $rules, $messages);
        if ($validator->fails()) {
            return view('lost-account.email.new', compact('email', 'confirmationKey'))
                ->with('errorMessage', preg_replace('/\s+/', ' ', $validator->errors()->first()));
        }
        $lostAccount = WebLostAccount::whereConfirmationKey($confirmationKey)->whereEmail($email)->first();
        if(is_null($lostAccount) || $lostAccount->created_at <= Carbon::now()->subDay()) {
            return Redirect::route('account.lost.confirm.index')
                ->with(
                    'error',
                    'You have either entered an incorrect confirmation key or no password change has been submitted for this account.'
                );
        }
        $account = Account::find($lostAccount->account_id);
        $account->password = Hash::make($request->input('newPassword'));
        $account->email = $request->input('email');
        $account->save();
        $details = [
            'to' => $lostAccount->email,
        ];
        $lostAccount->delete();

        $emailToSend = $email;
        $emailController = new EmailController();
    
        $response = $emailController->changePasswordComplete(
            $emailToSend,
            'x',
            $request->newPassword,
            $lostAccount->account_id
        );
    
        if ($response->getStatusCode() !== 200) {
            $errorMessage = json_decode($response->getContent(), true)['message'] ?? 'An unexpected error occurred.';
            return view('account.manage.change.password.index')
                ->with('errorMessage', $errorMessage);
        }

        return view('lost-account.email.complete');
    }

    public function hacked(string $emailOrChar, Model $lostAccount): View
    {
        return view(
            'lost-account.password.security-check',
            compact(
                'emailOrChar',
                'lostAccount'
            )
        );
    }

    public function password(string $emailOrChar, Model $lostAccount): View
    {
        return view(
            'lost-account.password.index',
            compact(
                'emailOrChar',
                'lostAccount'
            )
        );
    }

    public function provider(string $emailOrChar, Model $lostAccount): View
    {
        return view(
            'lost-account.email.lost-access',
            compact(
                'emailOrChar',
                'lostAccount'
            )
        );
    }

    public function confirmNewPassword(string $confirmationKey = null): View
    {
        return view('lost-account.password.reset', compact('confirmationKey'));
    }

    public function newPasswordAction(Request $request): RedirectResponse|View
    {
        $step = (string) $request->input('step');
        return match ($step) {
            'confirmation' => $this->confirmChangePasswordForm($request),
            'setpasswordperform' => $this->setNewPassword($request),
            default => $this->confirmNewPasswordAction($request),
        };
    }

    public function confirmNewPasswordAction(Request $request): RedirectResponse|View
    {
        $messages = [
            'confirmation.accepted' => 'Please confirm that you want to change your email address and choose a new password.',
            'confirmationKey.required' => 'Please enter a valid confirmation key.',
            'confirmationKey.string' => 'Your confirmation key has invalid format.',
            'email.required' => 'Please enter a valid email address.',
            'email.email' => 'Please enter a valid email address.',
            'email.exists' => 'No Account registered for <b>:input</b>.'
        ];
        $rules = [
            'confirmation' => 'accepted',
            'confirmationKey' => 'required|string',
            'email' => 'bail|required|string|email|exists:accounts,email',
        ];
        $validator = Validator::make($request->all(), $rules, $messages);
        $email = (string) $request->input('email');
        $confirmationKey = (string) $request->input('confirmationKey');
        if ($validator->fails()) {
            return view('lost-account.password.reset', compact('email', 'confirmationKey'))
                ->with('errorMessage', preg_replace('/\s+/', ' ', $validator->errors()->first()));
        }
        $email = (string) $request->input('email');
        $confirmationKey = (string) $request->input('confirmationKey');
        $lostAccount = WebLostAccount::whereConfirmationKey($confirmationKey)->whereEmail($email)->first();
        if(is_null($lostAccount) || $lostAccount->created_at <= Carbon::now()->subDay()) {
            return Redirect::route('account.lost.new.index')
                ->with(
                    'error',
                    'You have either entered an incorrect confirmation key or no password change has been submitted for this account.'
                );
        }
        return view('lost-account.password.new', compact('email', 'confirmationKey'));
    }

    public function setNewPassword(Request $request): RedirectResponse|View
    {
        $email = (string) $request->input('email');
        $confirmationKey = (string) $request->input('confirmationKey');
        $messages = [
            'newPassword.required' => 'You need to provide a new password.',
            'newPassword.string' => 'Your new password has invalid format.',
            'newPassword.min' => 'Your new password needs to be at least :min letters.',
            'newPassword.max' => 'Your password cannot have more than :max letters.',
            'newPassword.different' => 'Your new password cannot be same as current password.',
            'newPassword2.required' => 'You need to confirm your new password.',
            'newPassword2.string' =>  'Your confirm password has invalid format.',
            'newPassword2.same' =>  'Your confirm new password does not match.',
            'confirmation.accepted' => 'Please confirm that you want to change your email address and choose a new password.',
            'confirmationKey.required' => 'Please enter a valid confirmation key.',
            'confirmationKey.string' => 'Your confirmation key has invalid format.',
            'email.required' => 'Please enter a valid email address.',
            'email.email' => 'Please enter a valid email address.',
            'email.exists' => 'No Account registered for <b>:input</b>.'
        ];
        $rules = [
            'confirmation' => 'accepted',
            'confirmationKey' => 'required|string',
            'email' => 'bail|required|string|email|exists:web_lost_account,email',
            'newPassword' => 'required|string|min:1|max:30|different:current_password',
            'newPassword2' => 'required|string|same:newPassword',
        ];
        $validator = Validator::make($request->all(), $rules, $messages);
        if ($validator->fails()) {
            return view('lost-account.password.new', compact('email', 'confirmationKey'))
                ->with('errorMessage', preg_replace('/\s+/', ' ', $validator->errors()->first()));
        }
        $lostAccount = WebLostAccount::whereConfirmationKey($confirmationKey)->whereEmail($email)->first();
        if(is_null($lostAccount) || $lostAccount->created_at <= Carbon::now()->subDay()) {
            return Redirect::route('account.lost.new.index')
                ->with(
                    'error',
                    'You have either entered an incorrect confirmation key or no password change has been submitted for this account.'
                );
        }
        $account = Account::find($lostAccount->account_id);
        $account->password = Hash::make($request->input('newPassword'));
        $account->save();
        $details = [
            'to' => $lostAccount->email,
        ];

        $emailToSend = $email;
        $emailController = new EmailController();
    
        $response = $emailController->changePasswordComplete(
            $emailToSend,
            'x',
            $request->newPassword,
            $lostAccount->account_id
        );
    
        if ($response->getStatusCode() !== 200) {
            $errorMessage = json_decode($response->getContent(), true)['message'] ?? 'An unexpected error occurred.';
            return view('account.manage.change.password.index')
                ->with('errorMessage', $errorMessage);
        }

        SendPasswordSuccessfullyChangedJob::dispatch($details);
        $lostAccount->delete();
        return view('lost-account.password.complete');
    }

    public function confirmChangePasswordForm(Request $request): View
    {
        $confirmation = $request->input('confirmation');
        $email = $request->input('email');
        $confirmationKey = $request->input('confirmationKey');
        return view(
            'lost-account.password.reset',
            compact(
                'confirmationKey',
                'email',
                'confirmation'
            )
        );
    }

    public function sendEmailConfirmation(Request $request, $emailOrChar, $lostAccount): RedirectResponse|View
    {

        $messages = [
            'email.required' => 'Please enter a valid email address.',
            'email.email' => 'Please enter a valid email address.',
            'email.exists' => 'Incorrect character name or email address.'
        ];

        $rules = [
            'email' => 'required|email|exists:accounts,email',
        ];

        $validator = Validator::make($request->all(), $rules, $messages);

        if ($validator->fails()) {
            return view('lost-account.password.index', compact('emailOrChar', 'lostAccount'))
                ->with('errorMessage', preg_replace('/\s+/', ' ', $validator->errors()->first()));
        }

        $accountId = ($lostAccount instanceof Account) ? $lostAccount->id : $lostAccount->account_id;
        $account = Account::whereId($accountId)->whereEmail((string) $request->input('email'))->first();

        if (!$account) {
            return redirect()->back()
                ->with(
                    'error',
                    'Incorrect character name or email address.',
                );
        }

        if(WebLostAccount::whereAccountId($accountId)->exists()) {
            return view(
                'lost-account.password.reset',
                compact(
                    'emailOrChar',
                    'lostAccount',
                )
            )->with('errorMessage', 'A request for a new account password has already been submitted. If you have not received the email yet, it is possible that it did not reach you for some reason. Please make sure your email\'s spam filter is not blocking our mail as spam. Please also make sure that your mailbox is not full. You can use the Lost Account Interface again after approximately two days have passed to request a new password.');
        }

        $webLostPassword = WebLostAccount::create([
            'account_id' => $accountId,
            'confirmation_key' => Str::random('20'),
            'email' => Str::lower((string)$request->input('email')),
        ]);

        $details = [
            'to' => $webLostPassword->email,
            'confirmationKey' => $webLostPassword->confirmation_key,
        ];

        $emailController = new EmailController();
        $emailController->lostAccountPasswordReset(
            $webLostPassword->email,
            $webLostPassword->confirmation_key,
            'https://ravenor.online/account/lost/new/' . $webLostPassword->confirmation_key,
            $accountId
        );

        return view(
            'lost-account.password.reset',
            compact(
                'emailOrChar',
                'lostAccount',
            )
        )->with('recoverSuccess', true);
        
    }
}
