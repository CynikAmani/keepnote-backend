<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class PermissionMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string  $permission  Comma-separated permissions allowed
     * @return mixed
     */
    public function handle(Request $request, Closure $next, string $permission)
    {
        $user = $request->user();
    
        if (!$user) {
            return response()->json(['message' => 'Unauthorized'], 401);
        }
    
        $user->loadMissing('roles.permissions');
    
        // Bypass permission check for admins and super-admins
        $bypassRoles = ['admin', 'super-admin'];
        $userRoles = $user->roles->pluck('name')->toArray();
    
        if (!empty(array_intersect($bypassRoles, $userRoles))) {
            return $next($request);
        }
    
        $permissions = array_map('trim', explode(',', $permission));
    
        if (!$user->hasPermission($permissions)) {
            return response()->json(['message' => 'Forbidden'], 403);
        }
    
        return $next($request);
    }
}