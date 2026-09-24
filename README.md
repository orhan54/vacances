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
- **DAOInterface** : contrat générique (`create`, `findAll`, `findById`, `update`, `delete`).
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
├── sql/
│   └── schema.sql
├── index.php
└── README.md
```

## Modèle de données

5 tables, issues d'un MCD/MPD validé (voir `sql/schema.sql`) :

| Table         | Rôle                                                  | Clé                                |
| ------------- | ----------------------------------------------------- | ---------------------------------- |
| `user`        | Comptes utilisateurs (admin / utilisateur)            | `id_user` (auto-incrémenté)        |
| `lieu`        | Lieux de vacances proposés par un admin               | `id_lieu` (auto-incrémenté)        |
| `reservation` | Réservations d'un lieu par un utilisateur (répétable) | `id_reservation` (auto-incrémenté) |
| `commenter`   | Un commentaire par couple (utilisateur, lieu)         | composite `(id_user, id_lieu)`     |
| `liker`       | Un like par couple (utilisateur, lieu)                | composite `(id_user, id_lieu)`     |

## Installation

1. Cloner le dépôt dans le dossier `htdocs` de XAMPP.
2. Démarrer Apache et MySQL depuis le panneau XAMPP.
3. Créer une base de données (ex : `vacances`) dans phpMyAdmin, puis importer `sql/schema.sql`.
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
- [ ] Connexion Singleton
- [ ] Entités et DAO
- [ ] Authentification (inscription, connexion, rôles)
- [ ] CRUD des lieux (admin)
- [ ] Réservation, like, commentaire (utilisateur)
- [ ] Habillage Tailwind
- [ ] Hébergement en ligne
