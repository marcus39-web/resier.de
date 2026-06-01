<?php

declare(strict_types=1);

namespace App;

// Minimaler Router fuer feste GET- und POST-Routen.
final class Router
{
    /** @var array<string, array<string, callable>> */
    private array $routes = [];

    // Registriert eine GET-Route auf einen Handler.
    public function get(string $path, callable $handler): void
    {
        $this->routes['GET'][$path] = $handler;
    }

    // Registriert eine POST-Route auf einen Handler.
    public function post(string $path, callable $handler): void
    {
        $this->routes['POST'][$path] = $handler;
    }

    // Loest den Request-Pfad auf und fuehrt den passenden Handler aus.
    public function dispatch(string $method, string $uri): void
    {
        $path = parse_url($uri, PHP_URL_PATH);
        $path = is_string($path) && $path !== '' ? rtrim($path, '/') : '/';
        $path = $path === '' ? '/' : $path;

        $handler = $this->routes[strtoupper($method)][$path] ?? null;

        if ($handler === null) {
            http_response_code(404);
            echo '404 - Seite nicht gefunden';
            return;
        }

        try {
            // Handler immer gekapselt ausfuehren, damit Ausnahmen in eine saubere 500 muenden.
            $handler();
        } catch (\Throwable $exception) {
            if (\function_exists('app_log_error')) {
                \app_log_error($exception);
            }

            http_response_code(500);
            echo '500 - Interner Serverfehler';
        }
    }
}
