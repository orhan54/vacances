<?php

require_once __DIR__ . '/../../config/Database.php';
require_once __DIR__ . '/../entity/User.php';
include_once __DIR__ . '/DAOInterface.php';

/**
 * Classe UserDAO pour gérer les opérations CRUD sur les utilisateurs.
 */
class UserDAO implements DAOInterface
{
    /**
     * @var PDO $connexion La connexion à la base de données.
     */
    private PDO $connexion;

    /**
     * Constructeur de la classe UserDAO.
     * Initialise la connexion à la base de données.
     */
    public function __construct()
    {
        $this->connexion = Database::getInstance()->getConnexion();
    }

    /**
     * Crée un nouvel utilisateur dans la base de données.
     *
     * @param User $object L'objet User à insérer.
     * @return bool True si l'insertion a réussi, false sinon.
     * @throws InvalidArgumentException Si l'objet n'est pas une instance de User.
     */
    public function create(object $object): bool
    {
        if (!$object instanceof User) {
            throw new InvalidArgumentException("L'objet doit être une instance de User.");
        }

        $sql = "INSERT INTO Users (user_prenom, user_nom, user_adresse, user_cp, user_telephone, user_email, user_mp, user_role, user_created_at) 
                VALUES (:user_prenom, :user_nom, :user_adresse, :user_cp, :user_telephone, :user_email, :user_mp, :user_role, :user_created_at)";

        $stmt = $this->connexion->prepare($sql);

        $stmt->bindValue(':user_prenom', $object->getUserPrenom());
        $stmt->bindValue(':user_nom', $object->getUserNom());
        $stmt->bindValue(':user_adresse', $object->getUserAdresse());
        $stmt->bindValue(':user_cp', $object->getUserCp());
        $stmt->bindValue(':user_telephone', $object->getUserTelephone());
        $stmt->bindValue(':user_email', $object->getUserEmail());
        $stmt->bindValue(':user_mp', password_hash($object->getUserMp(), PASSWORD_DEFAULT));
        $stmt->bindValue(':user_role', $object->getUserRole());
        $stmt->bindValue(':user_created_at', $object->getUserCreatedAt()->format('Y-m-d H:i:s'));

        return $stmt->execute();
    }

    /**
     * Récupère un utilisateur par son ID.
     *
     * @param int $id L'ID de l'utilisateur.
     * @return User|null L'objet User correspondant ou null si non trouvé.
     */
    public function read(int $id): ?object
    {
        $sql = "SELECT * FROM Users WHERE Id_User = :Id_User";
        $stmt = $this->connexion->prepare($sql);
        $stmt->bindValue(':Id_User', $id, PDO::PARAM_INT);
        $stmt->execute();

        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($result) {
            return new User(
                $result['Id_User'],
                $result['user_prenom'],
                $result['user_nom'],
                $result['user_adresse'],
                $result['user_cp'],
                $result['user_telephone'],
                $result['user_email'],
                $result['user_mp'],
                $result['user_role'],
                new DateTime($result['user_created_at'])
            );
        }

        return null;
    }

    /**
     * Met à jour un utilisateur dans la base de données.
     *
     * @param User $object L'objet User à mettre à jour.
     * @return bool True si la mise à jour a réussi, false sinon.
     * @throws InvalidArgumentException Si l'objet n'est pas une instance de User.
     */
    public function update(object $object): bool
    {
        if (!$object instanceof User) {
            throw new InvalidArgumentException("L'objet doit être une instance de User.");
        }

        $sql = "UPDATE Users SET 
                    user_prenom = :user_prenom, 
                    user_nom = :user_nom, 
                    user_adresse = :user_adresse, 
                    user_cp = :user_cp, 
                    user_telephone = :user_telephone, 
                    user_email = :user_email, 
                    user_mp = :user_mp, 
                    user_role = :user_role, 
                    user_created_at = :user_created_at 
                WHERE Id_User = :Id_User";

        $stmt = $this->connexion->prepare($sql);

        $stmt->bindValue(':user_prenom', $object->getUserPrenom());
        $stmt->bindValue(':user_nom', $object->getUserNom());
        $stmt->bindValue(':user_adresse', $object->getUserAdresse());
        $stmt->bindValue(':user_cp', $object->getUserCp());
        $stmt->bindValue(':user_telephone', $object->getUserTelephone());
        $stmt->bindValue(':user_email', $object->getUserEmail());
        $stmt->bindValue(':user_mp', $object->getUserMp());
        $stmt->bindValue(':user_role', $object->getUserRole());
        $stmt->bindValue(':user_created_at', $object->getUserCreatedAt()->format('Y-m-d H:i:s'));
        $stmt->bindValue(':Id_User', $object->getUserId(), PDO::PARAM_INT);

        return $stmt->execute();
    }

    /**
     * Supprime un utilisateur de la base de données.
     *
     * @param int $id L'ID de l'utilisateur à supprimer.
     * @return bool True si la suppression a réussi, false sinon.
     */
    public function delete(int $id): bool
    {
        $sql = "DELETE FROM Users WHERE Id_User = :Id_User";
        $stmt = $this->connexion->prepare($sql);
        $stmt->bindValue(':Id_User', $id, PDO::PARAM_INT);

        return $stmt->execute();
    }

    /**
     * Récupère tous les utilisateurs de la base de données.
     *
     * @return User[] Un tableau d'objets User.
     */
    public function findAll(): array
    {
        $sql = "SELECT * FROM Users";
        $stmt = $this->connexion->query($sql);

        $users = [];
        while ($result = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $users[] = new User(
                $result['Id_User'],
                $result['user_prenom'],
                $result['user_nom'],
                $result['user_adresse'],
                $result['user_cp'],
                $result['user_telephone'],
                $result['user_email'],
                $result['user_mp'],
                $result['user_role'],
                new DateTime($result['user_created_at'])
            );
        }

        return $users;
    }

}