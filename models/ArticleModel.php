<?php

require_once __DIR__ . '/../config/database.php';

class ArticleModel {
    private $pdo;
    
    public function __construct() {
        $this->pdo = Database::getConnection();
    }
    
    // Récupérer tous les articles publiés avec pagination
    public function getAllPublished($limit = 15, $offset = 0) {
        $stmt = $this->pdo->prepare("
            SELECT a.*, c.name as category_name, c.slug as category_slug, u.name as author_name
            FROM articles a
            LEFT JOIN categories c ON a.category_id = c.id
            LEFT JOIN users u ON a.user_id = u.id
            WHERE a.published_at IS NOT NULL
            ORDER BY a.published_at DESC
            LIMIT :limit OFFSET :offset
        ");
        $stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
        $stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll();
    }
    
    // Récupérer un article par son slug
    public function getBySlug($slug) {
        $stmt = $this->pdo->prepare("
            SELECT a.*, c.name as category_name, c.slug as category_slug, u.name as author_name
            FROM articles a
            LEFT JOIN categories c ON a.category_id = c.id
            LEFT JOIN users u ON a.user_id = u.id
            WHERE a.slug = :slug AND a.published_at IS NOT NULL
        ");
        $stmt->execute(['slug' => $slug]);
        return $stmt->fetch();
    }
    
    // Récupérer le premier article publié
    public function getFirstPublished() {
        $stmt = $this->pdo->prepare("
            SELECT a.*, c.name as category_name, c.slug as category_slug, u.name as author_name
            FROM articles a
            LEFT JOIN categories c ON a.category_id = c.id
            LEFT JOIN users u ON a.user_id = u.id
            WHERE a.published_at IS NOT NULL
            ORDER BY a.published_at DESC
            LIMIT 1
        ");
        $stmt->execute();
        return $stmt->fetch();
    }
    
    // Récupérer les articles d'une catégorie
    public function getByCategory($categoryId, $limit = 12, $offset = 0) {
        $stmt = $this->pdo->prepare("
            SELECT a.*, c.name as category_name, c.slug as category_slug, u.name as author_name
            FROM articles a
            LEFT JOIN categories c ON a.category_id = c.id
            LEFT JOIN users u ON a.user_id = u.id
            WHERE a.category_id = :category_id AND a.published_at IS NOT NULL
            ORDER BY a.published_at DESC
            LIMIT :limit OFFSET :offset
        ");
        $stmt->bindValue(':category_id', $categoryId, PDO::PARAM_INT);
        $stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
        $stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll();
    }
    
    // Récupérer les articles similaires
    public function getRelated($categoryId, $articleId, $limit = 3) {
        $stmt = $this->pdo->prepare("
            SELECT a.*, c.name as category_name, c.slug as category_slug
            FROM articles a
            LEFT JOIN categories c ON a.category_id = c.id
            WHERE a.category_id = :category_id 
            AND a.id != :article_id 
            AND a.published_at IS NOT NULL
            ORDER BY a.published_at DESC
            LIMIT :limit
        ");
        $stmt->bindValue(':category_id', $categoryId, PDO::PARAM_INT);
        $stmt->bindValue(':article_id', $articleId, PDO::PARAM_INT);
        $stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll();
    }
    
    // Compter le nombre total d'articles publiés
    public function countPublished() {
        $stmt = $this->pdo->prepare("SELECT COUNT(*) as total FROM articles WHERE published_at IS NOT NULL");
        $stmt->execute();
        return $stmt->fetch()['total'];
    }
    
    // Compter les articles par catégorie
    public function countByCategory($categoryId) {
        $stmt = $this->pdo->prepare("
            SELECT COUNT(*) as total 
            FROM articles 
            WHERE category_id = :category_id AND published_at IS NOT NULL
        ");
        $stmt->execute(['category_id' => $categoryId]);
        return $stmt->fetch()['total'];
    }
}
?>
