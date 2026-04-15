<?php

namespace App\Services;

use App\Models\TodoItem;
use App\Models\TodoGroup;
use Illuminate\Support\Collection;

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

    /**
     * Batch create Todo Items for a group
     *
     * @param TodoGroup $todoGroup
     * @param array $items
     * @return Collection
     */
    public function batchCreate(TodoGroup $todoGroup, array $items): Collection
    {
        $createdItems = collect();

        foreach ($items as $itemData) {
            $createdItems->push($todoGroup->todoItems()->create($itemData));
        }

        return $createdItems;
    }

    /**
     * Batch update and delete Todo Items for a group
     *
     * @param TodoGroup $todoGroup
     * @param array $updates
     * @param array $deletes
     * @return Collection
     */
    public function batchUpdateAndDelete(TodoGroup $todoGroup, array $updates = [], array $deletes = []): Collection
    {
        if (!empty($deletes)) {
            $todoGroup->todoItems()->whereIn('id', $deletes)->delete();
        }

        $updatedItems = collect();
        foreach ($updates as $updateData) {
            $item = $todoGroup->todoItems()->find($updateData['id']);
            if ($item) {
                unset($updateData['id']);
                $item->update($updateData);
                $updatedItems->push($item->refresh());
            }
        }

        return $updatedItems;
    }
}