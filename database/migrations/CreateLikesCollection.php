<?php

require_once __DIR__ . '/../../config/database.php';

class CreateLikesCollection {
    private $db;
    
    public function __construct() {
        $this->db = Database::getInstance();
    }
    
    public function up() {
        echo "📝 Création de la collection Likes...\n";
        $collection = $this->db->getCollection('Likes');
        
        try {
            // Index composé unique sur post_id et user_id pour éviter les doublons
            $collection->createIndex(['post_id' => 1, 'user_id' => 1], ['unique' => true]);
            echo "  ✓ Index composé unique créé sur 'post_id' et 'user_id'\n";
        } catch (Exception $e) {
            echo "  ⚠ Index composé: " . $e->getMessage() . "\n";
        }
        
        try {
            // Index sur post_id pour les requêtes de comptage
            $collection->createIndex(['post_id' => 1]);
            echo "  ✓ Index créé sur 'post_id'\n";
        } catch (Exception $e) {
            echo "  ⚠ Index post_id: " . $e->getMessage() . "\n";
        }
        
        try {
            // Index sur user_id pour les requêtes de filtrage
            $collection->createIndex(['user_id' => 1]);
            echo "  ✓ Index créé sur 'user_id'\n";
        } catch (Exception $e) {
            echo "  ⚠ Index user_id: " . $e->getMessage() . "\n";
        }
        
        echo "  ✓ Collection Likes créée\n\n";
    }
    
    public function down() {
        echo "🗑️  Suppression de la collection Likes...\n";
        $collection = $this->db->getCollection('Likes');
        $collection->drop();
        echo "  ✓ Collection Likes supprimée\n\n";
    }
}

