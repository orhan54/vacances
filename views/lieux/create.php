<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create lieu</title>
</head>

<body>
    <h1>Create lieu</h1>

    <form action="index.php?controller=lieu&action=create.php" method="post">
        <label for="nom">Nom :</label>
        <input type="text" id="nom" name="nom" required>

        <label for="adresse">Adresse :</label>
        <input type="text" id="adresse" name="adresse" required>

        <label for="cp">Code postal :</label>
        <input type="text" id="cp" name="cp" required>

        <label for="telephone">Téléphone :</label>
        <input type="text" id="telephone" name="telephone" required>

        <label for="description">Description :</label>
        <textarea id="description" name="description" required></textarea>

        <label for="prix">Prix :</label>
        <input type="text" id="prix" name="prix" required>

        <label for="image">Image :</label>
        <input type="text" id="image" name="image">

        <button type="submit">Créer</button>
    </form>
</body>

</html>