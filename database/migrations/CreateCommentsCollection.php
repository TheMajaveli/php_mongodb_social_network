<?php

require_once __DIR__ . '/../../config/database.php';

class CreateCommentsCollection {
    private $db;
    
    public function __construct() {
        $this->db = Database::getInstance();
    }
    
    public function up() {
        echo "📝 Création de la collection Comments...\n";
        $collection = $this->db->getCollection('Comments');
        
        try {
            // Index sur post_id pour les requêtes de filtrage
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
        
        try {
            // Index sur date pour le tri
            $collection->createIndex(['date' => -1]);
            echo "  ✓ Index créé sur 'date'\n";
        } catch (Exception $e) {
            echo "  ⚠ Index date: " . $e->getMessage() . "\n";
        }
        
        echo "  ✓ Collection Comments créée\n\n";
    }
    
    public function down() {
        echo "🗑️  Suppression de la collection Comments...\n";
        $collection = $this->db->getCollection('Comments');
        $collection->drop();
        echo "  ✓ Collection Comments supprimée\n\n";
    }
}

