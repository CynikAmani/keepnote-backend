<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Permission;

class PermissionPolicy
{
    /**
     * Determine whether the user can create permissions.
     */
    public function create(User $user): bool
    {
        return $user->hasPermission('create-permission');
    }

    /**
     * Determine whether the user can update permissions.
     */
    public function update(User $user, Permission $permission): bool
    {
        return $user->hasPermission('update-permission');
    }

    /**
     * Determine whether the user can delete permissions.
     */
    public function delete(User $user, Permission $permission): bool
    {
        return $user->hasPermission('delete-permission');
    }
}