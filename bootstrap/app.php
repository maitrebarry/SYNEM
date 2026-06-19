<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        // Trust reverse proxies like ngrok so asset(), url(), and secure request
        // detection use the forwarded host/protocol instead of localhost/http.
        $middleware->trustProxies(at: '*');

        // Enforce a global max of 5 Mo per uploaded image (server-side guardrail)
        $middleware->web(append: [
            \App\Http\Middleware\LimitImageUploadSize::class,
            \App\Http\Middleware\TrackVisitor::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        $exceptions->render(function (\Illuminate\Http\Exceptions\PostTooLargeException $e, $request) {
            $message = "La requête est trop volumineuse pour le serveur. Réduisez la taille ou le nombre d'images, puis réessayez.";

            if (method_exists($request, 'expectsJson') && ($request->expectsJson() || $request->ajax())) {
                return response()->json([
                    'success' => false,
                    'error' => 'post_too_large',
                    'message' => $message,
                ], 413);
            }

            return redirect()->back()->withErrors(['upload' => $message])->withInput();
        });
    })->create();

