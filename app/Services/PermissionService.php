<?php

namespace App\Services;

use App\Models\Permission;

class PermissionService
{
    /**
     * Create a new permission.
     */
    public function createPermission(array $data): Permission
    {
        return Permission::create($data);
    }

    /**
     * Update an existing permission.
     */
    public function updatePermission(Permission $permission, array $data): Permission
    {
        $permission->update($data);

        return $permission->refresh();
    }

    /**
     * Delete a permission.
     */
    public function deletePermission(Permission $permission): void
    {
        $permission->delete();
    }
}