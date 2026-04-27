<?php

namespace App\Http\Requests\Role;

use App\Models\Role;
use Illuminate\Foundation\Http\FormRequest;

class UpdateRoleRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $role = $this->route('role');

        return [
            'name' => [
                'sometimes', 
                'string', 
                'max:150', 
                "unique:roles,name,{$role->id}"
            ],
            'description' => ['nullable', 'string', 'max:255'],
        ];
    }
}