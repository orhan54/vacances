<?php

$prenom = $_SESSION['user_prenom'] ?? 'Utilisateur';

?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Connexion réussie</title>

    <link rel="stylesheet" href="public/css/auth/style.css">
</head>

<body>

    <div class="welcome-container">

        <h1>Connexion réussie !</h1>

        <p>
            Bienvenue
            <strong><?= htmlspecialchars($prenom) ?></strong>
        </p>

        <div class="actions">

            <a href="index.php?controller=lieu&action=index" class="button">
                Voir les lieux à réserver
            </a>

            <a href="index.php?controller=reservation&action=index" class="button">
                Voir mes réservations
            </a>

        </div>

    </div>

</body>

</html>