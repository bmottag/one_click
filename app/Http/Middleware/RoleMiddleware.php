<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class RoleMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle($request, Closure $next, ...$roles)
    {
        // Verifica que el usuario esté autenticado
        if (!Auth::check()) {
            abort(403, "You don't have permission to access this page.");
        }

        // Obtiene el rol del usuario actual
        $userRole = Auth::user()->role;

        // Si el rol del usuario NO está dentro de los permitidos → 403
        if (!in_array($userRole, $roles)) {
            abort(403, "You don't have permission to access this page.");
        }

        return $next($request);
    }
}

