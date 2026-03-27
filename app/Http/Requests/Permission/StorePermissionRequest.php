<?php

namespace App\Http\Requests\Permission;

use Illuminate\Foundation\Http\FormRequest;

class StorePermissionRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Validation rules for creating a permission.
     */
    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:150', 'unique:permissions,name'],
            'description' => ['nullable', 'string', 'max:255'],
        ];
    }
}