<?php

namespace App\Policies;

use App\Models\TodoGroup;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class TodoGroupPolicy
{
    use HandlesAuthorization;

    /*
    --------------------------------------------------------------
    | Authorization for TodoGroup
    --------------------------------------------------------------
    */
    private function isOwner(User $user, TodoGroup $todoGroup): bool
    {
        return $todoGroup->user_id === $user->id;
    }

    /**
     * Determine whether the user can view any TodoGroups.
     */
    public function viewAny(User $user): bool
    {
        return true; // Filtered by service, so any user only sees their own groups
    }

    /**
     * Determine whether the user can view a specific TodoGroup.
     */
    public function view(User $user, TodoGroup $todoGroup): bool
    {
        return $this->isOwner($user, $todoGroup);
    }

    /**
     * Determine whether the user can create TodoGroups.
     */
    public function create(User $user): bool
    {
        return true;
    }

    /**
     * Determine whether the user can update a TodoGroup.
     */
    public function update(User $user, TodoGroup $todoGroup): bool
    {
        return $this->isOwner($user, $todoGroup);
    }

    /**
     * Determine whether the user can archive a TodoGroup.
     */
    public function archive(User $user, TodoGroup $todoGroup): bool
    {
        return $this->isOwner($user, $todoGroup);
    }

    /**
     * Determine whether the user can unarchive a TodoGroup.
     */
    public function unarchive(User $user, TodoGroup $todoGroup): bool
    {
        return $this->isOwner($user, $todoGroup);
    }

    /**
     * Determine whether the user can toggle pin.
     */
    public function togglePin(User $user, TodoGroup $todoGroup): bool
    {
        return $this->isOwner($user, $todoGroup);
    }

    /**
     * Determine whether the user can delete a TodoGroup.
     */
    public function delete(User $user, TodoGroup $todoGroup): bool
    {
        return $this->isOwner($user, $todoGroup);
    }
}
