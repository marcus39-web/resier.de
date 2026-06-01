<?php

declare(strict_types=1);

namespace App;

final class View
{
    /** @param array<string, mixed> $data */
    public static function render(string $template, array $data = []): void
    {
        extract($data, EXTR_SKIP);

        require COMPONENTS_PATH . '/layout/header.php';
        require COMPONENTS_PATH . '/' . $template . '.php';
        require COMPONENTS_PATH . '/layout/footer.php';
    }
}
