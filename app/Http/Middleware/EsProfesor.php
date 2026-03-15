<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EsProfesor
{
    public function handle(Request $request, Closure $next): Response
    {
        // ¿Está autenticado?
        if (!$request->user()) {
            return redirect()->route('login')
                             ->with('error', 'Debes iniciar sesión para acceder.');
        }

        // Admin tiene acceso total sin necesitar perfil de teacher
        if ($request->user()->esAdmin()) {
            return $next($request);
        }

        // Profesor normal: debe tener perfil de teacher vinculado
        if (!$request->user()->teacher()->exists()) {
            abort(403, 'Tu cuenta no tiene perfil de profesor asignado. Contacta con el administrador.');
        }

        return $next($request);
    }
}