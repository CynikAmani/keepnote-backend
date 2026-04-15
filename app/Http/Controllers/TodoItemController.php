<?php

namespace App\Http\Controllers;

use App\Models\TodoItem;
use App\Services\TodoItemService;
use App\Http\Resources\TodoItemResource;
use App\Http\Requests\TodoItem\StoreTodoItemRequest;
use App\Http\Requests\TodoItem\UpdateTodoItemRequest;
use App\Http\Requests\TodoItem\UpdateTodoItemPositionRequest;
use App\Http\Requests\TodoItem\BatchStoreTodoItemRequest;
use App\Http\Requests\TodoItem\BatchUpdateTodoItemRequest;
use App\Models\TodoGroup;
use Illuminate\Http\JsonResponse;

class TodoItemController extends Controller
{
    protected TodoItemService $service;

    public function __construct(TodoItemService $service)
    {
        $this->service = $service;
    }

    /**
     * Store a new Todo Item
     */
    public function store(StoreTodoItemRequest $request): TodoItemResource
    {
        $this->authorize('create', TodoItem::class);
        
        $todoItem = $this->service->create($request->validated());

        return new TodoItemResource($todoItem);
    }

    /**
     * Update a Todo Item (task or other attributes)
     */
    public function update(UpdateTodoItemRequest $request, TodoItem $todoItem): TodoItemResource
    {
        $this->authorize('update', $todoItem);

        $todoItem = $this->service->update(
            $todoItem,
            $request->validated()
        );

        return new TodoItemResource($todoItem);
    }

    /**
     * Delete a Todo Item
     */
    public function destroy(TodoItem $todoItem): JsonResponse
    {
        $this->authorize('delete', $todoItem);

        $this->service->delete($todoItem);

        return response()->json([
            'message' => 'Todo item deleted successfully'
        ]);
    }

    /**
     * Toggle completion status
     */
    public function toggleCompletion(TodoItem $todoItem): TodoItemResource
    {
        $this->authorize('toggleCompletion', $todoItem);

        $todoItem = $this->service->toggleCompletion($todoItem);

        return new TodoItemResource($todoItem);
    }

    /**
     * Update position (drag-and-drop ordering)
     */
    public function updatePosition(UpdateTodoItemPositionRequest $request, TodoItem $todoItem): TodoItemResource
    {
        $this->authorize('updatePosition', $todoItem);

        $todoItem = $this->service->updatePosition(
            $todoItem,
            $request->validated()['position']
        );

        return new TodoItemResource($todoItem);
    }

    /**
     * Batch create Todo Items for a give TodoGroup
     */
    public function batchStore(BatchStoreTodoItemRequest $request, TodoGroup $todoGroup)
    {
        // Require permission to update the group in order to add items to it
        $this->authorize('update', $todoGroup);

        $createdItems = $this->service->batchCreate(
            $todoGroup,
            $request->validated()['todo_items'] ?? []
        );

        return TodoItemResource::collection($createdItems);
    }

    /**
     * Batch update and delete Todo Items for a given TodoGroup
     */
    public function batchUpdate(BatchUpdateTodoItemRequest $request, TodoGroup $todoGroup): JsonResponse
    {
        // Require permission to update the group in order to update its items
        $this->authorize('update', $todoGroup);

        $validated = $request->validated();
        
        $updatedItems = $this->service->batchUpdateAndDelete(
            $todoGroup,
            $validated['update_items'] ?? [],
            $validated['delete_item_ids'] ?? []
        );

        return response()->json([
            'message' => 'Batch update completed',
            'data' => TodoItemResource::collection($updatedItems)
        ]);
    }
}