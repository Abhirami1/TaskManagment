<?php
namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class RoleMiddleware
{
    public function handle(Request $request, Closure $next, string $role)
    {
        $user = $request->user();
        $roleId = $role === 'admin' ? 1 : 2;

        if (!$user || $user->role_id !== $roleId) {
            abort(403, 'Unauthorized access.');
        }

        return $next($request);
    }
}