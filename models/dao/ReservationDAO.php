<?php

require_once __DIR__ . '/../../config/Database.php';
require_once __DIR__ . '/../entity/Reservation.php';
include_once __DIR__ . '/DAOInterface.php';

class ReservationDAO implements DAOInterface
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
     * Crée une nouvelle réservation dans la base de données.
     *
     * @param Reservation $object L'objet Reservation à insérer.
     * @return bool True si l'insertion a réussi, false sinon.
     * @throws InvalidArgumentException Si l'objet n'est pas une instance de Reservation.
     */
    public function create(object $object): bool
    {
        if (!$object instanceof Reservation) {
            throw new InvalidArgumentException("L'objet doit être une instance de Reservation.");
        }

        $sql = "INSERT INTO Reservation (id_user, id_lieu, reservation_date_debut, reservation_date_fin, reservation_status, reservation_created_at) 
                VALUES (:id_user, :id_lieu, :reservation_date_debut, :reservation_date_fin, :reservation_status, :reservation_created_at)";

        $stmt = $this->connexion->prepare($sql);

        $stmt->bindValue(':id_user', $object->getUserId());
        $stmt->bindValue(':id_lieu', $object->getLieuId());
        $stmt->bindValue(':reservation_date_debut', $object->getReservationDateDebut()->format('Y-m-d H:i:s'));
        $stmt->bindValue(':reservation_date_fin', $object->getReservationDateFin()->format('Y-m-d H:i:s'));
        $stmt->bindValue(':reservation_status', $object->getReservationStatus());
        $stmt->bindValue(':reservation_created_at', $object->getReservationCreatedAt()->format('Y-m-d H:i:s'));

        return $stmt->execute();
    }

    /**
     * Récupère une réservation par son ID.
     *
     * @param int $id L'ID de la réservation.
     * @return Reservation|null L'objet Reservation si trouvé, null sinon.
     */
    public function read(int $id): ?object
    {
        $sql = "SELECT
            Id_Reservation AS id_reservation,
            Id_User AS id_user,
            Id_Lieu AS id_lieu,
            reservation_date_debut,
            reservation_date_fin,
            reservation_status,
            reservation_created_at
        FROM Reservation
        WHERE Id_Reservation = :id_reservation";
        $stmt = $this->connexion->prepare($sql);
        $stmt->bindValue(':id_reservation', $id, PDO::PARAM_INT);
        $stmt->execute();

        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($row) {
            return new Reservation(
                (int) $row['id_reservation'],
                (int) $row['id_user'],
                (int) $row['id_lieu'],
                new DateTime($row['reservation_date_debut']),
                new DateTime($row['reservation_date_fin']),
                $row['reservation_status'],
                new DateTime($row['reservation_created_at'])
            );
        }

        return null;
    }

    /**
     * Met à jour une réservation existante dans la base de données.
     *
     * @param Reservation $object L'objet Reservation à mettre à jour.
     * @return bool True si la mise à jour a réussi, false sinon.
     * @throws InvalidArgumentException Si l'objet n'est pas une instance de Reservation.
     */
    public function update(object $object): bool
    {
        if (!$object instanceof Reservation) {
            throw new InvalidArgumentException("L'objet doit être une instance de Reservation.");
        }

        $sql = "UPDATE Reservation SET 
                    id_user = :id_user, 
                    id_lieu = :id_lieu, 
                    reservation_date_debut = :reservation_date_debut, 
                    reservation_date_fin = :reservation_date_fin, 
                    reservation_status = :reservation_status, 
                    reservation_created_at = :reservation_created_at
                WHERE id_reservation = :id_reservation";

        $stmt = $this->connexion->prepare($sql);

        $stmt->bindValue(':id_user', $object->getUserId());
        $stmt->bindValue(':id_lieu', $object->getLieuId());
        $stmt->bindValue(':reservation_date_debut', $object->getReservationDateDebut()->format('Y-m-d H:i:s'));
        $stmt->bindValue(':reservation_date_fin', $object->getReservationDateFin()->format('Y-m-d H:i:s'));
        $stmt->bindValue(':reservation_status', $object->getReservationStatus());
        $stmt->bindValue(':reservation_created_at', $object->getReservationCreatedAt()->format('Y-m-d H:i:s'));
        $stmt->bindValue(':id_reservation', $object->getReservationId());

        return $stmt->execute();
    }

    /**
     * Supprime une réservation de la base de données.
     *
     * @param int $id L'ID de la réservation à supprimer.
     * @return bool True si la suppression a réussi, false sinon.
     */
    public function delete(int $id): bool
    {
        $sql = "DELETE FROM Reservation WHERE id_reservation = :id_reservation";
        $stmt = $this->connexion->prepare($sql);
        $stmt->bindValue(':id_reservation', $id, PDO::PARAM_INT);
        return $stmt->execute();
    }

    /**
     * Récupère toutes les réservations de la base de données.
     *
     * @return array Un tableau d'objets Reservation.
     */
    public function findAll(): array
    {
        $sql = "SELECT
            Id_Reservation AS id_reservation,
            Id_User AS id_user,
            Id_Lieu AS id_lieu,
            reservation_date_debut,
            reservation_date_fin,
            reservation_status,
            reservation_created_at
        FROM Reservation";
        $stmt = $this->connexion->query($sql);
        $reservations = [];

        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $reservations[] = new Reservation(
                (int) $row['id_reservation'],
                (int) $row['id_user'],
                (int) $row['id_lieu'],
                new DateTime($row['reservation_date_debut']),
                new DateTime($row['reservation_date_fin']),
                $row['reservation_status'],
                new DateTime($row['reservation_created_at'])
            );
        }

        return $reservations;
    }
}