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
        $profile = require DATA_PATH . '/profile.php';

        View::render('pages/home', [
            'title' => 'Dozent und Lernprozessbegleiter',
            'profile' => $profile,
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

    public function cv(): void
    {
        $profile = require DATA_PATH . '/profile.php';
        $pages = array_values(array_filter((array) ($profile['cvProofUrls'] ?? []), 'is_string'));
        $pageCount = count($pages);

        if ($pageCount === 0) {
            http_response_code(404);
            View::render('pages/cv', [
                'title' => 'Lebenslauf',
                'pageImage' => null,
                'currentPage' => 0,
                'pageCount' => 0,
            ]);
            return;
        }

        $requestedPage = filter_input(INPUT_GET, 'seite', FILTER_VALIDATE_INT);
        $currentPage = $requestedPage === false || $requestedPage === null ? 1 : $requestedPage;
        $currentPage = max(1, min($pageCount, $currentPage));

        View::render('pages/cv', [
            'title' => 'Lebenslauf',
            'pageImage' => $pages[$currentPage - 1],
            'currentPage' => $currentPage,
            'pageCount' => $pageCount,
        ]);
    }

    public function certificate(): void
    {
        $certificates = PortfolioData::certificates();
        $requestedCertificate = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);
        $certificateIndex = $requestedCertificate === false || $requestedCertificate === null ? 0 : $requestedCertificate;

        if (!isset($certificates[$certificateIndex])) {
            http_response_code(404);
            View::render('pages/certificate', [
                'title' => 'Zertifikat',
                'certificateTitle' => 'Zertifikat nicht gefunden',
                'pageImage' => null,
                'currentPage' => 0,
                'pageCount' => 0,
            ]);
            return;
        }

        $certificate = $certificates[$certificateIndex];
        $pages = array_values(array_filter($certificate['proofUrls'], 'is_string'));
        $pageCount = count($pages);

        if ($pageCount === 0) {
            http_response_code(404);
            View::render('pages/certificate', [
                'title' => $certificate['title'],
                'certificateTitle' => $certificate['title'],
                'pageImage' => null,
                'currentPage' => 0,
                'pageCount' => 0,
            ]);
            return;
        }

        $requestedPage = filter_input(INPUT_GET, 'seite', FILTER_VALIDATE_INT);
        $currentPage = $requestedPage === false || $requestedPage === null ? 1 : $requestedPage;
        $currentPage = max(1, min($pageCount, $currentPage));

        View::render('pages/certificate', [
            'title' => $certificate['title'],
            'certificateTitle' => $certificate['title'],
            'certificateId' => $certificateIndex,
            'pageImage' => $pages[$currentPage - 1],
            'currentPage' => $currentPage,
            'pageCount' => $pageCount,
        ]);
    }
}
