<?php

namespace App\Services;

use App\Models\Label;
use Illuminate\Database\Eloquent\Collection;

class UserService
{
    /*
    ---------------------------------
    | Get all labels for a user
    | Optionally preload the latest note/todos
    | and include counts for notes/todoGroups
    ---------------------------------
    */
    public function getAllLabels(int $userId, bool $withPreview = false): Collection
    {
        $query = Label::forUser($userId)
            ->withCount(['notes', 'todoGroups']);

        if ($withPreview) {
            $query->with([
                'notes' => fn($q) => $q->latest()->limit(1),
                'todoGroups' => fn($q) => $q->latest()->limit(1),
            ]);
        }

        return $query->get();
    }

    /*
    ---------------------------------
    | Get label by ID for a user
    | Load all notes/todos for that label
    | and include counts
    ---------------------------------
    */
    public function getLabelById(int $userId, int $labelId): Label|null
    {
        return Label::forUser($userId)
            ->with(['notes', 'todoGroups'])
            ->withCount(['notes', 'todoGroups'])
            ->find($labelId);
    }

    /*
    ---------------------------------
    | Create a new label
    ---------------------------------
    */
    public function createLabel(int $userId, string $name): Label
    {
        return Label::create([
            'user_id' => $userId,
            'name' => $name,
        ]);
    }

    /*
    ---------------------------------
    | Update label
    ---------------------------------
    */
    public function updateLabel(Label $label, string $name): Label
    {
        $label->name = $name;
        $label->save();

        return $label;
    }

    /*
    ---------------------------------
    | Delete label
    ---------------------------------
    */
    public function deleteLabel(Label $label): void
    {
        $label->delete();
    }
}