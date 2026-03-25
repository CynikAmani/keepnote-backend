<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreNoteRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
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

            'title' => ['required', 'string', 'max:255'],

            'content' => ['nullable', 'string'],

            'color' => ['nullable', 'string', 'max:50'],

            'is_pinned' => ['sometimes', 'boolean'],
            'is_archived' => ['sometimes', 'boolean'],
        ];
    }

    /**
     * Inject default values for boolean fields to ensure consistent data handling and avoid null issues in the database
     */
    protected function prepareForValidation()
    {
        $this->merge([
            'is_pinned' => $this->is_pinned ?? false,
            'is_archived' => $this->is_archived ?? false,
        ]);
    }
}
