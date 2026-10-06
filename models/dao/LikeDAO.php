<?php

/**
 * Classe LikeDAO
 *
 * Cette classe gère les opérations CRUD pour l'entité Like.
 * Elle implémente l'interface DAOInterface.
 *
 * @package models\dao
 */
require_once __DIR__ . '/../../config/Database.php';
require_once __DIR__ . '/../entity/Like.php';
include_once __DIR__ . '/DAOInterface.php';

class LikeDAO implements DAOInterface
{
    /**
     * @var PDO $connexion
     */
    private PDO $connexion;

    /**
     * Constructeur de la classe LikeDAO.
     */
    public function __construct()
    {
        $this->connexion = Database::getInstance()->getConnexion();
    }

    /**
     * Crée un nouveau like.
     *
     * @param object $object Objet Like à insérer.
     * @return bool
     */
    public function create(object $object): bool
    {
        if (!$object instanceof Like) {
            throw new InvalidArgumentException(
                "L'objet doit être une instance de Like."
            );
        }

        $sql = "INSERT INTO Likes (Id_User, Id_Lieu)
                VALUES (:id_user, :id_lieu)";

        $stmt = $this->connexion->prepare($sql);

        $stmt->bindValue(
            ':id_user',
            $object->getUserId(),
            PDO::PARAM_INT
        );

        $stmt->bindValue(
            ':id_lieu',
            $object->getLieuId(),
            PDO::PARAM_INT
        );

        return $stmt->execute();
    }

    /**
     * Méthode read() de l'interface DAO.
     *
     * Impossible d'utiliser un seul ID car Like possède
     * une clé primaire composée de Id_User et Id_Lieu.
     *
     * @param int $id
     * @return Like|null
     */
    public function read(int $id): ?Like
    {
        throw new Exception(
            "La méthode read() n'est pas applicable à Like. "
            . "Utilisez findByUserAndLieu()."
        );
    }

    /**
     * Met à jour un like.
     *
     * Un like ne possède actuellement aucune donnée
     * modifiable à part sa clé primaire.
     *
     * @param object $object
     * @return bool
     */
    public function update(object $object): bool
    {
        throw new Exception(
            "La méthode update() n'est pas applicable à Like."
        );
    }

    /**
     * Supprime un like.
     *
     * Impossible d'utiliser un seul ID car Like possède
     * une clé primaire composée de Id_User et Id_Lieu.
     *
     * @param int $id
     * @return bool
     */
    public function delete(int $id): bool
    {
        throw new Exception(
            "La méthode delete() n'est pas applicable à Like. "
            . "Utilisez deleteByUserAndLieu()."
        );
    }

    /**
     * Récupère tous les likes.
     *
     * @return array
     */
    public function findAll(): array
    {
        $sql = "SELECT *
                FROM Likes
                ORDER BY like_created_at DESC";

        $stmt = $this->connexion->prepare($sql);
        $stmt->execute();

        $likes = [];

        while ($data = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $likes[] = new Like(
                (int) $data['Id_User'],
                (int) $data['Id_Lieu'],
                new DateTime($data['like_created_at'])
            );
        }

        return $likes;
    }

    /**
     * Vérifie si un utilisateur a aimé un lieu.
     *
     * @param int $userId
     * @param int $lieuId
     * @return bool
     */
    public function exists(int $userId, int $lieuId): bool
    {
        $sql = "SELECT 1
                FROM Likes
                WHERE Id_User = :id_user
                AND Id_Lieu = :id_lieu";

        $stmt = $this->connexion->prepare($sql);

        $stmt->bindValue(
            ':id_user',
            $userId,
            PDO::PARAM_INT
        );

        $stmt->bindValue(
            ':id_lieu',
            $lieuId,
            PDO::PARAM_INT
        );

        $stmt->execute();

        return $stmt->fetchColumn() !== false;
    }

    /**
     * Récupère un like avec l'utilisateur et le lieu.
     *
     * @param int $userId
     * @param int $lieuId
     * @return Like|null
     */
    public function findByUserAndLieu(
        int $userId,
        int $lieuId
    ): ?Like {
        $sql = "SELECT *
                FROM Likes
                WHERE Id_User = :id_user
                AND Id_Lieu = :id_lieu";

        $stmt = $this->connexion->prepare($sql);

        $stmt->bindValue(
            ':id_user',
            $userId,
            PDO::PARAM_INT
        );

        $stmt->bindValue(
            ':id_lieu',
            $lieuId,
            PDO::PARAM_INT
        );

        $stmt->execute();

        $data = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$data) {
            return null;
        }

        return new Like(
            (int) $data['Id_User'],
            (int) $data['Id_Lieu'],
            new DateTime($data['like_created_at'])
        );
    }

    /**
     * Supprime un like avec l'utilisateur et le lieu.
     *
     * @param int $userId
     * @param int $lieuId
     * @return bool
     */
    public function deleteByUserAndLieu(int $userId, int $lieuId): bool
    {
        $sql = "DELETE FROM Likes
                WHERE Id_User = :id_user
                AND Id_Lieu = :id_lieu";

        $stmt = $this->connexion->prepare($sql);

        $stmt->bindValue(
            ':id_user',
            $userId,
            PDO::PARAM_INT
        );

        $stmt->bindValue(
            ':id_lieu',
            $lieuId,
            PDO::PARAM_INT
        );

        return $stmt->execute();
    }

    /**
     * Récupère tous les likes d'un lieu.
     *
     * @param int $lieuId
     * @return array
     */
    public function findByLieu(int $lieuId): array
    {
        $sql = "SELECT *
                FROM Likes
                WHERE Id_Lieu = :id_lieu
                ORDER BY like_created_at DESC";

        $stmt = $this->connexion->prepare($sql);

        $stmt->bindValue(
            ':id_lieu',
            $lieuId,
            PDO::PARAM_INT
        );

        $stmt->execute();

        $likes = [];

        while ($data = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $likes[] = new Like(
                (int) $data['Id_User'],
                (int) $data['Id_Lieu'],
                new DateTime($data['like_created_at'])
            );
        }

        return $likes;
    }

    /**
     * Récupère tous les likes d'un utilisateur.
     *
     * @param int $userId
     * @return array
     */
    public function findByUser(int $userId): array
    {
        $sql = "SELECT *
                FROM Likes
                WHERE Id_User = :id_user
                ORDER BY like_created_at DESC";

        $stmt = $this->connexion->prepare($sql);

        $stmt->bindValue(
            ':id_user',
            $userId,
            PDO::PARAM_INT
        );

        $stmt->execute();

        $likes = [];

        while ($data = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $likes[] = new Like(
                (int) $data['Id_User'],
                (int) $data['Id_Lieu'],
                new DateTime($data['like_created_at'])
            );
        }

        return $likes;
    }

    /**
     * Compte le nombre de likes d'un lieu.
     *
     * @param int $lieuId
     * @return int
     */
    public function countByLieu(int $lieuId): int
    {
        $sql = "SELECT COUNT(*)
                FROM Likes
                WHERE Id_Lieu = :id_lieu";

        $stmt = $this->connexion->prepare($sql);

        $stmt->bindValue(
            ':id_lieu',
            $lieuId,
            PDO::PARAM_INT
        );

        $stmt->execute();

        return (int) $stmt->fetchColumn();
    }

    /**
     * Compte le nombre de likes d'un utilisateur.
     *
     * @param int $userId
     * @return int
     */
    public function countByUser(int $userId): int
    {
        $sql = "SELECT COUNT(*)
                FROM Likes
                WHERE Id_User = :id_user";

        $stmt = $this->connexion->prepare($sql);

        $stmt->bindValue(
            ':id_user',
            $userId,
            PDO::PARAM_INT
        );

        $stmt->execute();

        return (int) $stmt->fetchColumn();
    }
}
