<?php

use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        api: __DIR__.'/../routes/api.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        $middleware->redirectGuestsTo(function (Request $request) {
            if ($request->is('api/*') || $request->expectsJson()) {
                return null; // No redirigir, dejar que retorne 401
            }

            return route('login');
        });
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        $exceptions->shouldRenderJsonWhen(
            fn (Request $request) => $request->is('api/*') || $request->expectsJson(),
        );

        $exceptions->render(function (Throwable $e, Request $request) {
            if ($request->is('api/*') || $request->expectsJson()) {
                if ($e instanceof NotFoundHttpException) {
                    return response()->json([
                        'success' => false,
                        'message' => 'Recurso no encontrado',
                        'errors' => [],
                    ], 404);
                }

                if ($e instanceof ModelNotFoundException) {
                    return response()->json([
                        'success' => false,
                        'message' => 'Recurso no encontrado',
                        'errors' => [],
                    ], 404);
                }

                if ($e instanceof ValidationException) {
                    return response()->json([
                        'success' => false,
                        'message' => 'Error de validación',
                        'errors' => $e->errors(),
                    ], 422);
                }

                if ($e instanceof AuthenticationException) {
                    return response()->json([
                        'success' => false,
                        'message' => 'Debe autenticarse para acceder a esta ruta',
                        'errors' => [],
                    ], 401);
                }

                // Manejo de redirección no autorizada (cuando Sanctum intenta redirigir a login)
                if ($e instanceof AuthorizationException) {
                    return response()->json([
                        'success' => false,
                        'message' => 'No tiene permiso para acceder a este recurso',
                        'errors' => [],
                    ], 403);
                }

                // Manejo de errores 500 (errores generales del servidor)
                if (app()->environment('production')) {
                    return response()->json([
                        'success' => false,
                        'message' => 'Error interno del servidor',
                        'errors' => [],
                    ], 500);
                }

                // En desarrollo, permitir ver el error
                return response()->json([
                    'success' => false,
                    'message' => $e->getMessage(),
                    'errors' => [],
                ], 500);
            }
        });
    })->create();
