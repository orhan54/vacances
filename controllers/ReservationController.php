<?php

require_once __DIR__ . '/../middleware/Auth.php';
require_once __DIR__ . '/../models/entity/Reservation.php';
require_once __DIR__ . '/../models/dao/ReservationDAO.php';

class ReservationController
{
    /**
     * Affiche les réservations.
     */
    public function index(): void
    {
        // Vérifie si l'utilisateur est connecté
        Auth::exigerConnexion();

        // Création du DAO
        $reservationDAO = new ReservationDAO();

        // Récupère l'ID de l'utilisateur connecté depuis la session
        $userId = (int) $_SESSION['user_id'];

        // Récupère toutes les réservations de l'utilisateur
        $reservations = $reservationDAO->findByUserId($userId);

        // Affiche la vue avec les réservations
        require __DIR__ . '/../views/reservations/index.php';
    }

    /**
     * Affiche le formulaire de réservation.
     */
    public function create(): void
    {
        Auth::exigerConnexion();

        $id_lieu = (int) ($_GET['id_lieu'] ?? 0);

        if ($id_lieu <= 0) {
            die('Lieu invalide.');
        }

        require_once __DIR__ . '/../models/dao/LieuDAO.php';

        $lieuDAO = new LieuDAO();

        $lieu = $lieuDAO->read($id_lieu);

        if ($lieu === null) {
            die('Lieu introuvable.');
        }

        $reservationDAO = new ReservationDAO();

        // Récupération des périodes déjà réservées
        $reservations = $reservationDAO->findConfirmedByLieuId($id_lieu);

        require __DIR__ . '/../views/reservations/create.php';
    }

    /**
     * Enregistre une nouvelle réservation.
     */
    public function store(): void
    {
        // Vérifie si l'utilisateur est connecté
        Auth::exigerConnexion();

        // Vérifie que la requête est de type POST
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: index.php?controller=reservation&action=create');
            exit;
        }

        // Récupère l'ID de l'utilisateur connecté depuis la session
        $id_user = (int) ($_SESSION['user_id'] ?? 0);

        // Récupère l'ID du lieu et les dates de début et de fin depuis le formulaire
        $id_lieu = (int) ($_POST['id_lieu'] ?? 0);

        // Vérifie que l'ID du lieu est valide
        $reservationDateDebut = trim(
            $_POST['reservation_date_debut'] ?? ''
        );

        // Vérifie que les dates de début et de fin sont valides
        $reservationDateFin = trim(
            $_POST['reservation_date_fin'] ?? ''
        );

        // Vérifie que l'ID du lieu est valide
        if (empty($reservationDateDebut) || empty($reservationDateFin)) {
            die('Les dates de début et de fin sont obligatoires.');
        }

        // Vérifie que l'ID du lieu est valide
        $dateDebut = new DateTime($reservationDateDebut);
        $dateFin = new DateTime($reservationDateFin);

        // Vérifie que la date de fin est après la date de début
        if ($dateFin <= $dateDebut) {
            die('La date de fin doit être après la date de début.');
        }

        // Vérifie que l'ID du lieu est valide
        $reservationDAO = new ReservationDAO();

        // Vérifie si le lieu est disponible pour la période donnée
        if (!$reservationDAO->isAvailable($id_lieu, $dateDebut, $dateFin)) {
            die('Ce lieu est déjà réservé pour cette période.');
        }

        // Crée une nouvelle réservation
        $reservation = new Reservation(
            null,
            $id_user,
            $id_lieu,
            $dateDebut,
            $dateFin,
            'confirmee',
            new DateTime()
        );

        // Tente d'enregistrer la réservation dans la base de données
        if ($reservationDAO->create($reservation)) {
            header('Location: index.php?controller=reservation&action=index');
            exit;
        }

        // Si l'enregistrement échoue, affiche un message d'erreur
        die('Une erreur est survenue lors de l\'enregistrement de la réservation.');
    }


    /**
     * Annule une réservation.
     */
    public function cancel(): void
    {
        // Vérifie si l'utilisateur est connecté
        Auth::exigerConnexion();

        // Vérifie que la requête est de type POST
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: index.php?controller=reservation&action=index');
            exit;
        }

        // Récupère l'identifiant de la réservation
        $id = (int) ($_POST['id'] ?? 0);

        // Création du DAO
        $reservationDAO = new ReservationDAO();

        // Récupère la réservation
        $reservation = $reservationDAO->read($id);

        // Vérifie que la réservation existe
        if ($reservation === null) {
            die('Réservation introuvable.');
        }

        // Vérifie que la réservation appartient à l'utilisateur connecté
        if ($reservation->getUserId() !== (int) $_SESSION['user_id']) {
            die('Vous n\'êtes pas autorisé à annuler cette réservation.');
        }

        // Vérifie que la réservation n'est pas déjà annulée
        if ($reservation->getReservationStatus() === 'annulee') {
            die('Cette réservation est déjà annulée.');
        }

        // Change uniquement le statut
        $reservation->setReservationStatus('annulee');

        // Met à jour la réservation
        if ($reservationDAO->update($reservation)) {
            header('Location: index.php?controller=reservation&action=index');
            exit;
        }

        die('Une erreur est survenue lors de l\'annulation de la réservation.');
    }
}