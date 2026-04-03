<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class AuthResource extends JsonResource
{
    protected string $token;

    public function __construct($resource, string $token)
    {
        parent::__construct($resource);
        $this->token = $token;
    }

    public function toArray(Request $request): array
    {
        return [
            'token' => $this->token,

            'user' => new UserResource($this->resource),

            'roles' => $this->whenLoaded('roles', function () {
                return $this->roles->pluck('name');
            }),

            'permissions' => $this->whenLoaded('roles', function () {
                return $this->roles
                    ->flatMap(fn ($role) =>
                        $role->permissions->pluck('name')
                    )
                    ->unique()
                    ->values();
            }),
        ];
    }
}