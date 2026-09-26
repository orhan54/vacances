<?php

/**
 * Classe User pour représenter un utilisateur.
 */
class User
{
    private int $userId;
    private string $userPrenom;
    private string $userNom;
    private string $userAdresse;
    private string $userCp;
    private string $userTelephone;
    private string $userEmail;
    private string $userMp;
    private string $userRole;

    private DateTime $userCreatedAt;

    /**
     * Constructeur de la classe User.
     *
     * @param int $userId L'ID de l'utilisateur.
     * @param string $userPrenom Le prénom de l'utilisateur.
     * @param string $userNom Le nom de l'utilisateur.
     * @param string $userAdresse L'adresse de l'utilisateur.
     * @param string $userCp Le code postal de l'utilisateur.
     * @param string $userTelephone Le numéro de téléphone de l'utilisateur.
     * @param string $userEmail L'adresse e-mail de l'utilisateur.
     * @param string $userMp Le mot de passe de l'utilisateur.
     * @param string $userRole Le rôle de l'utilisateur.
     * @param DateTime $userCreatedAt La date de création de l'utilisateur.
     */
    public function __construct(
        int $userId,
        string $userPrenom,
        string $userNom,
        string $userAdresse,
        string $userCp,
        string $userTelephone,
        string $userEmail,
        string $userMp,
        string $userRole,
        DateTime $userCreatedAt
    ) {
        $this->userId = $userId;
        $this->userPrenom = $userPrenom;
        $this->userNom = $userNom;
        $this->userAdresse = $userAdresse;
        $this->userCp = $userCp;
        $this->userTelephone = $userTelephone;
        $this->userEmail = $userEmail;
        $this->userMp = $userMp;
        $this->userRole = $userRole;
        $this->userCreatedAt = $userCreatedAt;
    }

    /**
     * Getters et Setters pour les propriétés de l'utilisateur.
     */
    public function getUserId(): int
    {
        return $this->userId;
    }

    public function setUserPrenom(string $userPrenom): void
    {
        $this->userPrenom = $userPrenom;
    }

    public function getUserPrenom(): string
    {
        return $this->userPrenom;
    }

    public function setUserNom(string $userNom): void
    {
        $this->userNom = $userNom;
    }

    public function getUserNom(): string
    {
        return $this->userNom;
    }

    public function setUserAdresse(string $userAdresse): void
    {
        $this->userAdresse = $userAdresse;
    }

    public function getUserAdresse(): string
    {
        return $this->userAdresse;
    }

    public function setUserCp(string $userCp): void
    {
        $this->userCp = $userCp;
    }

    public function getUserCp(): string
    {
        return $this->userCp;
    }

    public function setUserTelephone(string $userTelephone): void
    {
        $this->userTelephone = $userTelephone;
    }

    public function getUserTelephone(): string
    {
        return $this->userTelephone;
    }

    public function setUserEmail(string $userEmail): void
    {
        $this->userEmail = $userEmail;
    }

    public function getUserEmail(): string
    {
        return $this->userEmail;
    }

    public function setUserMp(string $userMp): void
    {
        $this->userMp = $userMp;
    }

    public function getUserMp(): string
    {
        return $this->userMp;
    }

    public function getUserRole(): string
    {
        return $this->userRole;
    }

    public function getUserCreatedAt(): DateTime
    {
        return $this->userCreatedAt;
    }
}