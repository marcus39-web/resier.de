<?php
// Blaetteransicht fuer den mehrseitigen Lebenslauf.
/** @var string|null $pageImage */
/** @var int $currentPage */
/** @var int $pageCount */
?>
<section class="section container cv-page">
    <div class="cv-header">
        <p class="eyebrow">Lebenslauf</p>
        <h1>Lebenslauf ansehen</h1>
        <?php if ($pageCount > 0): ?>
            <p class="subtle">Seite <?= e((string) $currentPage) ?> von <?= e((string) $pageCount) ?></p>
        <?php else: ?>
            <p class="subtle">Der Lebenslauf ist aktuell noch nicht hinterlegt.</p>
        <?php endif; ?>
    </div>

    <?php if ($pageImage !== null): ?>
        <article class="card cv-card">
            <!-- Aktuelle Lebenslaufseite gross anzeigen -->
            <a class="cv-image-link" href="<?= e($pageImage) ?>" target="_blank" rel="noopener noreferrer">
                <img class="cv-image" src="<?= e($pageImage) ?>" alt="Lebenslauf Seite <?= e((string) $currentPage) ?>">
            </a>

            <!-- Navigation zwischen den Lebenslaufseiten -->
            <div class="cv-navigation">
                <?php if ($currentPage > 1): ?>
                    <a class="cta cv-nav-link" href="/lebenslauf?seite=<?= $currentPage - 1 ?>">Zurück</a>
                <?php else: ?>
                    <span class="cv-nav-placeholder"></span>
                <?php endif; ?>

                <a class="inline-link" href="<?= e($pageImage) ?>" target="_blank" rel="noopener noreferrer">Seite separat öffnen</a>

                <?php if ($currentPage < $pageCount): ?>
                    <a class="cta cv-nav-link" href="/lebenslauf?seite=<?= $currentPage + 1 ?>">Weiter</a>
                <?php else: ?>
                    <span class="cv-nav-placeholder"></span>
                <?php endif; ?>
            </div>
        </article>
    <?php endif; ?>
</section>