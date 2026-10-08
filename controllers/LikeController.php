<?php

require_once __DIR__ . '/../middleware/Auth.php';
require_once __DIR__ . '/../models/entity/Like.php';
require_once __DIR__ . '/../models/dao/LikeDAO.php';

class LikeController
{
    public function toggle(): void
    {
        Auth::exigerConnexion();

        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: index.php?controller=lieu&action=index');
            exit;
        }

        $idUser = (int) ($_SESSION['user_id'] ?? 0);
        $idLieu = (int) ($_POST['id_lieu'] ?? 0);

        if ($idLieu <= 0) {
            header('Location: index.php?controller=lieu&action=index');
            exit;
        }

        $likeDAO = new LikeDAO();

        // Vérifie si le like existe déjà
        $like = $likeDAO->findByUserAndLieu($idUser, $idLieu);

        if ($like) {

            // Supprime le like
            $likeDAO->deleteByUserAndLieu($idUser, $idLieu);

        } else {

            // Crée le like
            $like = new Like(
                $idUser,
                $idLieu,
                new DateTime()
            );

            $likeDAO->create($like);
        }

        /*
         * Redirection selon la page depuis laquelle
         * le bouton like a été utilisé.
         */
        $redirect = $_POST['redirect'] ?? 'index';

        if ($redirect === 'show') {

            header(
                'Location: index.php?controller=lieu&action=show&id=' . $idLieu
            );
            exit;
        }

        // Par défaut : retour à la liste des lieux
        header(
            'Location: index.php?controller=lieu&action=index'
        );
        exit;
    }
}