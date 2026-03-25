<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class StoreTodoGroupRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get validation rules for creating a TodoGroup
     *
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'label_id' => ['nullable', 'exists:labels,id'],
            'title' => ['required', 'string', 'max:255'],
            'color' => ['nullable', 'string', 'max:50'],
            'is_pinned' => ['sometimes', 'boolean'],

            // Nested TodoItems to reduce number of API calls when creating a group with items
            'todo_items' => ['sometimes', 'array'],
            'todo_items.*.content' => ['required_with:todo_items', 'string', 'max:1000'],
            'todo_items.*.position' => ['required_with:todo_items', 'integer', 'min:1', 'distinct'],
        ];
    }
}