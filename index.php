<?php

declare(strict_types=1);

require __DIR__ . '/bootstrap.php';

use App\Controllers\ContactController;
use App\Controllers\PageController;
use App\Router;

$router = new Router();
$pageController = new PageController();
$contactController = new ContactController();

$router->get('/', [$pageController, 'home']);
$router->get('/zertifikat', [$pageController, 'certificate']);
$router->get('/lebenslauf', [$pageController, 'cv']);
$router->get('/portfolio', [$pageController, 'portfolio']);
$router->get('/contact', [$contactController, 'show']);
$router->post('/contact', [$contactController, 'submit']);

$router->dispatch($_SERVER['REQUEST_METHOD'] ?? 'GET', $_SERVER['REQUEST_URI'] ?? '/');
