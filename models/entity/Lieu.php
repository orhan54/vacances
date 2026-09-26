<?php

/**
 * Classe Lieu pour représenter un lieu.
 */
class Lieu
{
    private int $lieuId;
    private string $lieuNom;
    private string $lieuAdresse;
    private string $lieuCp;
    private string $lieuTelephone;
    private string $lieuDescription;
    private float $lieuPrix;
    private string $lieuImage;
    private DateTime $lieuCreatedAt;

    /**
     * Constructeur de la classe Lieu.
     *
     * @param int $lieuId L'ID du lieu.
     * @param string $lieuNom Le nom du lieu.
     * @param string $lieuAdresse L'adresse du lieu.
     * @param string $lieuCp Le code postal du lieu.
     * @param string $lieuTelephone Le numéro de téléphone du lieu.
     * @param string $lieuDescription La description du lieu.
     * @param float $lieuPrix Le prix du lieu.
     * @param string $lieuImage L'image du lieu.
     * @param DateTime $lieuCreatedAt La date de création du lieu.
     */
    public function __construct(
        int $lieuId,
        string $lieuNom,
        string $lieuAdresse,
        string $lieuCp,
        string $lieuTelephone,
        string $lieuDescription,
        float $lieuPrix,
        string $lieuImage,
        DateTime $lieuCreatedAt
    ) {
        $this->lieuId = $lieuId;
        $this->lieuNom = $lieuNom;
        $this->lieuAdresse = $lieuAdresse;
        $this->lieuCp = $lieuCp;
        $this->lieuTelephone = $lieuTelephone;
        $this->lieuDescription = $lieuDescription;
        $this->lieuPrix = $lieuPrix;
        $this->lieuImage = $lieuImage;
        $this->lieuCreatedAt = $lieuCreatedAt;
    }

    /**
     * Getters et Setters pour les propriétés du lieu.
     */
    public function getLieuId(): int
    {
        return $this->lieuId;
    }

    public function setLieuNom(string $lieuNom): void
    {
        $this->lieuNom = $lieuNom;
    }

    public function getLieuNom(): string
    {
        return $this->lieuNom;
    }

    public function setLieuAdresse(string $lieuAdresse): void
    {
        $this->lieuAdresse = $lieuAdresse;
    }

    public function getLieuAdresse(): string
    {
        return $this->lieuAdresse;
    }

    public function setLieuCp(string $lieuCp): void
    {
        $this->lieuCp = $lieuCp;
    }

    public function getLieuCp(): string
    {
        return $this->lieuCp;
    }

    public function setLieuTelephone(string $lieuTelephone): void
    {
        $this->lieuTelephone = $lieuTelephone;
    }

    public function getLieuTelephone(): string
    {
        return $this->lieuTelephone;
    }

    public function setLieuDescription(string $lieuDescription): void
    {
        $this->lieuDescription = $lieuDescription;
    }

    public function getLieuDescription(): string
    {
        return $this->lieuDescription;
    }

    public function setLieuPrix(float $lieuPrix): void
    {
        $this->lieuPrix = $lieuPrix;
    }

    public function getLieuPrix(): float
    {
        return $this->lieuPrix;
    }

    public function setLieuImage(string $lieuImage): void
    {
        $this->lieuImage = $lieuImage;
    }

    public function getLieuImage(): string
    {
        return $this->lieuImage;
    }

    public function getLieuCreatedAt(): DateTime
    {
        return $this->lieuCreatedAt;
    }
}