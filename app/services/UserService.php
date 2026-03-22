<?php
namespace App\Services;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Pagination\LengthAwarePaginator;

class UserService
{
    public function getAllUsers(int $perPage = 15): LengthAwarePaginator
    {
        return User::with(['roles.permissions'])
            ->latest()
            ->paginate($perPage);
    }

    public function findUser(int $id): User
    {
        return User::with(['roles.permissions'])->findOrFail($id);
    }

    public function updateUser(User $user, array $data): User
    {
        // Handle Password Update
        if (!empty($data['password'])) {
            $data['password'] = Hash::make($data['password']);
        } else {
            unset($data['password']);
        }

        $user->update($data);

        // Sync Roles if provided in the request
        if (isset($data['roles'])) {
            $user->roles()->sync($data['roles']);
        }

        return $user->load(['roles.permissions']); //Lazy load: fresh roles and permissions after update incase they were changed
    }

    public function deleteUser(User $user): bool
    {
        return $user->delete();
    }
}