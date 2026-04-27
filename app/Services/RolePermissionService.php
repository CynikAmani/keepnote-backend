<?php

namespace App\Services;

use App\Models\Role;
use Illuminate\Database\Eloquent\Collection;

class RolePermissionService
{
    /**
     * Get all permissions currently assigned to a role.
     */
    public function getPermissionsForRole(Role $role): Collection
    {
        return $role->permissions()->get(['permissions.id', 'name', 'display_name', 'module']);
    }

    /**
     * Replace all permissions of a role in one batch.
     */
    public function syncRolePermissions(Role $role, array $permissionIds): Role
    {
        // sync() handles adding new and removing old links in the pivot table automatically
        $role->permissions()->sync($permissionIds);

        return $role->load('permissions');
    }
}