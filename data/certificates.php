<?php

// Rohdaten fuer Zertifikate und Zeugnisse inklusive Nachweis-URLs.

declare(strict_types=1);

return [
    // Klassische Berufsabschluesse und paedagogische Nachweise.
    [
        'title' => 'Facharbeiter Dreher (IHK)',
        'issuer' => 'BMW AG München / IHK',
        'credentialId' => 'IHK-DREHER-1988',
        'issuedAt' => '1988',
        'proofUrls' => ['/Components/images/zeugnis_dreher_marcus_reiser.jpg'],
        'skills' => ['Präzision', 'Technisches Verständnis', 'Facharbeiterabschluss'],
    ],
    [
        'title' => 'Industriekaufmann (IHK)',
        'issuer' => 'Dekra / BMW AG / IHK',
        'credentialId' => 'IHK-INDKAUF-1992',
        'issuedAt' => '1992',
        'proofUrls' => ['/Components/images/zeugnis_industriekaufmann_marcus_reiser.jpg'],
        'skills' => ['Kaufmännische Prozesse', 'Organisation', 'Wirtschaft'],
    ],
    [
        'title' => 'Ausbilder-Eignung (AEVO)',
        'issuer' => 'IHK / AEVO',
        'credentialId' => 'AEVO-REISER',
        'issuedAt' => '2024',
        'proofUrls' => ['/Components/images/aevo_marcus_reiser.jpg'],
        'skills' => ['Ausbildung', 'Didaktik', 'Lernzielplanung'],
    ],
    [
        'title' => 'Berufspädagogik',
        'issuer' => 'Berufspädagogischer Hintergrund',
        'credentialId' => 'BP-REISER',
        'issuedAt' => '2025',
        'proofUrls' => ['/Components/images/zeugnis_berufspaedagoge_marcus_reiser.jpg'],
        'skills' => ['Didaktik', 'Lernprozessbegleitung', 'Prüfungsvorbereitung'],
    ],
    [
        'title' => 'Betriebswirt des Handwerks (HWK)',
        'issuer' => 'Handwerkskammer (HWK)',
        'credentialId' => 'HWK-BW-REISER',
        'issuedAt' => '2022-09-30',
        'proofUrls' => ['/Components/images/zeugnis_betriebswirt_hwk_marcus_reiser.jpg'],
        'skills' => ['Wirtschaftliche Praxis', 'Personal', 'Organisation'],
    ],
    // Aktuelle IT-Weiterbildungen und Fachzertifikate.
    [
        'title' => 'Weiterbildung Anwendungsinformatik',
        'issuer' => 'IAD Erfurt',
        'credentialId' => 'AI-2026-03-06',
        'issuedAt' => '2026-03-06',
        'proofUrls' => [
            '/Components/images/zeugnis_iad_marcus_reiser_seite1.jpg',
            '/Components/images/zeugnis_iad_marcus_reiser_seite2.jpg',
        ],
        'skills' => ['C#', 'OOP', 'Softwareentwicklung'],
    ],
    [
        'title' => 'WPI Professional Certification: JavaScript / TypeScript Frontend-Entwickler',
        'issuer' => 'WPI',
        'credentialId' => 'WPI-JSTS-REISER',
        'issuedAt' => '2026-02-10',
        'proofUrls' => ['/Components/images/zertifikat_javascript_typescript_marcus_reiser.jpg'],
        'skills' => ['JavaScript', 'TypeScript', 'Frontend'],
    ],
    [
        'title' => 'WPI Professional Certification: PHP- und Laravel-Entwickler',
        'issuer' => 'WPI',
        'credentialId' => 'WPI-PHP-LARAVEL-REISER',
        'issuedAt' => '2026-02-10',
        'proofUrls' => ['/Components/images/zertifikat_php_laravel_marcus_reiser.jpg'],
        'skills' => ['PHP', 'Laravel', 'Backend'],
    ],
];
