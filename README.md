# 🏡 Vacances — Application de réservation de lieux

Application web de réservation de lieux développée en **PHP 8.2 orienté objet**, selon une architecture **MVC avec DAO**, permettant aux utilisateurs de consulter des lieux, les noter, les commenter, les aimer et effectuer des réservations.

Les administrateurs disposent d'un espace permettant de gérer les lieux proposés à la réservation.

---

## 🚀 Fonctionnalités

### 👤 Authentification

- Inscription utilisateur
- Connexion utilisateur
- Déconnexion
- Hashage sécurisé des mots de passe avec `password_hash()`
- Vérification des mots de passe avec `password_verify()`
- Gestion des sessions PHP
- Gestion des rôles utilisateur / administrateur
- Protection des actions sensibles avec le middleware `Auth`
- Protection CSRF des formulaires d'authentification

### 🏠 Gestion des lieux

Les administrateurs peuvent :

- Ajouter un lieu
- Modifier un lieu
- Supprimer un lieu
- Consulter la liste des lieux
- Consulter le détail d'un lieu
- Ajouter une image lors de la création d'un lieu
- Afficher l'image associée au lieu
- Gérer les informations :
  - Nom
  - Adresse
  - Code postal
  - Téléphone
  - Description
  - Prix par jour
  - Image

Les images sont contrôlées côté serveur :

- Taille maximale : 5 Mo
- Formats autorisés : JPG, PNG et WEBP
- Génération d'un nom de fichier aléatoire
- Stockage dans `public/images/`

Les formulaires de création, de modification et de suppression sont protégés contre les requêtes CSRF.

### ❤️ Likes

Les utilisateurs connectés peuvent :

- Ajouter un Like à un lieu
- Retirer leur Like
- Voir le nombre de Likes d'un lieu
- Voir si le lieu a déjà été aimé par l'utilisateur connecté

Le système utilise une clé primaire composée :

```text
(Id_User, Id_Lieu)
```

Les actions d'ajout et de retrait d'un Like utilisent une requête POST et une vérification du jeton CSRF côté serveur.

### ⭐ Commentaires et notation

Les utilisateurs connectés peuvent :

- Ajouter un commentaire
- Modifier leur commentaire
- Supprimer leur commentaire
- Attribuer une note de 1 à 5 étoiles
- Consulter les commentaires associés à un lieu

La page des lieux affiche également :

- La moyenne des notes
- Le nombre total d'avis
- La mention `Aucun avis` lorsqu'un lieu n'a encore reçu aucune note

Les actions de création, de modification et de suppression des commentaires sont protégées contre les requêtes CSRF.

Le JavaScript dédié aux commentaires est situé dans :

```text
public/js/commentaires/App.js
```

### 📅 Réservations

Les utilisateurs connectés peuvent :

- Consulter un lieu
- Accéder au formulaire de réservation
- Sélectionner une date de début
- Sélectionner une date de fin
- Vérifier la disponibilité du lieu
- Créer une réservation
- Consulter leurs réservations
- Annuler une réservation

Les périodes déjà réservées et confirmées sont automatiquement bloquées dans le calendrier.

Les réservations possèdent notamment les statuts :

```text
confirmee
annulee
```

La création et l'annulation des réservations sont protégées par une vérification CSRF côté serveur.

### 🗓️ Calendrier interactif

Le calendrier des réservations utilise **Flatpickr**.

Le JavaScript permet notamment :

- L'affichage d'un calendrier interactif
- La sélection des dates
- Le blocage des périodes déjà réservées
- La gestion des dates de début et de fin
- Le contrôle côté client avant l'envoi du formulaire

Le fichier principal est situé dans :

```text
public/js/reservations/App.js
```

La disponibilité est également vérifiée côté serveur afin de ne pas dépendre uniquement des contrôles réalisés dans le navigateur.

---

## 🏗️ Architecture du projet

Le projet utilise une architecture **MVC + DAO** afin de séparer :

- La logique métier
- L'accès aux données
- Les entités
- Les contrôleurs
- Les vues
- Les mécanismes de sécurité transversaux

### 📁 Structure

```text
vacances/
│
├── .env
├── .gitignore
├── index.php
├── README.md
│
├── config/
│   └── Database.php
│
├── controllers/
│   ├── AuthController.php
│   ├── UserController.php
│   ├── LieuController.php
│   ├── ReservationController.php
│   ├── CommenterController.php
│   └── LikeController.php
│
├── middleware/
│   ├── Auth.php
│   └── Csrf.php
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
│   │   ├── Auth/
│   │   │   └── style.css
│   │   │
│   │   └── reservations/
│   │       └── style.css
│   │
│   ├── js/
│   │   ├── reservations/
│   │   │   └── App.js
│   │   │
│   │   └── commentaires/
│   │       └── App.js
│   │
│   └── images/
│       ├── BG/
│       │   └── BG_welcome.jpg
│       │
│       └── [images des lieux]
│
└── SQL/
    └── script.sql
```

### ⚙️ Configuration

Les paramètres de l'environnement local sont stockés dans le fichier `.env`, situé à la racine du projet.

Le fichier `.env` contient les informations propres à l'environnement de développement et est exclu du dépôt Git grâce au `.gitignore`.

Le fichier `.env` ne doit jamais être publié sur GitHub.

---

## 🧩 Modèle de données

L'application utilise actuellement **5 tables principales**.

### 👤 User

Gère les utilisateurs de l'application.

Informations principales :

- Identifiant
- Prénom
- Nom
- Adresse
- Code postal
- Téléphone
- Email
- Mot de passe
- Rôle
- Date de création

### 🏠 Lieu

Représente les lieux disponibles à la réservation.

Informations principales :

- Identifiant
- Nom
- Adresse
- Code postal
- Téléphone
- Description
- Prix
- Image
- Date de création

### 📅 Reservation

Gère les réservations des utilisateurs.

Informations principales :

- Utilisateur
- Lieu
- Date de début
- Date de fin
- Statut
- Date de création

### 💬 Commenter

Permet aux utilisateurs de laisser un avis et une note sur un lieu.

Clé primaire composée :

```text
(Id_User, Id_Lieu)
```

Informations principales :

- Utilisateur
- Lieu
- Contenu du commentaire
- Note de 1 à 5
- Date de création

### ❤️ Like

Permet à un utilisateur d'aimer un lieu.

Clé primaire composée :

```text
(Id_User, Id_Lieu)
```

---

## 🛠️ Technologies utilisées

| Technologie  | Utilisation                                        |
| ------------ | -------------------------------------------------- |
| PHP 8.2      | Back-end / programmation orientée objet            |
| MySQL        | Base de données                                    |
| PDO          | Accès à la base de données avec requêtes préparées |
| HTML5        | Structure des pages                                |
| Tailwind CSS | Interface et mise en forme                         |
| JavaScript   | Interactions côté client                           |
| Flatpickr    | Calendrier des réservations                        |
| Lucide       | Icônes                                             |
| Git / GitHub | Gestion de versions                                |
| XAMPP        | Environnement de développement local               |

---

## 🔐 Sécurité

Plusieurs mesures de sécurité sont mises en place :

- Requêtes SQL préparées avec PDO
- Hashage sécurisé des mots de passe avec `password_hash()`
- Vérification des mots de passe avec `password_verify()`
- Gestion des sessions PHP
- Contrôle des rôles utilisateur / administrateur
- Protection des actions administrateur
- Protection CSRF des formulaires et des actions sensibles
- Validation des jetons CSRF côté serveur
- Utilisation de requêtes POST pour les opérations qui modifient les données
- Vérification des données reçues
- Échappement HTML avec `htmlspecialchars()`
- Contrôle des fichiers uploadés
- Vérification du type MIME des images
- Limitation de la taille des images
- Génération aléatoire des noms de fichiers
- Protection du fichier `.env` avec `.gitignore`

### 🛡️ Protection contre les attaques CSRF

La protection CSRF (_Cross-Site Request Forgery_) est implémentée dans le middleware dédié :

```text
middleware/Csrf.php
```

Elle repose sur les principes suivants :

- Génération d'un jeton aléatoire associé à la session PHP.
- Insertion du jeton dans les formulaires sensibles à l'aide d'un champ caché `csrf_token`.
- Transmission du jeton lors de l'envoi du formulaire.
- Validation du jeton côté serveur avant l'exécution de l'action.
- Refus des requêtes lorsque le jeton est absent, invalide ou incorrect.
- Utilisation de `hash_equals()` pour comparer les jetons de manière sécurisée.

Les contrôleurs concernés vérifient le jeton avant d'exécuter les actions protégées. Cette protection complète les contrôles d'authentification, de rôle et de propriété des données.

Un jeton CSRF valide ne remplace pas les vérifications de droits : chaque action sensible doit également contrôler que l'utilisateur est autorisé à l'effectuer.

---

## 🧱 Design Pattern et architecture

Le projet utilise plusieurs principes et patterns.

### MVC

Séparation entre :

```text
Model
View
Controller
```

### DAO

Chaque entité possède son propre DAO permettant de centraliser les requêtes SQL.

```text
User
 └── UserDAO

Lieu
 └── LieuDAO

Reservation
 └── ReservationDAO

Commenter
 └── CommenterDAO

Like
 └── LikeDAO
```

### Singleton

La connexion à la base de données est centralisée dans :

```text
config/Database.php
```

afin de réutiliser une instance de connexion PDO.

### Middleware

Le projet utilise deux classes complémentaires.

**`middleware/Auth.php`**

Permet notamment de vérifier :

- Si un utilisateur est connecté.
- Si l'utilisateur possède le rôle administrateur.
- Si une action nécessite une authentification.
- Si une action est réservée à l'administrateur.

**`middleware/Csrf.php`**

Permet notamment de :

- Générer un jeton CSRF.
- Fournir le jeton aux formulaires.
- Vérifier le jeton transmis lors des requêtes.
- Refuser les requêtes dont le jeton est absent ou invalide.

La séparation entre ces deux classes permet de distinguer la gestion des autorisations de la protection contre les requêtes CSRF.

---

## 🔄 Routage

L'application utilise un point d'entrée unique :

```text
index.php
```

Le contrôleur et l'action sont transmis via les paramètres GET.

Exemple :

```text
index.php?controller=lieu&action=index
```

Pour afficher un lieu :

```text
index.php?controller=lieu&action=show&id=8
```

Pour créer une réservation :

```text
index.php?controller=reservation&action=create&id_lieu=8
```

Les paramètres GET servent au routage et à l'affichage des pages. Les actions qui modifient les données utilisent des requêtes POST et appliquent les contrôles de sécurité nécessaires.

---

## 📅 Gestion des disponibilités

Lorsqu'un utilisateur souhaite réserver un lieu :

1. Le lieu est récupéré depuis la base de données.
2. Les réservations confirmées sont récupérées.
3. Les périodes déjà réservées sont transmises au calendrier.
4. Le JavaScript utilise ces informations avec Flatpickr.
5. Les périodes indisponibles sont bloquées dans le calendrier.
6. Le serveur vérifie la disponibilité avant de créer la réservation.
7. La requête est également protégée par un jeton CSRF.

La vérification côté serveur reste obligatoire afin de garantir l'intégrité des réservations, même si un utilisateur contourne les contrôles du navigateur.

---

## 🔀 Gestion des versions avec Git

Le projet utilise une organisation Git basée sur trois niveaux :

```text
main
 │
 └── dev
      │
      ├── feature/authentification
      ├── feature/lieux
      ├── feature/reservations
      ├── feature/commentaires
      └── feature/likes
```

### `main`

Branche stable destinée à la version finale du projet.

### `dev`

Branche d'intégration regroupant les fonctionnalités validées.

### `feature/*`

Branches utilisées pour développer les nouvelles fonctionnalités.

Exemple :

```bash
git checkout dev
git pull origin dev

git checkout -b feature/ma-fonctionnalite
```

Après développement et tests :

```bash
git add .
git commit -m "feat: ajout de ma fonctionnalité"
git push origin feature/ma-fonctionnalite
```

La branche peut ensuite être fusionnée dans `dev`.

---

## 🌐 Hébergement en ligne

L'application **Vacances** est déployée en ligne sur **AwardSpace**.

L'hébergement comprend :

- Hébergement PHP
- PHP 8.4 côté serveur
- Base de données MySQL
- Connexion de l'application à la base MySQL distante
- Déploiement des fichiers de l'application sur le serveur
- Application accessible publiquement depuis un navigateur

L'application est disponible à l'adresse suivante :

**https://vacancesapp.atwebpages.com/**

La base de données distante contient les tables :

```text
Users
Lieu
Reservation
Commenter
Likes
```

La configuration de connexion à la base de données est adaptée à l'environnement de production afin d'utiliser le serveur MySQL distant d'AwardSpace.

Les informations sensibles de l'environnement local sont protégées par le fichier `.gitignore`.

---

## 📊 État d'avancement

- [x] Modélisation MCD/MPD
- [x] Création des tables SQL
- [x] Connexion Singleton
- [x] Entité + DAO : `User` (CRUD testé)
- [x] Entité + DAO : `Lieu` (CRUD testé)
- [x] Entité + DAO : `Reservation` (CRUD testé)
- [x] Entité + DAO : `Commenter`
- [x] Entité + DAO : `Like`
- [x] Authentification (inscription, connexion, déconnexion)
- [x] Hashage sécurisé des mots de passe
- [x] Gestion des sessions
- [x] Protection par rôle avec la classe `Auth`
- [x] Protection CSRF avec le middleware `Csrf`
- [x] Génération et validation des jetons CSRF côté serveur
- [x] Intégration des jetons CSRF dans les formulaires sensibles
- [x] Test du refus d'une requête avec un jeton CSRF modifié
- [x] CRUD des lieux réservé à l'administrateur
- [x] Upload réel d'image pour un lieu
- [x] Contrôle du format et de la taille des images
- [x] Interface Tailwind CSS
- [x] JavaScript côté client avec `App.js`
- [x] JavaScript dédié aux commentaires avec `commentaires/App.js`
- [x] Calendrier interactif avec Flatpickr
- [x] Page détail d'un lieu
- [x] Ajout de commentaires
- [x] Modification des commentaires
- [x] Suppression des commentaires
- [x] Système de notation de 1 à 5
- [x] Calcul et affichage de la moyenne des avis
- [x] Affichage du nombre d'avis
- [x] Système de Likes
- [x] Ajout et retrait d'un Like
- [x] Affichage du nombre de Likes
- [x] Réservation d'un lieu
- [x] Vérification de disponibilité
- [x] Blocage des périodes réservées dans le calendrier
- [x] Affichage des réservations de l'utilisateur connecté
- [x] Annulation d'une réservation
- [x] Gestion des statuts `confirmee` et `annulee`
- [x] Redirection après connexion avec le pattern Post/Redirect/Get
- [x] Interface responsive
- [x] Mise en place du fichier `.env`
- [x] Protection du fichier `.env` avec `.gitignore`
- [x] Déploiement en ligne sur AwardSpace
- [x] Connexion à une base de données MySQL distante
- [x] Application accessible publiquement en ligne

---

## 🧪 Environnement de développement

Le projet est développé en local avec :

```text
XAMPP
├── Apache
└── MySQL
```

Le projet est placé dans :

```text
C:\xampp\htdocs\vacances
```

L'application est accessible localement depuis :

```text
http://localhost/vacances/
```

Une version de production est également disponible en ligne sur AwardSpace :

```text
https://vacancesapp.atwebpages.com/
```

---

## 🗃️ Base de données

### Environnement local

Base de données :

```text
vacances
```

La connexion locale est gérée par :

```text
config/Database.php
```

Le script SQL permettant de créer la structure de la base est disponible dans :

```text
SQL/script.sql
```

### Environnement de production

La version en ligne utilise une base de données **MySQL distante hébergée sur AwardSpace**.

Les tables utilisées sont :

```text
Users
Lieu
Reservation
Commenter
Likes
```

---

## 🎯 Objectifs du projet

Ce projet a été réalisé afin de mettre en pratique et de démontrer des compétences en :

- PHP orienté objet
- Architecture MVC
- DAO
- SQL / MySQL
- PDO
- CRUD
- Authentification
- Gestion des sessions
- Gestion des rôles
- Sécurité web
- Protection CSRF
- Upload de fichiers
- JavaScript
- Manipulation du DOM
- Tailwind CSS
- Calendrier interactif
- Gestion des réservations
- Gestion des commentaires
- Système de notation
- Système de Likes
- Git / GitHub
- Déploiement d'une application web
- Configuration d'un environnement de production

---

## 🚧 Évolutions possibles

Certaines améliorations pourront être ajoutées ultérieurement :

- [ ] Gestion de plusieurs images par lieu
- [ ] Galerie d'images
- [ ] Système de réservation plus avancé
- [ ] Notifications utilisateur

---

## 👨‍💻 Auteur

**Orhan Cicek**

Développeur Web / Concepteur Développeur d'Application

Projet réalisé dans le cadre de mon parcours de formation et de ma recherche d'un contrat d'apprentissage en développement full-stack.
