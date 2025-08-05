<?php

declare(strict_types=1);

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;

class AccountChangePasswordRequest extends FormRequest
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
        return [
            'password' => 'required|string|current_password',
            'newPassword' => 'required|string|min:6|max:12|different:password',
            'confirmNewPassword' => 'required|string|same:newPassword',
        ];
    }

    public function messages(): array
    {
        return [
            'password.required' => 'You need to provide your old password.',
            'password.string' => 'Your password has invalid format.',
            'password.current_password' => 'The password you have entered is not correct!',
            'newPassword.required' => 'You need to provide a new password.',
            'newPassword.string' => 'Your new password has invalid format.',
            'newPassword.min' => 'Your new password needs to be at least :min letters.',
            'newPassword.max' => 'Your password cannot have more than :max letters.',
            'newPassword.different' => 'Your new password cannot be same as current password.',
            'confirmNewPassword.required' => 'You need to confirm your new password.',
            'confirmNewPassword.string' =>  'Your confirm password has invalid format.',
            'confirmNewPassword.same' =>  'Your confirm new password does not match.',
        ];
    }
}