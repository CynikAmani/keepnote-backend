<?php

namespace App\Http\Controllers;

use App\Models\Role;
use App\Services\RolePermissionService;
use App\Http\Resources\PermissionResource;
use App\Http\Requests\RolePermission\SyncRolePermissionsRequest;

class RolePermissionController extends Controller
{
    protected RolePermissionService $service;

    public function __construct(RolePermissionService $service)
    {
        $this->service = $service;
    }

    /**
     * Get assigned permissions (to check active boxes in UI)
     */
    public function index(Role $role)
    {
        $permissions = $this->service->getPermissionsForRole($role);
        return PermissionResource::collection($permissions);
    }

    /**
     * Batch update all permissions for a role
     */
    public function sync(SyncRolePermissionsRequest $request, Role $role)
    {
        $role = $this->service->syncRolePermissions(
            $role,
            $request->validated()['permission_ids']
        );

        return PermissionResource::collection($role->permissions);
    }
}