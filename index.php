<?php

/**
 * Point d'entrée de l'application
 * 
 * Ce fichier est le point d'entrée principal de l'application. Il gère les requêtes entrantes,
 * détermine le contrôleur et l'action à exécuter, et délègue la responsabilité au contrôleur approprié.
 * 
 * @package Application
 */

/**
 * Démarre la session PHP pour gérer les informations de session.
 */
session_start();
/**
 * Récupère le nom du contrôleur et de l'action à partir des paramètres GET.
 * Si aucun paramètre n'est fourni, utilise les valeurs par défaut.
 */
$controllerName = $_GET['controller'] ?? 'lieu';
$action = $_GET['action'] ?? 'index';

/**
 * Génère le nom de la classe du contrôleur à partir du nom du contrôleur.
 * 
 * @param string $controllerName Le nom du contrôleur.
 * @return string Le nom de la classe du contrôleur.
 */
$controllerClass = ucfirst($controllerName) . 'Controller';

/**
 * Construit le chemin vers le fichier du contrôleur.
 * 
 * @var string $controllerFile Le chemin complet vers le fichier du contrôleur.
 */
$controllerFile = __DIR__ . '/controllers/' . $controllerClass . '.php';

if (!file_exists($controllerFile)) {
    die("Contrôleur introuvable : " . $controllerClass);
}

/**
 * Inclut le fichier du contrôleur.
 */
require_once $controllerFile;

/**
 * Vérifie si la classe du contrôleur existe.
 * 
 * @param string $controllerClass Le nom de la classe du contrôleur.
 * @return bool True si la classe existe, false sinon.
 */
if (!class_exists($controllerClass)) {
    die("Classe du contrôleur introuvable : " . $controllerClass);
}

/**
 * Crée une instance du contrôleur.
 * 
 * @var object $controller L'instance du contrôleur.
 */
$controller = new $controllerClass();

/**
 * Vérifie si la méthode de l'action existe dans le contrôleur.
 * 
 * @param object $controller L'instance du contrôleur.
 * @param string $action Le nom de l'action à exécuter.
 * @return bool True si la méthode existe, false sinon.
 */
if (!method_exists($controller, $action)) {
    die("Action introuvable : " . $action);
}

/**
 * Récupère l'identifiant (id) à partir des paramètres GET, si disponible.
 * Si un identifiant est fourni, appelle l'action avec l'identifiant comme argument.
 * Sinon, appelle l'action sans argument.
 */
$id = $_GET['id'] ?? null;

if ($id !== null) {
    $controller->$action($id);
} else {
    $controller->$action();
}