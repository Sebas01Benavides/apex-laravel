<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Session\TokenMismatchException;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        //
    })
    ->withExceptions(function (Exceptions $exceptions) {
        // Redirigir al login limpiamente cuando expira la sesión/token
        $exceptions->render(function (TokenMismatchException $e, $request) {
            return redirect()->route('login')->withErrors([
                'usuario' => 'Tu sesión ha expirado por inactividad. Por favor, ingresa nuevamente.'
            ]);
        });
    })->create();