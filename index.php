<?php

declare(strict_types=1);

require __DIR__ . '/bootstrap.php';

use App\Controllers\ContactController;
use App\Controllers\PageController;
use App\Router;

$router = new Router();
$pageController = new PageController();
$contactController = new ContactController();

$router->get('/', static function () use ($pageController): void {
	$pageController->home();
});
$router->get('/portfolio', static function () use ($pageController): void {
	$pageController->portfolio();
});
$router->get('/contact', static function () use ($contactController): void {
	$contactController->show();
});
$router->post('/contact', static function () use ($contactController): void {
	$contactController->submit();
});

$router->dispatch($_SERVER['REQUEST_METHOD'] ?? 'GET', $_SERVER['REQUEST_URI'] ?? '/');
