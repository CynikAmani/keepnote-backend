<?php

namespace App\Http\Requests\Label;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreLabelRequest extends FormRequest
{
    /*
    ---------------------------------
    | Determine if the user is authorized to make this request
    ---------------------------------
    */
    public function authorize(): bool
    {
        return true;
    }

    /*
    ---------------------------------
    | Validation rules for creating a label
    ---------------------------------
    */
    public function rules(): array
    {
        return [
            'name' => [
                'required',
                'string',
                'max:255',
                Rule::unique('labels', 'name')
                    ->where(fn($q) => $q->where('user_id', $this->user()->id)),
            ],
        ];
    }
}