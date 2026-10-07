<?php

$lieu = $lieu ?? null;

?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Réserver un lieu</title>

    <link rel="stylesheet" href="public/css/reservations/style.css">

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
</head>

<body>

    <h1>Réserver un lieu</h1>

    <?php if ($lieu !== null): ?>

        <div class="reservation-form">

            <h2>
                <?= htmlspecialchars($lieu->getLieuNom()) ?>
            </h2>

            <p>
                <?= htmlspecialchars($lieu->getLieuAdresse()) ?>
            </p>

            <form method="POST" action="index.php?controller=reservation&action=store">

                <input type="hidden" name="id_lieu" value="<?= htmlspecialchars((string) $lieu->getLieuId()) ?>">

                <div>
                    <label for="reservation_date_debut">Date de début</label>
                    <input type="text" id="reservation_date_debut" name="reservation_date_debut"
                        placeholder="Choisir une date" required>
                </div>

                <div>
                    <label for="reservation_date_fin">Date de fin</label>
                    <input type="text" id="reservation_date_fin" name="reservation_date_fin" placeholder="Choisir une date"
                        required>
                </div>

                <button type="submit">
                    Confirmer la réservation
                </button>

            </form>

        </div>

    <?php else: ?>

        <p>Lieu introuvable.</p>

    <?php endif; ?>

    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>

    <script>
        window.reservations = <?= json_encode($reservations ?? []) ?>;
    </script>

    <script src="public/js/reservations/App.js"></script>

</body>

</html>