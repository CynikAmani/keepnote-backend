<?php

namespace App\Services;

use App\Models\Role;
use Illuminate\Database\Eloquent\Collection;

class RoleService
{
    public function createRole(array $data): Role
    {
        return Role::create($data);
    }

    public function updateRole(Role $role, array $data): Role
    {
        $role->update($data);
        return $role->refresh();
    }

    public function getAllRoles(): Collection
    {
        return Role::query()->latest()->get();
    }

    public function getRole(Role $role): Role
    {
        return $role;
    }

    public function deleteRole(Role $role): void
    {
        $role->delete();
    }
}