<?php

namespace App\Policies;

use App\Models\Note;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class NotePolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any notes.
     */
    public function viewAny(User $user): bool
    {
        return $user->hasPermissionTo('view-notes');
    }

    /**
     * Determine whether the user can view a specific note.
     */
    public function view(User $user, Note $note): bool
    {
        return $user->hasPermissionTo('view-notes') && $note->user_id === $user->id;
    }

    /**
     * Determine whether the user can create notes.
     */
    public function create(User $user): bool
    {
        return $user->hasPermissionTo('create-note');
    }

    /**
     * Determine whether the user can update a specific note.
     */
    public function update(User $user, Note $note): bool
    {
        return $user->hasPermissionTo('update-note') && $note->user_id === $user->id;
    }

    /**
     * Determine whether the user can delete a specific note.
     */
    public function delete(User $user, Note $note): bool
    {
        return $user->hasPermissionTo('delete-note') && $note->user_id === $user->id;
    }

    /**
     * Determine whether the user can pin/unpin a note.
     */
    public function togglePin(User $user, Note $note): bool
    {
        return $this->update($user, $note);
    }

    /**
     * Determine whether the user can archive a note.
     */
    public function archive(User $user, Note $note): bool
    {
        return $this->update($user, $note);
    }

    /**
     * Determine whether the user can unarchive a note.
     */
    public function unarchive(User $user, Note $note): bool
    {
        return $this->update($user, $note);
    }
}