<?php

declare(strict_types=1);

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;

class HouseManagementRequest extends FormRequest
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

    public function rules(Request $request): array
    {
        $this->house = $request->house;
        $basename = basename($this->getPathInfo());
        return match ($basename) {
            'move-out' => [
                'password' => 'required|string|current_password',
                'date' => 'bail|required|date_in_past',
            ],
            'transfer' => [
                'character' => 'bail|required|character_exists',
                'gold' => 'bail|required|numeric|min:0|max:10000000000',
                'password' => 'required|string|current_password',
                'date' => 'bail|required|date_in_past',
            ],
            'keep-house' => [
                'password' => 'required|string|current_password',
            ],
            'accept' => [
                'action' => 'bail|required|in:1,2',
                'password' => 'required|string|current_password',
            ]
        };
    }

    public function messages(): array
    {
        $basename = basename($this->getPathInfo());
        return match ($basename) {
            'move-out' => [
                'date.date_in_past' => 'Please select a date within next 30 days.',
                'password.required' => 'The password is required.',
                'password.string' => 'The password format is invalid.',
                'password.current_password' => 'The password you have entered is not correct!',
            ],
            'transfer' => [
                'gold.required' => 'Enter a valid price.',
                'gold.min' => 'The gold must be at least :min.',
                'gold.max' => 'The gold cannot be more than :max.',
                'character.required' => 'Character was not found.',
                'character.character_exists' => 'Character was not found.',
                'date.date_in_past' => 'Please select a date within next 30 days.',
                'password.required' => 'The password is required.',
                'password.string' => 'The password format is invalid.',
                'password.current_password' => 'The password you have entered is not correct!',
            ],
            'keep-house' => [
                'password.required' => 'The password is required.',
                'password.string' => 'The password format is invalid.',
                'password.current_password' => 'The password you have entered is not correct!',
            ],
            'accept' => [
                'action.required' => 'Please select a valid option.',
                'action.in' => 'The selected option does not exists.',
                'password.required' => 'The password is required.',
                'password.string' => 'The password format is invalid.',
                'password.current_password' => 'The password you have entered is not correct!',
            ]
        };
    }
}