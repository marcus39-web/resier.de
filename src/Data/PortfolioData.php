<?php

declare(strict_types=1);

namespace App\Data;

use UnexpectedValueException;

final class PortfolioData
{
    /** @return array<int, array{title: string, issuer: string, credentialId: string, issuedAt: string, proofUrls: array<int, string>, skills: array<int, string>}> */
    public static function certificates(): array
    {
        $data = require DATA_PATH . '/certificates.php';

        if (!is_array($data)) {
            throw new UnexpectedValueException('Zertifikatsdaten muessen als Array vorliegen.');
        }

        $normalized = [];

        foreach ($data as $index => $certificate) {
            if (!is_array($certificate)) {
                throw new UnexpectedValueException(sprintf('Zertifikat %d ist ungueltig.', $index));
            }

            $normalized[] = [
                'title' => self::stringValue($certificate, 'title', 'certificate'),
                'issuer' => self::stringValue($certificate, 'issuer', 'certificate'),
                'credentialId' => self::stringValue($certificate, 'credentialId', 'certificate'),
                'issuedAt' => self::stringValue($certificate, 'issuedAt', 'certificate'),
                'proofUrls' => self::stringList($certificate, 'proofUrls', 'certificate'),
                'skills' => self::stringList($certificate, 'skills', 'certificate'),
            ];
        }

        return $normalized;
    }

    /** @return array<int, array{title: string, summary: string, tech: array<int, string>, challenge: string, solution: string, learning: string, url: string}> */
    public static function projects(): array
    {
        $data = require DATA_PATH . '/projects.php';

        if (!is_array($data)) {
            throw new UnexpectedValueException('Projektdaten muessen als Array vorliegen.');
        }

        $normalized = [];

        foreach ($data as $index => $project) {
            if (!is_array($project)) {
                throw new UnexpectedValueException(sprintf('Projekt %d ist ungueltig.', $index));
            }

            $normalized[] = [
                'title' => self::stringValue($project, 'title', 'project'),
                'summary' => self::stringValue($project, 'summary', 'project'),
                'tech' => self::stringList($project, 'tech', 'project'),
                'challenge' => self::stringValue($project, 'challenge', 'project'),
                'solution' => self::stringValue($project, 'solution', 'project'),
                'learning' => self::stringValue($project, 'learning', 'project'),
                'url' => self::optionalStringValue($project, 'url', 'project'),
            ];
        }

        return $normalized;
    }

    /** @param array<string, mixed> $item */
    private static function stringValue(array $item, string $key, string $context): string
    {
        $value = $item[$key] ?? null;

        if (!is_string($value) || trim($value) === '') {
            throw new UnexpectedValueException(sprintf('Feld "%s" in %s ist ungueltig.', $key, $context));
        }

        return $value;
    }

    /** @param array<string, mixed> $item */
    private static function optionalStringValue(array $item, string $key, string $context): string
    {
        $value = $item[$key] ?? '';

        if (!is_string($value)) {
            throw new UnexpectedValueException(sprintf('Optionales Feld "%s" in %s ist ungueltig.', $key, $context));
        }

        return $value;
    }

    /** @param array<string, mixed> $item
     *  @return array<int, string>
     */
    private static function stringList(array $item, string $key, string $context): array
    {
        $value = $item[$key] ?? null;

        if (!is_array($value) || $value === []) {
            throw new UnexpectedValueException(sprintf('Liste "%s" in %s ist ungueltig.', $key, $context));
        }

        $normalized = [];

        foreach ($value as $entry) {
            if (!is_string($entry) || trim($entry) === '') {
                throw new UnexpectedValueException(sprintf('Eintrag in "%s" in %s ist ungueltig.', $key, $context));
            }

            $normalized[] = $entry;
        }

        return $normalized;
    }
}