<?php

// Gemeinsamer Bootstrap: Session, Konstanten, Autoloading, Helfer und Fehlerbehandlung.

declare(strict_types=1);

session_start();

define('BASE_PATH', __DIR__);

define('COMPONENTS_PATH', BASE_PATH . '/Components');
define('DATA_PATH', BASE_PATH . '/data');

// Schreibt unerwartete Fehler in ein lokales Log unter /data/logs.
function app_log_error(\Throwable $exception): void
{
    $logDir = DATA_PATH . '/logs';

    try {
        if (!is_dir($logDir)) {
            mkdir($logDir, 0775, true);
        }

        $entry = sprintf(
            "[%s] %s in %s:%d\n%s\n----\n",
            date('c'),
            $exception->getMessage(),
            $exception->getFile(),
            $exception->getLine(),
            $exception->getTraceAsString()
        );

        file_put_contents($logDir . '/app-error.log', $entry, FILE_APPEND);
    } catch (\Throwable $loggingException) {
        error_log($loggingException->getMessage());
    }
}

/**
 * Loads key=value pairs from .env into process environment.
 */
function load_env_file(string $filePath): void
{
    try {
        if (!is_file($filePath) || !is_readable($filePath)) {
            return;
        }

        $lines = file($filePath, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
        if ($lines === false) {
            return;
        }

        foreach ($lines as $line) {
            $trimmed = trim($line);
            if ($trimmed === '' || str_starts_with($trimmed, '#')) {
                continue;
            }

            $parts = explode('=', $trimmed, 2);
            if (count($parts) !== 2) {
                continue;
            }

            $key = trim($parts[0]);
            $value = trim($parts[1]);

            if ($key === '') {
                continue;
            }

            if (
                (str_starts_with($value, '"') && str_ends_with($value, '"'))
                || (str_starts_with($value, "'") && str_ends_with($value, "'"))
            ) {
                $value = substr($value, 1, -1);
            }

            if (getenv($key) === false) {
                putenv($key . '=' . $value);
                $_ENV[$key] = $value;
                $_SERVER[$key] = $value;
            }
        }
    } catch (\Throwable $exception) {
        app_log_error($exception);
    }
}

/**
 * Returns env value or default when key is missing.
 */
function env(string $key, ?string $default = null): ?string
{
    $value = getenv($key);

    if ($value === false) {
        return $default;
    }

    return $value;
}

load_env_file(BASE_PATH . '/.env');

// Globaler Fallback fuer unbehandelte Exceptions.
set_exception_handler(static function (\Throwable $exception): void {
    app_log_error($exception);

    if (!headers_sent()) {
        http_response_code(500);
    }

    echo '500 - Interner Serverfehler';
});

// Einfacher PSR-4-aehnlicher Autoloader fuer Klassen unter /src.
spl_autoload_register(static function (string $class): void {
    $prefix = 'App\\';
    $baseDir = BASE_PATH . '/src/';

    if (strncmp($prefix, $class, strlen($prefix)) !== 0) {
        return;
    }

    $relativeClass = substr($class, strlen($prefix));
    $file = $baseDir . str_replace('\\', '/', $relativeClass) . '.php';

    if (is_file($file)) {
        require $file;
    }
});

// HTML-Ausgabe escapen, um XSS in Views zu vermeiden.
function e(string $value): string
{
    return htmlspecialchars($value, ENT_QUOTES, 'UTF-8');
}

// Formularwerte nach Redirect erneut anzeigen.
function old(string $key): string
{
    return e((string) ($_SESSION['form_old'][$key] ?? ''));
}

// CSRF-Token einmal pro Session erzeugen und wiederverwenden.
function csrf_token(): string
{
    if (empty($_SESSION['csrf_token'])) {
        try {
            $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
        } catch (\Throwable $exception) {
            app_log_error($exception);
            $_SESSION['csrf_token'] = hash('sha256', uniqid((string) mt_rand(), true));
        }
    }

    return $_SESSION['csrf_token'];
}

// Eingehenden CSRF-Token gegen den Session-Wert pruefen.
function csrf_token_is_valid(?string $token): bool
{
    $sessionToken = (string) ($_SESSION['csrf_token'] ?? '');

    return $sessionToken !== '' && $token !== null && hash_equals($sessionToken, $token);
}

// Einmalige Flash-Nachricht aus der Session lesen und direkt verwerfen.
function flash(string $key): ?string
{
    if (!isset($_SESSION['flash'][$key])) {
        return null;
    }

    $message = (string) $_SESSION['flash'][$key];
    unset($_SESSION['flash'][$key]);

    return $message;
}
