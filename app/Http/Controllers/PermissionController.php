<?php

namespace App\Http\Controllers;

use App\Models\Permission;
use App\Services\PermissionService;
use App\Http\Resources\PermissionResource;
use App\Http\Requests\Permission\StorePermissionRequest;
use App\Http\Requests\Permission\UpdatePermissionRequest;
use Illuminate\Http\JsonResponse;

class PermissionController extends Controller
{
    protected PermissionService $permissionService;

    public function __construct(PermissionService $permissionService)
    {
        $this->permissionService = $permissionService;
    }

    /**
     * Display a listing of the permissions grouped by module.
     */
    public function index(): JsonResponse
    {
        $grouped = Permission::all()
            ->groupBy('module')
            ->map(function ($items, $module) {
                return [
                    'sectionName' => $module,
                    'items' => PermissionResource::collection($items)
                ];
            })
            ->values();

        return response()->json($grouped);
    }

    public function store(StorePermissionRequest $request)
    {
        $permission = $this->permissionService->createPermission($request->validated());
        return new PermissionResource($permission);
    }

    public function update(UpdatePermissionRequest $request, Permission $permission)
    {
        $permission = $this->permissionService->updatePermission($permission, $request->validated());
        return new PermissionResource($permission);
    }

    public function destroy(Permission $permission)
    {
        $this->permissionService->deletePermission($permission);
        return response()->json(['message' => 'Permission deleted successfully']);
    }
}