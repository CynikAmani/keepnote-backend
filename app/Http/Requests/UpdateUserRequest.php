<?php
namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateUserRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()->hasPermission('edit-user');
    }

    public function rules(): array
    {
        $userId = $this->route('user')->id;

        return [
            'name'     => 'sometimes|string|max:255',
            'email'    => 'sometimes|email|unique:users,email,' . $userId,
            'password' => 'sometimes|string|min:8|confirmed',
            'roles'    => 'sometimes|array',
            'roles.*'  => 'exists:roles,id',
        ];
    }
}