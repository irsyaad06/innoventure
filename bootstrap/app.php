<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__ . '/../routes/web.php',
        api: __DIR__ . '/../routes/api.php',
        commands: __DIR__ . '/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        // Middleware Sanctum yang sudah kita tambahkan sebelumnya
        $middleware->api(prepend: [
            \Laravel\Sanctum\Http\Middleware\EnsureFrontendRequestsAreStateful::class,
        ]);

        // 👇 TAMBAHKAN KODE INI UNTUK PENGECUALIAN CSRF
        $middleware->validateCsrfTokens(except: [
            'api/login', // Tambahkan rute yang ingin dikecualikan di sini
            'api/logout', // Tambahkan rute yang ingin dikecualikan di sini
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        //
    })->create();
