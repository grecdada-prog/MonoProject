<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ContentSecurityPolicy
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $response = $next($request);

        // Configuration CSP stricte pour SmartStock
        $csp = [
            "default-src 'self'",
            "script-src 'self' 'unsafe-inline' 'unsafe-eval' cdn.jsdelivr.net unpkg.com", // Alpine.js, Chart.js
            "style-src 'self' 'unsafe-inline' cdn.jsdelivr.net fonts.googleapis.com", // Tailwind, Google Fonts
            "font-src 'self' fonts.gstatic.com data:", // Google Fonts
            "img-src 'self' data: https: ui-avatars.com", // Avatars externes + data URLs
            "connect-src 'self' ws: wss:", // WebSockets Pusher
            "frame-src 'none'", // Pas d'iframes
            "object-src 'none'", // Pas de Flash/Java
            "base-uri 'self'", // Protection contre base tag injection
            "form-action 'self'", // Formulaires uniquement vers même origine
            "upgrade-insecure-requests", // Force HTTPS si disponible
        ];

        $response->headers->set('Content-Security-Policy', implode('; ', $csp));

        // Headers de sécurité supplémentaires
        $response->headers->set('X-Frame-Options', 'DENY'); // Clickjacking protection
        $response->headers->set('X-Content-Type-Options', 'nosniff'); // MIME type sniffing
        $response->headers->set('X-XSS-Protection', '1; mode=block'); // XSS filter legacy
        $response->headers->set('Referrer-Policy', 'strict-origin-when-cross-origin'); // Referrer control
        $response->headers->set('Permissions-Policy', 'geolocation=(), microphone=(), camera=()'); // Feature policy

        return $response;
    }
}
