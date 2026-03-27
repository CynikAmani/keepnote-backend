<?php

namespace App\Services;

use App\Models\TodoItem;

class TodoItemService
{
    /**
     * Create Todo Item
     */
    public function create(array $data): TodoItem
    {
        return TodoItem::create($data);
    }

    /**
     * Update Todo Item
     */
    public function update(TodoItem $todoItem, array $data): TodoItem
    {
        $todoItem->update($data);

        return $todoItem->refresh();
    }

    /**
     * Delete Todo Item
     */
    public function delete(TodoItem $todoItem): void
    {
        $todoItem->delete();
    }

    /**
     * Toggle completion status
     */
    public function toggleCompletion(TodoItem $todoItem): TodoItem
    {
        $todoItem->update([
            'is_completed' => ! $todoItem->is_completed
        ]);

        return $todoItem->refresh();
    }

    /**
     * Update item position (drag-and-drop ordering)
     */
    public function updatePosition(TodoItem $todoItem, int $position): TodoItem
    {
        $todoItem->update([
            'position' => $position
        ]);

        return $todoItem->refresh();
    }
}