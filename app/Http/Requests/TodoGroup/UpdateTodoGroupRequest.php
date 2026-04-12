<?php

namespace App\Http\Requests\TodoGroup;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateTodoGroupRequest extends FormRequest
{
    public function authorize(): bool
    {
        $todoGroup = $this->route('todoGroup');

        if ($todoGroup && $todoGroup->is_archived) {
            return false;
        }

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
            'title' => ['sometimes', 'string', 'max:255'],
            'color' => ['sometimes', 'string', 'max:50'],
            'is_pinned' => ['sometimes', 'boolean'],
            'is_archived' => ['sometimes', 'boolean'],
        ];
    }
}