<?php

declare(strict_types=1);

namespace App\Http\Controllers\Login;

use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Str;
use Illuminate\View\View;

class AuthController extends Controller
{
    use AuthenticatesUsers;

    public function index(): View
    {
        return view('auth.login');
    }

    public function validateLogin(LoginRequest $request): RedirectResponse
    {
        if ($this->checkTooManyFailedAttempts()) {
            $seconds = RateLimiter::availableIn($this->throttleKey());
            return Redirect::back()
                ->with(
                    'error',
                    sprintf('Too many login attempts. Please try again in %s seconds.', $seconds)
                );
        }

        try {
            $request->request->add(['id' => $request->input('account')]);
            $credentials = $request->only('id', 'password');
            if (!Auth::attempt($credentials)) {
                RateLimiter::hit($this->throttleKey());
                return Redirect::back()
                    ->with(
                        'error',
                        'The account number and password does not match.'
                    );
            }

            RateLimiter::clear($this->throttleKey());
            return Redirect::route('account.index')
                ->with(
                    'success',
                    'Successfully logged in.'
                );
        } catch (\Exception $e) {
            report($e);
            return Redirect::back()
                ->with(
                    'error',
                    'Error while trying to logging you in.'
                );
        }
    }


    public function throttleKey(): string
    {
        return Str::lower(request('account')) . '|' . request()->ip();
    }

    public function checkTooManyFailedAttempts(): bool
    {
        if (!RateLimiter::tooManyAttempts($this->throttleKey(), 5)) {
            return false;
        }
        return true;
    }
}
