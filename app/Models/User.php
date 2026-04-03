<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Collection;
use Laravel\Sanctum\HasApiTokens;

/**
 * @property Collection $roles
 */
class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $fillable = ['name', 'email', 'password'];
    protected $hidden   = ['password', 'remember_token'];
    protected $casts    = ['email_verified_at' => 'datetime', 'password' => 'hashed'];

    public function roles()
    {
        return $this->belongsToMany(Role::class)->withTimestamps();
    }

    // --- ACCESSORS ---
    public function getIsVerifiedAttribute(): bool
    {
        return ! is_null($this->email_verified_at);
    }

    // --- RBAC LOGIC (For Controllers/Policies) ---

    public function hasRole(string|array $role): bool
    {
        $roles = is_array($role) ? $role : [$role];
        return $this->roles->pluck('name')->intersect($roles)->isNotEmpty();
    }

    public function hasPermission(string|array $permission): bool
    {
        // 1. Admin Bypass
        if ($this->hasRole(['admin', 'super-admin'])) {
            return true;
        }

        // 2. Check permissions across all roles
        $permissions = is_array($permission) ? $permission : [$permission];
        
        $userPermissions = $this->roles->flatMap(function ($role) {
            return $role->permissions->pluck('name');
        });

        return $userPermissions->intersect($permissions)->isNotEmpty();
    }
}