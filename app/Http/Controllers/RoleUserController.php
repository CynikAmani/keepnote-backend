<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Services\RoleUserService;
use App\Http\Resources\RoleResource;
use App\Http\Requests\RoleUser\SyncUserRolesRequest;

class RoleUserController extends Controller
{
    protected RoleUserService $service;

    public function __construct(RoleUserService $service)
    {
        $this->service = $service;
    }

    /**
     * Get assigned roles
     */
    public function index(User $user)
    {
        $roles = $this->service->getRolesForUser($user);

        return RoleResource::collection($roles);
    }

    /**
     * Batch update all roles for a user
     */
    public function sync(SyncUserRolesRequest $request, User $user)
    {
        $this->service->syncUserRoles(
            $user,
            $request->validated()['roles']
        );

        return response()->json([
            'message' => 'Roles updated successfully'
        ]);
    }
}