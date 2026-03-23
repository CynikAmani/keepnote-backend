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
        $user = $request->user(); // relations are lazy loaded on access

        if (!$user) {
            return response()->json(['message' => 'Unauthorized'], 401);
        }

        // Load roles + permissions if not already loaded
        $user->loadMissing('roles.permissions');

        // Support multiple permissions: "update-user,delete-user"
        $permissions = array_map('trim', explode(',', $permission));

        if (!$user->hasPermission($permissions)) {
            return response()->json(['message' => 'Forbidden'], 403);
        }

        return $next($request);
    }
}