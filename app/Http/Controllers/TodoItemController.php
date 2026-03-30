<?php

namespace App\Http\Controllers;

use App\Models\TodoItem;
use App\Services\TodoItemService;
use App\Http\Resources\TodoItemResource;
use App\Http\Requests\TodoItem\StoreTodoItemRequest;
use App\Http\Requests\TodoItem\UpdateTodoItemRequest;
use App\Http\Requests\TodoItem\UpdateTodoItemPositionRequest;
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
        // The policy for creation can be handled elsewhere, e.g., on the group
        $todoItem = $this->service->create($request->validated());

        return new TodoItemResource($todoItem);
    }

    /*
    ---------------------------------------------------------------------------------
     | Update a Todo Item (task, completion status, position)
     | Use the single `update` policy for all modifications
     ---------------------------------------------------------------------------------
     */
    public function update(UpdateTodoItemRequest|UpdateTodoItemPositionRequest $request, TodoItem $todoItem): TodoItemResource
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
        $this->authorize('update', $todoItem); // same policy

        $this->service->delete($todoItem);

        return response()->json([
            'message' => 'Todo item deleted successfully'
        ]);
    }
}