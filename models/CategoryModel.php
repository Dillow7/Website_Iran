<?php

require_once __DIR__ . '/../config/database.php';

class CategoryModel {
    private $pdo;
    
    public function __construct() {
        $this->pdo = Database::getConnection();
    }
    
    // Récupérer une catégorie par son slug
    public function getBySlug($slug) {
        $stmt = $this->pdo->prepare("SELECT * FROM categories WHERE slug = :slug");
        $stmt->execute(['slug' => $slug]);
        return $stmt->fetch();
    }
    
    // Récupérer toutes les catégories
    public function getAll() {
        $stmt = $this->pdo->prepare("SELECT * FROM categories ORDER BY name");
        $stmt->execute();
        return $stmt->fetchAll();
    }
    
    // Récupérer les catégories avec le nombre d'articles
    public function getAllWithCount() {
        $stmt = $this->pdo->prepare("
            SELECT c.*, COUNT(a.id) as articles_count
            FROM categories c
            LEFT JOIN articles a ON c.id = a.category_id AND a.published_at IS NOT NULL
            GROUP BY c.id, c.name, c.slug
            ORDER BY c.name
        ");
        $stmt->execute();
        return $stmt->fetchAll();
    }
}
?>
