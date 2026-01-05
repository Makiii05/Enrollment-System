<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Http\Request;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        $middleware->redirectGuestsTo(function (Request $request) {
            // Check if the request is for accounting routes
            if ($request->is('accounting/*')) {
                return route('accounting.login');
            }
            // Check if the request is for registrar routes
            if ($request->is('registrar/*')) {
                return route('registrar.login');
            }
            // Default redirect
            return route('registrar.login');
        });
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        //
    })->create();
