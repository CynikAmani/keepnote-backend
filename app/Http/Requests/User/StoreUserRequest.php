<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreUserRequest extends FormRequest
{
    /*
    ---------------------------------
    | Determine if user is authorized
    ---------------------------------
    */
    public function authorize(): bool
    {
        return true;
    }

    /*
    ---------------------------------
    | Validation rules for request
    ---------------------------------
    */
    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255'],

            'email' => [
                'required',
                'string',
                'email',
                'max:255',
                Rule::unique('users', 'email'),
            ],

            'password' => ['required', 'string', 'min:8'],
        ];
    }
}