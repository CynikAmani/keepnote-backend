<?php

namespace App\Policies;

use App\Models\Note;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class NotePolicy
{
    use HandlesAuthorization;

    /*
    --------------------------------------------------------------
    | Authorization for Note
    --------------------------------------------------------------
    */
    private function isOwner(User $user, Note $note): bool
    {
        return $note->user_id === $user->id;
    }

    /**
     * Determine whether the user can view any notes.
     */
    public function viewAny(User $user): bool
    {
        return true; // Service filters notes by user_id
    }

    /**
     * Determine whether the user can view a specific note.
     */
    public function view(User $user, Note $note): bool
    {
        return $this->isOwner($user, $note);
    }

    /**
     * Determine whether the user can create notes.
     */
    public function create(User $user): bool
    {
        return true;
    }

    /**
     * Determine whether the user can update a specific note.
     */
    public function update(User $user, Note $note): bool
    {
        return $this->isOwner($user, $note);
    }

    /**
     * Determine whether the user can delete a specific note.
     */
    public function delete(User $user, Note $note): bool
    {
        return $this->isOwner($user, $note);
    }

    /**
     * Pin / Unpin note.
     */
    public function togglePin(User $user, Note $note): bool
    {
        return $this->isOwner($user, $note);
    }

    /**
     * Archive note.
     */
    public function archive(User $user, Note $note): bool
    {
        return $this->isOwner($user, $note);
    }

    /**
     * Restore archived note.
     */
    public function unarchive(User $user, Note $note): bool
    {
        return $this->isOwner($user, $note);
    }
}