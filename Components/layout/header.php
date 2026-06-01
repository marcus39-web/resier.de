<?php
// Gemeinsamer Seitenkopf mit Meta-Tags, Fonts und Hauptnavigation.
/** @var string $title */
?>
<!doctype html>
<html lang="de">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?= e($title ?? 'PHP Bewerbungsseite') ?></title>
    <meta name="description" content="Junior PHP Entwickler mit 7 Monaten Erfahrung, Zertifikaten und Fokus auf sauberen Backend-Code.">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Space+Grotesk:wght@400;500;700&family=IBM+Plex+Mono:wght@400;500&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="/public/css/style.css">
</head>
<body>
<header class="site-header">
    <!-- Globale Hauptnavigation fuer alle Seiten -->
    <nav class="nav container">
        <a class="brand" href="/">PHP Karriereprofil</a>
        <div class="nav-links">
            <a href="/">Start</a>
            <a href="/portfolio">Portfolio</a>
            <a href="/contact">Kontakt</a>
        </div>
    </nav>
</header>
<main>
