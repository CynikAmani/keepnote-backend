<?php

namespace App\Http\Controllers;

use App\Models\TodoItem;
use App\Services\TodoItemService;
use App\Http\Resources\TodoItemResource;
use App\Http\Requests\TodoItem\StoreTodoItemRequest;
use App\Http\Requests\TodoItem\UpdateTodoItemRequest;

class TodoItemController extends Controller
{
    protected $service;

    public function __construct(TodoItemService $service)
    {
        $this->service = $service;
    }

    /**
     * Store Todo Item
     */
    public function store(StoreTodoItemRequest $request)
    {
        $todoItem = $this->service->create($request->validated());

        return new TodoItemResource($todoItem);
    }

    /**
     * Update Todo Item
     */
    public function update(UpdateTodoItemRequest $request, TodoItem $todoItem)
    {
        $todoItem = $this->service->update(
            $todoItem,
            $request->validated()
        );

        return new TodoItemResource($todoItem);
    }

    /**
     * Delete Todo Item
     */
    public function destroy(TodoItem $todoItem)
    {
        $this->service->delete($todoItem);

        return response()->json([
            'message' => 'Todo item deleted successfully'
        ]);
    }

    /**
     * Toggle completion status
     */
    public function toggleCompletion(TodoItem $todoItem)
    {
        $todoItem = $this->service->toggleCompletion($todoItem);

        return new TodoItemResource($todoItem);
    }

    /**
     * Update position (drag and drop)
     */
    public function updatePosition(TodoItem $todoItem)
    {
        $todoItem = $this->service->updatePosition(
            $todoItem,
            request('position')
        );

        return new TodoItemResource($todoItem);
    }
}