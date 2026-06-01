<?php
// Vollansicht aller Projekte aus den Projektdaten.
/** @var array<int, array{title: string, summary: string, tech: array<int, string>, challenge: string, solution: string, learning: string, url: string}> $projects */
?>
<section class="section container">
    <p class="eyebrow">Portfolio</p>
    <h1>Praxisprojekte fuer Unterricht und Anwendungsentwicklung</h1>
    <div class="grid cards">
        <!-- Jedes Projekt wird als eigenstaendige Karte gerendert -->
        <?php foreach ($projects as $project): ?>
            <article class="card">
                <h2><?= e($project['title']) ?></h2>
                <p><?= e($project['summary']) ?></p>
                <ul class="tag-list compact">
                    <?php foreach ($project['tech'] as $tech): ?>
                        <li><?= e($tech) ?></li>
                    <?php endforeach; ?>
                </ul>
                <p><strong>Problem geloest:</strong> <?= e($project['challenge']) ?></p>
                <p><strong>Loesungsansatz:</strong> <?= e($project['solution']) ?></p>
                <p><strong>Lerngewinn:</strong> <?= e($project['learning']) ?></p>
                <?php if ($project['url'] !== ''): ?>
                    <a href="<?= e($project['url']) ?>" target="_blank" rel="noopener noreferrer">Projekt ansehen</a>
                <?php endif; ?>
            </article>
        <?php endforeach; ?>
    </div>
</section>
