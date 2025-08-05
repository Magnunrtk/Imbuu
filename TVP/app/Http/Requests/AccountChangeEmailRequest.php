<?php

declare(strict_types=1);

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;

class AccountChangeEmailRequest extends FormRequest
{
    public function authorize(): bool
    {
        return Auth::check();
    }

    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(
            Redirect::back()->with(
                'error',
                preg_replace('/\s+/', ' ', $validator->errors()->first())
            )
        );
    }

    public function rules(): array
    {
        
        $basename = basename($this->getPathInfo());
        return match ($basename) {
            'change' => [
                'email' => 'required|email|unique:accounts|unique:web_change_emails|email_change_active',
                'password' => 'required|string|current_password',
            ],
        };
    }

    public function messages(): array
    {
        $basename = basename($this->getPathInfo());
        return match ($basename) {
            'change' => [
                'email.required' => 'Please enter a valid email address.',
                'email.email' => 'Please enter a valid email address.',
                'email.unique' => 'This email is already in use.',
                'email.email_change_active' => 'The email address of this account is already going to be changed. Cancel this request first if you want to assign another email address to your account!',
                'password.required' => 'The password is required.',
                'password.string' => 'The password format is invalid.',
                'password.current_password' => 'The password you have entered is not correct!',
            ],
        };
    }
}