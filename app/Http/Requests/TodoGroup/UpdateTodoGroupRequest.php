<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class UpdateTodoGroupRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'label_id' => ['nullable', 'exists:labels,id'],

            'title' => ['sometimes', 'string', 'max:255'],

            'color' => ['sometimes', 'string', 'max:50'],

            'is_pinned' => ['sometimes', 'boolean'],

            'is_archived' => ['sometimes', 'boolean'],
        ];
    }
}
