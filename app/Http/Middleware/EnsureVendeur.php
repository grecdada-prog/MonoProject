<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class EnsureVendeur
{
    public function handle($request, Closure $next)
    {
        if (!Auth::check() || !Auth::user()->hasRole('vendeur')) {
            abort(403, 'Accès refusé.');
        }

        return $next($request);
    }
}
