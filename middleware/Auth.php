<?php

class Auth
{
    /**
     * Vérifie si l'utilisateur est connecté.
     *
     * @return bool True si l'utilisateur est connecté, false sinon.
     */
    public static function estConnecte(): bool
    {
        return isset($_SESSION['user_id']);
    }

    /**
     * Vérifie si l'utilisateur est un administrateur.
     *
     * @return bool True si l'utilisateur est un administrateur, false sinon.
     */
    public static function estAdmin(): bool
    {
        return self::estConnecte() && $_SESSION['user_role'] === 'admin';
    }

    /**
     * Exige que l'utilisateur soit connecté pour accéder à une page.
     * Redirige vers la page de connexion si l'utilisateur n'est pas connecté.
     */
    public static function exigerConnexion(): void
    {
        if (!self::estConnecte()) {
            header('Location: index.php?controller=user&action=login');
            exit;
        }
    }

    /**
     * Exige que l'utilisateur soit un administrateur pour accéder à une page.
     * Redirige vers la page d'accueil si l'utilisateur n'est pas un administrateur.
     */
    public static function exigerAdmin(): void
    {
        self::exigerConnexion();

        if (!self::estAdmin()) {
            header('Location: index.php?controller=lieu&action=index');
            exit;
        }
    }
}