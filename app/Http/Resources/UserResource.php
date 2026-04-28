<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/** 
 * @mixin \App\Models\User
 */
class UserResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id'          => $this->id,
            'name'        => $this->name,
            'email'       => $this->email,
            'is_verified' => $this->is_verified,
            'is_deleted'  => $this->trashed(),
            'created_at'  => $this->created_at?->toDateTimeString(),

            'roles' => $this->whenLoaded('roles', function () {
                return $this->roles->pluck('name')->unique()->values();
            }),

            'permissions' => $this->whenLoaded('roles', function () {
                return $this->roles->flatMap->permissions->pluck('name')->unique()->values();
            }),
        ];
    }
}