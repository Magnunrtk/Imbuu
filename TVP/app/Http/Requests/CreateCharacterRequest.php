<?php

declare(strict_types=1);

namespace App\Http\Requests;

use App\Utils\World;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Support\Facades\Redirect;

class CreateCharacterRequest extends FormRequest
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
        if (!config('multi_world.enabled')) {
            $this->request->set('world', World::getCurrentWorld()['slug']);
        }
        return match ($basename) {
            'create' => [
                'name' => 'required|max_characters:'. config('new_account.max_characters_per_account') .'|unique:players,name',
                'sex' => 'required|in:0,1',
                'world' => 'required|world_slug_exists',
            ],
        };
    }

    public function messages(): array
    {
        $basename = basename($this->getPathInfo());
        return match ($basename) {
            'create' => [
                'name.required' => 'Please enter a valid name!',
                'name.unique' => 'This name is already used. Please choose another name!',
                'name.max_characters' => 'You cannot create more than 6 characters.',
                'sex.required' => 'The sex format is invalid.',
                'sex.in' => 'The sex format is invalid.',
                'world.required' => 'Please select a valid world.',
                'world.world_slug_exists' => 'The world you selected does not exists.'
            ],
        };
    }
}