<?php

declare(strict_types=1);

namespace App\Mail;

// Kleiner SMTP-Client fuer transaktionale Text-Mails (TLS/SSL, AUTH LOGIN).
final class SmtpMailer
{
    private string $host;
    private int $port;
    private string $username;
    private string $password;
    private string $encryption;
    private int $timeout;

    public function __construct(
        string $host,
        int $port,
        string $username = '',
        string $password = '',
        string $encryption = 'tls',
        int $timeout = 10
    ) {
        $this->host = $host;
        $this->port = $port;
        $this->username = $username;
        $this->password = $password;
        $this->encryption = strtolower($encryption);
        $this->timeout = $timeout;
    }

    public function send(
        string $fromAddress,
        string $fromName,
        string $toAddress,
        string $subject,
        string $textBody,
        string $replyTo = ''
    ): void {
        // Neue Verbindung pro Mail, damit Request-Laufzeiten und Fehler sauber gekapselt bleiben.
        $socket = $this->connect();

        try {
            $this->readResponse($socket, [220]);

            $hostname = gethostname();
            $ehloName = $hostname !== false && $hostname !== '' ? $hostname : 'localhost';

            $this->sendCommand($socket, 'EHLO ' . $ehloName, [250]);

            if ($this->encryption === 'tls') {
                // STARTTLS upgraden und danach EHLO erneut senden.
                $this->sendCommand($socket, 'STARTTLS', [220]);

                if (!stream_socket_enable_crypto($socket, true, STREAM_CRYPTO_METHOD_TLS_CLIENT)) {
                    throw new \RuntimeException('STARTTLS konnte nicht aktiviert werden.');
                }

                $this->sendCommand($socket, 'EHLO ' . $ehloName, [250]);
            }

            if ($this->username !== '' && $this->password !== '') {
                // SMTP Basic Auth ueber AUTH LOGIN.
                $this->sendCommand($socket, 'AUTH LOGIN', [334]);
                $this->sendCommand($socket, base64_encode($this->username), [334]);
                $this->sendCommand($socket, base64_encode($this->password), [235]);
            }

            $this->sendCommand($socket, 'MAIL FROM:<' . $fromAddress . '>', [250]);
            $this->sendCommand($socket, 'RCPT TO:<' . $toAddress . '>', [250, 251]);
            $this->sendCommand($socket, 'DATA', [354]);

            $headers = [
                'Date: ' . date(DATE_RFC2822),
                'From: ' . $this->formatAddressHeader($fromAddress, $fromName),
                'To: <' . $toAddress . '>',
                'Subject: ' . $this->encodeHeader($subject),
                'MIME-Version: 1.0',
                'Content-Type: text/plain; charset=UTF-8',
                'Content-Transfer-Encoding: 8bit',
            ];

            if ($replyTo !== '') {
                $headers[] = 'Reply-To: <' . $replyTo . '>';
            }

            // SMTP DATA mit finalem Terminator \r\n. senden.
            $message = implode("\r\n", $headers) . "\r\n\r\n" . $this->normalizeBody($textBody) . "\r\n.";

            fwrite($socket, $message . "\r\n");
            $this->readResponse($socket, [250]);

            $this->sendCommand($socket, 'QUIT', [221]);
        } finally {
            fclose($socket);
        }
    }

    /** @return resource */
    private function connect()
    {
        // Fuer SSL wird direkt ueber ssl:// verbunden, bei TLS erst plain + STARTTLS.
        $transport = $this->encryption === 'ssl' ? 'ssl://' : '';
        $endpoint = $transport . $this->host . ':' . $this->port;

        $socket = @stream_socket_client(
            $endpoint,
            $errorNumber,
            $errorMessage,
            $this->timeout,
            STREAM_CLIENT_CONNECT
        );

        if ($socket === false) {
            throw new \RuntimeException(sprintf('SMTP-Verbindung fehlgeschlagen: %s (%d)', $errorMessage, $errorNumber));
        }

        stream_set_timeout($socket, $this->timeout);

        return $socket;
    }

    /** @param resource $socket
     *  @param array<int, int> $expectedCodes
     */
    private function sendCommand($socket, string $command, array $expectedCodes): void
    {
        fwrite($socket, $command . "\r\n");
        $this->readResponse($socket, $expectedCodes);
    }

    /** @param resource $socket
     *  @param array<int, int> $expectedCodes
     */
    private function readResponse($socket, array $expectedCodes): string
    {
        // Mehrzeilige SMTP-Antworten lesen, bis die finale Statuszeile erreicht ist.
        $response = '';

        while (($line = fgets($socket, 515)) !== false) {
            $response .= $line;

            if (preg_match('/^\d{3}\s/', $line) === 1) {
                break;
            }
        }

        if ($response === '') {
            throw new \RuntimeException('Leere SMTP-Antwort erhalten.');
        }

        $code = (int) substr($response, 0, 3);
        if (!in_array($code, $expectedCodes, true)) {
            throw new \RuntimeException('Unerwartete SMTP-Antwort: ' . trim($response));
        }

        return $response;
    }

    private function encodeHeader(string $value): string
    {
        if (preg_match('/^[\x20-\x7E]+$/', $value) === 1) {
            return $value;
        }

        return '=?UTF-8?B?' . base64_encode($value) . '?=';
    }

    private function formatAddressHeader(string $email, string $name): string
    {
        if ($name === '') {
            return '<' . $email . '>';
        }

        return $this->encodeHeader($name) . ' <' . $email . '>';
    }

    private function normalizeBody(string $body): string
    {
        // Zeilenenden normalisieren und SMTP dot-stuffing anwenden.
        $normalized = str_replace(["\r\n", "\r"], "\n", $body);
        $normalized = str_replace("\n.", "\n..", $normalized);

        return str_replace("\n", "\r\n", $normalized);
    }
}