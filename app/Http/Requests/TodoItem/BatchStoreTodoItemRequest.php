<?php

namespace App\Http\Requests\TodoItem;

use Illuminate\Foundation\Http\FormRequest;

class BatchStoreTodoItemRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'todo_items' => ['required', 'array', 'min:1'],
            'todo_items.*.task' => ['required', 'string', 'max:255'],
            'todo_items.*.is_completed' => ['sometimes', 'boolean'],
            'todo_items.*.position' => ['sometimes', 'integer', 'min:0'],
        ];
    }
}
