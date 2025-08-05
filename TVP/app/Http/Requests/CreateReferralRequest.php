<?php

declare(strict_types=1);

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;

class CreateReferralRequest extends FormRequest
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
            'name' => 'bail|required|string|min:3|max:14|regex:/^[a-zA-Z]+$/|unique:web_accounts,referral',
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'Please enter your referral name.',
            'name.string' => 'Your referral has invalid format.',
            'name.unique' => 'A referral with this name already exists.',
            'name.min' => 'A referral name must have at least :min letters.',
            'name.max' => 'A referral name cannot have more than :max letters.',
        ];
    }
}