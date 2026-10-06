<?php

require_once __DIR__ . '/../../middleware/Auth.php';
require_once __DIR__ . '/../../models/dao/LikeDAO.php';
require_once __DIR__ . '/../../models/dao/CommenterDAO.php';

$likeDAO = new LikeDAO();
$commenterDAO = new CommenterDAO();

$idUser = (int) ($_SESSION['user_id'] ?? 0);
$idLieu = $lieu->getLieuId();

/*
 * Récupération du Like de l'utilisateur connecté.
 */
$like = null;

if ($idUser > 0) {
    $like = $likeDAO->findByUserAndLieu($idUser, $idLieu);
}

/*
 * Récupération des commentaires du lieu.
 *
 * Si ton CommenterDAO utilise un autre nom de méthode,
 * il faudra simplement modifier cette ligne.
 */
$commentaires = $commenterDAO->findByLieu($idLieu);

?>

<!DOCTYPE html>
<html lang="fr">

<head>

    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>
        <?= htmlspecialchars($lieu->getLieuNom()) ?>
    </title>

</head>

<body>

    <h1>
        <?= htmlspecialchars($lieu->getLieuNom()) ?>
    </h1>


    <!-- INFORMATIONS DU LIEU -->

    <h2>Informations</h2>

    <p>
        <strong>Adresse :</strong>
        <?= htmlspecialchars($lieu->getLieuAdresse()) ?>
    </p>

    <p>
        <strong>Code postal :</strong>
        <?= htmlspecialchars($lieu->getLieuCp()) ?>
    </p>

    <p>
        <strong>Téléphone :</strong>
        <?= htmlspecialchars($lieu->getLieuTelephone()) ?>
    </p>

    <p>
        <strong>Description :</strong><br>

        <?= nl2br(htmlspecialchars($lieu->getLieuDescription())) ?>
    </p>

    <p>
        <strong>Prix :</strong>
        <?= htmlspecialchars($lieu->getLieuPrix()) ?> €
    </p>


    <hr>


    <!-- LIKE -->

    <h2>Like</h2>

    <?php if ($idUser > 0): ?>

        <form action="index.php?controller=like&action=toggle" method="POST">

            <input type="hidden" name="id_lieu" value="<?= $idLieu ?>">

            <button type="submit">

                <?php if ($like): ?>

                    💔 Retirer le Like

                <?php else: ?>

                    ❤️ Liker ce lieu

                <?php endif; ?>

            </button>

        </form>

    <?php else: ?>

        <p>
            Connectez-vous pour liker ce lieu.
        </p>

    <?php endif; ?>


    <hr>


    <!-- COMMENTAIRES -->

    <h2>
        Commentaires
    </h2>


    <?php if (!empty($commentaires)): ?>

        <?php foreach ($commentaires as $commentaire): ?>

            <div>

                <p>

                    <strong>
                        Utilisateur #<?= $commentaire->getUserId() ?>
                    </strong>

                </p>

                <p>
                    <?= nl2br(
                        htmlspecialchars(
                            $commentaire->getCommenterContenu()
                        )
                    ) ?>
                </p>


                <?php if ($idUser === (int) $commentaire->getUserId()): ?>

                    <!-- MODIFIER -->

                    <form action="index.php?controller=commenter&action=update" method="POST">

                        <input type="hidden" name="id_lieu" value="<?= $idLieu ?>">

                        <textarea name="commentaire" rows="4" cols="50"><?= htmlspecialchars(
                            $commentaire->getCommenterContenu()
                        ) ?></textarea>

                        <br>

                        <button type="submit">
                            Modifier
                        </button>

                    </form>


                    <!-- SUPPRIMER -->

                    <form action="index.php?controller=commenter&action=delete" method="POST">

                        <input type="hidden" name="id_lieu" value="<?= $idLieu ?>">

                        <button type="submit">
                            Supprimer
                        </button>

                    </form>

                <?php endif; ?>

            </div>

            <hr>

        <?php endforeach; ?>

    <?php else: ?>

        <p>
            Aucun commentaire pour le moment.
        </p>

    <?php endif; ?>


    <!-- AJOUTER UN COMMENTAIRE -->

    <?php if ($idUser > 0): ?>

        <h3>
            Ajouter un commentaire
        </h3>

        <form action="index.php?controller=commenter&action=store" method="POST">

            <input type="hidden" name="id_lieu" value="<?= $idLieu ?>">

            <textarea name="commentaire" rows="5" cols="50" placeholder="Votre commentaire..." required></textarea>

            <br><br>

            <button type="submit">
                Ajouter le commentaire
            </button>

        </form>

    <?php else: ?>

        <p>
            Connectez-vous pour laisser un commentaire.
        </p>

    <?php endif; ?>


    <hr>


    <!-- RETOUR -->

    <p>

        <a href="index.php?controller=lieu&action=index">
            ← Retour à la liste des lieux
        </a>

    </p>


</body>

</html>