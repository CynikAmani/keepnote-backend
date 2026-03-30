<?php

namespace App\Policies;

use App\Models\User;
use App\Models\TodoItem;

class TodoItemPolicy
{
    /**
     * Determine if the user owns the todo item.
     */
    private function isOwner(User $user, TodoItem $todoItem): bool
    {
        return $todoItem->todoGroup->user_id === $user->id;
    }

    /**
     * Determine whether the user can view the todo item.
     */
    public function view(User $user, TodoItem $todoItem): bool
    {
        return $this->isOwner($user, $todoItem);
    }

    /*
    -----------------------------------------------------------------
     | Determine whether the user can create todo items.
     | Any authenticated user can create items, 
     | but the service will ensure they belong to a group they own.
     * --------------------------------------------------------------
     */
    public function create(User $user): bool
    {
        return true;
    }

    /**
     * Determine whether the user can update the todo item.
     */
    public function update(User $user, TodoItem $todoItem): bool
    {
        return $this->isOwner($user, $todoItem);
    }

    /**
     * Determine whether the user can delete the todo item.
     */
    public function delete(User $user, TodoItem $todoItem): bool
    {
        return $this->isOwner($user, $todoItem);
    }

    /**
     * Determine whether the user can toggle the completion status of the todo item.
     */
    public function toggleCompletion(User $user, TodoItem $todoItem): bool
    {
        return $this->isOwner($user, $todoItem);
    }

    /**
     * Determine whether the user can update the position of the todo item.
     */
    public function updatePosition(User $user, TodoItem $todoItem): bool
    {
        return $this->isOwner($user, $todoItem);
    }

    /**
     * Determine whether the user can restore the todo item.
     */
    public function restore(User $user, TodoItem $todoItem): bool
    {
        return $this->isOwner($user, $todoItem);
    }

    /**
     * Determine whether the user can permanently delete the todo item.
     */
    public function forceDelete(User $user, TodoItem $todoItem): bool
    {
        return $this->isOwner($user, $todoItem);
    }
}