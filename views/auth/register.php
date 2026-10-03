<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inscription</title>
</head>

<body>

    <h1>Inscription</h1>

    <form action="index.php?controller=user&action=store" method="post">

        <label for="prenom">Prénom :</label>
        <input type="text" id="prenom" name="prenom" required>

        <label for="nom">Nom :</label>
        <input type="text" id="nom" name="nom" required>

        <label for="adresse">Adresse :</label>
        <input type="text" id="adresse" name="adresse" required>

        <label for="cp">Code postal :</label>
        <input type="text" id="cp" name="cp" required>

        <label for="telephone">Téléphone :</label>
        <input type="text" id="telephone" name="telephone" required>

        <label for="email">Email :</label>
        <input type="email" id="email" name="email" required>

        <label for="mp">Mot de passe :</label>
        <input type="password" id="mp" name="mp" required>

        <label for="mp_confirm">Confirmer le mot de passe :</label>
        <input type="password" id="mp_confirm" name="mp_confirm" required>

        <button type="submit">S'inscrire</button>

    </form>

</body>

</html>