<?php

namespace App\Http\Controllers;

use App\Models\TodoItem;
use App\Services\TodoItemService;
use App\Http\Resources\TodoItemResource;
use App\Http\Requests\TodoItem\StoreTodoItemRequest;
use App\Http\Requests\TodoItem\UpdateTodoItemRequest;
use App\Http\Requests\TodoItem\UpdateTodoItemPositionRequest;

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
        $this->authorize('create', [TodoItem::class, $request->todo_group_id]);

        $todoItem = $this->service->create($request->validated());

        return new TodoItemResource($todoItem);
    }

    /**
     * Update Todo Item
     */
    public function update(UpdateTodoItemRequest $request, TodoItem $todoItem)
    {
        $this->authorize('update', $todoItem);

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
        $this->authorize('delete', $todoItem);

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
        $this->authorize('toggleCompletion', $todoItem);

        $todoItem = $this->service->toggleCompletion($todoItem);

        return new TodoItemResource($todoItem);
    }

    /**
     * Update position (drag and drop)
     */
    public function updatePosition(UpdateTodoItemPositionRequest $request, TodoItem $todoItem)
    {
        $this->authorize('updatePosition', $todoItem);
    
        $todoItem = $this->service->updatePosition(
            $todoItem,
            $request->validated()['position'] // guaranteed to be an integer
        );
    
        return new TodoItemResource($todoItem);
    }
}