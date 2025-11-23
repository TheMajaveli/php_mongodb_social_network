<?php

require_once __DIR__ . '/../../config/database.php';
require_once __DIR__ . '/CategorySeeder.php';
require_once __DIR__ . '/UserSeeder.php';
require_once __DIR__ . '/PostSeeder.php';
require_once __DIR__ . '/CommentSeeder.php';
require_once __DIR__ . '/LikeSeeder.php';
require_once __DIR__ . '/FollowSeeder.php';

class DatabaseSeeder {
    public function run() {
        echo "========================================\n";
        echo "  Démarrage du seeding de la base de données\n";
        echo "========================================\n\n";

        // Nettoyer toutes les collections
        $this->cleanCollections();

        // Exécuter les seeders dans l'ordre des dépendances
        $categorySeeder = new CategorySeeder();
        $categoryIds = $categorySeeder->run();

        $userSeeder = new UserSeeder();
        $userIds = $userSeeder->run();

        $postSeeder = new PostSeeder();
        $postIds = $postSeeder->run($categoryIds, $userIds);

        $commentSeeder = new CommentSeeder();
        $commentSeeder->run($postIds, $userIds);

        $likeSeeder = new LikeSeeder();
        $likeSeeder->run($postIds, $userIds);

        $followSeeder = new FollowSeeder();
        $followSeeder->run($userIds);

        echo "\n========================================\n";
        echo "  Seeding terminé avec succès !\n";
        echo "========================================\n";
        echo "Résumé:\n";
        echo "- 5 catégories\n";
        echo "- 100 utilisateurs\n";
        echo "- 40 posts\n";
        echo "- 90 commentaires\n";
        echo "- 300 likes\n";
        echo "- 250 follows\n";
        echo "========================================\n";
    }

    private function cleanCollections() {
        $db = Database::getInstance();
        $collections = ['Users', 'Posts', 'Categories', 'Comments', 'Likes', 'Follows'];
        
        foreach ($collections as $collectionName) {
            $db->getCollection($collectionName)->deleteMany([]);
        }
        
        echo "✓ Collections nettoyées.\n\n";
    }
}

// Exécuter le seeder si le fichier est appelé directement (pas via migrate.php)
$isDirectCall = php_sapi_name() === 'cli' && 
                isset($_SERVER['PHP_SELF']) && 
                basename($_SERVER['PHP_SELF']) === basename(__FILE__);
                
if ($isDirectCall) {
    $seeder = new DatabaseSeeder();
    $seeder->run();
}

