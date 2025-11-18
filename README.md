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

3. Exécuter les migrations pour créer les données de test :
```bash
php migrations/seed.php
```

4. Démarrer le serveur PHP :
```bash
php -S localhost:8080 -t .
```

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

## Migration des Données

Le fichier `migrations/seed.php` crée automatiquement :
- 100 utilisateurs
- 5 catégories
- 40 posts
- 90 commentaires
- 300 likes
- 250 follows

Pour exécuter la migration :
```bash
php migrations/seed.php
```

## Notes

- Les mots de passe sont hashés avec `password_hash()`
- Les IDs MongoDB sont des ObjectId convertis en string
- Les dates sont au format `Y-m-d H:i:s`
- CORS est activé pour toutes les origines (à restreindre en production)

