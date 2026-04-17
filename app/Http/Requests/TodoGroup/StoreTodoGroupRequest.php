<?php

namespace App\Http\Requests\TodoGroup;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreTodoGroupRequest extends FormRequest
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
            'color' => ['nullable', 'string', 'max:50'],
            'is_pinned' => ['sometimes', 'boolean'],
            'todo_items' => ['sometimes', 'array'],
            'todo_items.*.task' => ['required_with:todo_items', 'string', 'max:1000'],
            'todo_items.*.position' => ['required_with:todo_items', 'integer', 'min:0', 'distinct'],
        ];
    }
}