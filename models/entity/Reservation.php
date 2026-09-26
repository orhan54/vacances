<?php

/**
 * Classe Reservation pour représenter une réservation.
 */
class Reservation
{
    // Propriétés de la classe Reservation
    private ?int $reservationId;
    private int $userId;
    private int $lieuId;
    private DateTime $reservationDateDebut;
    private DateTime $reservationDateFin;
    private string $reservationStatus;
    private DateTime $reservationCreatedAt;

    /**
     * Constructeur de la classe Reservation.
     *
     * @param ?int $reservationId L'ID de la réservation.
     * @param int $userId L'ID de l'utilisateur qui a effectué la réservation.
     * @param int $lieuId L'ID du lieu réservé.
     * @param DateTime $reservationDateDebut La date de début de la réservation.
     * @param DateTime $reservationDateFin La date de fin de la réservation.
     * @param string $reservationStatus Le statut de la réservation.
     * @param DateTime $reservationCreatedAt La date de création de la réservation.
     */
    public function __construct(
        ?int $reservationId,
        int $userId,
        int $lieuId,
        DateTime $reservationDateDebut,
        DateTime $reservationDateFin,
        string $reservationStatus,
        DateTime $reservationCreatedAt
    ) {
        $this->reservationId = $reservationId;
        $this->userId = $userId;
        $this->lieuId = $lieuId;
        $this->reservationDateDebut = $reservationDateDebut;
        $this->reservationDateFin = $reservationDateFin;
        $this->reservationStatus = $reservationStatus;
        $this->reservationCreatedAt = $reservationCreatedAt;
    }

    /**
     * Getters et Setters pour les propriétés de la réservation.
     */

    public function getReservationId(): ?int
    {
        return $this->reservationId;
    }

    public function getUserId(): int
    {
        return $this->userId;
    }

    public function getLieuId(): int
    {
        return $this->lieuId;
    }

    public function getReservationDateDebut(): DateTime
    {
        return $this->reservationDateDebut;
    }

    public function setReservationDateDebut(DateTime $reservationDateDebut): void
    {
        $this->reservationDateDebut = $reservationDateDebut;
    }

    public function getReservationDateFin(): DateTime
    {
        return $this->reservationDateFin;
    }

    public function setReservationDateFin(DateTime $reservationDateFin): void
    {
        $this->reservationDateFin = $reservationDateFin;
    }

    public function getReservationStatus(): string
    {
        return $this->reservationStatus;
    }

    public function setReservationStatus(string $reservationStatus): void
    {
        $this->reservationStatus = $reservationStatus;
    }

    public function getReservationCreatedAt(): DateTime
    {
        return $this->reservationCreatedAt;
    }
}