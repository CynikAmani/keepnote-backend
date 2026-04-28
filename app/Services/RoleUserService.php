<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Database\Eloquent\Collection;

class RoleUserService
{
    /**
     * Get all roles assigned to a user
     */
    public function getRolesForUser(User $user): Collection
    {
        return $user->roles()->get(['roles.id', 'roles.name']);
    }

    /**
     * Replace all roles of a user in one batch
     */
    public function syncUserRoles(User $user, array $roleIds): void
    {
        $assignedBy = auth()->id();

        $syncData = collect($roleIds)
            ->mapWithKeys(fn ($id) => [
                $id => ['assigned_by' => $assignedBy]
            ])
            ->toArray();

        $user->roles()->sync($syncData);
    }
}