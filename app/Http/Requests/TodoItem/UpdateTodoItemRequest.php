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
            'task' => ['sometimes','string','max:255'],
            'is_completed' => ['sometimes','boolean'],
            'position' => ['sometimes','integer','min:0'],
        ];
    }
}