<?php

class Commenter
{
    // Propriétés de la classe Commenter
    private int $userId;
    private int $lieuId;

    private string $commenterContenu;
    private DateTime $commenterCreatedAt;

    /**
     * Constructeur de la classe Commenter.
     *
     * @param int $userId L'ID de l'utilisateur qui a fait le commentaire.
     * @param int $lieuId L'ID du lieu commenté.
     * @param string $commenterContenu Le contenu du commentaire.
     * @param DateTime $commenterCreatedAt La date de création du commentaire.
     */
    public function __construct(
        int $userId,
        int $lieuId,
        string $commenterContenu,
        DateTime $commenterCreatedAt
    ) {
        $this->userId = $userId;
        $this->lieuId = $lieuId;
        $this->commenterContenu = $commenterContenu;
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

    public function getCommenterCreatedAt(): DateTime
    {
        return $this->commenterCreatedAt;
    }
}