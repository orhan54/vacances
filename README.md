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
selon le pattern **Entité / DAO / Interface** :

- **Router** (`index.php`) : point d'entrée unique, dispatch dynamique vers le bon
  contrôleur/méthode à partir des paramètres `controller`, `action`, et `id` en `$_GET`.
- **Controller** : orchestre une requête (appelle le DAO, inclut la bonne vue).
- **Entity** : objet métier pur (propriétés typées, constructeur, getters/setters).
- **DAOInterface** : contrat générique (`create`, `read`, `update`, `delete`, `findAll`).
- **DAO** : implémente l'interface, exécute le SQL (requêtes préparées), convertit les
  lignes en objets Entité.
- **View** : affichage HTML/Tailwind, reçoit ses données du contrôleur.
- **Database** (Singleton) : une seule connexion PDO réutilisée dans toute l'application.

## Arborescence du projet

```
vacances/
├── config/
│   └── Database.php
├── controllers/
│   ├── AuthController.php
│   ├── LieuController.php
│   ├── ReservationController.php
│   └── UserController.php
├── models/
│   ├── entity/
│   │   ├── User.php
│   │   ├── Lieu.php
│   │   ├── Reservation.php
│   │   ├── Commentaire.php
│   │   └── Like.php
│   └── dao/
│       ├── DAOInterface.php
│       ├── UserDAO.php
│       ├── LieuDAO.php
│       ├── ReservationDAO.php
│       ├── CommentaireDAO.php
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
5. Ouvrir `http://localhost/vacances/`.

## Workflow Git

Le projet suit un modèle à 3 niveaux de branches :

- **`main`** — code stable, déployé/hébergé. On n'y pousse jamais directement.
- **`dev`** — branche d'intégration, où les fonctionnalités terminées sont regroupées avant
  d'aller en production.
- **`feature/nom-de-la-fonctionnalite`** — une branche par fonctionnalité, créée depuis `dev`.

### Cycle pour une nouvelle fonctionnalité

1. Se placer sur `dev` et la mettre à jour : `git checkout dev` puis `git pull`.
2. Créer la branche de fonctionnalité : `git checkout -b feature/base-donnees`.
3. Développer, committer régulièrement avec des messages clairs (convention ci-dessous).
4. Pousser la branche : `git push -u origin feature/base-donnees`.
5. Une fois la fonctionnalité terminée et testée, fusionner dans `dev` (via Pull Request sur
   GitHub, ou merge local) : `git checkout dev` puis `git merge feature/base-donnees`.
6. Quand `dev` est stable et prête à être publiée : fusionner `dev` dans `main`, puis
   déployer sur l'hébergement.

### Convention de messages de commit

```
feat: ajout de l'authentification utilisateur
fix: correction de la contrainte unique sur les likes
docs: mise à jour du README
refactor: extraction de la logique de connexion dans TaskDAO
```

## État d'avancement

- [x] Modélisation MCD/MPD
- [x] Création des tables SQL
- [x] Connexion Singleton
- [x] Entité + DAO : `User` (CRUD testé : create, read, update, delete)
- [x] Entité + DAO : `Lieu` (CRUD testé : create, read, update, delete)
- [ ] Entité + DAO : `Reservation`
- [ ] Entité + DAO : `Commentaire`
- [ ] Entité + DAO : `Like`
- [ ] Authentification (inscription, connexion, rôles)
- [ ] CRUD des lieux (admin, avec upload d'image)
- [ ] Réservation, like, commentaire (utilisateur)
- [ ] Habillage Tailwind
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
