<?php

use App\Exceptions\Handler;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Foundation\Http\Middleware\ConvertEmptyStringsToNull;
use Illuminate\Http\Request;
use Illuminate\Session\Middleware\StartSession;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        //
        $middleware->trustProxies(at: [
            '192.168.1.1',
            '127.0.0.1',
            '10.0.0.0/8'
        ]);
        $middleware->trustProxies(headers: Request::HEADER_X_FORWARDED_FOR |
            Request::HEADER_X_FORWARDED_HOST |
            Request::HEADER_X_FORWARDED_PORT |
            Request::HEADER_X_FORWARDED_PROTO |
            Request::HEADER_X_FORWARDED_AWS_ELB
        );
        $middleware->use([
            \Illuminate\Http\Middleware\TrustProxies::class,
            \App\Http\Middleware\OperationLog::class,
        ]);
        $middleware->appendToGroup('auth', [
            \App\Http\Middleware\LoginControl::class,
            \App\Http\Middleware\AuthControl::class,
        ]);
        $middleware->validateCsrfTokens([
            '*'
        ]);
        $middleware->remove([ConvertEmptyStringsToNull::class, StartSession::class]);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        $exceptions->render(function (Throwable $e, Request $request) {
            $handler = new Handler(app());
            return $handler->render($request, $e);
        });
    })->create();
