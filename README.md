# PHP Bewerbungsseite (Vanilla, Clean Struktur)

Diese Seite ist bewusst ohne Framework aufgebaut, um Core-Skills in modernem PHP zu zeigen:

- Front-Controller Routing
- OOP Controller und View-Renderer
- Dynamische Daten aus PHP-Arrays
- Sicheres Kontaktformular mit CSRF, XSS-Schutz und serverseitiger Validierung

## Lokal starten

Voraussetzung: PHP 8.1+

```powershell
Set-Location d:\09-resier.de
php -S localhost:8000
```

Dann im Browser aufrufen:

- http://localhost:8000/
- http://localhost:8000/portfolio
- http://localhost:8000/contact

## Zugangsdaten auslagern (.env)

1. Datei `.env.example` nach `.env` kopieren
2. Eigene Werte eintragen (z. B. SMTP-Zugangsdaten)
3. `.env` bleibt lokal und wird nicht ins Git-Repository committed

Beispiel in PHP:

```php
$smtpHost = env('SMTP_HOST', 'localhost');
```

## Inhalte anpassen

- Zertifikate: `data/certificates.php`
- Projekte: `data/projects.php`

## Orientierung an anderen Portfolios

Ja, das macht Sinn, solange du das Prinzip uebernimmst statt Design 1:1 zu kopieren.

- Fokus auf Struktur: klare Sektionen statt visuelle Ueberladung
- Fokus auf Codebezug: was gebaut, welches Problem geloest, was gelernt
- Fokus auf Minimalismus: wenige starke Komponenten, dafuer sauber umgesetzt

Aktuell ist die Startseite bereits auf ein Developer-First Muster angepasst:

- Dark, text-first Look
- Bento-Grid fuer Inhalte mit klarer Gewichtung
- Zertifikate als Timeline aus dynamischen PHP-Daten

## Kontaktformular

Nachrichten werden lokal protokolliert in:

- `data/messages/contact.log`

Hinweis: Fuer produktive Nutzung sollte zusaetzlich ein Mailversand (z. B. PHPMailer ueber Composer) und Rate-Limiting eingebaut werden.
