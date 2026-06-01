<?php
/** @var array<int, array<string, string>> $projects */
?>
<section class="section container">
    <p class="eyebrow">Portfolio</p>
    <h1>Praxisprojekte aus meiner Lernphase</h1>
    <div class="grid cards">
        <?php foreach ($projects as $project): ?>
            <article class="card">
                <h2><?= e($project['title']) ?></h2>
                <p><?= e($project['description']) ?></p>
                <p><strong>Tech:</strong> <?= e($project['tech']) ?></p>
                <p><strong>Problem geloest:</strong> <?= e($project['challenge']) ?></p>
                <p><strong>Lerngewinn:</strong> <?= e($project['learning']) ?></p>
                <?php if ($project['url'] !== ''): ?>
                    <a href="<?= e($project['url']) ?>" target="_blank" rel="noopener noreferrer">Projekt ansehen</a>
                <?php endif; ?>
            </article>
        <?php endforeach; ?>
    </div>
</section>
