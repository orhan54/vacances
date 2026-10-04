<?php

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
        Auth::exigerAdmin();

        require_once __DIR__ . '/../views/lieux/create.php';
    }

    /**
     * Enregistre un nouveau lieu.
     */
    public function store(): void
    {
        Auth::exigerAdmin();

        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: index.php?controller=lieu&action=create');
            exit;
        }

        $nom = trim($_POST['nom'] ?? '');
        $adresse = trim($_POST['adresse'] ?? '');
        $cp = trim($_POST['cp'] ?? '');
        $telephone = trim($_POST['telephone'] ?? '');
        $description = trim($_POST['description'] ?? '');
        $prix = trim($_POST['prix'] ?? '');
        $image = trim($_POST['image'] ?? '');

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

        $lieuDAO = new LieuDAO();

        if ($lieuDAO->create($lieu)) {
            header('Location: index.php?controller=lieu&action=index');
            exit;
        }

        die('Une erreur est survenue lors de la création du lieu.');
    }

    /**
     * Affiche le formulaire de modification d'un lieu.
     *
     * @param int|string $id Identifiant du lieu.
     */
    public function edit($id): void
    {
        Auth::exigerAdmin();

        $lieuDAO = new LieuDAO();

        $lieu = $lieuDAO->read((int) $id);

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
        Auth::exigerAdmin();

        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: index.php?controller=lieu&action=index');
            exit;
        }

        $id = (int) ($_POST['id'] ?? 0);
        $nom = trim($_POST['nom'] ?? '');
        $adresse = trim($_POST['adresse'] ?? '');
        $cp = trim($_POST['cp'] ?? '');
        $telephone = trim($_POST['telephone'] ?? '');
        $description = trim($_POST['description'] ?? '');
        $prix = trim($_POST['prix'] ?? '');
        $image = trim($_POST['image'] ?? '');

        $lieuDAO = new LieuDAO();

        $lieuExistant = $lieuDAO->read($id);

        if ($lieuExistant === null) {
            die('Lieu introuvable.');
        }

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

        if ($lieuDAO->update($lieu)) {
            header('Location: index.php?controller=lieu&action=index');
            exit;
        }

        die('Une erreur est survenue lors de la modification du lieu.');
    }

    /**
     * Supprime un lieu.
     */
    public function delete(): void
    {
        Auth::exigerAdmin();

        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: index.php?controller=lieu&action=index');
            exit;
        }

        $id = (int) ($_POST['id'] ?? 0);

        $lieuDAO = new LieuDAO();

        $lieu = $lieuDAO->read($id);

        if ($lieu === null) {
            die('Lieu introuvable.');
        }

        if ($lieuDAO->delete($id)) {
            header('Location: index.php?controller=lieu&action=index');
            exit;
        }

        die('Une erreur est survenue lors de la suppression du lieu.');
    }
}
