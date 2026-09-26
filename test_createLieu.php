<?php

require_once __DIR__ . '/config/Database.php';
require_once __DIR__ . '/models/dao/LieuDAO.php';
require_once __DIR__ . '/models/entity/Lieu.php';

$lieuDAO = new LieuDAO();

$lieux = $lieuDAO->findAll();
foreach ($lieux as $lieu) {
    echo $lieu->getLieuNom() . ' - ' . $lieu->getLieuPrix() . ' €<br>';
}