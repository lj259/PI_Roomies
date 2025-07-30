<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class PropietarioMiddleware
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next)
    {
        $propietario = Session::get('propietario');
        
        if (!$propietario) {
            return redirect()->route('propietario.login')->with('Fallo', 'Debes iniciar sesión como propietario para acceder a esta página.');
        }

        return $next($request);
    }
}
