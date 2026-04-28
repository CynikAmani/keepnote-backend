<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Services\UserService;
use App\Http\Resources\UserResource;
use App\Http\Requests\User\UpdateUserRequest;
use App\Http\Requests\User\StoreUserRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class UserController extends Controller
{
    protected UserService $userService;

    /*
    ---------------------------------
    | Controller constructor
    ---------------------------------
    */
    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    /*
    ---------------------------------
    | Get all users
    ---------------------------------
    */
    public function index(): AnonymousResourceCollection
    {
        return UserResource::collection(
            $this->userService->getAllUsers()
        );
    }

    /*
    ---------------------------------
    | Get single user by ID
    ---------------------------------
    */
    public function show(int $id): UserResource
    {
        return new UserResource(
            $this->userService->findUser($id)
        );
    }

    /*
    ---------------------------------
    | Store new user
    ---------------------------------
    */
    public function store(StoreUserRequest $request): UserResource
    {
        $user = $this->userService->createUser(
            $request->validated()
        );

        return new UserResource($user);
    }

    /*
    ---------------------------------
    | Update user
    ---------------------------------
    */
    public function update(UpdateUserRequest $request, User $user): UserResource
    {
        $updatedUser = $this->userService->updateUser(
            $user,
            $request->validated()
        );

        return new UserResource($updatedUser);
    }

    /*
    ---------------------------------
    | Delete user (soft delete)
    ---------------------------------
    */
    public function destroy(User $user): JsonResponse
    {
        $this->userService->deleteUser($user);

        return response()->json([
            'message' => 'User deactivated successfully.'
        ]);
    }

    /*
    ---------------------------------
    | Restore user (activate)
    ---------------------------------
    */
    public function restore(User $user): JsonResponse
    {
        $this->userService->restoreUser($user);

        return response()->json([
            'message' => 'User activated successfully.'
        ]);
    }

    /*
    ---------------------------------
    | Revoke all user tokens
    ---------------------------------
    */
    public function revokeTokens(User $user): JsonResponse
    {
        $this->userService->revokeTokens($user);

        return response()->json([
            'message' => 'User tokens revoked successfully.'
        ]);
    }

        /*
    ---------------------------------
    | Reset user password (admin)
    ---------------------------------
    */
    public function resetPassword(User $user): JsonResponse
    {
        $this->userService->resetPassword($user);

        return response()->json([
            'message' => 'User password reset successfully.'
        ]);
    }
}