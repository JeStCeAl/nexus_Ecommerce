<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, ...$roles): Response
    {

        // verificacion de usuario
        if (!$request->user()) {
            return response()->json(['error' => 'No autorizado'], 401);
        }

        $userRole = $request->user()->role;

        if (!in_array($userRole, $roles)) {
            return response()->json(['error' => 'No tienes el permiso para acceder a este recurso'], 403);
        }

        return $next($request);
    }
}
