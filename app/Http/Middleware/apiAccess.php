<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class apiAccess
{
    /**
     * Handle an incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Closure $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next, $role)
    {
        $roles = is_array($role)
            ? $role
            : explode('|', $role);

        if (auth()->user()->checkRole($roles)) {
            return $next($request);
        }
        return response(['errors' => ['auth' => 'Доступ запрещен']], 401);

    }
}
