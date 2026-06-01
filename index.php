<?php

// Front-Controller der Anwendung: Bootstrap laden, Routen registrieren, Request dispatchen.

declare(strict_types=1);

require __DIR__ . '/bootstrap.php';

use App\Controllers\ContactController;
use App\Controllers\PageController;
use App\Router;

// Zentrale Instanzen fuer Seitenlogik und Kontaktformular.
$router = new Router();
$pageController = new PageController();
$contactController = new ContactController();

// Oeffentliche GET- und POST-Routen der Website.
$router->get('/', [$pageController, 'home']);
$router->get('/projekt', [$pageController, 'project']);
$router->get('/zertifikat', [$pageController, 'certificate']);
$router->get('/lebenslauf', [$pageController, 'cv']);
$router->get('/portfolio', [$pageController, 'portfolio']);
$router->get('/impressum', [$pageController, 'impressum']);
$router->get('/datenschutz', [$pageController, 'datenschutz']);
$router->get('/contact', [$contactController, 'show']);
$router->post('/contact', [$contactController, 'submit']);

// Aktuellen HTTP-Request an den Router uebergeben.
$router->dispatch($_SERVER['REQUEST_METHOD'] ?? 'GET', $_SERVER['REQUEST_URI'] ?? '/');
