<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Mail\SmtpMailer;
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
            $errors[] = 'Sicherheitsprüfung fehlgeschlagen. Bitte erneut versuchen.';
        }

        if ($website !== '') {
            $errors[] = 'Anfrage konnte nicht verarbeitet werden.';
        }

        if (mb_strlen($name) < 2) {
            $errors[] = 'Bitte gib einen gültigen Namen ein.';
        }

        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $errors[] = 'Bitte gib eine gültige E-Mail-Adresse ein.';
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
        $mailWasSent = false;
        $mailSendFailed = false;
        $mailFailureHint = '';

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

            $_SESSION['form_errors'] = ['Technischer Fehler beim Senden. Bitte später erneut versuchen.'];
            header('Location: /contact', true, 302);
            return;
        }

        // Optionaler SMTP-Versand: Formular bleibt auch ohne SMTP nutzbar.
        if ($this->isSmtpConfigured()) {
            try {
                $this->sendContactMail($safeName, $safeEmail, $message);
                $mailWasSent = true;
            } catch (\Throwable $exception) {
                if (\function_exists('app_log_error')) {
                    \app_log_error($exception);
                }

                $mailSendFailed = true;

                $errorText = $exception->getMessage();
                if (strpos($errorText, '5.7.139') !== false || stripos($errorText, 'basic authentication is disabled') !== false) {
                    $mailFailureHint = ' Der Anbieter blockiert SMTP-Benutzername/Passwort (Basic Auth).';
                }
            }
        }

        // Erfolgreiche Abgabe per Flash-Meldung bestaetigen.
        if ($mailWasSent) {
            $_SESSION['flash']['success'] = 'Danke! Deine Nachricht wurde erfolgreich gesendet.';
        } elseif ($mailSendFailed) {
            $_SESSION['flash']['success'] = 'Danke! Deine Nachricht wurde gespeichert. Der E-Mail-Versand ist aktuell fehlgeschlagen.' . $mailFailureHint;
        } else {
            $_SESSION['flash']['success'] = 'Danke! Deine Nachricht wurde gespeichert. Der E-Mail-Versand ist noch nicht konfiguriert.';
        }
        unset($_SESSION['form_old'], $_SESSION['form_errors']);

        header('Location: /contact', true, 302);
    }

    private function isSmtpConfigured(): bool
    {
        // Nur echte, nicht-platzhalterhafte Werte als aktiv konfigurierte SMTP-Umgebung akzeptieren.
        $host = trim((string) env('SMTP_HOST', ''));
        $username = trim((string) env('SMTP_USERNAME', ''));
        $password = trim((string) env('SMTP_PASSWORD', ''));
        $toAddress = trim((string) env('MAIL_TO', ''));
        $fromAddress = trim((string) env('MAIL_FROM_ADDRESS', ''));
        $isPlaceholderUser = stripos($username, 'dein_') !== false
            || stripos($username, 'example') !== false
            || stripos($username, 'change_me') !== false;
        $isPlaceholderPassword = stripos($password, 'dein_') !== false
            || stripos($password, 'example') !== false
            || stripos($password, 'change_me') !== false;
        $isPlaceholderTo = stripos($toAddress, 'deine-') !== false
            || stripos($toAddress, 'example.com') !== false
            || stripos($toAddress, 'change_me') !== false;
        $isPlaceholderFrom = stripos($fromAddress, 'deine-') !== false
            || stripos($fromAddress, 'example.com') !== false
            || stripos($fromAddress, 'deinedomain.de') !== false
            || stripos($fromAddress, 'change_me') !== false;

        return $host !== ''
            && $username !== ''
            && $password !== ''
            && $toAddress !== ''
            && $fromAddress !== ''
            && !$isPlaceholderUser
            && !$isPlaceholderPassword
            && !$isPlaceholderTo
            && !$isPlaceholderFrom
            && extension_loaded('openssl');
    }

    private function sendContactMail(string $senderName, string $senderEmail, string $message): void
    {
        // SMTP- und Mail-Metadaten zentral aus .env lesen.
        $smtpHost = trim((string) env('SMTP_HOST', ''));
        $smtpPort = (int) env('SMTP_PORT', '587');
        $smtpUsername = trim((string) env('SMTP_USERNAME', ''));
        $smtpPassword = (string) env('SMTP_PASSWORD', '');
        $smtpEncryption = trim((string) env('SMTP_ENCRYPTION', 'tls'));

        $fromAddress = trim((string) env('MAIL_FROM_ADDRESS', ''));
        $fromName = trim((string) env('MAIL_FROM_NAME', 'Kontaktformular'));
        $toAddress = trim((string) env('MAIL_TO', ''));

        // Hauptmail an die Zieladresse der Bewerbung/Website.
        $subject = 'Kontaktformular resier.de | Neue Anfrage von ' . $senderName;
        $body = "Name: {$senderName}\n"
            . "E-Mail: {$senderEmail}\n"
            . "Zeitpunkt: " . date('d.m.Y H:i:s') . "\n\n"
            . "Nachricht:\n{$message}\n";

        $mailer = new SmtpMailer(
            $smtpHost,
            $smtpPort > 0 ? $smtpPort : 587,
            $smtpUsername,
            $smtpPassword,
            $smtpEncryption,
            12
        );

        $mailer->send($fromAddress, $fromName, $toAddress, $subject, $body, $senderEmail);

        // Auto-Bestaetigung an den Absender senden, ohne die Hauptanfrage zu blockieren.
        try {
            $confirmSubject = 'Eingangsbestätigung Ihrer Nachricht an resier.de';
            $confirmBody = "Guten Tag {$senderName},\n\n"
                . "vielen Dank für Ihre Nachricht über das Kontaktformular von resier.de.\n"
                . "Ihre Anfrage ist bei mir eingegangen und wird zeitnah bearbeitet.\n\n"
                . "Ihre Nachricht:\n"
                . "--------------------\n"
                . $message . "\n"
                . "--------------------\n\n"
                . "Freundliche Grüße\n"
                . $fromName . "\n";

            $mailer->send($fromAddress, $fromName, $senderEmail, $confirmSubject, $confirmBody, $toAddress);
        } catch (\Throwable $exception) {
            if (\function_exists('app_log_error')) {
                \app_log_error($exception);
            }
        }
    }
}
