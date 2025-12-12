<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Http\Request;
use App\Http\Middleware\PreventBackHistory;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        
        $middleware->alias([
            'prevent-back-history' => PreventBackHistory::class,
        ]);

        $middleware->redirectGuestsTo(function (Request $request) {
            if ($request->is('owner/*')) {
                return route('owner.login'); // Lempar ke Login Owner
            }
            
            return route('kasir.login');
        });
        
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();