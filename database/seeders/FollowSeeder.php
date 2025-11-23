<?php

require_once __DIR__ . '/../../config/database.php';

class FollowSeeder {
    private $db;
    private $collection;

    public function __construct() {
        $this->db = Database::getInstance();
        $this->collection = $this->db->getCollection('Follows');
    }

    public function run($userIds = []) {
        // Nettoyer la collection
        $this->collection->deleteMany([]);

        if (empty($userIds)) {
            echo "⚠ Aucun utilisateur disponible pour créer des follows.\n";
            return [];
        }

        $followCount = 0;
        $userCount = count($userIds);
        $maxAttempts = 1000; // Limite pour éviter les boucles infinies
        $attempts = 0;

        while ($followCount < 250 && $attempts < $maxAttempts) {
            $user1 = rand(1, min(100, $userCount));
            $user2 = rand(1, min(100, $userCount));
            
            if ($user1 !== $user2) {
                $follow = [
                    'user_id' => $user1,
                    'user_follow_id' => $user2
                ];
                
                // Vérifier si le follow existe déjà
                $existing = $this->collection->findOne($follow);
                if (!$existing) {
                    $this->collection->insertOne($follow);
                    $followCount++;
                }
            }
            $attempts++;
        }

        echo "✓ $followCount follows créés.\n";
        return [];
    }
}

