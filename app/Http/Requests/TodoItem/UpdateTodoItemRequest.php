<?php

namespace App\Http\Requests\TodoItem;

use Illuminate\Foundation\Http\FormRequest;

class UpdateTodoItemRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'task' => ['sometimes', 'string', 'max:255', 'required_without:is_completed'],
            'is_completed' => ['sometimes', 'boolean', 'required_without:task'],
        ];
    }

    public function messages(): array
    {
        return [
            'task.required_without' => 'You must provide either a task title or completion status.',
            'is_completed.required_without' => 'You must provide either a task title or completion status.',
        ];
    }
}