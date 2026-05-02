<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Support\Collection;

class RoleUserService
{
    public function getRolesForUser(User $user): Collection
    {
        return $user->roles()->get(['roles.id', 'roles.name']);
    }

    public function syncUserRoles(User $user, array $roleIds): void
    {
        $adminId = auth()->id();

        // Format sync data: [role_id => ['assigned_by' => X]]
        $syncData = array_fill_keys($roleIds, ['assigned_by' => $adminId]);

        $user->roles()->sync($syncData);
    }
}