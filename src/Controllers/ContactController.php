<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Mail\SmtpMailer;
use App\View;

final class ContactController
{
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

    public function submit(): void
    {
        $name = trim((string) ($_POST['name'] ?? ''));
        $email = trim((string) ($_POST['email'] ?? ''));
        $message = trim((string) ($_POST['message'] ?? ''));
        $website = trim((string) ($_POST['website'] ?? ''));
        $token = (string) ($_POST['_csrf'] ?? '');

        $_SESSION['form_old'] = ['name' => $name, 'email' => $email, 'message' => $message];

        $errors = [];
        if (!csrf_token_is_valid($token)) $errors[] = 'Sicherheitsprüfung fehlgeschlagen.';
        if ($website !== '') $errors[] = 'Anfrage konnte nicht verarbeitet werden.';
        if (mb_strlen($name) < 2) $errors[] = 'Bitte gib einen gültigen Namen ein.';
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) $errors[] = 'Bitte gib eine gültige E-Mail-Adresse ein.';
        if (mb_strlen($message) < 20) $errors[] = 'Bitte gib mindestens 20 Zeichen ein.';

        if ($errors !== []) {
            $_SESSION['form_errors'] = $errors;
            header('Location: /contact', true, 302);
            return;
        }

        $safeName = str_replace(["\r", "\n"], '', $name);
        $safeEmail = str_replace(["\r", "\n"], '', $email);
        $mailWasSent = false;
        $mailSendFailed = false;

        try {
            $logDir = DATA_PATH . '/messages';
            if (!is_dir($logDir)) mkdir($logDir, 0775, true);
            $logFile = $logDir . '/contact.log';
            $this->purgeExpiredContactLogEntries($logFile);
            $entry = sprintf("[%s] %s <%s>\n%s\n----\n", date('c'), $safeName, $safeEmail, $message);
            file_put_contents($logFile, $entry, FILE_APPEND);
        } catch (\Throwable $exception) {
            $_SESSION['form_errors'] = ['Technischer Fehler.'];
            header('Location: /contact', true, 302);
            return;
        }

        if ($this->isSmtpConfigured()) {
            try {
                $this->sendContactMail($safeName, $safeEmail, $message);
                $mailWasSent = true;
            } catch (\Throwable $exception) {
                if (\function_exists('app_log_error')) \app_log_error($exception);
                $mailSendFailed = true;
            }
        }

        $_SESSION['flash']['success'] = $mailWasSent 
            ? 'Danke! Deine Nachricht wurde erfolgreich gesendet.' 
            : ($mailSendFailed ? 'Danke! Nachricht gespeichert, Versand fehlgeschlagen (SMTP-Fehler).' : 'Nachricht gespeichert, SMTP nicht konfiguriert.');
            
        unset($_SESSION['form_old'], $_SESSION['form_errors']);
        header('Location: /contact', true, 302);
    }

    private function isSmtpConfigured(): bool
    {
        return env('SMTP_HOST') !== '' && env('SMTP_USERNAME') !== '' && env('SMTP_PASSWORD') !== '' && extension_loaded('openssl');
    }

    private function sendContactMail(string $senderName, string $senderEmail, string $message): void
    {
        $smtpHost = (string) env('SMTP_HOST');
        $smtpPort = (int) env('SMTP_PORT', 587);
        $smtpUsername = (string) env('SMTP_USERNAME');
        $smtpPassword = (string) env('SMTP_PASSWORD');
        $smtpEncryption = (string) env('SMTP_ENCRYPTION', 'tls');

        $mailer = new SmtpMailer($smtpHost, $smtpPort, $smtpUsername, $smtpPassword, $smtpEncryption, 12);
        
        $subject = 'Kontaktformular marcusreiser.de | ' . $senderName;
        $body = "Name: {$senderName}\nE-Mail: {$senderEmail}\n\nNachricht:\n{$message}";

        try {
            $mailer->send((string)env('MAIL_FROM_ADDRESS'), (string)env('MAIL_FROM_NAME'), (string)env('MAIL_TO'), $subject, $body, $senderEmail);
        } catch (\Throwable $e) {
            // Fallback: Falls STARTTLS scheitert, Versuch ohne Verschlüsselung auf Port 25
            if (strpos($e->getMessage(), 'STARTTLS') !== false) {
                $fallbackMailer = new SmtpMailer($smtpHost, 25, $smtpUsername, $smtpPassword, 'none', 12);
                $fallbackMailer->send((string)env('MAIL_FROM_ADDRESS'), (string)env('MAIL_FROM_NAME'), (string)env('MAIL_TO'), $subject, $body, $senderEmail);
            } else {
                throw $e;
            }
        }
    }

    private function purgeExpiredContactLogEntries(string $logFile): void
    {
        // (Deine Log-Reinigungs-Logik bleibt hier unverändert...)
        if (!is_file($logFile) || !is_readable($logFile)) return;
        $retentionDays = (int) env('CONTACT_RETENTION_DAYS', 183);
        $rawContent = file_get_contents($logFile);
        if (!$rawContent) return;
        $blocks = explode("\n----\n", str_replace(["\r\n", "\r"], "\n", $rawContent));
        $cutoff = time() - ($retentionDays * 86400);
        $kept = [];
        foreach ($blocks as $block) {
            if (trim($block) === '') continue;
            if (preg_match('/^\[([^\]]+)\]/', (string)strtok($block, "\n"), $m) && strtotime($m[1]) < $cutoff) continue;
            $kept[] = $block;
        }
        file_put_contents($logFile, $kept === [] ? '' : implode("\n----\n", $kept) . "\n----\n");
    }
}