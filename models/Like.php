<?php

require_once __DIR__ . '/../config/database.php';

class Like {
    private $collection;

    public function __construct() {
        $db = Database::getInstance();
        $this->collection = $db->getCollection('Likes');
    }

    public function create($data) {
        if (!isset($data['post_id']) || !isset($data['user_id'])) {
            return ['success' => false, 'message' => 'post_id et user_id sont requis'];
        }

        $postId = (string)$data['post_id'];
        $userId = (int)$data['user_id'];

        // Vérifier si le like existe déjà
        $existing = $this->collection->findOne([
            'post_id' => $postId,
            'user_id' => $userId
        ]);

        if ($existing) {
            return ['success' => false, 'message' => 'Like déjà existant'];
        }

        $like = [
            'post_id' => $postId,
            'user_id' => $userId
        ];

        $result = $this->collection->insertOne($like);
        $like['_id'] = $result->getInsertedId();

        return ['success' => true, 'data' => $like];
    }

    public function getAll() {
        $likes = $this->collection->find()->toArray();
        return ['success' => true, 'data' => $likes];
    }

    public function getById($id) {
        try {
            $like = $this->collection->findOne(['_id' => new MongoDB\BSON\ObjectId($id)]);
            if (!$like) {
                return ['success' => false, 'message' => 'Like non trouvé'];
            }
            return ['success' => true, 'data' => $like];
        } catch (Exception $e) {
            return ['success' => false, 'message' => 'ID invalide'];
        }
    }

    public function delete($id) {
        try {
            $result = $this->collection->deleteOne(['_id' => new MongoDB\BSON\ObjectId($id)]);
            if ($result->getDeletedCount() === 0) {
                return ['success' => false, 'message' => 'Like non trouvé'];
            }
            return ['success' => true, 'message' => 'Like supprimé'];
        } catch (Exception $e) {
            return ['success' => false, 'message' => 'ID invalide'];
        }
    }

    public function getAverageLikesByCategory($categoryId) {
        $db = Database::getInstance();
        $postsCollection = $db->getCollection('Posts');
        
        // Récupérer tous les posts de la catégorie
        $posts = $postsCollection->find(['category_id' => (int)$categoryId])->toArray();
        
        if (empty($posts)) {
            return ['success' => true, 'data' => ['average' => 0]];
        }

        $totalLikes = 0;
        $postCount = 0;

        foreach ($posts as $post) {
            $postId = (string)$post['_id'];
            $likesCount = $this->collection->countDocuments(['post_id' => $postId]);
            $totalLikes += $likesCount;
            $postCount++;
        }

        $average = $postCount > 0 ? $totalLikes / $postCount : 0;

        return ['success' => true, 'data' => ['average' => round($average, 2)]];
    }
}

