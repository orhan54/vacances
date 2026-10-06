<?php

/**
 * Contrôleur pour gérer les commentaires.
 */
require_once __DIR__ . '/../middleware/Auth.php';
require_once __DIR__ . '/../models/entity/Commenter.php';
require_once __DIR__ . '/../models/dao/CommenterDAO.php';

class CommenterController
{
    /**
     * Crée un nouveau commentaire.
     */
    public function store(): void
    {
        // Vérifier que l'utilisateur est connecté
        Auth::exigerConnexion();

        // Vérifier que la requête est bien de type POST
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: index.php');
            exit;
        }

        // Récupérer les données du formulaire
        $commentaire = trim($_POST['commentaire'] ?? '');
        $idUser = (int) ($_SESSION['user_id'] ?? 0);
        $idLieu = (int) ($_POST['id_lieu'] ?? 0);

        // Vérifier que le commentaire n'est pas vide et que l'ID du lieu est valide
        if (empty($commentaire) || $idLieu <= 0) {
            header('Location: index.php?controller=lieu&action=show&id=' . $idLieu);
            exit;
        }

        // Créer un nouvel objet Commenter
        $commenterDAO = new CommenterDAO();
        $commenter = new Commenter(
            $idUser,
            $idLieu,
            $commentaire,
            new DateTime()
        );

        // Enregistrer le commentaire
        if ($commenterDAO->create($commenter)) {
            header('Location: index.php?controller=lieu&action=show&id=' . $idLieu);
            exit;
        }

        die('Une erreur est survenue lors de la création du commentaire.');
    }

    /**
     * Met à jour un commentaire existant.
     */
    public function update(): void
    {
        // Vérifier que l'utilisateur est connecté
        Auth::exigerConnexion();

        // Vérifier que la requête est bien de type POST
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: index.php');
            exit;
        }

        // Récupérer les données
        $idUser = (int) ($_SESSION['user_id'] ?? 0);
        $idLieu = (int) ($_POST['id_lieu'] ?? 0);
        $contenu = trim($_POST['commentaire'] ?? '');

        // Vérifier les données
        if (empty($contenu) || $idLieu <= 0) {
            header('Location: index.php?controller=lieu&action=show&id=' . $idLieu);
            exit;
        }

        // Rechercher le commentaire existant
        $commenterDAO = new CommenterDAO();
        $commentaire = $commenterDAO->findByUserAndLieu($idUser, $idLieu);

        if ($commentaire === null) {
            die('Commentaire introuvable.');
        }

        // Modifier le contenu
        $commentaire->setCommenterContenu($contenu);

        // Enregistrer la modification
        if (!$commenterDAO->update($commentaire)) {
            die('Une erreur est survenue lors de la modification du commentaire.');
        }

        // Retour à la liste des lieux
        header('Location: index.php?controller=lieu&action=show&id=' . $idLieu);
        exit;
    }

    /**
     * Supprime un commentaire.
     */
    public function delete(): void
    {
        // Vérifier que l'utilisateur est connecté
        Auth::exigerConnexion();

        // Vérifier que la requête est bien de type POST
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: index.php');
            exit;
        }

        // Récupérer les données
        $idUser = (int) ($_SESSION['user_id'] ?? 0);
        $idLieu = (int) ($_POST['id_lieu'] ?? 0);

        // Vérifier que l'ID du lieu est valide
        if ($idLieu <= 0) {
            header('Location: index.php?controller=lieu&action=show&id=' . $idLieu);
            exit;
        }

        // Rechercher le commentaire
        $commenterDAO = new CommenterDAO();
        $commentaire = $commenterDAO->findByUserAndLieu($idUser, $idLieu);

        if ($commentaire === null) {
            die('Commentaire introuvable.');
        }

        // Supprimer le commentaire
        if (!$commenterDAO->deleteByUserAndLieu($idUser, $idLieu)) {
            die('Une erreur est survenue lors de la suppression du commentaire.');
        }

        // Retour à la liste des lieux
        header('Location: index.php?controller=lieu&action=index');
        exit;
    }
}