<?php

declare(strict_types=1);

namespace App\Controllers;

use App\View;

// Steuert Anzeige und Verarbeitung des Kontaktformulars.
final class ContactController
{
    // Zeigt das Formular zusammen mit Fehlermeldungen und Profildaten an.
    public function show(): void
    {
        $profile = require DATA_PATH . '/profile.php';

        View::render('pages/contact', [
            'title' => 'Kontakt',
            'profile' => $profile,
            'errors' => (array) ($_SESSION['form_errors'] ?? []),
            'success' => flash('success'),
        ]);

        unset($_SESSION['form_errors'], $_SESSION['form_old']);
    }

    // Validiert den Form-Post und schreibt gueltige Nachrichten in das Log.
    public function submit(): void
    {
        $name = trim((string) ($_POST['name'] ?? ''));
        $email = trim((string) ($_POST['email'] ?? ''));
        $message = trim((string) ($_POST['message'] ?? ''));
        $website = trim((string) ($_POST['website'] ?? ''));
        $token = (string) ($_POST['_csrf'] ?? '');

        $_SESSION['form_old'] = [
            'name' => $name,
            'email' => $email,
            'message' => $message,
        ];

        $errors = [];

        if (!csrf_token_is_valid($token)) {
            $errors[] = 'Sicherheitspruefung fehlgeschlagen. Bitte erneut versuchen.';
        }

        if ($website !== '') {
            $errors[] = 'Anfrage konnte nicht verarbeitet werden.';
        }

        if (mb_strlen($name) < 2) {
            $errors[] = 'Bitte gib einen gueltigen Namen ein.';
        }

        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $errors[] = 'Bitte gib eine gueltige E-Mail-Adresse ein.';
        }

        if (mb_strlen($message) < 20) {
            $errors[] = 'Bitte gib mindestens 20 Zeichen im Nachrichtentext ein.';
        }

        if ($errors !== []) {
            $_SESSION['form_errors'] = $errors;
            header('Location: /contact', true, 302);
            return;
        }

        // Header-Injection in Name und E-Mail verhindern.
        $safeName = str_replace(["\r", "\n"], '', $name);
        $safeEmail = str_replace(["\r", "\n"], '', $email);

        try {
            $logDir = DATA_PATH . '/messages';
            if (!is_dir($logDir)) {
                mkdir($logDir, 0775, true);
            }

            $entry = sprintf(
                "[%s] %s <%s>\n%s\n----\n",
                date('c'),
                $safeName,
                $safeEmail,
                $message
            );

            file_put_contents($logDir . '/contact.log', $entry, FILE_APPEND);
        } catch (\Throwable $exception) {
            if (\function_exists('app_log_error')) {
                \app_log_error($exception);
            }

            $_SESSION['form_errors'] = ['Technischer Fehler beim Senden. Bitte spaeter erneut versuchen.'];
            header('Location: /contact', true, 302);
            return;
        }

        // Erfolgreiche Abgabe per Flash-Meldung bestaetigen.
        $_SESSION['flash']['success'] = 'Danke! Deine Nachricht wurde erfolgreich gesendet.';
        unset($_SESSION['form_old'], $_SESSION['form_errors']);

        header('Location: /contact', true, 302);
    }
}
