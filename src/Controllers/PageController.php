<?php

declare(strict_types=1);

namespace App\Controllers;

use App\View;

final class PageController
{
    public function home(): void
    {
        $certificates = require DATA_PATH . '/certificates.php';
        $projects = require DATA_PATH . '/projects.php';

        View::render('pages/home', [
            'title' => 'Junior PHP Entwickler',
            'certificates' => $certificates,
            'projects' => $projects,
        ]);
    }

    public function portfolio(): void
    {
        $projects = require DATA_PATH . '/projects.php';

        View::render('pages/portfolio', [
            'title' => 'Portfolio',
            'projects' => $projects,
        ]);
    }
}
