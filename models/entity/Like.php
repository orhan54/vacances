<?php

class Like
{
    private int $userId;
    private int $lieuId;
    private DateTime $likeCreatedAt;

    /**
     * Constructeur de la classe Like.
     *
     * @param int $userId L'ID de l'utilisateur qui a aimé le lieu.
     * @param int $lieuId L'ID du lieu aimé.
     * @param DateTime|null $likeCreatedAt La date de création du like (optionnelle).
     */
    public function __construct(
        int $userId,
        int $lieuId,
        ?DateTime $likeCreatedAt = null
    ) {
        $this->userId = $userId;
        $this->lieuId = $lieuId;
        $this->likeCreatedAt = $likeCreatedAt ?? new DateTime();
    }

    /**
     * Getters pour les propriétés du like.
     */
    public function getUserId(): int
    {
        return $this->userId;
    }

    public function getLieuId(): int
    {
        return $this->lieuId;
    }

    public function getLikeCreatedAt(): DateTime
    {
        return $this->likeCreatedAt;
    }
}