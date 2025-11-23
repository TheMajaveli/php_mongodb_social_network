<?php

require_once __DIR__ . '/../../config/database.php';

class LikeSeeder {
    private $db;
    private $collection;

    public function __construct() {
        $this->db = Database::getInstance();
        $this->collection = $this->db->getCollection('Likes');
    }

    public function run($postIds = [], $userIds = []) {
        // Nettoyer la collection
        $this->collection->deleteMany([]);

        if (empty($postIds)) {
            echo "⚠ Aucun post disponible pour créer des likes.\n";
            return [];
        }

        $likeCount = 0;
        $userCount = count($userIds);
        $maxAttempts = 1000; // Limite pour éviter les boucles infinies
        $attempts = 0;

        while ($likeCount < 300 && $attempts < $maxAttempts) {
            $like = [
                'post_id' => $postIds[array_rand($postIds)],
                'user_id' => $userCount > 0 ? rand(1, min(100, $userCount)) : rand(1, 100)
            ];
            
            // Vérifier si le like existe déjà
            $existing = $this->collection->findOne($like);
            if (!$existing) {
                $this->collection->insertOne($like);
                $likeCount++;
            }
            $attempts++;
        }

        echo "✓ $likeCount likes créés.\n";
        return [];
    }
}

