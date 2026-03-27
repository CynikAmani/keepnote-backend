<?php

namespace App\Http\Requests\Role;

use Illuminate\Foundation\Http\FormRequest;

class UpdateRoleRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Validation rules for updating a role.
     */
    public function rules(): array
    {
        $roleId = $this->route('role');

        return [
            'name' => ['sometimes', 'string', 'max:150', "unique:roles,name,$roleId"],
        ];
    }
}