<?php

declare(strict_types=1);

namespace App\Http\Requests;

use App\Utils\World;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Support\Facades\Redirect;

class CreateAccountRequest extends FormRequest
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
                'g-recaptcha-response' => 'recaptcha',
                'rulesAgreement' => 'required',
                'termsAgreement' => 'required',
                'id' => 'required|unique:accounts|digits_between:6,8',
                'password' => 'required|string|min:1|max:50',
                'confirmPassword' => 'required|string|same:password',
                'email' => 'required|email|unique:accounts',
                'name' => 'required|unique:players,name',
                'sex' => 'required|in:0,1',
                'world' => 'required|world_slug_exists',
                'country_code' => 'required|in:' . implode(',', config('country_codes_validation'))
            ],
        };
    }

    public function messages(): array
    {
        $basename = basename($this->getPathInfo());
        return match ($basename) {
            'create' => [
                'id.required' => 'Your account number is required.',
                'id.integer' => 'Your account number can only contain numbers.',
                'id.digits_between' => 'Your account number need to be between :min and :max numbers.',
                'id.unique' => 'This account number is already in use.',
                'password.required' => 'Your password is required.',
                'password.string' => 'Your password has invalid format.',
                'password.min' => 'Your password needs to be at least :min letters.',
                'password.max' => 'Your password cannot have more than :max letters.',
                'confirmPassword.required' => 'Confirm password is required.',
                'confirmPassword.same' => 'Confirm password does not match with password.',
                'email.required' => 'Your email is required.',
                'email.email' => 'Please enter a valid email address.',
                'email.unique' => 'This email is already in use.',
                'g-recaptcha-response.recaptcha' => 'The Google reCaptcha validation failed.',
                'rulesAgreement.required' => 'You have to agree to the rules in order to create an account!',
                'termsAgreement.required' => 'You have to agree to the terms in order to create an account!',
                'name.required' => 'Please enter a valid character name!',
                'name.unique' => 'This character name is already used. Please choose another character name!',
                'sex.required' => 'The sex format is invalid.',
                'sex.in' => 'The sex format is invalid.',
                'world.required' => 'Please select a valid world.',
                'world.world_slug_exists' => 'The world you selected does not exists.',
                'country_code.required' => 'Select a valid country.',
                'country_code.in' => 'The country you have selected is not valid.',
            ],
        };
    }
}