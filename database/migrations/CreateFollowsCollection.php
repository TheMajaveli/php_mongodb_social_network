<?php

require_once __DIR__ . '/../../config/database.php';

class CreateFollowsCollection {
    private $db;
    
    public function __construct() {
        $this->db = Database::getInstance();
    }
    
    public function up() {
        echo "📝 Création de la collection Follows...\n";
        $collection = $this->db->getCollection('Follows');
        
        try {
            // Index composé unique sur user_id et user_follow_id pour éviter les doublons
            $collection->createIndex(['user_id' => 1, 'user_follow_id' => 1], ['unique' => true]);
            echo "  ✓ Index composé unique créé sur 'user_id' et 'user_follow_id'\n";
        } catch (Exception $e) {
            echo "  ⚠ Index composé: " . $e->getMessage() . "\n";
        }
        
        try {
            // Index sur user_id pour les requêtes de comptage (following-count)
            $collection->createIndex(['user_id' => 1]);
            echo "  ✓ Index créé sur 'user_id'\n";
        } catch (Exception $e) {
            echo "  ⚠ Index user_id: " . $e->getMessage() . "\n";
        }
        
        try {
            // Index sur user_follow_id pour les requêtes de comptage (followers-count)
            $collection->createIndex(['user_follow_id' => 1]);
            echo "  ✓ Index créé sur 'user_follow_id'\n";
        } catch (Exception $e) {
            echo "  ⚠ Index user_follow_id: " . $e->getMessage() . "\n";
        }
        
        echo "  ✓ Collection Follows créée\n\n";
    }
    
    public function down() {
        echo "🗑️  Suppression de la collection Follows...\n";
        $collection = $this->db->getCollection('Follows');
        $collection->drop();
        echo "  ✓ Collection Follows supprimée\n\n";
    }
}

