# resier.de

Vanilla-PHP-Bewerbungsseite fuer Marcus Reiser mit Fokus auf Dozententätigkeit, Lernprozessbegleitung, kaufmännische Bildung und IT-Praxis.

Die Seite ist bewusst ohne Framework umgesetzt. Sie dient gleichzeitig als persönliche Bewerbungsseite und als nachvollziehbares Codebeispiel für saubere Struktur in PHP.

## Ziel des Projekts

Die Website kombiniert drei Aufgaben in einer Anwendung:

- professionelle Selbstdarstellung als Dozent und Lernprozessbegleiter
- strukturierte Darstellung von Profil, Werdegang, Projekten und Nachweisen
- technische Umsetzung mit klarem Vanilla-PHP-Aufbau statt Framework-Abhängigkeit

## Technische Merkmale

- Front-Controller über [index.php](index.php)
- einfacher Router für GET- und POST-Routen
- OOP-Controller unter [src/Controllers](src/Controllers)
- View-Rendering über zentrale Layout- und Seitentemplates
- datengetriebene Inhalte aus PHP-Arrays unter [data](data)
- Kontaktformular mit CSRF-Schutz, Honeypot, Escaping und Server-Validierung
- Fehlerprotokollierung über [bootstrap.php](bootstrap.php)
- eigene Detailansichten für Lebenslauf, Zertifikate und Projekt-Fokus mit Rücksprüngen zur passenden Stelle auf der Startseite

## Projektstruktur

```text
resier.de/
|- Components/
|  |- layout/
|  |- pages/
|  |- images/
|- data/
|- public/
|  |- css/
|  |- assets/
|- src/
|  |- Controllers/
|  |- Data/
|  |- Router.php
|  |- View.php
|- bootstrap.php
|- index.php
|- README.md
```

## Wichtige Dateien

- [index.php](index.php): Einstiegspunkt und Routing-Registrierung
- [bootstrap.php](bootstrap.php): Session, Helfer, .env-Laden, Fehlerbehandlung, Autoloading
- [src/Router.php](src/Router.php): einfacher Router
- [src/View.php](src/View.php): rendert Header, Seite und Footer
- [src/Controllers/PageController.php](src/Controllers/PageController.php): Seitenlogik für Startseite, Portfolio, Lebenslauf, Zertifikate und Projektdetails
- [src/Controllers/ContactController.php](src/Controllers/ContactController.php): Anzeige und Verarbeitung des Kontaktformulars
- [src/Data/PortfolioData.php](src/Data/PortfolioData.php): Validierung und Normalisierung der Rohdaten
- [Components/pages/home.php](Components/pages/home.php): Startseite
- [Components/pages/contact.php](Components/pages/contact.php): Kontaktseite
- [Components/pages/cv.php](Components/pages/cv.php): Lebenslauf-Blätteransicht
- [Components/pages/certificate.php](Components/pages/certificate.php): Nachweisansicht für Zertifikate
- [Components/pages/project.php](Components/pages/project.php): Detailseite für Projekt Fokus
- [data/profile.php](data/profile.php): Stammdaten, Kompetenzen, Werdegang, Motivation
- [data/certificates.php](data/certificates.php): Zertifikate und Nachweisbilder
- [data/projects.php](data/projects.php): Projektkarten und Projektdetails
- [public/css/style.css](public/css/style.css): gesamtes Styling

## Lokal starten

Voraussetzung: PHP 8.1 oder neuer

```powershell
Set-Location d:\09-resier.de
php -S localhost:8000
```

Danach im Browser öffnen:

- http://localhost:8000/
- http://localhost:8000/portfolio
- http://localhost:8000/contact

## Verfügbare Routen

- /: Startseite
- /portfolio: vollständige Projektübersicht
- /projekt?id=n: Detailansicht eines Projekts aus Projekt Fokus
- /lebenslauf: Lebenslauf mit Vor/Zurück-Navigation
- /zertifikat?id=n: Zertifikats- oder Zeugnisnachweis mit Vor/Zurück-Navigation
- /contact: Kontaktseite

## Inhalte pflegen

Die Seite ist datengetrieben. Änderungen erfolgen in den Dateien unter [data](data).

- [data/profile.php](data/profile.php): Personendaten, Zielregion, Werdegang, Kompetenzen, Motivation, Lebenslaufbilder
- [data/certificates.php](data/certificates.php): Titel, Aussteller, Datum, Nachweisbilder, Skill-Tags
- [data/projects.php](data/projects.php): Projekttexte, Technologien, Lerngewinn, optionale externe Links

Bilddateien liegen aktuell unter [Components/images](Components/images).

## Nachweise und Detailansichten

Mehrseitige Inhalte werden nicht direkt als Rohbild geöffnet, sondern über eigene Seiten dargestellt:

- Lebenslauf über /lebenslauf
- Zertifikate über /zertifikat?id=n
- Projekt Fokus über /projekt?id=n

Dadurch bleibt die Navigation konsistent, und Nutzer können jeweils gezielt zurück zur passenden Stelle auf der Startseite wechseln.

## Kontaktformular

Das Formular auf [Components/pages/contact.php](Components/pages/contact.php) verarbeitet Eingaben serverseitig und speichert Nachrichten lokal in:

- [data/messages/contact.log](data/messages/contact.log)

Umgesetzt sind bereits:

- CSRF-Token
- Honeypot-Feld
- Escaping über die Hilfsfunktion e()
- serverseitige Pflichtfeld- und Längenprüfung
- Logging technischer Fehler

Hinweis: Für produktiven Mailversand wären zusätzlich SMTP-Anbindung, Rate-Limiting und Spam-Schutz sinnvoll.

## Umgebungsvariablen

Das Projekt unterstützt eine einfache .env-Datei.

Vorgehen:

1. [ .env.example ](.env.example) nach .env kopieren
2. lokale Werte eintragen
3. .env nicht committen

Beispiel:

```php
$smtpHost = env('SMTP_HOST', 'localhost');
```

## Qualität und Wartung

Vor Änderungen oder vor einem Push sind diese Punkte sinnvoll:

- relevante PHP-Dateien mit php -l prüfen
- Startseite, Portfolio und Kontakt kurz im Browser testen
- Rücksprünge aus Lebenslauf, Zertifikaten und Projekt Fokus prüfen
- Bildpfade und Nachweise kontrollieren
- README und Inhalte aktuell halten

Eine kurze Checkliste liegt zusätzlich in [RELEASE_CHECKLIST.md](RELEASE_CHECKLIST.md).

## Hinweise zur Weiterentwicklung

Naheliegende Erweiterungen:

- Mailversand statt reinem Logfile
- bessere Formular- und Eingabefehler für produktiven Einsatz
- weitere Projekte mit stärkerem Lehrbezug
- sprachliche Feinpolitur der noch transliterierten Texte
- Überarbeitung von Titel und Meta-Description für die aktuelle Zielrolle
