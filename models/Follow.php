<?php

require_once __DIR__ . '/../config/database.php';

class Follow {
    private $collection;

    public function __construct() {
        $db = Database::getInstance();
        $this->collection = $db->getCollection('Follows');
    }

    public function create($data) {
        if (!isset($data['user_id']) || !isset($data['user_follow_id'])) {
            return ['success' => false, 'message' => 'user_id et user_follow_id sont requis'];
        }

        // Vérifier si le follow existe déjà
        $existing = $this->collection->findOne([
            'user_id' => (int)$data['user_id'],
            'user_follow_id' => (int)$data['user_follow_id']
        ]);

        if ($existing) {
            return ['success' => false, 'message' => 'Follow déjà existant'];
        }

        $follow = [
            'user_id' => (int)$data['user_id'],
            'user_follow_id' => (int)$data['user_follow_id']
        ];

        $result = $this->collection->insertOne($follow);
        $follow['_id'] = $result->getInsertedId();

        return ['success' => true, 'data' => $follow];
    }

    public function getAll() {
        $follows = $this->collection->find()->toArray();
        return ['success' => true, 'data' => $follows];
    }

    public function getById($id) {
        try {
            $follow = $this->collection->findOne(['_id' => new MongoDB\BSON\ObjectId($id)]);
            if (!$follow) {
                return ['success' => false, 'message' => 'Follow non trouvé'];
            }
            return ['success' => true, 'data' => $follow];
        } catch (Exception $e) {
            return ['success' => false, 'message' => 'ID invalide'];
        }
    }

    public function delete($id) {
        try {
            $result = $this->collection->deleteOne(['_id' => new MongoDB\BSON\ObjectId($id)]);
            if ($result->getDeletedCount() === 0) {
                return ['success' => false, 'message' => 'Follow non trouvé'];
            }
            return ['success' => true, 'message' => 'Follow supprimé'];
        } catch (Exception $e) {
            return ['success' => false, 'message' => 'ID invalide'];
        }
    }

    public function getFollowingCount($userId) {
        $count = $this->collection->countDocuments(['user_id' => (int)$userId]);
        return ['success' => true, 'data' => ['count' => $count]];
    }

    public function getFollowersCount($userId) {
        $count = $this->collection->countDocuments(['user_follow_id' => (int)$userId]);
        return ['success' => true, 'data' => ['count' => $count]];
    }

    public function getTopThreeMostFollowed() {
        $pipeline = [
            ['$group' => [
                '_id' => '$user_follow_id',
                'followers_count' => ['$sum' => 1]
            ]],
            ['$sort' => ['followers_count' => -1]],
            ['$limit' => 3]
        ];

        $results = $this->collection->aggregate($pipeline)->toArray();
        return ['success' => true, 'data' => $results];
    }
}

