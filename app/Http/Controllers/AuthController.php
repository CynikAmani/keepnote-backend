<?php

namespace App\Http\Controllers;

use App\Services\AuthService;
use App\Http\Requests\Auth\SigninRequest;
use App\Http\Requests\Auth\SignupRequest;
use App\Http\Resources\AuthResource;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    protected AuthService $authService;

    /*
    ---------------------------------
    | Controller constructor
    ---------------------------------
    */
    public function __construct(AuthService $authService)
    {
        $this->authService = $authService;
    }

    /*
    ---------------------------------
    | Signin
    ---------------------------------
    */
    public function signin(SigninRequest $request): AuthResource
    {
        $user = $this->authService->signin($request->validated());

        $token = $this->authService->createToken($user);

        return new AuthResource($user, $token);
    }

    /*
    ---------------------------------
    | Signup
    ---------------------------------
    */
    public function signup(SignupRequest $request): AuthResource
    {
        $user = $this->authService->signup($request->validated());

        $token = $this->authService->createToken($user);

        return new AuthResource($user, $token);
    }

    /*
    ---------------------------------
    | Logout
    ---------------------------------
    */
    public function logout(Request $request): JsonResponse
    {
        $this->authService->logout($request->user());

        return response()->json([
            'message' => 'Logged out successfully.'
        ]);
    }
}