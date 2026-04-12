<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;
use \App\Models\Role;

class AuthService
{
    public function signin(array $credentials): User
    {
        if (!Auth::attempt($credentials)) {
            throw ValidationException::withMessages([
                'email' => ['Invalid credentials.']
            ]);
        }

        return Auth::user()->load(['roles.permissions']);
    }


    public function signup(array $data): User
    {
        $user = User::create($data);
    
        // We use firstOrCreate just in case the role isn't in the DB yet
        $defaultRole = Role::firstOrCreate(['name' => 'user']);
        
        $user->roles()->attach($defaultRole->id);
    
        return $user->load(['roles.permissions']);
    }


    public function createToken(User $user): string
    {
        return $user->createToken('auth_token')->plainTextToken;
    }
    

    public function logout(User $user): void
    {
        $user->currentAccessToken()->delete();
    }
}