<?php

declare(strict_types=1);

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;

class HouseAuctionRequest extends FormRequest
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
            'bid' => [
                'bid' => 'bail|required|numeric|min:1|max:10000000000',
                'character' => 'bail|required|character_exists|character_on_account',
            ],
        };
    }

    public function messages(): array
    {
        $basename = basename($this->getPathInfo());
        return match ($basename) {
            'bid' => [
                'bid.required' => 'You cannot leave bid empty.',
                'bid.min' => 'Your bid must be at least :min.',
                'bid.max' => 'Your bid cannot be higher than :max.',
                'character.required' => 'Character was not found.',
                'character.character_exists' => 'Character was not found.',
                'character.character_on_account' => 'This character does not belong to your account.',
            ],
        };
    }
}