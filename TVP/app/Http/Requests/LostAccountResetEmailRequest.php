<?php

declare(strict_types=1);

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Support\Facades\Redirect;

class LostAccountResetEmailRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(
            Redirect::route('account.lost.confirm.index')->with(
                'error',
                preg_replace('/\s+/', ' ', $validator->errors()->first())
            )
        );
    }

    public function rules(): array
    {
        $basename = basename($this->getPathInfo());
        return match ($basename) {
            'confirm' => [
                'confirmation' => 'accepted',
                'confirmationKey' => 'required|string',
                'email' => 'bail|required|string|email|unique:accounts,email|exists:web_lost_account,email',
            ],
        };
    }

    public function messages(): array
    {
        $basename = basename($this->getPathInfo());
        return match ($basename) {
            'confirm' => [
                'confirmation.accepted' => 'Please confirm that you want to change your email address and choose a new password.',
                'confirmationKey.required' => 'Please enter a valid confirmation key.',
                'confirmationKey.string' => 'Your confirmation key has invalid format.',
                'email.required' => 'Please enter a valid email address.',
                'email.unique' => 'This email is already in use.',
                'email.email' => 'Please enter a valid email address.',
                'email.exists' => 'No email change request to the email address <b>:input</b> submitted.'
            ],
        };
    }
}