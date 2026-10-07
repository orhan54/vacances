<?php

/**
 * Contrôleur pour gérer les lieux.
 */
require_once __DIR__ . '/../middleware/Auth.php';
require_once __DIR__ . '/../models/entity/Lieu.php';
require_once __DIR__ . '/../models/dao/LieuDAO.php';

class LieuController
{
    /**
     * Affiche la liste des lieux.
     */
    public function index(): void
    {
        $lieuDAO = new LieuDAO();

        $lieux = $lieuDAO->findAll();

        require_once __DIR__ . '/../views/lieux/index.php';
    }

    /**
     * Affiche le formulaire de création d'un lieu.
     */
    public function create(): void
    {
        // Vérifie si l'utilisateur est un administrateur
        Auth::exigerAdmin();

        require_once __DIR__ . '/../views/lieux/create.php';
    }

    /**
     * Enregistre un nouveau lieu.
     */
    public function store(): void
    {
        // Vérifie si l'utilisateur est un administrateur
        Auth::exigerAdmin();

        // Vérifie si la requête est de type POST
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: index.php?controller=lieu&action=create');
            exit;
        }

        // Récupère et nettoie les données du formulaire
        $nom = trim($_POST['nom'] ?? '');
        $adresse = trim($_POST['adresse'] ?? '');
        $cp = trim($_POST['cp'] ?? '');
        $telephone = trim($_POST['telephone'] ?? '');
        $description = trim($_POST['description'] ?? '');
        $prix = trim($_POST['prix'] ?? '');
        $image = trim($_POST['image'] ?? '');

        // Crée un nouvel objet Lieu
        $lieu = new Lieu(
            null,
            $nom,
            $adresse,
            $cp,
            $telephone,
            $description,
            (float) $prix,
            $image,
            new DateTime()
        );

        // Crée une instance de LieuDAO pour interagir avec la base de données
        $lieuDAO = new LieuDAO();

        // Tente de créer le lieu dans la base de données
        if ($lieuDAO->create($lieu)) {
            header('Location: index.php?controller=lieu&action=index');
            exit;
        }

        // Si la création échoue, affiche un message d'erreur
        die('Une erreur est survenue lors de la création du lieu.');
    }

    /**
     * Affiche le formulaire de modification d'un lieu.
     *
     * @param int|string $id Identifiant du lieu.
     */
    public function edit($id): void
    {
        // Vérifie si l'utilisateur est un administrateur
        Auth::exigerAdmin();

        // Crée une instance de LieuDAO pour interagir avec la base de données
        $lieuDAO = new LieuDAO();

        // Récupère le lieu à modifier
        $lieu = $lieuDAO->read((int) $id);

        // Si le lieu n'existe pas, affiche un message d'erreur
        if ($lieu === null) {
            die('Lieu introuvable.');
        }

        require_once __DIR__ . '/../views/lieux/edit.php';
    }

    /**
     * Met à jour un lieu.
     */
    public function update(): void
    {
        // Vérifie si l'utilisateur est un administrateur
        Auth::exigerAdmin();

        // Vérifie si la requête est de type POST
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: index.php?controller=lieu&action=index');
            exit;
        }

        // Récupère et nettoie les données du formulaire
        $id = (int) ($_POST['id'] ?? 0);
        $nom = trim($_POST['nom'] ?? '');
        $adresse = trim($_POST['adresse'] ?? '');
        $cp = trim($_POST['cp'] ?? '');
        $telephone = trim($_POST['telephone'] ?? '');
        $description = trim($_POST['description'] ?? '');
        $prix = trim($_POST['prix'] ?? '');
        $image = trim($_POST['image'] ?? '');

        // Vérifie si l'utilisateur est un administrateur
        Auth::exigerAdmin();

        // Crée une instance de LieuDAO pour interagir avec la base de données
        $lieuDAO = new LieuDAO();

        // Récupère le lieu existant pour conserver la date de création
        $lieuExistant = $lieuDAO->read($id);

        // Si le lieu n'existe pas, affiche un message d'erreur
        if ($lieuExistant === null) {
            die('Lieu introuvable.');
        }

        // Crée un nouvel objet Lieu avec les données mises à jour
        $lieu = new Lieu(
            $id,
            $nom,
            $adresse,
            $cp,
            $telephone,
            $description,
            (float) $prix,
            $image,
            $lieuExistant->getLieuCreatedAt()
        );

        // Tente de mettre à jour le lieu dans la base de données
        if ($lieuDAO->update($lieu)) {
            header('Location: index.php?controller=lieu&action=index');
            exit;
        }

        // Si la mise à jour échoue, affiche un message d'erreur
        die('Une erreur est survenue lors de la modification du lieu.');
    }

    /**
     * Supprime un lieu.
     */
    public function delete(): void
    {
        // Vérifie si l'utilisateur est un administrateur
        Auth::exigerAdmin();

        // Vérifie si la requête est de type POST
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: index.php?controller=lieu&action=index');
            exit;
        }

        // Récupère l'identifiant du lieu à supprimer
        $id = (int) ($_POST['id'] ?? 0);

        // Crée une instance de LieuDAO pour interagir avec la base de données
        $lieuDAO = new LieuDAO();

        // Récupère le lieu à supprimer
        $lieu = $lieuDAO->read($id);

        // Si le lieu n'existe pas, affiche un message d'erreur
        if ($lieu === null) {
            die('Lieu introuvable.');
        }

        // Tente de supprimer le lieu dans la base de données
        if ($lieuDAO->delete($id)) {
            header('Location: index.php?controller=lieu&action=index');
            exit;
        }

        // Si la suppression échoue, affiche un message d'erreur
        die('Une erreur est survenue lors de la suppression du lieu.');
    }

    /**
     * Affiche les détails d'un lieu.
     *
     * @param int|string $id Identifiant du lieu.
     */
    public function show($id): void
    {
        // Crée une instance de LieuDAO pour interagir avec la base de données
        $lieuDAO = new LieuDAO();

        // Récupère le lieu à afficher
        $lieu = $lieuDAO->read((int) $id);

        // Si le lieu n'existe pas, affiche un message d'erreur
        if ($lieu === null) {
            die('Lieu introuvable.');
        }

        require_once __DIR__ . '/../views/lieux/show.php';
    }
}
