<?php
// Detailansicht fuer Zertifikate und Zeugnisse mit Ruecksprung zur Timeline.
/** @var string $certificateTitle */
/** @var int $certificateId */
/** @var string|null $pageImage */
/** @var int $currentPage */
/** @var int $pageCount */
?>
<section class="section container cv-page">
    <div class="cv-header">
        <p class="eyebrow">Zertifikat</p>
        <h1><?= e($certificateTitle) ?></h1>
        <?php if ($pageCount > 0): ?>
            <p class="subtle">Seite <?= e((string) $currentPage) ?> von <?= e((string) $pageCount) ?></p>
        <?php else: ?>
            <p class="subtle">Der Nachweis ist aktuell noch nicht hinterlegt.</p>
        <?php endif; ?>
        <p><a class="inline-link" href="/#zertifikate-timeline">Zurück zur Zertifikate Timeline</a></p>
    </div>

    <?php if ($pageImage !== null): ?>
        <article class="card cv-card">
            <!-- Aktuelle Nachweisseite gross anzeigen -->
            <a class="cv-image-link" href="<?= e($pageImage) ?>" target="_blank" rel="noopener noreferrer">
                <img class="cv-image" src="<?= e($pageImage) ?>" alt="<?= e($certificateTitle) ?> Seite <?= e((string) $currentPage) ?>">
            </a>

            <!-- Navigation fuer mehrseitige Zertifikatsnachweise -->
            <div class="cv-navigation">
                <?php if ($currentPage > 1): ?>
                    <a class="cta cv-nav-link" href="/zertifikat?id=<?= $certificateId ?>&seite=<?= $currentPage - 1 ?>">Zurück</a>
                <?php else: ?>
                    <span class="cv-nav-placeholder"></span>
                <?php endif; ?>

                <a class="inline-link" href="<?= e($pageImage) ?>" target="_blank" rel="noopener noreferrer">Seite separat öffnen</a>

                <?php if ($currentPage < $pageCount): ?>
                    <a class="cta cv-nav-link" href="/zertifikat?id=<?= $certificateId ?>&seite=<?= $currentPage + 1 ?>">Weiter</a>
                <?php else: ?>
                    <span class="cv-nav-placeholder"></span>
                <?php endif; ?>
            </div>
        </article>
    <?php endif; ?>
</section>