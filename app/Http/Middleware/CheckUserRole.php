<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckUserRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, $role)
    {
        if (!$request->user() || $request->user()->role_id != $role) {
            // Redirige al usuario al dashboard si no tiene el rol necesario
            return redirect('/dashboard')->with('error', 'No tienes permiso para acceder a esta página.');
        }

        return $next($request);
    }
}
