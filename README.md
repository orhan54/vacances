# Vacances — Plateforme de réservation de lieux

Plateforme web permettant à un administrateur de proposer des lieux de vacances, et aux
utilisateurs de consulter, réserver, aimer et commenter ces lieux.

## Sommaire

- [Stack technique](#stack-technique)
- [Architecture](#architecture)
- [Arborescence du projet](#arborescence-du-projet)
- [Modèle de données](#modèle-de-données)
- [Installation](#installation)
- [Workflow Git](#workflow-git)
- [État d'avancement](#état-davancement)
- [Conventions du DAO](#conventions-du-dao)
- [Authentification et rôles](#authentification-et-rôles)

## Stack technique

| Domaine             | Technologie                             |
| ------------------- | --------------------------------------- |
| Langage back-end    | PHP 8.2 (orienté objet, sans framework) |
| Base de données     | MySQL                                   |
| Accès aux données   | PDO, requêtes préparées                 |
| Front-end           | HTML5, Tailwind CSS                     |
| Serveur local       | XAMPP (Apache + MySQL)                  |
| Gestion de versions | Git                                     |

## Architecture

Le projet suit une architecture **MVC** maison (sans framework), avec un modèle structuré
selon le pattern **Entité / DAO / Interface**, et une couche d'autorisation séparée :

- **Router** (`index.php`) : point d'entrée unique. Démarre la session (`session_start()`),
  lit `controller`, `action` et `id` en `$_GET`, instancie dynamiquement le bon contrôleur
  et appelle la bonne méthode (avec l'id en argument si présent).
- **Controller** : orchestre une requête (appelle le DAO, inclut la bonne vue, applique les
  règles d'accès via `Auth`).
- **Entity** : objet métier pur (propriétés typées, constructeur, getters/setters).
- **DAOInterface** : contrat générique (`create`, `read`, `update`, `delete`, `findAll`).
- **DAO** : implémente l'interface, exécute le SQL (requêtes préparées), convertit les
  lignes en objets Entité.
- **Auth** (`middleware/Auth.php`) : classe statique centralisant les vérifications de
  session et de rôle (`estConnecte`, `estAdmin`, `exigerConnexion`, `exigerAdmin`).
- **View** : affichage HTML/Tailwind, reçoit ses données du contrôleur.
- **Database** (Singleton) : une seule connexion PDO réutilisée dans toute l'application.

## Arborescence du projet

```
vacances/
├── config/
│   └── Database.php
├── controllers/
│   ├── UserController.php
│   ├── LieuController.php
│   ├── ReservationController.php
│   ├── CommenterController.php
│   └── LikeController.php
├── middleware/
│   └── Auth.php
├── models/
│   ├── entity/
│   │   ├── User.php
│   │   ├── Lieu.php
│   │   ├── Reservation.php
│   │   ├── Commenter.php
│   │   └── Like.php
│   └── dao/
│       ├── DAOInterface.php
│       ├── UserDAO.php
│       ├── LieuDAO.php
│       ├── ReservationDAO.php
│       ├── CommenterDAO.php
│       └── LikeDAO.php
├── views/
│   ├── auth/
│   │   ├── login.php
│   │   └── register.php
│   ├── lieux/
│   │   ├── index.php
│   │   ├── show.php
│   │   ├── create.php
│   │   └── edit.php
│   └── reservations/
│       └── index.php
├── public/
│   └── css/ (si besoin de CSS custom en complément de Tailwind)
├── SQL/
│   └── script.sql
├── index.php
└── README.md
```

## Modèle de données

5 tables, issues d'un MCD/MPD validé (voir `SQL/script.sql`) :

| Table         | Rôle                                                                                            | Clé                                |
| ------------- | ----------------------------------------------------------------------------------------------- | ---------------------------------- |
| `Users`       | Comptes utilisateurs (admin / utilisateur)                                                      | `Id_User` (auto-incrémenté)        |
| `Lieu`        | Lieux de vacances proposés par un admin (nom, adresse, CP, téléphone, description, prix, image) | `Id_Lieu` (auto-incrémenté)        |
| `Reservation` | Réservations d'un lieu par un utilisateur (répétable)                                           | `Id_Reservation` (auto-incrémenté) |
| `Commenter`   | Un commentaire par couple (utilisateur, lieu)                                                   | composite `(Id_User, Id_Lieu)`     |
| `Likes`       | Un like par couple (utilisateur, lieu)                                                          | composite `(Id_User, Id_Lieu)`     |

## Installation

1. Cloner le dépôt dans le dossier `htdocs` de XAMPP.
2. Démarrer Apache et MySQL depuis le panneau XAMPP.
3. Créer une base de données (ex : `vacances`) dans phpMyAdmin, puis importer `SQL/script.sql`.
4. Renseigner les identifiants de connexion dans `config/Database.php`.
5. Ouvrir `http://localhost/vacances/` (affiche directement la liste des lieux, accessible
   sans connexion).

## Workflow Git

Le projet suit un modèle à 3 niveaux de branches :

- **`main`** — code stable, déployé/hébergé. On n'y pousse jamais directement.
- **`dev`** — branche d'intégration, où les fonctionnalités terminées sont regroupées avant
  d'aller en production.
- **`feature/nom-de-la-fonctionnalite`** — une branche par fonctionnalité, créée depuis `dev`.

### Cycle pour une nouvelle fonctionnalité

1. Se placer sur `dev` et la mettre à jour : `git checkout dev` puis `git pull`.
2. Créer la branche de fonctionnalité : `git checkout -b feature/nom-du-module`.
3. Développer, tester manuellement chaque méthode, puis committer avec des messages clairs.
4. Pousser la branche : `git push -u origin feature/nom-du-module`.
5. Fusionner dans `dev` : `git checkout dev` puis `git merge feature/nom-du-module`, `git push`.
6. Nettoyer si besoin : `git branch -d feature/nom-du-module` puis
   `git push origin --delete feature/nom-du-module`.
7. Quand `dev` est stable et prête à être publiée : fusionner `dev` dans `main`, puis
   déployer sur l'hébergement.

### Convention de messages de commit

```
feat: ajout d'une nouvelle fonctionnalite
fix: correction d'un bug
docs: mise a jour de la documentation
refactor: reorganisation du code sans changement de comportement
```

## État d'avancement

- [x] Modélisation MCD/MPD
- [x] Création des tables SQL
- [x] Connexion Singleton
- [x] Entité + DAO : `User` (CRUD testé : create, read, update, delete)
- [x] Entité + DAO : `Lieu` (CRUD testé : create, read, update, delete)
- [x] Entité + DAO : `Reservation` (CRUD testé : create, read, update, delete)
- [x] Entité + DAO : `Commenter` (create, findByUserAndLieu, update, deleteByUserAndLieu, findAll)
- [x] Entité + DAO : `Like` (create, findByUserAndLieu, deleteByUserAndLieu, findAll)
- [x] Authentification (inscription, connexion, déconnexion)
- [x] Protection par rôle (classe `Auth`, appliquée sur `LieuController`)
- [x] CRUD des lieux (admin) — `LieuController` complet et protégé
- [x] Page détail d'un lieu (`show.php`) avec affichage des informations
- [x] Commentaires : ajout, affichage, modification et suppression par l'utilisateur connecté
- [x] Likes : ajout et retrait du Like par l'utilisateur connecté
- [ ] Upload réel d'image pour un lieu (actuellement un simple chemin texte)
- [ ] Réservation, like, commentaire (actions utilisateur connecté)
- [ ] Habillage Tailwind sur l'ensemble des vues
- [ ] Hébergement en ligne

## Conventions du DAO

- Chaque DAO implémente `DAOInterface` : `create(object)`, `read(int $id)`, `update(object)`,
  `delete(int $id)`, `findAll()`. Pas de `findById()` séparé — `read()` couvre déjà ce besoin.
- Chaque méthode `create`/`update` vérifie le type réel de l'objet reçu (`instanceof`) avant
  de l'utiliser, puisque l'interface accepte un `object` générique.
- Les dates (`*_created_at`) sont converties en véritable objet `DateTime` dans le DAO au
  moment de la lecture (`new DateTime($row['...'])`), et reformatées en chaîne
  (`->format('Y-m-d H:i:s')`) au moment de l'écriture en base.
- Seule `create()` sur `UserDAO` hache le mot de passe (`password_hash`) ; `update()` ne le
  touche jamais, pour ne pas re-hacher un hash déjà stocké.
- Convention de nommage : les classes/entités restent au singulier (`User`, `Lieu`), seul le
  nom réel de la table SQL (`Users`, `Lieu`) est utilisé tel quel à l'intérieur des requêtes.
- `Commenter` et `Likes` n'ont pas d'id auto-incrémenté propre : leur clé primaire est la
  paire `(Id_User, Id_Lieu)`. Leurs entités n'ont donc pas de propriété `id`, et leurs DAO
  n'implémentent pas `read()`/`delete()` au sens strict (ces deux méthodes lèvent une
  exception) — ils exposent à la place `findByUserAndLieu()` et `deleteByUserAndLieu()`.

## Authentification et rôles

- `session_start()` est appelé une seule fois, tout en haut de `index.php` (le routeur),
  pour que `$_SESSION` soit disponible dans tous les contrôleurs sans avoir à y penser.
- À la connexion (`UserController::authenticate()`), 4 informations sont stockées en
  session : `user_id`, `user_prenom`, `user_email`, `user_role`. Ça évite une requête SQL
  supplémentaire sur chaque page pour ces infos de base, au prix d'un léger décalage
  possible si le rôle est changé en base pendant qu'une session est active.
- Les mots de passe sont hachés avec `password_hash()` (algorithme `PASSWORD_DEFAULT`) à
  l'inscription, et vérifiés avec `password_verify()` à la connexion.
- La classe statique `Auth` (`middleware/Auth.php`) centralise les contrôles d'accès :
  - `Auth::estConnecte()` / `Auth::estAdmin()` : simples vérifications booléennes.
  - `Auth::exigerConnexion()` : redirige vers le login si personne n'est connecté.
  - `Auth::exigerAdmin()` : appelle `exigerConnexion()` puis redirige vers la liste des
    lieux si la personne est connectée mais n'est pas admin.
- Chaque méthode de contrôleur qui doit être protégée appelle `Auth::exigerAdmin()` (ou
  `exigerConnexion()`) en toute première ligne, avant tout autre traitement.
