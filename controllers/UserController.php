<?php

require_once __DIR__ . '/../models/entity/User.php';
require_once __DIR__ . '/../models/dao/UserDAO.php';
require_once __DIR__ . '/../middleware/Auth.php';
require_once __DIR__ . '/../middleware/Csrf.php';

class UserController
{
    // Action pour afficher la liste des lieux
    public function index(): void
    {
        require_once __DIR__ . '/../views/lieu/index.php';
    }

    // Action pour afficher le formulaire d'inscription
    public function register(): void
    {
        require_once __DIR__ . '/../views/auth/register.php';
    }

    // Action pour traiter l'inscription d'un nouvel utilisateur
    public function store(): void
    {
        // Vérifier que la requête est bien de type POST
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: index.php?controller=user&action=register');
            exit;
        }

        // Vérification du token CSRF
        $token = $_POST['csrf_token'] ?? null;
        if (!Csrf::validateToken($token)) {
            http_response_code(403);
            exit('Erreur CSRF : requête non autorisée.');
        }

        // Récupérer les données du formulaire
        $prenom = trim($_POST['prenom'] ?? '');
        $nom = trim($_POST['nom'] ?? '');
        $adresse = trim($_POST['adresse'] ?? '');
        $cp = trim($_POST['cp'] ?? '');
        $telephone = trim($_POST['telephone'] ?? '');
        $email = trim($_POST['email'] ?? '');
        $mp = $_POST['mp'] ?? '';
        $mpConfirm = $_POST['mp_confirm'] ?? '';

        if ($mp !== $mpConfirm) {
            die('Les mots de passe ne correspondent pas.');
        }

        $userDAO = new UserDAO();

        // Vérifier si l'email est déjà utilisé
        if ($userDAO->findByEmail($email) !== null) {
            die('Cette adresse email est déjà utilisée.');
        }

        $user = new User(
            null,
            $prenom,
            $nom,
            $adresse,
            $cp,
            $telephone,
            $email,
            $mp,
            'utilisateur',
            new DateTime()
        );

        if ($userDAO->create($user)) {
            header('Location: index.php?controller=user&action=login');
            exit;
        }

        die('Une erreur est survenue lors de la création du compte.');
    }

    // Action pour afficher le formulaire de connexion
    public function login(): void
    {
        require_once __DIR__ . '/../views/auth/login.php';
    }

    // Action pour traiter la connexion d'un utilisateur
    public function authenticate(): void
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: index.php?controller=user&action=login');
            exit;
        }

        // Vérification du token CSRF
        $token = $_POST['csrf_token'] ?? null;
        if (!Csrf::validateToken($token)) {
            http_response_code(403);
            exit('Erreur CSRF : requête non autorisée.');
        }

        $email = trim($_POST['email'] ?? '');
        $mp = $_POST['mp'] ?? '';

        $userDAO = new UserDAO();

        $user = $userDAO->findByEmail($email);

        if ($user === null || !password_verify($mp, $user->getUserMp())) {
            die('Email ou mot de passe incorrect.');
        }

        $_SESSION['user_id'] = $user->getUserId();
        $_SESSION['user_prenom'] = $user->getUserPrenom();
        $_SESSION['user_email'] = $user->getUserEmail();
        $_SESSION['user_role'] = $user->getUserRole();

        header('Location: index.php?controller=user&action=welcome');
        exit;
    }

    // Action pour afficher la page d'accueil après la connexion
    public function welcome(): void
    {
        require __DIR__ . '/../views/auth/welcome.php';
    }

    // Action pour déconnecter l'utilisateur
    public function logout(): void
    {
        // Vérifier que la requête est de type POST
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: index.php?controller=user&action=welcome');
            exit;
        }

        // Vérification du token CSRF
        $token = $_POST['csrf_token'] ?? null;

        if (!Csrf::validateToken($token)) {
            http_response_code(403);
            exit('Erreur CSRF : requête non autorisée.');
        }

        session_unset();
        session_destroy();

        header('Location: index.php?controller=user&action=login');
        exit;
    }
}