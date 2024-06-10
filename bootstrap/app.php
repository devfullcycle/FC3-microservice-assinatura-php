<?php

use Core\SeedWork\Domain\Exceptions\EntityNotFoundException;
use Core\SeedWork\Domain\Exceptions\EntityValidationException;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        api: __DIR__.'/../routes/api.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        //
    })
    ->withExceptions(function (Exceptions $exceptions) {
        $exceptions->render(function (EntityNotFoundException $exception) {
            return response()->json([
                'message' => $exception->getMessage(),
            ], 404);
        });

        $exceptions->render(function (EntityValidationException $exception) {
            return response()->json([
                'message' => $exception->getMessage(),
            ], 422);
        });
    })->create();
