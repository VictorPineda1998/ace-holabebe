<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EnsureRoles
{
    public function handle(Request $request, Closure $next, ...$roles)
    {
        if (Auth::check() && in_array(Auth::user()->tipo_usuario, $roles)) {
            return $next($request);
        }

        return redirect('dashboard')->with('error', 'No autorizado');
    }
}
