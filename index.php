<?php

/**
 * Point d'entrée de l'application
 *
 * Ce fichier gère les requêtes entrantes,
 * détermine le contrôleur et l'action à exécuter,
 * puis délègue la responsabilité au contrôleur approprié.
 *
 * @package Application
 */

// Démarrage de la session
session_start();

/**
 * Contrôleur et action par défaut.
 *
 * Lorsque l'utilisateur accède simplement à :
 *
 * http://localhost/vacances/
 *
 * il sera dirigé vers :
 *
 * AuthController -> welcome()
 */
$controllerName = $_GET['controller'] ?? 'auth';
$action = $_GET['action'] ?? 'welcome';

/**
 * Génère le nom de la classe du contrôleur.
 */
$controllerClass = ucfirst($controllerName) . 'Controller';

/**
 * Construit le chemin vers le contrôleur.
 */
$controllerFile = __DIR__ . '/controllers/' . $controllerClass . '.php';

/**
 * Vérifie que le contrôleur existe.
 */
if (!file_exists($controllerFile)) {
    die("Contrôleur introuvable : " . $controllerClass);
}

/**
 * Charge le contrôleur.
 */
require_once $controllerFile;

/**
 * Vérifie que la classe du contrôleur existe.
 */
if (!class_exists($controllerClass)) {
    die("Classe du contrôleur introuvable : " . $controllerClass);
}

/**
 * Création du contrôleur.
 */
$controller = new $controllerClass();

/**
 * Vérifie que l'action demandée existe.
 */
if (!method_exists($controller, $action)) {
    die("Action introuvable : " . $action);
}

/**
 * Récupère l'identifiant depuis l'URL si présent.
 */
$id = $_GET['id'] ?? null;

/**
 * Exécute l'action.
 */
if ($id !== null) {
    $controller->$action($id);
} else {
    $controller->$action();
}