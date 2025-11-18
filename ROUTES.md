# Liste des Routes API

## Users

| Méthode | Route | Description |
|---------|-------|-------------|
| GET | `/users` | Liste tous les utilisateurs (pagination) |
| GET | `/users/{id}` | Récupère un utilisateur par ID |
| POST | `/users` | Crée un nouvel utilisateur |
| PUT | `/users/{id}` | Met à jour un utilisateur |
| DELETE | `/users/{id}` | Supprime un utilisateur |
| GET | `/users/count` | Nombre d'utilisateurs inscrits |
| GET | `/users/usernames?page=1` | Pseudos des utilisateurs (3 par page) |

## Posts

| Méthode | Route | Description |
|---------|-------|-------------|
| GET | `/posts` | Liste tous les posts |
| GET | `/posts/{id}` | Récupère un post par ID |
| POST | `/posts` | Crée un nouveau post |
| PUT | `/posts/{id}` | Met à jour un post |
| DELETE | `/posts/{id}` | Supprime un post |
| GET | `/posts/count` | Nombre de posts |
| GET | `/posts/last-five` | 5 derniers posts |
| GET | `/posts/{id}/comments` | Post avec ses commentaires |
| GET | `/posts/without-comments` | Posts sans commentaires |
| GET | `/posts/search?word=mot` | Posts contenant un mot |
| GET | `/posts/before-date?date=2024-01-01` | Posts avant une date |
| GET | `/posts/after-date?date=2024-01-01` | Posts après une date |

## Categories

| Méthode | Route | Description |
|---------|-------|-------------|
| GET | `/categories` | Liste toutes les catégories |
| GET | `/categories/{id}` | Récupère une catégorie par ID |
| POST | `/categories` | Crée une nouvelle catégorie |
| PUT | `/categories/{id}` | Met à jour une catégorie |
| DELETE | `/categories/{id}` | Supprime une catégorie |

## Comments

| Méthode | Route | Description |
|---------|-------|-------------|
| GET | `/comments` | Liste tous les commentaires |
| GET | `/comments/{id}` | Récupère un commentaire par ID |
| POST | `/comments` | Crée un nouveau commentaire |
| PUT | `/comments/{id}` | Met à jour un commentaire |
| DELETE | `/comments/{id}` | Supprime un commentaire |
| GET | `/comments/count?post_id={id}` | Nombre de commentaires pour un post |

## Likes

| Méthode | Route | Description |
|---------|-------|-------------|
| GET | `/likes` | Liste tous les likes |
| GET | `/likes/{id}` | Récupère un like par ID |
| POST | `/likes` | Crée un nouveau like |
| DELETE | `/likes/{id}` | Supprime un like |
| GET | `/likes/average?category_id=1` | Moyenne des likes pour une catégorie |

## Follows

| Méthode | Route | Description |
|---------|-------|-------------|
| GET | `/follows` | Liste tous les follows |
| GET | `/follows/{id}` | Récupère un follow par ID |
| POST | `/follows` | Crée un nouveau follow |
| DELETE | `/follows/{id}` | Supprime un follow |
| GET | `/follows/following-count?user_id=1` | Nombre de personnes suivies |
| GET | `/follows/followers-count?user_id=1` | Nombre d'abonnés |
| GET | `/follows/top-three` | 3 personnes les plus suivies |

