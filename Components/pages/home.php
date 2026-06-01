<?php
/** @var array<string, mixed> $profile */
/** @var array<int, array{title: string, issuer: string, credentialId: string, issuedAt: string, proofUrls: array<int, string>, skills: array<int, string>}> $certificates */
/** @var array<int, array{title: string, summary: string, tech: array<int, string>, challenge: string, solution: string, learning: string, url: string}> $projects */

$timeline = $certificates;
usort($timeline, static fn (array $a, array $b): int => strcmp($a['issuedAt'], $b['issuedAt']));

$profileImageCandidates = [
    '/Components/images/profilbild.jpg',
    '/Components/images/profilbild.jpeg',
    '/Components/images/profilbild.png',
    '/Components/images/profilbild.webp',
    '/public/assets/images/profile.webp',
    '/public/assets/images/profile.jpg',
    '/public/assets/images/profile.jpeg',
    '/public/assets/images/profile.png',
    '/public/assets/images/profile.heic',
];

$profileImagePath = null;
foreach ($profileImageCandidates as $candidate) {
    if (is_file(BASE_PATH . $candidate)) {
        $profileImagePath = $candidate;
        break;
    }
}
?>
<section class="section container intro">
    <div class="intro-grid">
        <div>
            <p class="eyebrow">Dozent und Lernprozessbegleiter</p>
            <h1>Handlungsorientierter Unterricht für kaufmännische Bildung und IT.</h1>
            <p class="lead">
                <?= e((string) ($profile['summary'] ?? '')) ?>
            </p>
            <p class="profile-meta">
                <?= e((string) ($profile['name'] ?? '')) ?> · <?= e((string) ($profile['headline'] ?? '')) ?><br>
                <?= e((string) ($profile['location'] ?? '')) ?> · <?= e((string) ($profile['phone'] ?? '')) ?> · <?= e((string) ($profile['email'] ?? '')) ?>
            </p>
            <a class="cta" href="/contact">Zum Erstgespraech</a>
        </div>

        <aside class="card profile-photo-wrap">
            <?php if ($profileImagePath !== null): ?>
                <img class="profile-photo" src="<?= e($profileImagePath) ?>" alt="Profilfoto">
            <?php else: ?>
                <p class="profile-photo-placeholder">Lege dein Bild als /public/assets/images/profile.jpg (oder .png/.webp/.heic) ab.</p>
            <?php endif; ?>
        </aside>
    </div>
</section>

<section class="section container bento-grid">
    <article class="card bento about">
        <h2>Über mich</h2>
        <p>
            Ich arbeite seit Jahren in der Erwachsenenbildung und habe kaufmännische Schüler und
            Umschüler praxisnah begleitet. Handlungsorientierter Unterricht bedeutet für mich, wirtschaftliche,
            organisatorische und digitale Inhalte so zu vermitteln, dass Lernende sie direkt auf betriebliche
            Situationen, Fachgespräche und Abschlussprüfungen übertragen können.
        </p>
        <p class="subtle"><?= e((string) ($profile['born'] ?? '')) ?> · <?= e((string) ($profile['status'] ?? '')) ?></p>
    </article>

    <article class="card bento stack">
        <h2>Lehr- und Fachprofil</h2>
        <ul class="tag-list">
            <li>Berufspädagogik</li>
            <li>Erwachsenenbildung</li>
            <li>Prüfungsvorbereitung IHK/HWK</li>
            <li>Lernprozessbegleitung</li>
            <li>C#</li>
            <li>.NET</li>
            <li>OOP</li>
            <li>SOLID</li>
            <li>PHP 8.x</li>
            <li>JavaScript/TypeScript</li>
            <li>Git/GitHub</li>
            <li>KI-gestütztes Lernen</li>
        </ul>
    </article>

    <article class="card bento competencies-block">
        <h2>IT-Kompetenzen</h2>
        <?php foreach ((array) ($profile['competencies'] ?? []) as $competency): ?>
            <div class="competency-group">
                <h3><?= e((string) ($competency['category'] ?? '')) ?></h3>
                <ul class="tag-list compact">
                    <?php foreach ((array) ($competency['items'] ?? []) as $item): ?>
                        <li><?= e((string) $item) ?></li>
                    <?php endforeach; ?>
                </ul>
            </div>
        <?php endforeach; ?>
    </article>

    <article class="card bento motivation-block">
        <h2>Bewerbungsmotivation</h2>
        <p><strong>Zielposition:</strong> <?= e((string) ($profile['targetRole'] ?? '')) ?></p>
        <p><strong>Referenz:</strong> <?= e((string) ($profile['targetReference'] ?? '')) ?></p>
        <p><strong>Zielregion:</strong> <?= e((string) ($profile['targetRegion'] ?? '')) ?></p>
        <ul>
            <?php foreach ((array) ($profile['motivation'] ?? []) as $point): ?>
                <li><?= e((string) $point) ?></li>
            <?php endforeach; ?>
        </ul>
        <?php if ((string) ($profile['projectFocusUrl'] ?? '') !== ''): ?>
            <p>
                <a href="<?= e((string) ($profile['projectFocusUrl'] ?? '')) ?>" target="_blank" rel="noopener noreferrer">Projektbezug auf GitHub ansehen</a>
            </p>
        <?php endif; ?>
    </article>

    <article class="card bento timeline-block">
        <h2>Zertifikate Timeline</h2>
        <div class="timeline">
            <?php foreach ($timeline as $certificate): ?>
                <div class="timeline-item">
                    <p class="timeline-date"><?= e($certificate['issuedAt']) ?></p>
                    <h3><?= e($certificate['title']) ?></h3>
                    <p><?= e($certificate['issuer']) ?> · <?= e($certificate['credentialId']) ?></p>
                    <ul class="tag-list compact">
                        <?php foreach ($certificate['skills'] as $skill): ?>
                            <li><?= e($skill) ?></li>
                        <?php endforeach; ?>
                    </ul>
                    <div class="proof-links">
                        <?php foreach ($certificate['proofUrls'] as $index => $proofUrl): ?>
                            <a href="<?= e($proofUrl) ?>" target="_blank" rel="noopener noreferrer">
                                <?= count($certificate['proofUrls']) > 1 ? 'Nachweis ' . ($index + 1) : 'Nachweis' ?>
                            </a>
                        <?php endforeach; ?>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </article>

    <article class="card bento project-block">
        <h2>Projekt Fokus</h2>
        <?php foreach (array_slice($projects, 0, 2) as $project): ?>
            <div class="project-mini">
                <h3><?= e($project['title']) ?></h3>
                <p><?= e($project['summary']) ?></p>
                <ul class="tag-list compact">
                    <?php foreach ($project['tech'] as $tech): ?>
                        <li><?= e($tech) ?></li>
                    <?php endforeach; ?>
                </ul>
                <p><strong>Lerngewinn:</strong> <?= e($project['learning']) ?></p>
            </div>
        <?php endforeach; ?>
        <a class="inline-link" href="/portfolio">Alle Projekte ansehen</a>
    </article>

    <article class="card bento career-block">
        <h2>Beruflicher Werdegang</h2>
        <div class="timeline">
            <?php foreach ((array) ($profile['career'] ?? []) as $station): ?>
                <div class="timeline-item">
                    <p class="timeline-date"><?= e((string) ($station['period'] ?? '')) ?></p>
                    <h3><?= e((string) ($station['role'] ?? '')) ?></h3>
                    <?php if ((string) ($station['organization'] ?? '') !== ''): ?>
                        <p><?= e((string) ($station['organization'] ?? '')) ?></p>
                    <?php endif; ?>
                    <ul>
                        <?php foreach ((array) ($station['details'] ?? []) as $detail): ?>
                            <li><?= e((string) $detail) ?></li>
                        <?php endforeach; ?>
                    </ul>
                </div>
            <?php endforeach; ?>
        </div>
    </article>

    <article class="card bento qualification-block">
        <h2>Ausbildung und Qualifikationen</h2>
        <ul>
            <?php foreach ((array) ($profile['qualifications'] ?? []) as $qualification): ?>
                <li><?= e((string) $qualification) ?></li>
            <?php endforeach; ?>
        </ul>
    </article>

    <article class="card bento contact-block">
        <h2>Kontakt</h2>
        <p>
            Wenn Sie einen Dozenten mit paedagogischer Erfahrung und IT-Praxis suchen,
            freue ich mich auf ein persönliches Kennenlernen.
        </p>
        <p class="subtle"><strong>Region:</strong> <?= e((string) ($profile['targetRegion'] ?? '')) ?></p>
        <a class="cta" href="/contact">Nachricht senden</a>
    </article>
</section>
