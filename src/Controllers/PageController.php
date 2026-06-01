<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Data\PortfolioData;
use App\View;

final class PageController
{
    public function home(): void
    {
        $certificates = PortfolioData::certificates();
        $projects = PortfolioData::projects();

        View::render('pages/home', [
            'title' => 'Junior PHP Entwickler',
            'certificates' => $certificates,
            'projects' => $projects,
        ]);
    }

    public function portfolio(): void
    {
        $projects = PortfolioData::projects();

        View::render('pages/portfolio', [
            'title' => 'Portfolio',
            'projects' => $projects,
        ]);
    }
}
