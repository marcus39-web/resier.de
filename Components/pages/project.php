<?php
// Detailansicht fuer ein einzelnes Projekt aus dem Projektfokus.
/** @var array{title: string, summary: string, tech: array<int, string>, challenge: string, solution: string, learning: string, url: string}|null $project */
?>
<section class="section container cv-page">
    <?php if ($project === null): ?>
        <div class="cv-header">
            <p class="eyebrow">Projekt</p>
            <h1>Projekt nicht gefunden</h1>
            <p><a class="inline-link" href="/#projekt-fokus">Zurück zu Projekt Fokus</a></p>
        </div>
    <?php else: ?>
        <div class="cv-header">
            <p class="eyebrow">Projekt</p>
            <h1><?= e($project['title']) ?></h1>
            <p class="subtle"><?= e($project['summary']) ?></p>
            <p><a class="inline-link" href="/#projekt-fokus">Zurück zu Projekt Fokus</a></p>
        </div>

        <article class="card cv-card">
            <!-- Technologien und Kernaussagen des Projekts komprimiert darstellen -->
            <ul class="tag-list compact">
                <?php foreach ($project['tech'] as $tech): ?>
                    <li><?= e($tech) ?></li>
                <?php endforeach; ?>
            </ul>

            <p><strong>Herausforderung:</strong> <?= e($project['challenge']) ?></p>
            <p><strong>Lösung:</strong> <?= e($project['solution']) ?></p>
            <p><strong>Lerngewinn:</strong> <?= e($project['learning']) ?></p>

            <?php if ($project['url'] !== ''): ?>
                <p><a class="inline-link" href="<?= e($project['url']) ?>" target="_blank" rel="noopener noreferrer">Projekt auf GitHub öffnen</a></p>
            <?php endif; ?>
        </article>
    <?php endif; ?>
</section>