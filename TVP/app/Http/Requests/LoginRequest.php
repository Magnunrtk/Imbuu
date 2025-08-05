<?php

declare(strict_types=1);

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;

class LoginRequest extends FormRequest
{
    public function authorize(): bool
    {
        return !Auth::check();
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
            'login' => [
                'account' => 'required|digits_between:1,10',
                'password' => 'required|string|min:1|max:20',
            ],
        };
    }

    public function messages(): array
    {
        $basename = basename($this->getPathInfo());
        return match ($basename) {
            'login' => [
                'account.digits_between' => 'The account number field needs to be between :min and :max.',
                'account.required' => 'The account number is required.',
                'account.integer' => 'The account number format is invalid, only numbers allowed.',
                'password.required' => 'The password is required.',
                'password.string' => 'The password format is invalid.',
            ],
        };
    }
}