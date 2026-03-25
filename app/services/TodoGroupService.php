<?php

namespace App\Services;

use App\Models\TodoGroup;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\DB;

class TodoGroupService
{
    /**
     * Retrieve all active TodoGroups belonging to a user
     */
    public function getUserTodoGroups(int $userId): Collection
    {
        return TodoGroup::forUser($userId)
            ->with('todoItems')
            ->active()
            ->orderByDesc('is_pinned')
            ->latest()
            ->get();
    }

    /**
     * Create a new TodoGroup with optional TodoItems: one request - good practice for atomic operations and reduces client-server round trips
     */
    public function createTodoGroup(array $data): TodoGroup
    {
        return DB::transaction(function () use ($data) {
            $items = $data['todo_items'] ?? [];
            unset($data['todo_items']);

            $todoGroup = TodoGroup::create($data);

            if (!empty($items)) {
                $todoGroup->todoItems()->createMany($items);
            }

            return $todoGroup->load('todoItems');
        });
    }

    /**
     * Update an existing TodoGroup (only group-level fields)
     */
    public function updateTodoGroup(TodoGroup $todoGroup, array $data): TodoGroup
    {
        $todoGroup->update($data);

        return $todoGroup->load('todoItems'); // still eager load items for response
    }

    /**
     * Archive a TodoGroup
     */
    public function archiveTodoGroup(TodoGroup $todoGroup): TodoGroup
    {
        $todoGroup->update([
            'is_archived' => true,
        ]);

        return $todoGroup->load('todoItems');
    }

    /**
     * Toggle pin state of a TodoGroup
     */
    public function toggleTodoGroupPin(TodoGroup $todoGroup): TodoGroup
    {
        $todoGroup->update([
            'is_pinned' => !$todoGroup->is_pinned,
        ]);

        return $todoGroup->load('todoItems');
    }

    /**
     * Delete a TodoGroup
     */
    public function deleteTodoGroup(TodoGroup $todoGroup): void
    {
        $todoGroup->delete();
    }
}