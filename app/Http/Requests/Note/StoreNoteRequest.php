<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreNoteRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'label_id' => [
                'nullable',
                Rule::exists('labels', 'id')->where(function ($query) {
                    $query->where('user_id', auth()->id());
                }),
            ],
            'title' => ['required', 'string', 'max:255'],
            'content' => ['nullable', 'string'],
            'color' => ['nullable', 'string', 'max:50'],
            'is_pinned' => ['sometimes', 'boolean'],
            'is_archived' => ['sometimes', 'boolean'],
        ];
    }

    protected function prepareForValidation()
    {
        $this->merge([
            'is_pinned' => $this->is_pinned ?? false,
            'is_archived' => $this->is_archived ?? false,
        ]);
    }
}