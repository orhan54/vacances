# Vacances — Plateforme de réservation de lieux

Plateforme web permettant à un administrateur de proposer des lieux de vacances, et aux utilisateurs de consulter, réserver, aimer et commenter ces lieux.

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
- [Réservation et calendrier](#réservation-et-calendrier)

## Stack technique

| Domaine             | Technologie                             |
| ------------------- | --------------------------------------- |
| Langage back-end    | PHP 8.2 (orienté objet, sans framework) |
| Base de données     | MySQL                                   |
| Accès aux données   | PDO, requêtes préparées                 |
| Front-end           | HTML5, CSS, JavaScript                  |
| Calendrier          | Flatpickr                               |
| Serveur local       | XAMPP (Apache + MySQL)                  |
| Gestion de versions | Git                                     |

## Architecture

Le projet suit une architecture **MVC** maison (sans framework), avec un modèle structuré selon le pattern **Entité / DAO / Interface**, et une couche d'autorisation séparée.

- **Router** (`index.php`) : point d'entrée unique. Démarre la session (`session_start()`), lit `controller`, `action` et `id` en `$_GET`, instancie dynamiquement le bon contrôleur et appelle la bonne méthode.
- **Controller** : orchestre une requête, appelle les DAO, inclut les vues et applique les règles d'accès via `Auth`.
- **Entity** : objet métier pur avec propriétés typées, constructeur, getters et setters.
- **DAOInterface** : définit le contrat générique des DAO avec `create`, `read`, `update`, `delete` et `findAll`.
- **DAO** : implémente l'interface, exécute les requêtes SQL avec PDO et convertit les données de la base en objets Entité.
- **Auth** (`middleware/Auth.php`) : classe statique centralisant les vérifications de session et de rôle (`estConnecte`, `estAdmin`, `exigerConnexion`, `exigerAdmin`).
- **View** : affichage HTML et CSS, avec les données transmises par le contrôleur.
- **JavaScript** : gère les interactions côté client, notamment le calendrier de réservation et le blocage visuel des périodes déjà réservées.
- **Database** (Singleton) : fournit une seule connexion PDO réutilisée dans toute l'application.

## Arborescence du projet

```text
vacances/
├── config/
│   └── Database.php
│
├── controllers/
│   ├── UserController.php
│   ├── AuthController.php
│   ├── LieuController.php
│   ├── ReservationController.php
│   ├── CommenterController.php
│   └── LikeController.php
│
├── middleware/
│   └── Auth.php
│
├── models/
│   ├── entity/
│   │   ├── User.php
│   │   ├── Lieu.php
│   │   ├── Reservation.php
│   │   ├── Commenter.php
│   │   └── Like.php
│   │
│   └── dao/
│       ├── DAOInterface.php
│       ├── UserDAO.php
│       ├── LieuDAO.php
│       ├── ReservationDAO.php
│       ├── CommenterDAO.php
│       └── LikeDAO.php
│
├── views/
│   ├── auth/
│   │   ├── login.php
│   │   ├── register.php
│   │   └── welcome.php
│   │
│   ├── lieux/
│   │   ├── index.php
│   │   ├── show.php
│   │   ├── create.php
│   │   └── edit.php
│   │
│   └── reservations/
│       ├── index.php
│       └── create.php
│
├── public/
│   ├── css/
│   │   ├── auth/
│   │   │   └── style.css
│   │   └── reservations/
│   │       └── style.css
│   │
│   └── js/
│       └── reservations/
│           └── App.js
│
├── SQL/
│   └── script.sql
│
├── index.php
└── README.md
```

## Modèle de données

5 tables, issues d'un MCD/MPD validé (voir `SQL/script.sql`) :

| Table         | Rôle                                                                                            | Clé                                |
| ------------- | ----------------------------------------------------------------------------------------------- | ---------------------------------- |
| `Users`       | Comptes utilisateurs (admin / utilisateur)                                                      | `Id_User` (auto-incrémenté)        |
| `Lieu`        | Lieux de vacances proposés par un admin (nom, adresse, CP, téléphone, description, prix, image) | `Id_Lieu` (auto-incrémenté)        |
| `Reservation` | Réservations d'un lieu par un utilisateur                                                       | `Id_Reservation` (auto-incrémenté) |
| `Commenter`   | Un commentaire par couple (utilisateur, lieu)                                                   | composite `(Id_User, Id_Lieu)`     |
| `Likes`       | Un like par couple (utilisateur, lieu)                                                          | composite `(Id_User, Id_Lieu)`     |

La table `Reservation` contient notamment :

- l'utilisateur ayant effectué la réservation ;
- le lieu réservé ;
- la date de début ;
- la date de fin ;
- le statut de la réservation (`confirmee` ou `annulee`) ;
- la date de création de la réservation.

Les périodes déjà réservées sont récupérées depuis la base de données et affichées comme indisponibles dans le calendrier de réservation.

## Installation

1. Cloner le dépôt dans le dossier `htdocs` de XAMPP.
2. Démarrer Apache et MySQL depuis le panneau XAMPP.
3. Créer une base de données, par exemple `vacances`, dans phpMyAdmin, puis importer `SQL/script.sql`.
4. Renseigner les identifiants de connexion dans `config/Database.php`.
5. Ouvrir :

```text
http://localhost/vacances/
```

La liste des lieux est accessible sans connexion.

Pour effectuer une réservation, l'utilisateur doit être connecté.

## Workflow Git

Le projet suit un modèle à 3 niveaux de branches :

- **`main`** — code stable, déployé/hébergé. On n'y pousse jamais directement.
- **`dev`** — branche d'intégration, où les fonctionnalités terminées sont regroupées avant d'aller en production.
- **`feature/nom-de-la-fonctionnalite`** — une branche par fonctionnalité, créée depuis `dev`.

### Cycle pour une nouvelle fonctionnalité

1. Se placer sur `dev` et la mettre à jour :

```bash
git checkout dev
git pull
```

2. Créer la branche de fonctionnalité :

```bash
git checkout -b feature/nom-du-module
```

3. Développer, tester manuellement chaque méthode, puis committer avec des messages clairs.

4. Pousser la branche :

```bash
git push -u origin feature/nom-du-module
```

5. Fusionner dans `dev` :

```bash
git checkout dev
git merge feature/nom-du-module
git push
```

6. Nettoyer si besoin :

```bash
git branch -d feature/nom-du-module
git push origin --delete feature/nom-du-module
```

7. Quand `dev` est stable et prête à être publiée : fusionner `dev` dans `main`, puis déployer sur l'hébergement.

### Convention de messages de commit

```text
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
- [x] Réservation d'un lieu par un utilisateur connecté
- [x] Vérification de disponibilité des périodes
- [x] Blocage des périodes déjà réservées dans le calendrier
- [x] Affichage des réservations de l'utilisateur connecté
- [x] Annulation d'une réservation
- [x] Gestion des statuts `confirmee` et `annulee`
- [x] Redirection après connexion avec le pattern Post/Redirect/Get
- [ ] Upload réel d'image pour un lieu (actuellement un simple chemin texte)
- [ ] Habillage Tailwind sur l'ensemble des vues
- [ ] Hébergement en ligne

## Conventions du DAO

- Chaque DAO implémente `DAOInterface` : `create(object)`, `read(int $id)`, `update(object)`, `delete(int $id)`, `findAll()`. Pas de `findById()` séparé — `read()` couvre déjà ce besoin.
- Chaque méthode `create`/`update` vérifie le type réel de l'objet reçu (`instanceof`) avant de l'utiliser, puisque l'interface accepte un `object` générique.
- Les dates (`*_created_at`) sont converties en véritable objet `DateTime` dans le DAO au moment de la lecture (`new DateTime($row['...'])`), et reformatées en chaîne (`->format('Y-m-d H:i:s')`) au moment de l'écriture en base.
- Seule `create()` sur `UserDAO` hache le mot de passe (`password_hash`) ; `update()` ne le touche jamais, pour ne pas re-hacher un hash déjà stocké.
- Convention de nommage : les classes/entités restent au singulier (`User`, `Lieu`), seul le nom réel de la table SQL (`Users`, `Lieu`) est utilisé tel quel à l'intérieur des requêtes.
- `Commenter` et `Likes` n'ont pas d'id auto-incrémenté propre : leur clé primaire est la paire `(Id_User, Id_Lieu)`. Leurs entités n'ont donc pas de propriété `id`, et leurs DAO n'implémentent pas `read()`/`delete()` au sens strict (ces deux méthodes lèvent une exception) — ils exposent à la place `findByUserAndLieu()` et `deleteByUserAndLieu()`.
- `ReservationDAO` possède des méthodes spécifiques à la réservation, notamment `findByUserId()`, `isAvailable()` et `findConfirmedByLieuId()`, afin de récupérer les réservations d'un utilisateur et de vérifier les périodes déjà réservées.

## Authentification et rôles

- `session_start()` est appelé une seule fois, tout en haut de `index.php` (le routeur), pour que `$_SESSION` soit disponible dans tous les contrôleurs sans avoir à y penser.
- À la connexion (`UserController::authenticate()`), 4 informations sont stockées en session : `user_id`, `user_prenom`, `user_email`, `user_role`.
- Les mots de passe sont hachés avec `password_hash()` (algorithme `PASSWORD_DEFAULT`) à l'inscription, et vérifiés avec `password_verify()` à la connexion.
- La classe statique `Auth` (`middleware/Auth.php`) centralise les contrôles d'accès :
  - `Auth::estConnecte()` / `Auth::estAdmin()` : simples vérifications booléennes.
  - `Auth::exigerConnexion()` : redirige vers le login si personne n'est connecté.
  - `Auth::exigerAdmin()` : appelle `exigerConnexion()` puis redirige vers la liste des lieux si la personne est connectée mais n'est pas admin.
- Chaque méthode de contrôleur qui doit être protégée appelle `Auth::exigerAdmin()` ou `Auth::exigerConnexion()` en toute première ligne, avant tout autre traitement.
- Après une connexion réussie, l'utilisateur est redirigé vers une page dédiée avec le pattern **Post/Redirect/Get**, ce qui évite les erreurs `ERR_CACHE_MISS` ou les demandes de renvoi du formulaire lors de l'utilisation du bouton précédent du navigateur.
- La réservation nécessite une connexion utilisateur.
- Un utilisateur ne peut consulter et annuler que ses propres réservations.
- Un administrateur dispose des droits nécessaires à la gestion des lieux.

## Réservation et calendrier

Le système de réservation permet à un utilisateur connecté de :

1. Consulter les lieux disponibles.
2. Sélectionner un lieu.
3. Ouvrir le calendrier de réservation.
4. Visualiser les périodes déjà réservées.
5. Sélectionner une période disponible.
6. Enregistrer la réservation.
7. Consulter ses réservations.
8. Annuler une réservation.

Le calendrier utilise **Flatpickr**.

Les réservations confirmées sont récupérées depuis la base de données pour le lieu sélectionné. Les périodes correspondantes sont automatiquement désactivées et affichées comme indisponibles dans le calendrier.

Chaque lieu possède son propre calendrier. Les disponibilités affichées correspondent uniquement aux réservations du lieu sélectionné.

Lorsqu'une réservation est annulée, son statut passe à `annulee`. Elle n'est alors plus considérée comme bloquante pour une nouvelle réservation.

La disponibilité est également vérifiée côté serveur avec `ReservationDAO::isAvailable()`, afin de ne pas dépendre uniquement du contrôle JavaScript côté client.

Ainsi, même si deux utilisateurs tentent de réserver la même période, la vérification côté serveur empêche la création d'une réservation en conflit.
