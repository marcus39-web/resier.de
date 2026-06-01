<?php

// Zentrale Profildaten fuer Startseite, Kontaktseite und Lebenslauf-Ansicht.

declare(strict_types=1);

return [
    // Stammdaten und Kurzprofil.
    'name' => 'Marcus Klaus-Dieter Reiser',
    'headline' => 'Berufspädagogischer Hintergrund | Betriebswirt (HWK) | IT-Spezialist',
    'location' => 'Lerchenweg 16, 99428 Weimar/Legefeld',
    'phone' => '0176 12742069',
    'email' => 'marcus.39@hotmail.de',
    'born' => '08.02.1970 in München',
    'status' => 'geschieden, 4 Kinder',
    'summary' => 'Dozent mit berufspädagogischem Hintergrund, breiter technischer Erfahrung und ausgeprägter Serviceorientierung. Neben IT-Themen vermittle ich handlungsorientiert genau die Inhalte, die kaufmännische Schüler und Umschüler für einen erfolgreichen Berufsabschluss brauchen: wirtschaftliche Zusammenhänge, betriebliche Prozesse, Prüfungsvorbereitung und strukturiertes Arbeiten. Komplexe Sachverhalte bereite ich verständlich, praxisnah und zielgruppenorientiert auf.',
    'targetRole' => 'Dozent / Lernprozessbegleiter in Festanstellung',
    'targetReference' => 'Initiativbewerbung',
    'targetRegion' => 'Bayern und Thüringen',
    // Kernaussagen fuer den Motivationsblock.
    'motivation' => [
        'Ich verbinde pädagogische Kompetenz mit wirtschaftlicher Praxis und aktueller IT-Erfahrung und bereite Lernende handlungsorientiert auf IHK- und HWK-Prüfungen vor.',
        'Meine Weiterbildung in der Anwendungsinformatik sowie WPI-Zertifizierungen in JavaScript/TypeScript und PHP/Laravel ergänzen mein Lehrprofil um aktuelle Tech-Inhalte.',
        'Mein C#-OOP-Projekt mit KI-Bezug auf GitHub zeigt, wie ich komplexe Inhalte praxisnah und nachvollziehbar in Lernprojekte überführe.',
        'Ich suche eine langfristige Perspektive in der Fachkräfteausbildung, um Lernende fachlich und methodisch sicher zum Abschluss zu begleiten.',
    ],
    // Link zum hervorgehobenen Projekt und Lebenslaufnachweise.
    'projectFocusUrl' => 'https://github.com/marcus39-web/GHI-CSharp-Roboter-OOP.git',
    'cvProofUrls' => [
        '/Components/images/lebenlslauf_seite1.jpg',
        '/Components/images/lebenlslauf_seite2.jpg',
        '/Components/images/lebenlslauf_seite3.jpg',
    ],
    // Beruflicher Werdegang fuer Timeline und CV-Kontext.
    'career' => [
        [
            'period' => '08/2025 - 03/2026',
            'role' => 'Weiterbildung Anwendungsinformatiker und KI',
            'organization' => 'IAD Erfurt',
            'details' => [
                'Fokus auf Fullstack-Entwicklung, Java, Python, C# und KI-Integration.',
            ],
        ],
        [
            'period' => '01/2024 - 07/2025',
            'role' => 'Long-Covid (Reha/Genesung)',
            'organization' => '',
            'details' => [
                'Geordneter Wiedereinstieg in berufliche und fachliche Praxis.',
            ],
        ],
        [
            'period' => '03/2021 - 12/2023',
            'role' => 'Vertrieb, Kundenmanagement und Disposition',
            'organization' => 'SFS-Personalservice, Manpower (E.ON), Home Channel 24',
            'details' => [
                'Personaldisposition, Kundenberatung und Key-Account-Management.',
            ],
        ],
        [
            'period' => '09/2016 - 08/2017',
            'role' => 'Sozialcoach und Lernbegleiter',
            'organization' => 'GSM Integration GmbH',
            'details' => [
                'Coaching zur beruflichen Neuorientierung und Motivationserhalt.',
            ],
        ],
        [
            'period' => '09/2012 - 08/2016',
            'role' => 'Dozent und Trainer (freiberuflich)',
            'organization' => 'Witt Auerbach / VW Schulungszentrum',
            'details' => [
                'Kaufmännische Umschulungen, IT-Grundlagen und Prüfungsvorbereitung.',
            ],
        ],
        [
            'period' => '01/2008 - 08/2012',
            'role' => 'Geschäftsstellenleiter',
            'organization' => 'AvjS GmbH Personaldienstleistung',
            'details' => [
                'Operative Leitung, Personaldisposition und Kundenbetreuung.',
            ],
        ],
    ],
    // Fachliche Kompetenzgruppen fuer die Startseite.
    'competencies' => [
        [
            'category' => 'Betriebssysteme',
            'items' => ['Windows 10/11', 'Windows Server', 'Linux-Grundlagen'],
        ],
        [
            'category' => 'Hardware und Peripherie',
            'items' => ['Arbeitsplatzsysteme', 'Drucker', 'Scanner', 'Mobile Endgeräte'],
        ],
        [
            'category' => 'Netzwerk und Administration',
            'items' => ['Benutzerverwaltung', 'Rechtekonzepte', 'Basis-Netzwerkdiagnose'],
        ],
        [
            'category' => 'Entwicklung und Technik',
            'items' => ['Java', 'Python', 'C#', 'JavaScript', 'PHP/Laravel', 'KI-Integration'],
        ],
        [
            'category' => 'Support und Service',
            'items' => ['Ticketbearbeitung', 'Fehleranalyse', 'Anwenderbetreuung', 'Schulungen'],
        ],
        [
            'category' => 'Kaufmännischer Unterricht',
            'items' => ['Betriebliche Prozesse', 'Personal', 'Vertrieb', 'Prüfungsvorbereitung', 'Handlungsorientierter Unterricht'],
        ],
    ],
    // Kompakte Abschluss- und Weiterbildungsuebersicht.
    'qualifications' => [
        'Berufspädagogischer Hintergrund und Ausbilder-Eignung (AEVO).',
        'Betriebswirt des Handwerks (HWK).',
        'Industriekaufmann (IHK), Ausbildung bei Dekra/BMW AG.',
        'Facharbeiter Dreher (IHK), Ausbildung bei BMW AG München.',
        'WPI Professional Certification: JavaScript/TypeScript Frontend-Entwickler.',
        'WPI Professional Certification: PHP- und Laravel-Entwickler.',
    ],
];
