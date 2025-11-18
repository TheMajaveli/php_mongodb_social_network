<?php

require_once __DIR__ . '/../config/database.php';

$db = Database::getInstance();

// Nettoyer les collections existantes
$db->getCollection('Users')->deleteMany([]);
$db->getCollection('Posts')->deleteMany([]);
$db->getCollection('Categories')->deleteMany([]);
$db->getCollection('Comments')->deleteMany([]);
$db->getCollection('Likes')->deleteMany([]);
$db->getCollection('Follows')->deleteMany([]);

echo "Collections nettoyées.\n";

// Créer 5 catégories
$categories = [
    ['name' => 'Technologie'],
    ['name' => 'Voyage'],
    ['name' => 'Cuisine'],
    ['name' => 'Sport'],
    ['name' => 'Musique']
];

$categoryIds = [];
foreach ($categories as $category) {
    $result = $db->getCollection('Categories')->insertOne($category);
    $categoryIds[] = (string)$result->getInsertedId();
}
echo "5 catégories créées.\n";

// Créer 100 utilisateurs
$users = [];
$userIds = [];
for ($i = 1; $i <= 100; $i++) {
    $user = [
        'username' => 'user' . $i,
        'email' => 'user' . $i . '@example.com',
        'password' => password_hash('password123', PASSWORD_DEFAULT),
        'is_active' => $i <= 95 // 95 actifs, 5 inactifs
    ];
    $result = $db->getCollection('Users')->insertOne($user);
    $userIds[] = (string)$result->getInsertedId();
    $users[] = $user;
}
echo "100 utilisateurs créés.\n";

// Créer 40 posts
$posts = [];
$postIds = [];
$postContents = [
    'Découvrez les dernières innovations technologiques',
    'Mon voyage incroyable en Asie',
    'Recette de lasagnes maison',
    'Entraînement matinal réussi',
    'Nouvel album de musique à écouter',
    'Les meilleurs outils de développement',
    'Plages paradisiaques de Thaïlande',
    'Gâteau au chocolat facile',
    'Course à pied dans la nature',
    'Concert de rock inoubliable',
    'Intelligence artificielle et avenir',
    'Exploration des temples bouddhistes',
    'Pâtes carbonara authentiques',
    'Yoga et méditation quotidienne',
    'Festival de musique électronique',
    'Applications mobiles révolutionnaires',
    'Randonnée en montagne',
    'Tarte aux pommes traditionnelle',
    'Natation en piscine olympique',
    'Découverte de nouveaux artistes',
    'Blockchain et cryptomonnaies',
    'Safari en Afrique',
    'Sushi fait maison',
    'Crossfit et musculation',
    'Jazz et blues',
    'Cloud computing moderne',
    'Voyage en train à travers l\'Europe',
    'Pizza italienne authentique',
    'Cyclisme en ville',
    'Opéra et musique classique',
    'Machine learning avancé',
    'Plongée sous-marine',
    'Desserts français',
    'Basketball professionnel',
    'Hip-hop et rap',
    'Sécurité informatique',
    'Road trip aux USA',
    'Cuisine méditerranéenne',
    'Tennis de compétition',
    'Rock alternatif'
];

for ($i = 0; $i < 40; $i++) {
    $post = [
        'content' => $postContents[$i] ?? 'Post numéro ' . ($i + 1),
        'category_id' => rand(1, 5),
        'user_id' => rand(1, 100),
        'date' => date('Y-m-d H:i:s', strtotime('-' . rand(0, 60) . ' days'))
    ];
    $result = $db->getCollection('Posts')->insertOne($post);
    $postId = (string)$result->getInsertedId();
    $postIds[] = $postId;
    $post['_id'] = $result->getInsertedId();
    $posts[] = $post;
}
echo "40 posts créés.\n";

// Créer 90 commentaires
$commentContents = [
    'Super intéressant !',
    'Merci pour le partage',
    'Je suis d\'accord',
    'Excellente idée',
    'À essayer absolument',
    'Très bien écrit',
    'J\'adore ça',
    'Informations utiles',
    'Bravo pour cet article',
    'Je partage votre avis'
];

for ($i = 0; $i < 90; $i++) {
    $comment = [
        'content' => $commentContents[array_rand($commentContents)] . ' - Commentaire ' . ($i + 1),
        'user_id' => rand(1, 100),
        'post_id' => $postIds[array_rand($postIds)],
        'date' => date('Y-m-d H:i:s', strtotime('-' . rand(0, 30) . ' days'))
    ];
    $db->getCollection('Comments')->insertOne($comment);
}
echo "90 commentaires créés.\n";

// Créer 300 likes
$likeCount = 0;
while ($likeCount < 300) {
    $like = [
        'post_id' => $postIds[array_rand($postIds)],
        'user_id' => rand(1, 100)
    ];
    
    // Vérifier si le like existe déjà
    $existing = $db->getCollection('Likes')->findOne($like);
    if (!$existing) {
        $db->getCollection('Likes')->insertOne($like);
        $likeCount++;
    }
}
echo "300 likes créés.\n";

// Créer 250 follows
$followCount = 0;
while ($followCount < 250) {
    $user1 = rand(1, 100);
    $user2 = rand(1, 100);
    
    if ($user1 !== $user2) {
        $follow = [
            'user_id' => $user1,
            'user_follow_id' => $user2
        ];
        
        // Vérifier si le follow existe déjà
        $existing = $db->getCollection('Follows')->findOne($follow);
        if (!$existing) {
            $db->getCollection('Follows')->insertOne($follow);
            $followCount++;
        }
    }
}
echo "250 follows créés.\n";

echo "\nMigration terminée avec succès !\n";
echo "Résumé:\n";
echo "- 100 utilisateurs\n";
echo "- 5 catégories\n";
echo "- 40 posts\n";
echo "- 90 commentaires\n";
echo "- 300 likes\n";
echo "- 250 follows\n";

