<?php

require_once __DIR__ . '/../../config/Database.php';
require_once __DIR__ . '/../entity/Lieu.php';
include_once __DIR__ . '/DAOInterface.php';

/**
 * Classe LieuDAO pour gérer les opérations CRUD sur les lieux.
 */
class LieuDAO implements DAOInterface
{
    /**
     * @var PDO $connexion La connexion à la base de données.
     */
    private PDO $connexion;

    /**
     * Constructeur de la classe LieuDAO.
     * Initialise la connexion à la base de données.
     */
    public function __construct()
    {
        $this->connexion = Database::getInstance()->getConnexion();
    }

    /**
     * Crée un nouveau lieu dans la base de données.
     *
     * @param Lieu $object L'objet Lieu à insérer.
     * @return bool True si l'insertion a réussi, false sinon.
     * @throws InvalidArgumentException Si l'objet n'est pas une instance de Lieu.
     */
    public function create(object $object): bool
    {
        if (!$object instanceof Lieu) {
            throw new InvalidArgumentException("L'objet doit être une instance de Lieu.");
        }

        $sql = "INSERT INTO Lieu (lieu_nom, lieu_adresse, lieu_cp, lieu_telephone, lieu_description, lieu_prix, lieu_image, lieu_created_at) 
                VALUES (:lieu_nom, :lieu_adresse, :lieu_cp, :lieu_telephone, :lieu_description, :lieu_prix, :lieu_image, :lieu_created_at)";

        $stmt = $this->connexion->prepare($sql);

        $stmt->bindValue(':lieu_nom', $object->getLieuNom());
        $stmt->bindValue(':lieu_adresse', $object->getLieuAdresse());
        $stmt->bindValue(':lieu_cp', $object->getLieuCp());
        $stmt->bindValue(':lieu_telephone', $object->getLieuTelephone());
        $stmt->bindValue(':lieu_description', $object->getLieuDescription());
        $stmt->bindValue(':lieu_prix', $object->getLieuPrix());
        $stmt->bindValue(':lieu_image', $object->getLieuImage());
        $stmt->bindValue(':lieu_created_at', $object->getLieuCreatedAt()->format('Y-m-d H:i:s'));

        return $stmt->execute();
    }

    /**
     * Récupère un lieu par son ID.
     *
     * @param int $id L'ID du lieu.
     * @return Lieu|null L'objet Lieu correspondant ou null si non trouvé.
     */
    public function read(int $id): ?object
    {
        $sql = "SELECT * FROM Lieu WHERE Id_Lieu = :Id_Lieu";
        $stmt = $this->connexion->prepare($sql);
        $stmt->bindValue(':Id_Lieu', $id, PDO::PARAM_INT);
        $stmt->execute();

        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($result) {
            return new Lieu(
                $result['Id_Lieu'],
                $result['lieu_nom'],
                $result['lieu_adresse'],
                $result['lieu_cp'],
                $result['lieu_telephone'],
                $result['lieu_description'],
                $result['lieu_prix'],
                $result['lieu_image'],
                new DateTime($result['lieu_created_at'])
            );
        }

        return null;
    }

    /**
     * Met à jour un lieu dans la base de données.
     *
     * @param Lieu $object L'objet Lieu à mettre à jour.
     * @return bool True si la mise à jour a réussi, false sinon.
     * @throws InvalidArgumentException Si l'objet n'est pas une instance de Lieu.
     */
    public function update(object $object): bool
    {
        if (!$object instanceof Lieu) {
            throw new InvalidArgumentException("L'objet doit être une instance de Lieu.");
        }

        $sql = "UPDATE Lieu SET 
                    lieu_nom = :lieu_nom, 
                    lieu_adresse = :lieu_adresse, 
                    lieu_cp = :lieu_cp, 
                    lieu_telephone = :lieu_telephone, 
                    lieu_description = :lieu_description, 
                    lieu_prix = :lieu_prix, 
                    lieu_image = :lieu_image, 
                    lieu_created_at = :lieu_created_at
                WHERE Id_Lieu = :Id_Lieu";

        $stmt = $this->connexion->prepare($sql);

        $stmt->bindValue(':Id_Lieu', $object->getLieuId(), PDO::PARAM_INT);
        $stmt->bindValue(':lieu_nom', $object->getLieuNom());
        $stmt->bindValue(':lieu_adresse', $object->getLieuAdresse());
        $stmt->bindValue(':lieu_cp', $object->getLieuCp());
        $stmt->bindValue(':lieu_telephone', $object->getLieuTelephone());
        $stmt->bindValue(':lieu_description', $object->getLieuDescription());
        $stmt->bindValue(':lieu_prix', $object->getLieuPrix());
        $stmt->bindValue(':lieu_image', $object->getLieuImage());
        $stmt->bindValue(':lieu_created_at', $object->getLieuCreatedAt()->format('Y-m-d H:i:s'));

        return $stmt->execute();
    }

    /**
     * Supprime un lieu de la base de données.
     *
     * @param int $id L'ID du lieu à supprimer.
     * @return bool True si la suppression a réussi, false sinon.
     */
    public function delete(int $id): bool
    {
        $sql = "DELETE FROM Lieu WHERE Id_Lieu = :Id_Lieu";
        $stmt = $this->connexion->prepare($sql);
        $stmt->bindValue(':Id_Lieu', $id, PDO::PARAM_INT);

        return $stmt->execute();
    }

    /**
     * Récupère tous les lieux de la base de données.
     *
     * @return array Un tableau d'objets Lieu.
     */
    public function findAll(): array
    {
        $sql = "SELECT * FROM Lieu";
        $stmt = $this->connexion->query($sql);
        $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $lieux = [];
        foreach ($results as $result) {
            $lieux[] = new Lieu(
                $result['Id_Lieu'],
                $result['lieu_nom'],
                $result['lieu_adresse'],
                $result['lieu_cp'],
                $result['lieu_telephone'],
                $result['lieu_description'],
                $result['lieu_prix'],
                $result['lieu_image'],
                new DateTime($result['lieu_created_at'])
            );
        }

        return $lieux;
    }
}