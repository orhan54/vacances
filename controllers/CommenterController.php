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
        $note = (int) ($_POST['note'] ?? 0);
        $idUser = (int) ($_SESSION['user_id'] ?? 0);
        $idLieu = (int) ($_POST['id_lieu'] ?? 0);

        // Vérifier que le commentaire n'est pas vide,
        // que l'ID du lieu est valide et que la note est comprise entre 1 et 5
        if (
            empty($commentaire)
            || $idLieu <= 0
            || $note < 1
            || $note > 5
        ) {
            header('Location: index.php?controller=lieu&action=show&id=' . $idLieu);
            exit;
        }

        // Créer un nouvel objet Commenter
        $commenterDAO = new CommenterDAO();

        $commenter = new Commenter(
            $idUser,
            $idLieu,
            $commentaire,
            $note,
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
        $note = (int) ($_POST['note'] ?? 0);

        // Vérifier les données
        if (
            empty($contenu)
            || $idLieu <= 0
            || $note < 1
            || $note > 5
        ) {
            header('Location: index.php?controller=lieu&action=show&id=' . $idLieu);
            exit;
        }

        // Rechercher le commentaire existant
        $commenterDAO = new CommenterDAO();
        $commentaire = $commenterDAO->findByUserAndLieu($idUser, $idLieu);

        if ($commentaire === null) {
            die('Commentaire introuvable.');
        }

        // Modifier le contenu et la note
        $commentaire->setCommenterContenu($contenu);
        $commentaire->setNote($note);

        // Enregistrer la modification
        if (!$commenterDAO->update($commentaire)) {
            die('Une erreur est survenue lors de la modification du commentaire.');
        }

        // Retour au détail du lieu
        header('Location: index.php?controller=lieu&action=show&id=' . $idLieu);
        exit;
    }

    // Supprimer un commentaire
    public function delete(): void
    {
        Auth::exigerConnexion();

        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: index.php');
            exit;
        }

        $idUserConnecte = (int) ($_SESSION['user_id'] ?? 0);
        $idLieu = (int) ($_POST['id_lieu'] ?? 0);

        if ($idLieu <= 0) {
            header('Location: index.php?controller=lieu&action=index');
            exit;
        }

        // Détermine l'utilisateur concerné par le commentaire
        if (Auth::estAdmin()) {
            $idUserCommentaire = (int) ($_POST['id_user'] ?? 0);
        } else {
            $idUserCommentaire = $idUserConnecte;
        }

        if ($idUserCommentaire <= 0) {
            die('Identifiant utilisateur invalide.');
        }

        $commenterDAO = new CommenterDAO();

        $commentaire = $commenterDAO->findByUserAndLieu(
            $idUserCommentaire,
            $idLieu
        );

        if ($commentaire === null) {
            die('Commentaire introuvable.');
        }

        if (
            !$commenterDAO->deleteByUserAndLieu(
                $idUserCommentaire,
                $idLieu
            )
        ) {
            die('Une erreur est survenue lors de la suppression du commentaire.');
        }

        header(
            'Location: index.php?controller=lieu&action=show&id=' . $idLieu
        );
        exit;
    }
}