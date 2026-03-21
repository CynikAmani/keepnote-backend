<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    protected $fillable = ['name', 'description'];

    /**
     * Relationship: A role can belong to many users
     */
    public function users()
    {
        return $this->belongsToMany(User::class)->withTimestamps();
    }

    /**
     * Relationship: A role can have many permissions
     */
    public function permissions()
    {
        return $this->belongsToMany(Permission::class)->withTimestamps();
    }

    /**
     * Helper: Check if this role has a specific permission
     */
    public function hasPermission(string $permissionName): bool
    {
        return $this->permissions->pluck('name')->contains($permissionName);
    }
}