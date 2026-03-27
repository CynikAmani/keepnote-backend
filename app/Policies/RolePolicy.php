<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Role;

class RolePolicy
{
    public function viewAny(User $user): bool
    {
        return $user->hasPermission('view-roles');
    }

    public function view(User $user, Role $role): bool
    {
        return $user->hasPermission('view-role');
    }

    public function create(User $user): bool
    {
        return $user->hasPermission('create-role');
    }

    public function update(User $user, Role $role): bool
    {
        return $user->hasPermission('update-role');
    }

    public function delete(User $user, Role $role): bool
    {
        return $user->hasPermission('delete-role');
    }
}