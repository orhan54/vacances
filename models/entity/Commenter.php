<?php

class Commenter
{
    // Propriétés de la classe Commenter
    private int $userId;
    private int $lieuId;

    private string $commenterContenu;
    private int $note;
    private DateTime $commenterCreatedAt;

    /**
     * Constructeur de la classe Commenter.
     *
     * @param int $userId L'ID de l'utilisateur qui a fait le commentaire.
     * @param int $lieuId L'ID du lieu commenté.
     * @param string $commenterContenu Le contenu du commentaire.
     * @param int $note La note attribuée au lieu, de 1 à 5.
     * @param DateTime $commenterCreatedAt La date de création du commentaire.
     */
    public function __construct(
        int $userId,
        int $lieuId,
        string $commenterContenu,
        int $note,
        DateTime $commenterCreatedAt
    ) {
        $this->userId = $userId;
        $this->lieuId = $lieuId;
        $this->commenterContenu = $commenterContenu;
        $this->note = $note;
        $this->commenterCreatedAt = $commenterCreatedAt;
    }

    /**
     * Getters et Setters pour les propriétés du commentaire.
     */
    public function getUserId(): int
    {
        return $this->userId;
    }

    public function getLieuId(): int
    {
        return $this->lieuId;
    }

    public function getCommenterContenu(): string
    {
        return $this->commenterContenu;
    }

    public function setCommenterContenu(string $commenterContenu): void
    {
        $this->commenterContenu = $commenterContenu;
    }

    public function getNote(): int
    {
        return $this->note;
    }

    public function setNote(int $note): void
    {
        $this->note = $note;
    }

    public function getCommenterCreatedAt(): DateTime
    {
        return $this->commenterCreatedAt;
    }

    public function getUserPrenom(): string
    {
        return $this->userPrenom;
    }

    public function setUserPrenom(string $userPrenom): void
    {
        $this->userPrenom = $userPrenom;
    }

    public function getUserNom(): string
    {
        return $this->userNom;
    }

    public function setUserNom(string $userNom): void
    {
        $this->userNom = $userNom;
    }
}