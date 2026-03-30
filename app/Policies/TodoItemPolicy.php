<?php

namespace App\Policies;

use App\Models\User;
use App\Models\TodoItem;

class TodoItemPolicy
{
    /*
    --------------------------------------------------------------
    | Authorization for TodoItem
    --------------------------------------------------------------
    */
    private function isOwner(User $user, TodoItem $todoItem): bool
    {
        return $todoItem->todoGroup->user_id === $user->id;
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
}