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

    public function createUser(array $data): User
    {
        // Hash password if provided
        if (!empty($data['password'])) {
            $data['password'] = Hash::make($data['password']);
        }

        // Create user
        $user = User::create($data);

        // Sync roles if provided
        if (isset($data['roles'])) {
            $user->roles()->sync($data['roles']);
        }

        return $user->load(['roles.permissions']); // Load roles and permissions for API response
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

        return $user->load(['roles.permissions']); // Lazy load: fresh roles and permissions after update
    }

    public function deleteUser(User $user): bool
    {
        return $user->delete();
    }
}