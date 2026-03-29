<?php

namespace App\Services;

use App\Models\Role;

class RoleService
{
    /**
     * Create a new role.
     */
    public function createRole(array $data): Role
    {
        return Role::create($data);
    }

    /**
     * Update an existing role.
     */
    public function updateRole(Role $role, array $data): Role
    {
        $role->update($data);

        return $role->refresh();
    }

    /**
     * Retrieve all roles.
     */
    public function getAllRoles()
    {
        return Role::query()
            ->latest()
            ->get();
    }

    /**
     * Retrieve a single role.
     */
    public function getRole(Role $role): Role
    {
        return $role;
    }

    /**
     * Delete a role.
     */
    public function deleteRole(Role $role): void
    {
        $role->delete();
    }
}