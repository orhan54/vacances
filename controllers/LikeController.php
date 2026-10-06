<?php

/**
 * Contrôleur pour gérer les likes.
 */
require_once __DIR__ . '/../middleware/Auth.php';
require_once __DIR__ . '/../models/entity/Like.php';
require_once __DIR__ . '/../models/dao/LikeDAO.php';

class LikeController
{
    /**
     * Ajoute un like à un lieu.
     */
    public function toggle(): void
    {
        // Vérifier que l'utilisateur est connecté
        Auth::exigerConnexion();

        // Vérifier que la requête est bien de type POST
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: index.php');
            exit;
        }

        // Récupérer les données du formulaire
        $idUser = (int) ($_SESSION['user_id'] ?? 0);
        $idLieu = (int) ($_POST['id_lieu'] ?? 0);

        // Vérifier que l'ID du lieu est valide
        if ($idLieu <= 0) {
            header('Location: index.php');
            exit;
        }

        // Vérifier si l'utilisateur a déjà liké le lieu
        $likeDAO = new LikeDAO();
        $like = $likeDAO->findByUserAndLieu($idUser, $idLieu);

        // Si le like existe déjà, le supprimer (toggle), sinon créer un nouveau like
        if ($like) {
            // Si le like existe déjà, le supprimer (toggle)
            $likeDAO->deleteByUserAndLieu($idUser, $idLieu);
        } else {
            // Sinon, créer un nouveau like
            $like = new Like($idUser, $idLieu, new DateTime());
            $likeDAO->create($like);
        }

        // Rediriger vers la page du lieu après l'action
        header('Location: index.php?controller=lieu&action=show&id=' . $idLieu);
        exit;
    }
}