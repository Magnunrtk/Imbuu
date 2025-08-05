<?php

declare(strict_types=1);

namespace App\Http\Requests\Guilds;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;

class CreateGuildRequest extends FormRequest
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
            'create' => [
                'guildName' => 'bail|required|unique:guilds,name',
                'character' => 'bail|required|character_exists|character_on_account|has_no_guild',
                'password' => 'bail|required|string|current_password',
            ],
        };
    }

    public function messages(): array
    {
        $basename = basename($this->getPathInfo());
        return match ($basename) {
            'create' => [
                'guildName.required' => 'Please enter a valid guild name.',
                'guildName.unique' => 'This guild name is already used. Please choose another name!',
                'character.required' => 'Character was not found.',
                'character.character_exists' => 'Character was not found.',
                'character.character_on_account' => 'This character does not belong to your account.',
                'character.has_no_guild' => 'This character is already a member of a guild.',
                'password.required' => 'The password is required.',
                'password.string' => 'The password format is invalid.',
                'password.current_password' => 'The password you have entered is not correct!',
            ],
        };
    }
}