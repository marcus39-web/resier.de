<section class="legal">
    <div class="container">
        <?php
        $legalName = (string) ($profile['name'] ?? 'Marcus Reiser');
        $legalAddress = (string) ($profile['location'] ?? 'Deutschland');
        ?>

        <article class="card">
            <h1>Impressum</h1>
            <p>Angaben gemaess § 5 TMG.</p>
        </article>

        <article class="card">
            <h2>Anbieter</h2>
            <p>
                <?= e($legalName) ?><br>
                <?= e($legalAddress) ?>
            </p>
        </article>

        <article class="card">
            <h2>Kontakt</h2>
            <p>
                E-Mail: <a href="mailto:<?= e((string) ($profile['email'] ?? 'kontakt@marcusreiser.de')) ?>"><?= e((string) ($profile['email'] ?? 'kontakt@marcusreiser.de')) ?></a>
            </p>
            <p>
                Telefon: <?= e((string) ($profile['phone'] ?? 'auf Anfrage')) ?>
            </p>
        </article>

        <article class="card">
            <h2>Datenschutzhinweis</h2>
            <p>
                Informationen zur Verarbeitung von Kontaktanfragen, zu Speicherdauer und Loeschfristen finden Sie in der
                <a href="/datenschutz">Datenschutzerklaerung</a>.
            </p>
        </article>

    </div>
</section>
