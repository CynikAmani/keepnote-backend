<?php

namespace App\Http\Requests\Label;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateLabelRequest extends FormRequest
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
    | Validation rules for updating a label
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
                    ->ignore($this->route('label')->id)
                    ->where(fn($q) => $q->where('user_id', $this->user()->id)),
            ],
        ];
    }
}