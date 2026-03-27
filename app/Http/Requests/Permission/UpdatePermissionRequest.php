<?php

namespace App\Http\Requests\Permission;

use Illuminate\Foundation\Http\FormRequest;

class UpdatePermissionRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Validation rules for updating a permission.
     */
    public function rules(): array
    {
        $permissionId = $this->route('permission');

        return [
            'name' => ['sometimes', 'string', 'max:150', "unique:permissions,name,$permissionId"],
            'description' => ['sometimes', 'nullable', 'string', 'max:255'],
        ];
    }
}