<?php

class User
{
    private int $id;
    private string $userPrenom;
    private string $userNom;
    private string $userAdresse;
    private string $userCp;
    private string $userTelephone;
    private string $userEmail;
    private string $userMp;
    private string $userRole;

    private DateTime $userCreatedAt;

    public function __construct(
        int $id,
        string $userPrenom,
        string $userNom,
        string $userAdresse,
        string $userCp,
        string $userTelephone,
        string $userEmail,
        string $userMp,
        string $userRole,
        DateTime $userCreatedAt
    ) {
        $this->id = $id;
        $this->userPrenom = $userPrenom;
        $this->userNom = $userNom;
        $this->userAdresse = $userAdresse;
        $this->userCp = $userCp;
        $this->userTelephone = $userTelephone;
        $this->userEmail = $userEmail;
        $this->userMp = $userMp;
        $this->userRole = $userRole;
        $this->userCreatedAt = $userCreatedAt;
    }

    public function getUserId(): int
    {
        return $this->id;
    }

    public function setUserPrenom(string $userPrenom): void
    {
        $this->userPrenom = $userPrenom;
    }

    public function getUserPrenom(): string
    {
        return $this->userPrenom;
    }

    public function setUserNom(string $userNom): void
    {
        $this->userNom = $userNom;
    }

    public function getUserNom(): string
    {
        return $this->userNom;
    }

    public function setUserAdresse(string $userAdresse): void
    {
        $this->userAdresse = $userAdresse;
    }

    public function getUserAdresse(): string
    {
        return $this->userAdresse;
    }

    public function setUserCp(string $userCp): void
    {
        $this->userCp = $userCp;
    }

    public function getUserCp(): string
    {
        return $this->userCp;
    }

    public function setUserTelephone(string $userTelephone): void
    {
        $this->userTelephone = $userTelephone;
    }

    public function getUserTelephone(): string
    {
        return $this->userTelephone;
    }

    public function setUserEmail(string $userEmail): void
    {
        $this->userEmail = $userEmail;
    }

    public function getUserEmail(): string
    {
        return $this->userEmail;
    }

    public function setUserMp(string $userMp): void
    {
        $this->userMp = $userMp;
    }

    public function getUserMp(): string
    {
        return $this->userMp;
    }

    public function getUserRole(): string
    {
        return $this->userRole;
    }

    public function getUserCreatedAt(): DateTime
    {
        return $this->userCreatedAt;
    }
}