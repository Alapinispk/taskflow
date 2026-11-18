## TaskFlow — Gestionnaire de Tâches Moderne (Laravel)

**TaskFlow** est une application web de gestion de tâches (Todo List) conçue avec **Laravel**, **Tailwind CSS** et **Alpine.js**. Elle offre une expérience utilisateur fluide et réactive grâce à des interactions en **AJAX** (sans rechargement de page) et un système d'authentification complet et sécurisé.

---

## Fonctionnalités principales

### Authentification & Sécurité
- **Système complet** : Inscription, connexion, déconnexion et réinitialisation de mot de passe par email (propulsé par Laravel Breeze).
- **Isolation stricte des données** : Chaque utilisateur accède uniquement à ses propres tâches et catégories.
- **Sécurité renforcée** : Hachage des mots de passe (Bcrypt), protection CSRF native et vérification serveur des autorisations avant toute modification ou suppression.

### Gestion des Tâches & Catégories (AJAX)
- **CRUD complet en temps réel** : Ajout via modale dédiée, modification rapide du statut (`À faire` / `Terminée`) et suppression sans rechargement de page.
- **Organisation avancée** : Attribution de niveaux de priorité (`Basse`, `Moyenne`, `Haute`), de dates d'échéance et de catégories personnalisées.
- **Filtres & Recherche instantanée** : Recherche dynamique par mot-clé et filtrage combiné par statut (dont les tâches *En retard*), priorité ou catégorie.
- **Interface épurée** : Design moderne à bords droits (`rounded-none`) propulsé par Tailwind CSS et Lucide Icons.

---

## Stack Technique

- **Backend** : PHP 8.2+ / Laravel 11
- **Authentification** : Laravel Breeze
- **Frontend** : Blade, Tailwind CSS, Alpine.js (AJAX / Fetch API)
- **Base de données** : MySQL / MariaDB
- **Icônes** : Lucide Icons & Heroicons

---

## Installation en local

Suivez ces étapes pour installer et lancer le projet sur votre machine :

### 1. Cloner le dépôt
```bash
git clone https://github.com/Alapinispk/taskflow.git
cd taskflow
```

### 2. Installer les dépendances PHP et Node.js
```bash
composer install
npm install
```

### 3. Configurer l'environnement
Copiez le fichier d'exemple `.env.example` vers `.env` et générez la clé de l'application :
```bash
cp .env.example .env
php artisan key:generate
```

Ouvrez le fichier `.env` et renseignez les paramètres de votre base de données :
```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=todo_db
DB_USERNAME=root
DB_PASSWORD=
```

### 4. Exécuter les migrations
Créez les tables (`users`, `categories`, `tasks`, etc.) dans votre base de données :
```bash
php artisan migrate
```

### 5. Compiler les assets et lancer le serveur
Ouvrez deux terminaux :

**Terminal 1 (Serveur Laravel) :**
```bash
php artisan serve
```

**Terminal 2 (Compilation Vite / Tailwind CSS) :**
```bash
npm run dev
```

Rendez-vous ensuite sur [http://127.0.0.1:8000](http://127.0.0.1:8000) dans votre navigateur.

---

## Modèle de données

- **`users`** : `id`, `name`, `email`, `password`, `created_at`, `updated_at`
- **`categories`** : `id`, `user_id` (FK), `nom`, `created_at`, `updated_at`
- **`tasks`** : `id`, `user_id` (FK), `category_id` (FK nullable), `titre`, `description`, `statut` (`a_faire`, `terminee`), `priorite` (`basse`, `moyenne`, `haute`), `echeance`, `created_at`, `updated_at`

---

## Auteur

Développé par **SPK**.