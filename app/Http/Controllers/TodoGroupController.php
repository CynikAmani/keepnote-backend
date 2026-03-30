<?php

namespace App\Http\Controllers;

use App\Models\TodoGroup;
use App\Services\TodoGroupService;
use App\Http\Resources\TodoGroupResource;
use App\Http\Requests\TodoGroup\StoreTodoGroupRequest;
use App\Http\Requests\TodoGroup\UpdateTodoGroupRequest;

class TodoGroupController extends Controller
{
    protected TodoGroupService $todoGroupService;

    public function __construct(TodoGroupService $todoGroupService)
    {
        $this->todoGroupService = $todoGroupService;
    }

    /**
     * List all TodoGroups belonging to the authenticated user
     */
    public function index()
    {
        $this->authorize('viewAny', TodoGroup::class);

        $todoGroups = $this->todoGroupService->getUserTodoGroups(auth()->id());

        return TodoGroupResource::collection($todoGroups);
    }

    /** 
     * Store a new TodoGroup
     */
    public function store(StoreTodoGroupRequest $request)
    {
        $this->authorize('create', TodoGroup::class);

        $data = $request->validated();
        $data['user_id'] = auth()->id();

        $todoGroup = $this->todoGroupService->createTodoGroup($data);

        return new TodoGroupResource($todoGroup);
    }

    /**
     * Display a specific TodoGroup
     */
    public function show(TodoGroup $todoGroup)
    {
        $this->authorize('view', $todoGroup);

        return new TodoGroupResource($todoGroup);
    }

    /**
     * Update a TodoGroup
     */
    public function update(UpdateTodoGroupRequest $request, TodoGroup $todoGroup)
    {
        $this->authorize('update', $todoGroup);

        $todoGroup = $this->todoGroupService->updateTodoGroup(
            $todoGroup,
            $request->validated()
        );

        return new TodoGroupResource($todoGroup);
    }

    /**
     * Archive a TodoGroup
     */
    public function archive(TodoGroup $todoGroup)
    {
        $this->authorize('archive', $todoGroup);

        $todoGroup = $this->todoGroupService->archiveTodoGroup($todoGroup);

        return new TodoGroupResource($todoGroup);
    }

    /**
     * Toggle pin state of a TodoGroup
     */
    public function togglePin(TodoGroup $todoGroup)
    {
        $this->authorize('togglePin', $todoGroup);

        $todoGroup = $this->todoGroupService->toggleTodoGroupPin($todoGroup);

        return new TodoGroupResource($todoGroup);
    }

    /**
     * Delete a TodoGroup
     */
    public function destroy(TodoGroup $todoGroup)
    {
        $this->authorize('delete', $todoGroup);

        $this->todoGroupService->deleteTodoGroup($todoGroup);

        return response()->json([
            'message' => 'TodoGroup deleted successfully'
        ]);
    }
}