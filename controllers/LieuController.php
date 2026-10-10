<?php

/**
 * Contrôleur pour gérer les lieux.
 */
require_once __DIR__ . '/../middleware/Auth.php';
require_once __DIR__ . '/../models/entity/Lieu.php';
require_once __DIR__ . '/../models/dao/LieuDAO.php';
require_once __DIR__ . '/../models/dao/LikeDAO.php';
require_once __DIR__ . '/../models/dao/CommenterDAO.php';
require_once __DIR__ . '/../middleware/Csrf.php';

class LieuController
{
    /**
     * Affiche la liste des lieux.
     */
    public function index(): void
    {
        $lieuDAO = new LieuDAO();
        $likeDAO = new LikeDAO();
        $commenterDAO = new CommenterDAO();

        // Récupère tous les lieux
        $lieux = $lieuDAO->findAll();

        // ID de l'utilisateur connecté
        $userId = $_SESSION['user_id'] ?? null;

        // Informations sur les likes de chaque lieu
        $likes = [];

        // Moyenne des notes et nombre d'avis de chaque lieu
        $ratings = [];

        foreach ($lieux as $lieu) {

            $lieuId = $lieu->getLieuId();

            $likes[$lieuId] = [
                'count' => $likeDAO->countByLieu($lieuId),
                'liked' => $userId !== null
                    ? $likeDAO->exists((int) $userId, $lieuId)
                    : false
            ];

            $ratings[$lieuId] = $commenterDAO->getRatingStatsByLieuId($lieuId);
        }

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

        // Vérification du token CSRF
        $token = $_POST['csrf_token'] ?? null;
        if (!Csrf::validateToken($token)) {
            http_response_code(403);
            exit('Erreur CSRF : requête non autorisée.');
        }

        // Récupère et nettoie les données du formulaire
        $nom = trim($_POST['nom'] ?? '');
        $adresse = trim($_POST['adresse'] ?? '');
        $cp = trim($_POST['cp'] ?? '');
        $telephone = trim($_POST['telephone'] ?? '');
        $description = trim($_POST['description'] ?? '');
        $prix = trim($_POST['prix'] ?? '');

        // Vérifie qu'une image a bien été envoyée
        if (!isset($_FILES['image']) || $_FILES['image']['error'] !== UPLOAD_ERR_OK) {
            die('Une image est obligatoire.');
        }

        $image = $_FILES['image'];

        // Vérifie la taille maximale : 5 Mo
        if ($image['size'] > 5 * 1024 * 1024) {
            die('L\'image ne doit pas dépasser 5 Mo.');
        }

        // Vérifie le type MIME réel du fichier
        $finfo = new finfo(FILEINFO_MIME_TYPE);
        $mimeType = $finfo->file($image['tmp_name']);

        $typesAutorises = [
            'image/jpeg' => 'jpg',
            'image/png' => 'png',
            'image/webp' => 'webp'
        ];

        if (!isset($typesAutorises[$mimeType])) {
            die('Format d\'image non autorisé. Utilisez JPG, PNG ou WEBP.');
        }

        // Génère un nom de fichier unique
        $extension = $typesAutorises[$mimeType];
        $nomFichier = bin2hex(random_bytes(16)) . '.' . $extension;

        // Chemin physique du dossier images
        $dossierImages = __DIR__ . '/../public/images/';

        // Vérifie que le dossier existe
        if (!is_dir($dossierImages)) {
            die('Le dossier public/images est introuvable.');
        }

        // Chemin physique complet du fichier
        $cheminFichier = $dossierImages . $nomFichier;

        // Déplace l'image vers public/images/
        if (!move_uploaded_file($image['tmp_name'], $cheminFichier)) {
            die('Impossible d\'enregistrer l\'image.');
        }

        // Chemin qui sera enregistré dans la base de données
        $cheminImage = 'public/images/' . $nomFichier;

        // Crée l'objet Lieu
        $lieu = new Lieu(
            null,
            $nom,
            $adresse,
            $cp,
            $telephone,
            $description,
            (float) $prix,
            $cheminImage,
            new DateTime()
        );

        // Crée une instance de LieuDAO
        $lieuDAO = new LieuDAO();

        // Enregistre le lieu
        if ($lieuDAO->create($lieu)) {
            header('Location: index.php?controller=lieu&action=index');
            exit;
        }

        // Si la création échoue, supprime l'image qui vient d'être uploadée
        if (file_exists($cheminFichier)) {
            unlink($cheminFichier);
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

        // Vérification du token CSRF
        $token = $_POST['csrf_token'] ?? null;

        if (!Csrf::validateToken($token)) {
            http_response_code(403);
            exit('Erreur CSRF : requête non autorisée.');
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

        // Vérifie que l'identifiant du lieu est valide
        if ($id <= 0) {
            http_response_code(400);
            exit('Identifiant du lieu invalide.');
        }

        // Crée une instance de LieuDAO
        $lieuDAO = new LieuDAO();

        // Récupère le lieu existant pour conserver la date de création
        $lieuExistant = $lieuDAO->read($id);

        if ($lieuExistant === null) {
            http_response_code(404);
            exit('Lieu introuvable.');
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

        // Met à jour le lieu dans la base de données
        if ($lieuDAO->update($lieu)) {
            header('Location: index.php?controller=lieu&action=index');
            exit;
        }

        http_response_code(500);
        exit('Une erreur est survenue lors de la modification du lieu.');
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

        // Vérification du token CSRF
        $token = $_POST['csrf_token'] ?? null;
        if (!Csrf::validateToken($token)) {
            http_response_code(403);
            exit('Erreur CSRF : requête non autorisée.');
        }

        $id = (int) ($_POST['id'] ?? 0);

        if ($id <= 0) {
            die('Identifiant du lieu invalide.');
        }

        $lieuDAO = new LieuDAO();

        // Récupérer le lieu avant suppression
        $lieu = $lieuDAO->read($id);

        if ($lieu === null) {
            die('Lieu introuvable.');
        }

        // Récupérer le chemin de l'image
        $cheminImage = $lieu->getLieuImage();

        // Supprimer le lieu de la base de données
        if (!$lieuDAO->delete($id)) {
            die('Une erreur est survenue lors de la suppression du lieu.');
        }

        // Supprimer l'image physique après la suppression BDD
        if (!empty($cheminImage)) {

            $cheminFichier = __DIR__ . '/../' . $cheminImage;

            if (file_exists($cheminFichier)) {
                unlink($cheminFichier);
            }
        }

        // Retour à la liste des lieux
        header('Location: index.php?controller=lieu&action=index');
        exit;
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
