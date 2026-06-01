<?php

declare(strict_types=1);

return [
    [
        'title' => 'CRUD Bewerberverwaltung',
        'summary' => 'Kleine PHP-Anwendung mit Erstellen, Bearbeiten, Loeschen und Filtern von Datensaetzen.',
        'tech' => ['PHP 8', 'MySQL', 'HTML', 'CSS'],
        'challenge' => 'Formulardaten konsistent validieren und Fehler sauber an den User zurueckgeben.',
        'solution' => 'Requests zentral verarbeitet und Validierungsfehler strukturiert an die View zurueckgegeben.',
        'learning' => 'Serverseitige Validierung, strukturierte Fehlerbehandlung und robustes Request-Handling.',
        'url' => '',
    ],
    [
        'title' => 'REST API Mini-Service',
        'summary' => 'Einfacher API-Endpunkt fuer To-do-Daten mit JSON-Antworten und HTTP-Statuscodes.',
        'tech' => ['PHP 8', 'JSON', 'Postman'],
        'challenge' => 'Saubere Trennung zwischen Routing, Logik und Ausgabeformat.',
        'solution' => 'Routing und Response-Logik getrennt, damit Endpunkte klar testbar und wartbar bleiben.',
        'learning' => 'Verstaendnis fuer API-Design, Fehlercodes und idempotente Requests.',
        'url' => '',
    ],
    [
        'title' => 'Kontaktmodul mit Security Fokus',
        'summary' => 'Kontaktformular mit CSRF-Schutz, Honeypot und XSS-sicherer Ausgabe.',
        'tech' => ['PHP 8', 'Sessions', 'Security Basics'],
        'challenge' => 'Sicherheit ohne Framework umsetzen und trotzdem wartbar bleiben.',
        'solution' => 'Schutzmechanismen als kleine, getrennte Schritte eingebaut statt Sicherheit quer durch die View zu verteilen.',
        'learning' => 'Praktische Security-Basics und defensive Programmierung.',
        'url' => '',
    ],
    [
        'title' => 'Lern-Dashboard',
        'summary' => 'Uebersicht ueber Lernziele, Meilensteine und Tagesfortschritt.',
        'tech' => ['PHP 8', 'SQLite'],
        'challenge' => 'Klare Datenstruktur fuer kleine Reports aufbauen.',
        'solution' => 'Metriken ueber eine einfache Datenstruktur modelliert und fuer kleine Reports aufbereitet.',
        'learning' => 'Datenmodellierung und einfache Metrik-Auswertung.',
        'url' => '',
    ],
];
