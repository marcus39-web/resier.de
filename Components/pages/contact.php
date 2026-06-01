<?php
/** @var array<int, string> $errors */
/** @var string|null $success */
?>
<section class="section container contact-wrap">
    <div>
        <p class="eyebrow">Kontakt</p>
        <h1>Schreib mir direkt</h1>
        <p>
            Das Formular ist bewusst in purem PHP gebaut: Validierung, CSRF-Token, XSS-Schutz und
            strukturierte Server-Logik ohne Plugin-Abhaengigkeiten.
        </p>
    </div>

    <div class="card">
        <?php if ($success !== null): ?>
            <p class="notice success"><?= e($success) ?></p>
        <?php endif; ?>

        <?php if (!empty($errors)): ?>
            <div class="notice error">
                <strong>Bitte pruefe deine Eingabe:</strong>
                <ul>
                    <?php foreach ($errors as $error): ?>
                        <li><?= e($error) ?></li>
                    <?php endforeach; ?>
                </ul>
            </div>
        <?php endif; ?>

        <form method="post" action="/contact" class="form-grid" novalidate>
            <input type="hidden" name="_csrf" value="<?= e(csrf_token()) ?>">

            <label for="name">Name</label>
            <input id="name" name="name" type="text" value="<?= old('name') ?>" required minlength="2">

            <label for="email">E-Mail</label>
            <input id="email" name="email" type="email" value="<?= old('email') ?>" required>

            <label for="message">Nachricht</label>
            <textarea id="message" name="message" rows="6" required minlength="20"><?= old('message') ?></textarea>

            <input class="hp" type="text" name="website" value="" tabindex="-1" autocomplete="off" aria-hidden="true">

            <button type="submit">Nachricht senden</button>
        </form>
    </div>
</section>
