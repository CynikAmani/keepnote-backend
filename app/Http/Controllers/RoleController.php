<?php

namespace App\Http\Controllers;

use App\Models\Role;
use App\Services\RoleService;

use App\Http\Resources\RoleResource;
use App\Http\Requests\Role\StoreRoleRequest;
use App\Http\Requests\Role\UpdateRoleRequest;

class RoleController extends Controller
{
    protected RoleService $roleService;

    public function __construct(RoleService $roleService)
    {
        $this->roleService = $roleService;
    }

    /**
     * List all roles.
     */
    public function index()
    {
        $roles = $this->roleService->getAllRoles();

        return RoleResource::collection($roles);
    }

    /**
     * Store a new role.
     */
    public function store(StoreRoleRequest $request)
    {
        $role = $this->roleService->createRole(
            $request->validated()
        );

        return new RoleResource($role);
    }

    /**
     * Show a role.
     */
    public function show(Role $role)
    {
        $role = $this->roleService->getRole($role);

        return new RoleResource($role);
    }

    /**
     * Update role.
     */
    public function update(UpdateRoleRequest $request, Role $role)
    {
        $role = $this->roleService->updateRole(
            $role,
            $request->validated()
        );

        return new RoleResource($role);
    }

    /**
     * Delete role.
     */
    public function destroy(Role $role)
    {
        $this->roleService->deleteRole($role);

        return response()->json([
            'message' => 'Role deleted successfully'
        ]);
    }
}