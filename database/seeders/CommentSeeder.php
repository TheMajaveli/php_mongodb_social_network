<?php

require_once __DIR__ . '/../../config/database.php';

class CommentSeeder {
    private $db;
    private $collection;

    public function __construct() {
        $this->db = Database::getInstance();
        $this->collection = $this->db->getCollection('Comments');
    }

    public function run($postIds = [], $userIds = []) {
        // Nettoyer la collection
        $this->collection->deleteMany([]);

        if (empty($postIds)) {
            echo "⚠ Aucun post disponible pour créer des commentaires.\n";
            return [];
        }

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

        $userCount = count($userIds);
        $postCount = count($postIds);

        for ($i = 0; $i < 90; $i++) {
            $comment = [
                'content' => $commentContents[array_rand($commentContents)] . ' - Commentaire ' . ($i + 1),
                'user_id' => $userCount > 0 ? rand(1, min(100, $userCount)) : rand(1, 100),
                'post_id' => $postIds[array_rand($postIds)],
                'date' => date('Y-m-d H:i:s', strtotime('-' . rand(0, 30) . ' days'))
            ];
            $this->collection->insertOne($comment);
        }

        echo "✓ 90 commentaires créés.\n";
        return [];
    }
}

