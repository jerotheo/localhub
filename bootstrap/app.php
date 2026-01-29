<?php

use App\Exceptions\Handler as AppExceptionHandler;
use App\Exceptions\ResourceNotFoundException;
use App\Exceptions\UnauthorizedException;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Contracts\Debug\ExceptionHandler;
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
        $middleware->alias([
            'auth' => \App\Http\Middleware\Authenticate::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        $exceptions->shouldRenderJsonWhen(function (Request $request) {
            return $request->is('api/*') || $request->expectsJson();
        });

        $exceptions->render(function (ValidationException $exception) {
            return response()->json([
                'success' => false,
                'message' => 'Validation failed',
                'errors' => $exception->errors(),
            ], 422);
        });

        $exceptions->render(function (AuthenticationException $exception) {
            return response()->json([
                'success' => false,
                'message' => 'Unauthenticated',
                'errors' => [],
            ], 401);
        });

        $exceptions->render(function (UnauthorizedException $exception) {
            return response()->json([
                'success' => false,
                'message' => $exception->getMessage(),
                'errors' => [],
            ], 401);
        });

        $exceptions->render(function (ResourceNotFoundException $exception) {
            return response()->json([
                'success' => false,
                'message' => $exception->getMessage(),
                'errors' => [],
            ], 404);
        });

        $exceptions->render(function (NotFoundHttpException $exception) {
            return response()->json([
                'success' => false,
                'message' => 'Resource not found',
                'errors' => [],
            ], 404);
        });

        $exceptions->render(function (\Throwable $exception) {
            $message = config('app.debug')
                ? $exception->getMessage()
                : 'Server error';

            return response()->json([
                'success' => false,
                'message' => $message,
                'errors' => [],
            ], 500);
        });
    })
    ->withSingletons([
        ExceptionHandler::class => AppExceptionHandler::class,
    ])
    ->create();
