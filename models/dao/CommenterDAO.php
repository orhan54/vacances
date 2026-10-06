<?php

/**
 * Data Access Object (DAO) pour gérer les opérations CRUD sur les commentaires.
 */
require_once __DIR__ . '/../../config/Database.php';
require_once __DIR__ . '/../entity/Commenter.php';
include_once __DIR__ . '/DAOInterface.php';

class CommenterDAO implements DAOInterface
{
    /**
     * @var PDO $connexion La connexion à la base de données.
     */
    private PDO $connexion;

    /**
     * Constructeur de la classe CommenterDAO.
     * Initialise la connexion à la base de données.
     */
    public function __construct()
    {
        $this->connexion = Database::getInstance()->getConnexion();
    }

    /**
     * Crée un nouveau commentaire dans la base de données.
     *
     * @param Commenter $object L'objet Commenter à insérer.
     * @return bool True si l'insertion a réussi, false sinon.
     * @throws InvalidArgumentException Si l'objet n'est pas une instance de Commenter.
     */
    public function create(object $object): bool
    {
        if (!$object instanceof Commenter) {
            throw new InvalidArgumentException("L'objet doit être une instance de Commenter.");
        }

        $sql = "INSERT INTO Commenter (Id_User, Id_Lieu, contenu, commenter_created_at) 
                VALUES (:id_user, :id_lieu, :contenu, :commenter_created_at)";

        $stmt = $this->connexion->prepare($sql);

        $stmt->bindValue(':id_user', $object->getUserId(), PDO::PARAM_INT);
        $stmt->bindValue(':id_lieu', $object->getLieuId(), PDO::PARAM_INT);
        $stmt->bindValue(':contenu', $object->getCommenterContenu(), PDO::PARAM_STR);
        $stmt->bindValue(
            ':commenter_created_at',
            $object->getCommenterCreatedAt()->format('Y-m-d H:i:s'),
            PDO::PARAM_STR
        );

        return $stmt->execute();
    }

    /**
     * Récupère un commentaire par son identifiant.
     *
     * Cette méthode n'est pas utilisable pour Commenter,
     * car un commentaire est identifié par Id_User et Id_Lieu.
     *
     * @param int $id Identifiant unique non applicable à Commenter.
     * @return Commenter|null Ne retourne jamais de commentaire.
     * @throws Exception Si la méthode est appelée.
     */
    public function read(int $id): ?object
    {
        throw new Exception(
            "Impossible de lire un commentaire avec un seul ID : "
            . "un commentaire est identifié par id_user et id_lieu."
        );
    }

    /**
     * Met à jour un commentaire existant dans la base de données.
     *
     * Le commentaire est identifié par Id_User et Id_Lieu.
     *
     * @param Commenter $object L'objet Commenter à mettre à jour.
     * @return bool True si la mise à jour a réussi, false sinon.
     * @throws InvalidArgumentException Si l'objet n'est pas une instance de Commenter.
     */
    public function update(object $object): bool
    {
        if (!$object instanceof Commenter) {
            throw new InvalidArgumentException("L'objet doit être une instance de Commenter.");
        }

        $sql = "UPDATE Commenter 
                SET contenu = :contenu 
                WHERE Id_User = :id_user 
                AND Id_Lieu = :id_lieu";

        $stmt = $this->connexion->prepare($sql);

        $stmt->bindValue(':contenu', $object->getCommenterContenu(), PDO::PARAM_STR);
        $stmt->bindValue(':id_user', $object->getUserId(), PDO::PARAM_INT);
        $stmt->bindValue(':id_lieu', $object->getLieuId(), PDO::PARAM_INT);

        return $stmt->execute();
    }

    /**
     * Supprime un commentaire de la base de données.
     *
     * Cette méthode n'est pas utilisable pour Commenter,
     * car un commentaire est identifié par Id_User et Id_Lieu.
     *
     * @param int $id Identifiant unique non applicable à Commenter.
     * @return bool Ne retourne jamais de résultat.
     * @throws Exception Si la méthode est appelée.
     */
    public function delete(int $id): bool
    {
        throw new Exception(
            "Impossible de supprimer un commentaire avec un seul ID : "
            . "un commentaire est identifié par id_user et id_lieu."
        );
    }

    /**
     * Récupère tous les commentaires de la base de données.
     *
     * @return array Un tableau d'objets Commenter.
     */
    public function findAll(): array
    {
        $sql = "SELECT * FROM Commenter";

        $stmt = $this->connexion->prepare($sql);
        $stmt->execute();

        $commentaires = [];

        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $commentaires[] = new Commenter(
                $row['Id_User'],
                $row['Id_Lieu'],
                $row['contenu'],
                new DateTime($row['commenter_created_at'])
            );
        }

        return $commentaires;
    }

    /**
     * Récupère un commentaire par l'ID de l'utilisateur et l'ID du lieu.
     *
     * @param int $idUser L'ID de l'utilisateur.
     * @param int $idLieu L'ID du lieu.
     * @return Commenter|null L'objet Commenter si trouvé, null sinon.
     */
    public function findByUserAndLieu(int $idUser, int $idLieu): ?object
    {
        $sql = "SELECT *
                FROM Commenter
                WHERE Id_User = :id_user
                AND Id_Lieu = :id_lieu";

        $stmt = $this->connexion->prepare($sql);

        $stmt->bindValue(':id_user', $idUser, PDO::PARAM_INT);
        $stmt->bindValue(':id_lieu', $idLieu, PDO::PARAM_INT);

        $stmt->execute();

        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($row) {
            return new Commenter(
                $row['Id_User'],
                $row['Id_Lieu'],
                $row['contenu'],
                new DateTime($row['commenter_created_at'])
            );
        }

        return null;
    }

    /**
     * Récupère tous les commentaires d'un lieu.
     *
     * @param int $idLieu L'ID du lieu.
     * @return array Un tableau d'objets Commenter.
     */
    public function findByLieu(int $idLieu): array
    {
        $sql = "SELECT *
            FROM Commenter
            WHERE Id_Lieu = :id_lieu
            ORDER BY commenter_created_at DESC";

        $stmt = $this->connexion->prepare($sql);

        $stmt->bindValue(':id_lieu', $idLieu, PDO::PARAM_INT);

        $stmt->execute();

        $commentaires = [];

        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $commentaires[] = new Commenter(
                $row['Id_User'],
                $row['Id_Lieu'],
                $row['contenu'],
                new DateTime($row['commenter_created_at'])
            );
        }

        return $commentaires;
    }

    /**
     * Supprime un commentaire par l'ID de l'utilisateur et l'ID du lieu.
     *
     * @param int $idUser L'ID de l'utilisateur.
     * @param int $idLieu L'ID du lieu.
     * @return bool True si la suppression a réussi, false sinon.
     */
    public function deleteByUserAndLieu(int $idUser, int $idLieu): bool
    {
        $sql = "DELETE FROM Commenter 
                WHERE Id_User = :id_user 
                AND Id_Lieu = :id_lieu";

        $stmt = $this->connexion->prepare($sql);

        $stmt->bindValue(':id_user', $idUser, PDO::PARAM_INT);
        $stmt->bindValue(':id_lieu', $idLieu, PDO::PARAM_INT);

        return $stmt->execute();
    }
}