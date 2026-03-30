<?php

namespace App\Policies;

use App\Models\Label;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class LabelPolicy
{
    use HandlesAuthorization;

    /*
    --------------------------------------------------------------
    | Authorization for Label
    --------------------------------------------------------------
    */
    private function isOwner(User $user, Label $label): bool
    {
        return $label->user_id === $user->id;
    }

    /**
     * Determine whether the user can view any labels.
     */
    public function viewAny(User $user): bool
    {
        return true;
    }

    /**
     * Determine whether the user can view a specific label.
     */
    public function view(User $user, Label $label): bool
    {
        return $this->isOwner($user, $label);
    }

    /**
     * Determine whether the user can create labels.
     */
    public function create(User $user): bool
    {
        return true;
    }

    /**
     * Determine whether the user can update a label.
     */
    public function update(User $user, Label $label): bool
    {
        return $this->isOwner($user, $label);
    }

    /**
     * Determine whether the user can delete a label.
     */
    public function delete(User $user, Label $label): bool
    {
        return $this->isOwner($user, $label);
    }
}