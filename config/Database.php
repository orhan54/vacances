<?php

class Database
{
    private $dns = 'mysql:dbname=vacances;host=127.0.0.1;';

    private $user = 'root';

    private $password = '';

    private $dbh;

    private static ?Database $connexion = null;

    private function __construct()
    {
        try {
            $this->dbh = new PDO(
                $this->dns,
                $this->user,
                $this->password
            );

            $this->dbh->setAttribute(
                PDO::ATTR_ERRMODE,
                PDO::ERRMODE_EXCEPTION
            );

            $this->dbh->exec(
                "SET NAMES utf8mb4"
            );

        } catch (PDOException $e) {
            die("Impossible de se connecter à la base de données.");
        }
    }

    public static function getInstance(): Database
    {
        if (self::$connexion === null) {
            self::$connexion = new self();
        }

        return self::$connexion;
    }

    public function getConnexion(): PDO
    {
        return $this->dbh;
    }
}