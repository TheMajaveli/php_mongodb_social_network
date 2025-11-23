# API RESTful PHP - Réseau Social

API RESTful pour un réseau social utilisant PHP et MongoDB.

## Prérequis

- PHP 7.4 ou supérieur
- MongoDB PHP Driver (mongodb extension)
- MongoDB (local ou Atlas)
- Serveur web (Apache/Nginx) ou PHP built-in server

## Installation

1. Installer les dépendances PHP MongoDB :
```bash
composer require mongodb/mongodb
```

Ou installer l'extension MongoDB directement :
```bash
pecl install mongodb
```

2. Configurer la connexion MongoDB dans `config/database.php` :
   - Pour MongoDB local : `mongodb://localhost:27017`
   - Pour MongoDB Atlas : définir la variable d'environnement `MONGODB_URI`

3. Exécuter les migrations pour créer les collections et les données de test :
```bash
# Créer les collections et index (toutes les migrations)
php database/migrations/migrate.php

# Seeder les données
php database/seeders/seed.php

# Ou exécuter une migration individuelle
php -r "require 'database/migrations/CreateUsersCollection.php'; \$m = new CreateUsersCollection(); \$m->up();"
```

4. Démarrer le serveur PHP :
```bash
php -S localhost:8080 -t .
```

## Architecture du Système

### Philosophie de Conception

Cette API a été conçue avec les principes suivants en tête :

1. **Simplicité avant Complexité**
   - Structure claire et directe, sans sur-ingénierie
   - Patterns standards et reconnus (MVC, Singleton)
   - Code lisible et auto-documenté

2. **Maintenabilité à Long Terme**
   - Organisation modulaire facilitant les modifications
   - Séparation des responsabilités pour réduire les effets de bord
   - Documentation intégrée dans le code

3. **Évolutivité Progressive**
   - Facile d'ajouter de nouvelles fonctionnalités
   - Structure extensible sans refactoring majeur
   - Migration et seeding modulaires

4. **Performance et Efficacité**
   - Indexes MongoDB optimisés pour les requêtes fréquentes
   - Singleton pour éviter les connexions multiples
   - Pagination pour gérer de gros volumes

5. **Développement Rapide**
   - Structure prête à l'emploi
   - Patterns réutilisables
   - Outils de développement intégrés (migrations, seeders)

### Pourquoi cette Architecture ?

Cette API RESTful suit une **architecture en couches (layered architecture)** avec séparation claire des responsabilités. Cette approche offre plusieurs avantages :

#### ✅ **Séparation des Responsabilités**
- Chaque couche a un rôle précis et bien défini
- Facilite la maintenance et les tests
- Permet de modifier une couche sans affecter les autres

#### ✅ **Scalabilité**
- Facile d'ajouter de nouvelles fonctionnalités
- Structure modulaire permet l'extension progressive
- Chaque composant peut être optimisé indépendamment

#### ✅ **Maintenabilité**
- Code organisé et facile à naviguer
- Patterns cohérents dans tout le projet
- Documentation claire de chaque composant

#### ✅ **Testabilité**
- Chaque couche peut être testée indépendamment
- Mocking facilité grâce à l'injection de dépendances
- Tests unitaires et d'intégration simplifiés

#### ✅ **Réutilisabilité**
- Modèles réutilisables dans différents contextes
- Utilitaires partagés (Response, Database)
- Contrôleurs modulaires

### Comparaison avec d'Autres Approches

**Pourquoi pas un Framework (Laravel, Symfony) ?**
- ✅ **Légèreté** : Pas de dépendances lourdes, démarrage rapide
- ✅ **Contrôle** : Compréhension complète du code
- ✅ **Simplicité** : Pas de courbe d'apprentissage complexe
- ✅ **Performance** : Moins de surcharge, code minimal

**Pourquoi pas une Architecture Monolithique ?**
- ✅ **Organisation** : Séparation claire facilite la maintenance
- ✅ **Équipe** : Plusieurs développeurs peuvent travailler en parallèle
- ✅ **Tests** : Chaque couche testable indépendamment
- ✅ **Évolution** : Facile de refactoriser une couche sans toucher aux autres

**Pourquoi pas une API GraphQL ?**
- ✅ **Simplicité** : REST est plus simple à comprendre et implémenter
- ✅ **Standard** : REST est universellement supporté
- ✅ **Caching** : HTTP caching natif avec REST
- ✅ **Outils** : Nombreux outils de test et debugging pour REST

### Vue d'ensemble

Cette API RESTful suit une architecture en couches (layered architecture) avec séparation claire des responsabilités :

```
┌─────────────────────────────────────────┐
│         Client (HTTP Request)            │
└─────────────────┬───────────────────────┘
                  │
┌─────────────────▼───────────────────────┐
│         index.php (Entry Point)          │
└─────────────────┬───────────────────────┘
                  │
┌─────────────────▼───────────────────────┐
│         router.php (Routing)              │
└─────────────────┬───────────────────────┘
                  │
┌─────────────────▼───────────────────────┐
│      Controller (Business Logic)          │
│  - UserController                         │
│  - PostController                         │
│  - CategoryController                     │
│  - CommentController                      │
│  - LikeController                         │
│  - FollowController                       │
└─────────────────┬───────────────────────┘
                  │
┌─────────────────▼───────────────────────┐
│         Model (Data Access)              │
│  - User, Post, Category, etc.            │
└─────────────────┬───────────────────────┘
                  │
┌─────────────────▼───────────────────────┐
│      Database (MongoDB)                   │
│  - Collections avec Indexes              │
└──────────────────────────────────────────┘
```

### Structure du Projet

```
social-network-api/
├── config/                    # Configuration
│   ├── database.php          # Singleton pour connexion MongoDB
│   └── cors.php              # Configuration CORS
│
├── controllers/              # Contrôleurs (Couche de logique métier)
│   ├── UserController.php
│   ├── PostController.php
│   ├── CategoryController.php
│   ├── CommentController.php
│   ├── LikeController.php
│   └── FollowController.php
│
├── models/                   # Modèles (Couche d'accès aux données)
│   ├── User.php
│   ├── Post.php
│   ├── Category.php
│   ├── Comment.php
│   ├── Like.php
│   └── Follow.php
│
├── database/                 # Migrations et Seeders
│   ├── migrations/          # Migrations de collections
│   │   ├── migrate.php      # Runner de migrations
│   │   ├── CreateUsersCollection.php
│   │   ├── CreateCategoriesCollection.php
│   │   ├── CreatePostsCollection.php
│   │   ├── CreateCommentsCollection.php
│   │   ├── CreateLikesCollection.php
│   │   └── CreateFollowsCollection.php
│   │
│   └── seeders/             # Seeders de données
│       ├── DatabaseSeeder.php    # Orchestrateur principal
│       ├── seed.php              # Point d'entrée legacy
│       ├── CategorySeeder.php
│       ├── UserSeeder.php
│       ├── PostSeeder.php
│       ├── CommentSeeder.php
│       ├── LikeSeeder.php
│       └── FollowSeeder.php
│
├── utils/                    # Utilitaires
│   └── Response.php         # Formatage des réponses JSON
│
├── views/                   # Vues web (optionnel)
│   ├── layout.php          # Template principal
│   ├── ViewHelper.php      # Helpers pour les vues
│   ├── dashboard.php
│   ├── users.php
│   └── ...
│
├── index.php                # Point d'entrée principal
├── router.php               # Routeur HTTP
├── views.php                # Routeur pour les vues web
└── composer.json            # Dépendances
```

### Flux de Requête (Request Flow)

#### Pourquoi ce Flux ?

**Avantages de cette approche :**
- ✅ **Séparation claire** : Chaque étape a une responsabilité unique
- ✅ **Traçabilité** : Facile de suivre une requête de bout en bout
- ✅ **Debugging** : Points d'interception clairs pour le debugging
- ✅ **Testabilité** : Chaque étape peut être testée indépendamment
- ✅ **Flexibilité** : Facile d'ajouter middleware ou logging à chaque étape

#### 1. Requête HTTP Arrive
```
Client → index.php
```

#### 2. Détection du Type de Requête
```php
// index.php détermine si c'est une route API ou View
if (route est /view ou /) → views.php
sinon → router.php
```

#### 3. Routage API (router.php)
```php
// Extraction de l'URI et de la méthode HTTP
URI: /users/123/count
→ resource: "users"
→ id: "123"
→ action: "count"
→ method: "GET"
```

#### 4. Sélection du Contrôleur
```php
switch (resource) {
    case 'users': → UserController
    case 'posts': → PostController
    // etc.
}
```

#### 5. Traitement par le Contrôleur
```php
// UserController::handleRequest()
switch (method) {
    case 'GET':
        if (action === 'count') → User::getCount()
        else if (id) → User::getById(id)
        else → User::getAll(page)
    case 'POST': → User::create(data)
    // etc.
}
```

#### 6. Accès aux Données (Model)
```php
// User::getAll()
1. Récupère la collection MongoDB
2. Exécute la requête avec pagination
3. Retourne les données formatées
```

#### 7. Formatage de la Réponse
```php
// Response::success() ou Response::error()
{
    "success": true/false,
    "message": "...",
    "data": {...}
}
```

#### 8. Réponse HTTP
```
Response → Client (JSON)
```

### Architecture de la Base de Données

#### Pourquoi cette Organisation ?

**Connexion Singleton :**
- ✅ **Performance** : Une seule connexion réutilisée
- ✅ **Ressources** : Évite la surcharge de multiples connexions
- ✅ **Cohérence** : Tous les composants partagent la même connexion

**Collections Séparées :**
- ✅ **Organisation** : Chaque entité a sa propre collection
- ✅ **Performance** : Indexes optimisés par collection
- ✅ **Scalabilité** : Possibilité de sharder par collection
- ✅ **Clarté** : Structure de données claire et prévisible

#### Connexion (Singleton Pattern)
```php
// config/database.php
Database::getInstance()  // Une seule instance partagée
```

#### Collections MongoDB
- **Users** : Utilisateurs du système
- **Categories** : Catégories de posts
- **Posts** : Publications des utilisateurs
- **Comments** : Commentaires sur les posts
- **Likes** : Likes sur les posts
- **Follows** : Relations de suivi entre utilisateurs

#### Indexes pour Performance

**Pourquoi ces Indexes ?**

- ✅ **Performance** : Requêtes fréquentes optimisées (user_id, post_id, etc.)
- ✅ **Unicité** : Indexes uniques garantissent l'intégrité (username, email)
- ✅ **Recherche** : Index texte pour la recherche full-text dans les posts
- ✅ **Tri** : Index sur date pour les requêtes "last-five", "before-date"
- ✅ **Agrégations** : Indexes composites pour les requêtes complexes (likes, follows)

**Stratégie d'indexation :**
- Index sur tous les champs utilisés dans WHERE
- Index unique sur les champs qui doivent être uniques
- Index composite pour les requêtes multi-champs
- Index texte pour la recherche full-text

Chaque collection a des indexes optimisés :
- **Users** : `username` (unique), `email` (unique), `is_active`
- **Categories** : `name` (unique)
- **Posts** : `user_id`, `category_id`, `date` (desc), `content` (text)
- **Comments** : `post_id`, `user_id`, `date`
- **Likes** : `post_id + user_id` (composite unique), `post_id`, `user_id`
- **Follows** : `user_id + user_follow_id` (composite unique), `user_id`, `user_follow_id`

### Système de Migrations

#### Pourquoi des Migrations Séparées ?

**Avantages de cette approche :**
- ✅ **Modularité** : Chaque collection est indépendante, facile à modifier ou supprimer
- ✅ **Clarté** : Un fichier = une collection, facile à comprendre
- ✅ **Rollback ciblé** : Possibilité de rollback par collection si nécessaire
- ✅ **Ordre d'exécution explicite** : Les dépendances sont claires dans le code
- ✅ **Maintenance** : Modifier une collection n'affecte pas les autres
- ✅ **Versioning** : Chaque migration peut être versionnée et trackée

#### Concept
Les migrations créent les collections et leurs indexes dans MongoDB. Chaque collection a sa propre migration.

#### Structure d'une Migration
```php
class CreateUsersCollection {
    public function up() {
        // Créer la collection et les indexes
    }
    
    public function down() {
        // Supprimer la collection (rollback)
    }
}
```

#### Ordre d'Exécution
1. **CreateUsersCollection** (pas de dépendances)
2. **CreateCategoriesCollection** (pas de dépendances)
3. **CreatePostsCollection** (dépend de Users et Categories)
4. **CreateCommentsCollection** (dépend de Posts et Users)
5. **CreateLikesCollection** (dépend de Posts et Users)
6. **CreateFollowsCollection** (dépend de Users)

#### Utilisation
```bash
# Exécuter toutes les migrations
php database/migrations/migrate.php

# Rollback toutes les migrations
php database/migrations/migrate.php --down
```

### Système de Seeding

#### Pourquoi des Seeders Modulaires ?

**Avantages de cette approche :**
- ✅ **Réutilisabilité** : Chaque seeder peut être exécuté indépendamment
- ✅ **Gestion des dépendances** : Les IDs sont passés explicitement entre seeders
- ✅ **Testabilité** : Facile de tester chaque seeder individuellement
- ✅ **Flexibilité** : Possibilité de seeder seulement certaines entités
- ✅ **Maintenance** : Modifier un seeder n'affecte pas les autres
- ✅ **Clarté** : Chaque seeder a une responsabilité unique et claire

#### Concept
Les seeders peuplent la base de données avec des données de test. Chaque entité a son propre seeder.

#### Architecture Modulaire
```
DatabaseSeeder (Orchestrateur)
    ├── CategorySeeder → retourne categoryIds
    ├── UserSeeder → retourne userIds
    ├── PostSeeder → utilise categoryIds + userIds
    ├── CommentSeeder → utilise postIds + userIds
    ├── LikeSeeder → utilise postIds + userIds
    └── FollowSeeder → utilise userIds
```

#### Flux de Seeding
1. **Nettoyage** : Supprime toutes les données existantes
2. **Categories** : Crée 5 catégories → retourne IDs
3. **Users** : Crée 100 utilisateurs → retourne IDs
4. **Posts** : Crée 40 posts (utilise categoryIds et userIds) → retourne IDs
5. **Comments** : Crée 90 commentaires (utilise postIds et userIds)
6. **Likes** : Crée 300 likes (utilise postIds et userIds)
7. **Follows** : Crée 250 follows (utilise userIds)

#### Utilisation
```bash
# Seeder complet
php database/seeders/seed.php

# Ou via DatabaseSeeder directement
php database/seeders/DatabaseSeeder.php
```

### Comment les Composants Fonctionnent Ensemble

#### Exemple : Créer un Post

1. **Requête HTTP**
   ```
   POST /posts
   Body: {"content": "...", "category_id": 1, "user_id": 1}
   ```

2. **Router** (`router.php`)
   ```php
   resource = "posts"
   method = "POST"
   → PostController::handleRequest()
   ```

3. **Controller** (`PostController.php`)
   ```php
   $data = json_decode(file_get_contents('php://input'), true);
   $result = $this->post->create($data);
   ```

4. **Model** (`Post.php`)
   ```php
   // Validation
   if (empty($data['content']) || !isset($data['category_id'])) {
       return ['success' => false, 'message' => '...'];
   }
   
   // Insertion dans MongoDB
   $result = $this->collection->insertOne($post);
   return ['success' => true, 'data' => $post];
   ```

5. **Response** (`Response.php`)
   ```php
   Response::success($result['data'], 'Post créé');
   // → JSON: {"success": true, "message": "Post créé", "data": {...}}
   ```

#### Exemple : Récupérer les Posts avec Pagination

1. **Requête HTTP**
   ```
   GET /posts?page=2
   ```

2. **Router** → `PostController::handleRequest('GET', null, null)`

3. **Controller**
   ```php
   $page = $_GET['page'] ?? 1;
   $result = $this->post->getAll($page);
   ```

4. **Model**
   ```php
   $skip = ($page - 1) * $limit;
   $posts = $this->collection->find(
       [],
       ['skip' => $skip, 'limit' => $limit]
   )->toArray();
   ```

5. **Response** → JSON avec les posts paginés

### Patterns Utilisés

#### 1. Singleton Pattern
**Où** : `Database` class dans `config/database.php`

**Pourquoi** :
- ✅ **Performance** : Une seule connexion MongoDB réutilisée
- ✅ **Ressources** : Évite d'ouvrir plusieurs connexions inutilement
- ✅ **Cohérence** : Tous les composants utilisent la même connexion
- ✅ **Simplicité** : Accès global via `Database::getInstance()`

**Implémentation** :
```php
Database::getInstance()  // Retourne toujours la même instance
```

#### 2. MVC (Model-View-Controller)
**Où** : Structure complète du projet

**Pourquoi** :
- ✅ **Séparation claire** : Logique métier, données et présentation séparées
- ✅ **Maintenabilité** : Chaque couche peut évoluer indépendamment
- ✅ **Testabilité** : Tests unitaires facilités par la séparation
- ✅ **Standard** : Pattern reconnu et compris par tous les développeurs

**Répartition** :
- **Model** (`models/`) : Accès aux données, validation, logique métier
- **View** (`views/`) : Présentation, formatage pour l'utilisateur
- **Controller** (`controllers/`) : Orchestration, routage, coordination

#### 3. Dependency Injection
**Où** : Contrôleurs et Modèles

**Pourquoi** :
- ✅ **Testabilité** : Facile de mocker les dépendances
- ✅ **Flexibilité** : Changement d'implémentation sans modifier le code
- ✅ **Découplage** : Composants moins dépendants les uns des autres
- ✅ **Maintenabilité** : Dépendances explicites et claires

**Implémentation** :
```php
// Les modèles reçoivent la connexion DB via singleton
$this->db = Database::getInstance();

// Les contrôleurs instancient leurs modèles
$this->user = new User();
```

#### 4. Factory Pattern
**Où** : `Database::getInstance()`

**Pourquoi** :
- ✅ **Contrôle** : Contrôle sur la création de l'instance
- ✅ **Initialisation** : Peut initialiser la connexion à la première création
- ✅ **Validation** : Peut valider la configuration avant création
- ✅ **Abstraction** : Cache les détails de création à l'utilisateur

### Sécurité

#### Pourquoi cette Approche de Sécurité ?

**Validation des Données**
- ✅ **Prévention** : Validation avant insertion évite les données corrompues
- ✅ **Cohérence** : Toute la validation centralisée dans les modèles
- ✅ **Sécurité** : Protection contre l'injection et les données malformées
- ✅ **Clarté** : Règles de validation visibles et maintenables

**Hashage des Mots de Passe**
- ✅ **Sécurité** : Utilisation de `password_hash()` (bcrypt par défaut)
- ✅ **Standard** : Fonction native PHP, testée et sécurisée
- ✅ **Future-proof** : Support automatique des meilleurs algorithmes

**CORS**
- ✅ **Flexibilité** : Permet l'intégration avec différents frontends
- ✅ **Contrôle** : Configuration centralisée dans `config/cors.php`
- ⚠️ **Production** : À restreindre aux domaines autorisés

**Gestion des Erreurs**
- ✅ **Expérience utilisateur** : Messages d'erreur clairs et cohérents
- ✅ **Debugging** : Try-catch permet de capturer et logger les erreurs
- ✅ **Sécurité** : Ne pas exposer les détails techniques aux clients
- ✅ **Standardisation** : Format d'erreur uniforme via `Response::error()`

#### Implémentation

**Validation des Données**
- Validation dans les modèles avant insertion
- Vérification des champs requis
- Hashage des mots de passe avec `password_hash()`

**CORS**
- Configuration dans `config/cors.php`
- Permet les requêtes cross-origin (à restreindre en production)

**Gestion des Erreurs**
- Try-catch dans les modèles pour les ObjectId invalides
- Messages d'erreur standardisés via `Response::error()`

### Pourquoi MongoDB ?

**Avantages de MongoDB pour ce projet :**
- ✅ **Flexibilité** : Schéma dynamique, facile d'ajouter de nouveaux champs
- ✅ **Performance** : Indexes optimisés pour les requêtes fréquentes
- ✅ **Scalabilité** : Horizontal scaling facile avec sharding
- ✅ **Document-oriented** : Structure JSON native, parfait pour les APIs REST
- ✅ **Relations simples** : Pas besoin de JOINs complexes, références par ID
- ✅ **Développement rapide** : Pas de migrations de schéma complexes

**Trade-offs :**
- ⚠️ **Pas de transactions multi-documents** : (sauf avec répliques)
- ⚠️ **Pas de relations strictes** : Cohérence à gérer au niveau application
- ⚠️ **Requêtes complexes** : Moins flexible que SQL pour certaines requêtes

**Pourquoi c'est adapté ici :**
- Relations simples (user_id, post_id, etc.)
- Pas besoin de transactions complexes
- Structure de données flexible pour un réseau social
- Performance importante pour les lectures fréquentes

### Points d'Extension

#### Pourquoi cette Structure est Extensible ?

**Avantages :**
- ✅ **Modularité** : Ajouter une ressource = ajouter des fichiers, pas modifier l'existant
- ✅ **Cohérence** : Nouvelle ressource suit les mêmes patterns
- ✅ **Isolation** : Nouvelle fonctionnalité n'affecte pas l'existant
- ✅ **Réutilisabilité** : Patterns et utilitaires déjà en place

#### Ajouter une Nouvelle Ressource

1. **Créer le Model** (`models/NewResource.php`)
   ```php
   class NewResource {
       private $collection;
       public function __construct() {
           $this->collection = Database::getInstance()->getCollection('NewResources');
       }
       // Méthodes CRUD
   }
   ```

2. **Créer le Controller** (`controllers/NewResourceController.php`)
   ```php
   class NewResourceController {
       private $resource;
       public function handleRequest($method, $id, $action) {
           // Logique de routage
       }
   }
   ```

3. **Ajouter la Route** (`router.php`)
   ```php
   case 'newresources':
       $controller = new NewResourceController();
       $controller->handleRequest($method, $id, $action);
       break;
   ```

4. **Créer la Migration** (`database/migrations/CreateNewResourcesCollection.php`)

5. **Créer le Seeder** (`database/seeders/NewResourceSeeder.php`)

## Structure des Collections

### Users
```json
{
  "username": "string",
  "email": "string",
  "password": "string",
  "is_active": boolean
}
```

### Posts
```json
{
  "content": "string",
  "category_id": number,
  "user_id": number,
  "date": "string"
}
```

### Categories
```json
{
  "name": "string"
}
```

### Comments
```json
{
  "content": "string",
  "user_id": number,
  "post_id": "string",
  "date": "string"
}
```

### Likes
```json
{
  "post_id": "string",
  "user_id": number
}
```

### Follows
```json
{
  "user_follow_id": number,
  "user_id": number
}
```

## Endpoints API

### Users (CRUD)

#### GET /users
Récupère tous les utilisateurs (avec pagination)
- Query params: `page` (optionnel, défaut: 1)

#### GET /users/{id}
Récupère un utilisateur par ID

#### POST /users
Crée un nouvel utilisateur
```bash
curl -X POST -H "Content-Type: application/json" -d '{"username": "fred", "email": "fredfred@gmail.com", "password": "password123"}' http://localhost:8080/users
```

#### PUT /users/{id}
Met à jour un utilisateur

#### DELETE /users/{id}
Supprime un utilisateur

#### GET /users/count
Récupère le nombre d'utilisateurs inscrits

#### GET /users/usernames?page=1
Récupère les pseudos des utilisateurs (3 par page)

### Posts (CRUD)

#### GET /posts
Récupère tous les posts

#### GET /posts/{id}
Récupère un post par ID

#### POST /posts
Crée un nouveau post
```json
{
  "content": "Mon premier post",
  "category_id": 1,
  "user_id": 1
}
```

#### PUT /posts/{id}
Met à jour un post

#### DELETE /posts/{id}
Supprime un post

#### GET /posts/count
Récupère le nombre de posts

#### GET /posts/last-five
Récupère les 5 derniers posts

#### GET /posts/{id}/comments
Récupère un post et ses commentaires

#### GET /posts/without-comments
Récupère les posts sans commentaires

#### GET /posts/search?word=mot
Récupère les posts contenant un mot recherché

#### GET /posts/before-date?date=2024-01-01
Récupère les posts avant une date

#### GET /posts/after-date?date=2024-01-01
Récupère les posts après une date

### Categories (CRUD)

#### GET /categories
Récupère toutes les catégories

#### GET /categories/{id}
Récupère une catégorie par ID

#### POST /categories
Crée une nouvelle catégorie
```json
{
  "name": "Technologie"
}
```

#### PUT /categories/{id}
Met à jour une catégorie

#### DELETE /categories/{id}
Supprime une catégorie

### Comments (CRUD)

#### GET /comments
Récupère tous les commentaires

#### GET /comments/{id}
Récupère un commentaire par ID

#### POST /comments
Crée un nouveau commentaire
```json
{
  "content": "Super post !",
  "user_id": 1,
  "post_id": "507f1f77bcf86cd799439011"
}
```

#### PUT /comments/{id}
Met à jour un commentaire

#### DELETE /comments/{id}
Supprime un commentaire

#### GET /comments/count?post_id=507f1f77bcf86cd799439011
Récupère le nombre de commentaires pour un post

### Likes (CRD)

#### GET /likes
Récupère tous les likes

#### GET /likes/{id}
Récupère un like par ID

#### POST /likes
Crée un nouveau like
```json
{
  "post_id": "507f1f77bcf86cd799439011",
  "user_id": 1
}
```

#### DELETE /likes/{id}
Supprime un like

#### GET /likes/average?category_id=1
Récupère la moyenne des likes pour les posts d'une catégorie

### Follows (CRD)

#### GET /follows
Récupère tous les follows

#### GET /follows/{id}
Récupère un follow par ID

#### POST /follows
Crée un nouveau follow
```json
{
  "user_id": 1,
  "user_follow_id": 2
}
```

#### DELETE /follows/{id}
Supprime un follow

#### GET /follows/following-count?user_id=1
Récupère le nombre de personnes qu'un utilisateur suit

#### GET /follows/followers-count?user_id=1
Récupère le nombre de personnes abonnées à un utilisateur

#### GET /follows/top-three
Récupère les 3 personnes les plus suivies

## Exemples de Requêtes

### Créer un utilisateur
```bash
curl -X POST -H "Content-Type: application/json" -d '{"username": "fred", "email": "fredfred@gmail.com", "password": "password123"}' http://localhost:8080/users
```

### Récupérer tous les utilisateurs
```bash
curl http://localhost:8080/users
```

### Récupérer le nombre d'utilisateurs
```bash
curl http://localhost:8080/users/count
```

### Récupérer les 5 derniers posts
```bash
curl http://localhost:8080/posts/last-five
```

### Rechercher des posts
```bash
curl "http://localhost:8080/posts/search?word=technologie"
```

### Récupérer un post avec ses commentaires
```bash
curl http://localhost:8080/posts/{post_id}/comments
```

## Réponses API

Toutes les réponses sont au format JSON :

### Succès
```json
{
  "success": true,
  "message": "Succès",
  "data": {...}
}
```

### Erreur
```json
{
  "success": false,
  "message": "Message d'erreur"
}
```

## Codes de Statut HTTP

- 200 : Succès
- 400 : Erreur de requête
- 404 : Ressource non trouvée
- 405 : Méthode non autorisée
- 500 : Erreur serveur

## Migration et Seeding

### Migrations (Création des Collections)

Les migrations créent les collections MongoDB et leurs indexes. Chaque collection a sa propre migration :

- `CreateUsersCollection.php` - Collection Users avec indexes
- `CreateCategoriesCollection.php` - Collection Categories avec indexes
- `CreatePostsCollection.php` - Collection Posts avec indexes
- `CreateCommentsCollection.php` - Collection Comments avec indexes
- `CreateLikesCollection.php` - Collection Likes avec indexes
- `CreateFollowsCollection.php` - Collection Follows avec indexes

**Exécuter toutes les migrations :**
```bash
php database/migrations/migrate.php
```

**Rollback (supprimer toutes les collections) :**
```bash
php database/migrations/migrate.php --down
```

### Seeding (Données de Test)

Le fichier `database/seeders/seed.php` crée automatiquement :
- 100 utilisateurs
- 5 catégories
- 40 posts
- 90 commentaires
- 300 likes
- 250 follows

**Exécuter le seeding :**
```bash
php database/seeders/seed.php
```

**Ordre d'exécution recommandé :**
```bash
# 1. Créer les collections et indexes
php database/migrations/migrate.php

# 2. Peupler avec des données de test
php database/seeders/seed.php
```

## Notes

- Les mots de passe sont hashés avec `password_hash()`
- Les IDs MongoDB sont des ObjectId convertis en string
- Les dates sont au format `Y-m-d H:i:s`
- CORS est activé pour toutes les origines (à restreindre en production)

