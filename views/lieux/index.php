<?php foreach ($lieux as $lieu): ?>

    <div class="lieu">

        <p>
            <?= htmlspecialchars($lieu->getLieuNom()) ?>
        </p>

        <p>
            <?= htmlspecialchars($lieu->getLieuAdresse()) ?>
        </p>

        <a href="index.php?controller=reservation&action=create&id=<?= $lieu->getLieuId() ?>">
            Réserver
        </a>

    </div>

<?php endforeach; ?>