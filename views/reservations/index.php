<?php

$reservations = $reservations ?? [];

?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Mes réservations</title>

    <link rel="stylesheet" href="public/css/reservation/style.css">
</head>

<body>

    <h1>Mes réservations</h1>

    <?php if (empty($reservations)): ?>

        <div class="message">
            <p>Aucune réservation trouvée.</p>
        </div>

    <?php else: ?>

        <?php foreach ($reservations as $reservation): ?>

            <div class="reservation">

                <p>
                    <strong>ID réservation :</strong>
                    <?= htmlspecialchars((string) $reservation->getReservationId()) ?>
                </p>

                <p>
                    <strong>ID utilisateur :</strong>
                    <?= htmlspecialchars((string) $reservation->getUserId()) ?>
                </p>

                <p>
                    <strong>ID lieu :</strong>
                    <?= htmlspecialchars((string) $reservation->getLieuId()) ?>
                </p>

                <p>
                    <strong>Date de début :</strong>
                    <?= htmlspecialchars(
                        $reservation->getReservationDateDebut()->format('d/m/Y H:i')
                    ) ?>
                </p>

                <p>
                    <strong>Date de fin :</strong>
                    <?= htmlspecialchars(
                        $reservation->getReservationDateFin()->format('d/m/Y H:i')
                    ) ?>
                </p>

                <p>
                    <strong>Statut :</strong>

                    <span class="status <?= htmlspecialchars($reservation->getReservationStatus()) ?>">
                        <?= htmlspecialchars($reservation->getReservationStatus()) ?>
                    </span>
                </p>

                <?php if ($reservation->getReservationStatus() === 'confirmee'): ?>

                    <form method="POST" action="index.php?controller=reservation&action=cancel"
                        onsubmit="return confirm('Voulez-vous vraiment annuler cette réservation ?');">

                        <input type="hidden" name="id" value="<?= htmlspecialchars(
                            (string) $reservation->getReservationId()
                        ) ?>">

                        <button type="submit">
                            Annuler la réservation
                        </button>

                    </form>

                <?php else: ?>

                    <p class="annulee-message">
                        Cette réservation est annulée.
                    </p>

                <?php endif; ?>

            </div>

        <?php endforeach; ?>

    <?php endif; ?>

</body>

</html>