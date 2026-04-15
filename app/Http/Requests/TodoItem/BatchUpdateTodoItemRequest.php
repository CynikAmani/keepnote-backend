<?php

namespace App\Http\Requests\TodoItem;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class BatchUpdateTodoItemRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $todoGroupId = $this->route('todoGroup')->id;

        return [
            'update_items' => ['sometimes', 'array'],
            'update_items.*.id' => [
                'required', 
                'integer', 
                Rule::exists('todo_items', 'id')->where('todo_group_id', $todoGroupId)
            ],
            'update_items.*.task' => ['sometimes', 'string', 'max:255'],
            'update_items.*.is_completed' => ['sometimes', 'boolean'],
            'update_items.*.position' => ['sometimes', 'integer', 'min:0'],
            
            'delete_item_ids' => ['sometimes', 'array'],
            'delete_item_ids.*' => [
                'integer',
                Rule::exists('todo_items', 'id')->where('todo_group_id', $todoGroupId)
            ],
        ];
    }
}
