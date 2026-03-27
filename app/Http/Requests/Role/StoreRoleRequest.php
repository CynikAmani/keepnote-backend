<?php

namespace App\Http\Requests\Role;

use Illuminate\Foundation\Http\FormRequest;

class StoreRoleRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Validation rules for creating a role.
     */
    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:150', 'unique:roles,name'],
        ];
    }
}