<?php
/** @var array<int, array<string, string>> $certificates */
/** @var array<int, array<string, string>> $projects */

$timeline = $certificates;
usort($timeline, static fn (array $a, array $b): int => strcmp($a['date'], $b['date']));
?>
<section class="section container intro">
    <p class="eyebrow">Junior PHP Entwickler</p>
    <h1>Struktur. Codebezug. Lernkurve.</h1>
    <p class="lead">
        7 Monate Praxiserfahrung, saubere Serverlogik und Zertifikate mit direktem Bezug zu PHP, Security und Daten.
        Ich baue backend-fokussierte Features, die klar wartbar und testbar bleiben.
    </p>
    <a class="cta" href="/contact">Zum Erstgespraech</a>
</section>

<section class="section container bento-grid">
    <article class="card bento about">
        <h2>Ueber mich</h2>
        <p>
            Ich komme mit frischem Blick in Teams, lerne schnell in bestehende Codebases hinein und arbeite bewusst
            mit kleinen, nachvollziehbaren Schritten statt mit kompliziertem Overengineering.
        </p>
    </article>

    <article class="card bento stack">
        <h2>Tech Stack</h2>
        <ul class="tag-list">
            <li>PHP 8.x</li>
            <li>MySQL</li>
            <li>REST APIs</li>
            <li>HTML/CSS</li>
            <li>Git/GitHub</li>
            <li>Web Security</li>
        </ul>
    </article>

    <article class="card bento timeline-block">
        <h2>Zertifikate Timeline</h2>
        <div class="timeline">
            <?php foreach ($timeline as $certificate): ?>
                <div class="timeline-item">
                    <p class="timeline-date"><?= e($certificate['date']) ?></p>
                    <h3><?= e($certificate['name']) ?></h3>
                    <p><?= e($certificate['issuer']) ?> · <?= e($certificate['id']) ?></p>
                    <a href="<?= e($certificate['url']) ?>" target="_blank" rel="noopener noreferrer">Nachweis</a>
                </div>
            <?php endforeach; ?>
        </div>
    </article>

    <article class="card bento project-block">
        <h2>Projekt Fokus</h2>
        <?php foreach (array_slice($projects, 0, 2) as $project): ?>
            <div class="project-mini">
                <h3><?= e($project['title']) ?></h3>
                <p><?= e($project['description']) ?></p>
                <p><strong>Lerngewinn:</strong> <?= e($project['learning']) ?></p>
            </div>
        <?php endforeach; ?>
        <a class="inline-link" href="/portfolio">Alle Projekte ansehen</a>
    </article>

    <article class="card bento contact-block">
        <h2>Kontakt</h2>
        <p>
            Wenn du einen motivierten Junior mit klarem Backend-Fokus suchst, lass uns sprechen.
        </p>
        <a class="cta" href="/contact">Nachricht senden</a>
    </article>
</section>
