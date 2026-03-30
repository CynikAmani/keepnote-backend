<?php

namespace App\Http\Requests\TodoItem;

use Illuminate\Foundation\Http\FormRequest;

class UpdateTodoItemPositionRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true; // controller handles policy
    }

    public function rules(): array
    {
        return [
            'position' => ['required', 'integer', 'min:1'],
        ];
    }
}