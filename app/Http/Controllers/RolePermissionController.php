<?php

namespace App\Http\Controllers;

use App\Models\Role;
use App\Models\Permission;

use App\Services\RolePermissionService;

use App\Http\Resources\PermissionResource;

use App\Http\Requests\RolePermission\AssignPermissionsToRoleRequest;
use App\Http\Requests\RolePermission\SyncRolePermissionsRequest;

class RolePermissionController extends Controller
{
    protected RolePermissionService $service;

    public function __construct(RolePermissionService $service)
    {
        $this->service = $service;
    }

    /**
     * Get permissions for a role
     */
    public function index(Role $role)
    {
        $permissions = $this->service->getPermissionsForRole($role);

        return PermissionResource::collection($permissions);
    }

    /**
     * Assign permissions to role
     */
    public function assign(AssignPermissionsToRoleRequest $request, Role $role)
    {
        $role = $this->service->assignPermissionsToRole(
            $role,
            $request->validated()['permission_ids']
        );

        return PermissionResource::collection($role->permissions);
    }

    /**
     * Sync role permissions
     */
    public function sync(SyncRolePermissionsRequest $request, Role $role)
    {
        $role = $this->service->syncRolePermissions(
            $role,
            $request->validated()['permission_ids']
        );

        return PermissionResource::collection($role->permissions);
    }

    /**
     * Remove permission from role
     */
    public function revoke(Role $role, Permission $permission)
    {
        $role = $this->service->revokePermissionFromRole($role, $permission);

        return PermissionResource::collection($role->permissions);
    }
}