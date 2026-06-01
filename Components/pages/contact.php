<?php
// Kontaktseite fuer Schulen und Bildungstraeger mit Formular und Direktdaten.
/** @var array<string, mixed> $profile */
/** @var array<int, string> $errors */
/** @var string|null $success */
?>
<section class="section container contact-wrap">
    <div>
        <p class="eyebrow">Kontakt</p>
        <h1>Anfrage für Schulen und Bildungsträger</h1>
        <p>
            Wenn Sie einen Dozenten oder Lernprozessbegleiter für kaufmännische Bildung, IT-Grundlagen,
            Prüfungsvorbereitung oder berufliche Qualifizierung suchen, freue ich mich über Ihre Nachricht.
        </p>
        <div class="card contact-facts">
            <!-- Direkte Kontaktdaten fuer schnelle Rueckmeldung ohne Formular -->
            <p><strong>Zielrolle:</strong> <?= e((string) ($profile['targetRole'] ?? '')) ?></p>
            <p><strong>Region:</strong> <?= e((string) ($profile['targetRegion'] ?? '')) ?></p>
            <p><strong>Telefon:</strong> <a href="tel:<?= e((string) ($profile['phone'] ?? '')) ?>"><?= e((string) ($profile['phone'] ?? '')) ?></a></p>
            <p><strong>E-Mail:</strong> <a href="mailto:<?= e((string) ($profile['email'] ?? '')) ?>"><?= e((string) ($profile['email'] ?? '')) ?></a></p>
        </div>
    </div>

    <div class="card">
        <?php if ($success !== null): ?>
            <p class="notice success"><?= e($success) ?></p>
        <?php endif; ?>

        <?php if (!empty($errors)): ?>
            <div class="notice error">
                <strong>Bitte prüfen Sie Ihre Eingabe:</strong>
                <ul>
                    <?php foreach ($errors as $error): ?>
                        <li><?= e($error) ?></li>
                    <?php endforeach; ?>
                </ul>
            </div>
        <?php endif; ?>

        <!-- Formular bleibt serverseitig validiert und CSRF-geschuetzt -->
        <form method="post" action="/contact" class="form-grid" novalidate>
            <input type="hidden" name="_csrf" value="<?= e(csrf_token()) ?>">

            <label for="name">Name</label>
            <input id="name" name="name" type="text" value="<?= old('name') ?>" required minlength="2">

            <label for="email">E-Mail</label>
            <input id="email" name="email" type="email" value="<?= old('email') ?>" required>

            <label for="message">Nachricht</label>
            <textarea id="message" name="message" rows="6" required minlength="20"><?= old('message') ?></textarea>

            <input class="hp" type="text" name="website" value="" tabindex="-1" autocomplete="off" aria-hidden="true">

            <button type="submit">Anfrage senden</button>
        </form>
    </div>
</section>
