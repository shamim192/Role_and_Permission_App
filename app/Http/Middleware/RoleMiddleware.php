<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RoleMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, $role, $guard = null): Response
    {
        $authGuard = app('auth')->guard($guard);

        if ($authGuard->guest()) {
            abort(403, 'Unauthorized action.');
        }

        $roles = is_array($role)
            ? $role
            : explode('|', $role);

        if (! $authGuard->user()->hasAnyRole($roles)) {
            abort(403, 'Unauthorized action.');
        }

        return $next($request);
    }
}
