<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class EnsureGerant
{
    public function handle($request, Closure $next)
    {
        if (!Auth::check() || !Auth::user()->hasRole('gerant')) {
            abort(403, 'Accès refusé.');
        }

        return $next($request);
    }
}
