# Guide de Démarrage Rapide

## Installation

1. **Installer l'extension MongoDB pour PHP** :
```bash
pecl install mongodb
```

Ou via Composer :
```bash
composer install
```

2. **Configurer MongoDB** :
   - Pour MongoDB local : Aucune configuration nécessaire (défaut: `mongodb://localhost:27017`)
   - Pour MongoDB Atlas : Définir la variable d'environnement `MONGODB_URI`

3. **Créer la base de données et les données de test** :
```bash
php migrations/seed.php
```

4. **Démarrer le serveur PHP** :
```bash
php -S localhost:8080 -t .
```

## Test Rapide

### Créer un utilisateur
```bash
curl -X POST -H "Content-Type: application/json" \
  -d '{"username": "fred", "email": "fredfred@gmail.com", "password": "password123"}' \
  http://localhost:8080/users
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

## Structure du Projet

```
social-network-api/
├── config/          # Configuration (database, CORS)
├── controllers/     # Contrôleurs pour chaque ressource
├── models/          # Modèles MongoDB
├── migrations/      # Script de migration des données
├── utils/           # Utilitaires (Response)
├── index.php        # Point d'entrée
├── router.php       # Routeur principal
└── README.md        # Documentation complète
```

## Endpoints Principaux

- **Users** : `/users` (CRUD + count + usernames paginés)
- **Posts** : `/posts` (CRUD + statistiques + recherche)
- **Categories** : `/categories` (CRUD)
- **Comments** : `/comments` (CRUD + count par post)
- **Likes** : `/likes` (CRD + moyenne par catégorie)
- **Follows** : `/follows` (CRD + statistiques)

Voir `ROUTES.md` pour la liste complète des routes.

## Données de Test

Le script de migration crée :
- 100 utilisateurs
- 5 catégories
- 40 posts
- 90 commentaires
- 300 likes
- 250 follows

## Support

Consultez `README.md` pour la documentation complète de l'API.

