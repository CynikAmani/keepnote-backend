<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateNoteRequest extends FormRequest
{
    /**
     * Determine if the user is authorized
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Validation rules
     */
    public function rules(): array
    {
        return [
            'label_id' => ['nullable', 'exists:labels,id'],

            'title' => ['sometimes', 'string', 'max:255'],

            'content' => ['nullable', 'string'],

            'color' => ['nullable', 'string', 'max:50'],

            'is_pinned' => ['sometimes', 'boolean'],
            'is_archived' => ['sometimes', 'boolean'],
        ];
    }
}

