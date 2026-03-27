<?php

namespace App\Services;

use App\Models\Role;
use App\Models\Permission;

class RolePermissionService
{
    /**
     * Get permissions assigned to a role
     */
    public function getPermissionsForRole(Role $role)
    {
        return $role->permissions()->get();
    }

    /**
     * Attach permissions to role
     */
    public function assignPermissionsToRole(Role $role, array $permissionIds): Role
    {
        $role->permissions()->syncWithoutDetaching($permissionIds);

        return $role->load('permissions');
    }

    /**
     * Replace all permissions of a role
     */
    public function syncRolePermissions(Role $role, array $permissionIds): Role
    {
        $role->permissions()->sync($permissionIds);

        return $role->load('permissions');
    }

    /**
     * Remove permission from role
     */
    public function revokePermissionFromRole(Role $role, Permission $permission): Role
    {
        $role->permissions()->detach($permission->id);

        return $role->load('permissions');
    }
}