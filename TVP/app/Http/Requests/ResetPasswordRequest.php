<?php

declare(strict_types=1);

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Support\Facades\Redirect;

class ResetPasswordRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
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
            'password' => [
                'confirmationKey' => 'required|string',
                'email' => 'bail|required|string|exists:accounts,email',
            ],
            'new' => [
                'password' => 'required|string|min:6|max:12',
                'confirmPassword' => 'required|string|same:password',
                'confirmationKey' => 'required|string',
                'email' => 'bail|required|string|exists:accounts,email',
            ]
        };
    }

    public function messages(): array
    {
        $basename = basename($this->getPathInfo());
        return match ($basename) {
            'password' => [
                'confirmationKey.required' => 'Please enter a valid confirmation key.',
                'confirmationKey.string' => 'Your confirmation key has invalid format.',
                'email.required' => 'Please enter a valid email address.',
                'email.exists' => 'No Account with this email registered.',
            ],
            'new' => [
                'confirmationKey.required' => 'Please enter a valid confirmation key.',
                'confirmationKey.string' => 'Your confirmation key has invalid format.',
                'email.required' => 'Please enter a valid email address.',
                'password.required' => 'You need to provide a new password.',
                'password.string' => 'Your new password has invalid format.',
                'password.min' => 'Your new password needs to be at least :min letters.',
                'password.max' => 'Your password cannot have more than :max letters.',
                'confirmPassword.required' => 'You need to confirm your new password.',
                'confirmPassword.string' =>  'Your confirm password has invalid format.',
                'confirmPassword.same' =>  'Your confirm new password does not match.',
                'email.exists' => 'No Account with this email registered.',
            ],
        };
    }
}