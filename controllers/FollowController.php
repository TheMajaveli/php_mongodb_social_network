<?php

require_once __DIR__ . '/../models/Follow.php';
require_once __DIR__ . '/../utils/Response.php';

class FollowController {
    private $follow;

    public function __construct() {
        $this->follow = new Follow();
    }

    public function handleRequest($method, $id = null, $action = null) {
        switch ($method) {
            case 'GET':
                if ($action === 'following-count' && isset($_GET['user_id'])) {
                    $userId = $_GET['user_id'];
                    $result = $this->follow->getFollowingCount($userId);
                } elseif ($action === 'followers-count' && isset($_GET['user_id'])) {
                    $userId = $_GET['user_id'];
                    $result = $this->follow->getFollowersCount($userId);
                } elseif ($action === 'top-three') {
                    $result = $this->follow->getTopThreeMostFollowed();
                } elseif ($id) {
                    $result = $this->follow->getById($id);
                } else {
                    $result = $this->follow->getAll();
                }
                break;

            case 'POST':
                $data = json_decode(file_get_contents('php://input'), true);
                $result = $this->follow->create($data);
                break;

            case 'DELETE':
                if (!$id) {
                    Response::error('ID requis', 400);
                }
                $result = $this->follow->delete($id);
                break;

            default:
                Response::error('Méthode non autorisée', 405);
        }

        if ($result['success']) {
            Response::success($result['data'] ?? null, $result['message'] ?? 'Succès');
        } else {
            Response::error($result['message'], 400);
        }
    }
}

