<?php

declare(strict_types=1);

namespace App;

// Rendert Layout und Seitenvorlage in fester Reihenfolge.
final class View
{
    /** @param array<string, mixed> $data */
    public static function render(string $template, array $data = []): void
    {
        $headerPath = COMPONENTS_PATH . '/layout/header.php';
        $templatePath = COMPONENTS_PATH . '/' . $template . '.php';
        $footerPath = COMPONENTS_PATH . '/layout/footer.php';

        foreach ([$headerPath, $templatePath, $footerPath] as $path) {
            if (!is_file($path) || !is_readable($path)) {
                throw new \RuntimeException(sprintf('Template-Datei nicht gefunden oder nicht lesbar: %s', $path));
            }
        }

        // Daten nur innerhalb des lokalen Render-Scope extrahieren.
        $render = static function (string $__path, array $__data): void {
            extract($__data, EXTR_SKIP);
            require $__path;
        };

        $render($headerPath, $data);
        $render($templatePath, $data);
        $render($footerPath, $data);
    }
}
