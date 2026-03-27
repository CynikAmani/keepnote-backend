<?php

namespace App\Http\Controllers;

use App\Models\Permission;
use App\Services\PermissionService;

use App\Http\Resources\PermissionResource;
use App\Http\Requests\Permission\StorePermissionRequest;
use App\Http\Requests\Permission\UpdatePermissionRequest;

class PermissionController extends Controller
{
    protected PermissionService $permissionService;

    public function __construct(PermissionService $permissionService)
    {
        $this->permissionService = $permissionService;
    }

    /**
     * Store a new permission.
     */
    public function store(StorePermissionRequest $request)
    {
        $permission = $this->permissionService->createPermission(
            $request->validated()
        );

        return new PermissionResource($permission);
    }

    /**
     * Update an existing permission.
     */
    public function update(UpdatePermissionRequest $request, Permission $permission)
    {
        $permission = $this->permissionService->updatePermission(
            $permission,
            $request->validated()
        );

        return new PermissionResource($permission);
    }

    /**
     * Delete a permission.
     */
    public function destroy(Permission $permission)
    {
        $this->permissionService->deletePermission($permission);

        return response()->json([
            'message' => 'Permission deleted successfully'
        ]);
    }
}