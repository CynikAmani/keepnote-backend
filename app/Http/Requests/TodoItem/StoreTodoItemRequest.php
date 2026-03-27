<?php

namespace App\Http\Requests\TodoItem;

use Illuminate\Foundation\Http\FormRequest;

class StoreTodoItemRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'todo_group_id' => ['required','exists:todo_groups,id'],
            'task' => ['required','string','max:255'],
            'is_completed' => ['sometimes','boolean'],
            'position' => ['sometimes','integer','min:0'],
        ];
    }
}