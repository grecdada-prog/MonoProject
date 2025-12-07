<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        channels: __DIR__.'/../routes/channels.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        $middleware->alias([
            'superadmin' => \App\Http\Middleware\EnsureSuperAdmin::class,
            'gerant'     => \App\Http\Middleware\EnsureGerant::class,
            'vendeur'    => \App\Http\Middleware\EnsureVendeur::class,
        ]);

        // Global middlewares for web routes
        $middleware->web(append: [
            \Illuminate\Routing\Middleware\ThrottleRequests::class.':60,1', // 60 requests/min
            \App\Http\Middleware\ContentSecurityPolicy::class, // CSP headers
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        //
    })->create();
