<?php

require_once __DIR__ . '/../middleware/Auth.php';
require_once __DIR__ . '/../models/entity/Like.php';
require_once __DIR__ . '/../models/dao/LikeDAO.php';
require_once __DIR__ . '/../middleware/Csrf.php';

class LikeController
{
    /**
     * Ajoute ou retire un like.
     */
    public function toggle(): void
    {
        Auth::exigerConnexion();

        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: index.php?controller=lieu&action=index');
            exit;
        }

        // Vérification du token CSRF.
        $token = $_POST['csrf_token'] ?? null;

        if (!Csrf::validateToken($token)) {
            http_response_code(403);
            exit('Erreur CSRF : requête non autorisée.');
        }

        $idUser = (int) ($_SESSION['user_id'] ?? 0);
        $idLieu = (int) ($_POST['id_lieu'] ?? 0);

        if ($idUser <= 0 || $idLieu <= 0) {
            header('Location: index.php?controller=lieu&action=index');
            exit;
        }

        $likeDAO = new LikeDAO();

        // Vérifier si le like existe déjà.
        $like = $likeDAO->findByUserAndLieu($idUser, $idLieu);

        if ($like) {
            // Retirer le like.
            $likeDAO->deleteByUserAndLieu($idUser, $idLieu);
        } else {
            // Créer le like.
            $like = new Like(
                $idUser,
                $idLieu,
                new DateTime()
            );

            $likeDAO->create($like);
        }

        // Redirection selon la page d'origine.
        $redirect = $_POST['redirect'] ?? 'index';

        if ($redirect === 'show') {
            header(
                'Location: index.php?controller=lieu&action=show&id=' . $idLieu
            );
            exit;
        }

        header('Location: index.php?controller=lieu&action=index');
        exit;
    }
}
