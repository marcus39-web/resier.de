<?php

declare(strict_types=1);

return [
    [
        'title' => 'GHI CSharp Roboter OOP',
        'summary' => 'Objektorientiertes C#-Projekt mit Fokus auf sauberer Klassenstruktur, Kapselung und wartbarer Logik.',
        'tech' => ['C#', '.NET', 'OOP', 'GitHub'],
        'challenge' => 'Komplexe Ablaufe in klar getrennte Klassen und Verantwortlichkeiten aufteilen.',
        'solution' => 'Domainenlogik in eigenstaendige Komponenten zerlegt und OOP-Prinzipien konsequent angewendet.',
        'learning' => 'Architekturdenken, saubere Modellierung von Objekten und strukturierte Weiterentwicklung im Team-Workflow.',
        'url' => 'https://github.com/marcus39-web/GHI-CSharp-Roboter-OOP.git',
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
        'summary' => 'Übersicht über Lernziele, Meilensteine und Tagesfortschritt.',
        'tech' => ['PHP 8', 'SQLite'],
        'challenge' => 'Klare Datenstruktur fuer kleine Reports aufbauen.',
        'solution' => 'Metriken über eine einfache Datenstruktur modelliert und fuer kleine Reports aufbereitet.',
        'learning' => 'Datenmodellierung und einfache Metrik-Auswertung.',
        'url' => '',
    ],
];
