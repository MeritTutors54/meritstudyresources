<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        $middleware->validateCsrfTokens(except: [
            '/stripe/webhook',
        ]);

        $middleware->alias([
            'user-access' => \App\Http\Middleware\UserAccess::class,
            'admin' => \App\Http\Middleware\Admin::class,
            'team.permission' => \App\Http\Middleware\TeamsPermission::class
        ])->redirectGuestsTo(function (Request $request) {
            if ($request->routeIs('admin.*')) {
                return route('admin.login');
            }

            return route('login');
        });
    })
    ->withExceptions(function (Exceptions $exceptions) {

    })->create();
