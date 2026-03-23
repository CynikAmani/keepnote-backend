<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Services\UserService;
use App\Http\Resources\UserResource;
use App\Http\Requests\UpdateUserRequest;
use App\Http\Requests\StoreUserRequest; // <-- For creating new user
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class UserController extends Controller
{
    protected UserService $userService;

    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    public function index(): AnonymousResourceCollection
    {
        return UserResource::collection($this->userService->getAllUsers());
    }

    public function show(int $id): UserResource
    {
        return new UserResource($this->userService->findUser($id));
    }

    public function store(StoreUserRequest $request): UserResource
    {
        $user = $this->userService->createUser($request->validated());

        return new UserResource($user);
    }

    public function update(UpdateUserRequest $request, User $user): UserResource
    {
        $updatedUser = $this->userService->updateUser($user, $request->validated());

        return new UserResource($updatedUser);
    }

    public function destroy(User $user): JsonResponse
    {
        $this->userService->deleteUser($user);

        return response()->json(['message' => 'User deleted successfully.']);
    }
}