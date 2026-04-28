<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Pagination\LengthAwarePaginator;

class UserService
{
    /**
     * Get paginated users (no heavy relations)
     */
    public function getAllUsers(int $perPage = 30): LengthAwarePaginator
    {
        return User::latest()
            ->paginate($perPage);
    }

    /**
     * Get single user (roles handled separately)
     */
    public function findUser(int $id): User
    {
        return User::findOrFail($id);
    }

    /**
     * Create user (no role handling here)
     */
    public function createUser(array $data): User
    {
        if (!empty($data['password'])) {
            $data['password'] = Hash::make($data['password']);
        }

        return User::create($data);
    }

    /**
     * Update user (no role handling here)
     */
    public function updateUser(User $user, array $data): User
    {
        if (!empty($data['password'])) {
            $data['password'] = Hash::make($data['password']);
        } else {
            unset($data['password']);
        }

        $user->update($data);

        return $user;
    }

    /**
     * Soft delete user (deactivate)
     */
    public function deleteUser(User $user): bool
    {
        return $user->delete();
    }

    /**
     * Restore soft deleted user (activate)
     */
    public function restoreUser(User $user): bool
    {
        return $user->restore();
    }

    /**
     * Revoke all Sanctum tokens
     */
    public function revokeTokens(User $user): void
    {
        $user->tokens()->delete();
    }


    /**
     * Admin password reset (sets default password)
     */
    public function resetPassword(User $user): void
    {
        $user->update([
            'password' => Hash::make('ChangeMir!Bitte')
        ]);
    }
}