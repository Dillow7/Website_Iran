<?php

require_once __DIR__ . '/../config/database.php';

class ArticleModel {
    private $pdo;
    
    public function __construct() {
        $this->pdo = Database::getConnection();
    }

    public function getAll($limit = 50, $offset = 0) {
        $stmt = $this->pdo->prepare("
            SELECT a.*, c.name as category_name, c.slug as category_slug, u.name as author_name
            FROM articles a
            LEFT JOIN categories c ON a.category_id = c.id
            LEFT JOIN users u ON a.user_id = u.id
            ORDER BY a.created_at DESC
            LIMIT :limit OFFSET :offset
        ");
        $stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
        $stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    public function getById($id) {
        $stmt = $this->pdo->prepare("
            SELECT a.*, c.name as category_name, c.slug as category_slug, u.name as author_name
            FROM articles a
            LEFT JOIN categories c ON a.category_id = c.id
            LEFT JOIN users u ON a.user_id = u.id
            WHERE a.id = :id
        ");
        $stmt->execute(['id' => $id]);
        return $stmt->fetch();
    }

    public function slugExists($slug, $ignoreId = null) {
        if ($ignoreId !== null) {
            $stmt = $this->pdo->prepare('SELECT 1 FROM articles WHERE slug = :slug AND id != :id LIMIT 1');
            $stmt->execute(['slug' => $slug, 'id' => $ignoreId]);
        } else {
            $stmt = $this->pdo->prepare('SELECT 1 FROM articles WHERE slug = :slug LIMIT 1');
            $stmt->execute(['slug' => $slug]);
        }
        return (bool)$stmt->fetchColumn();
    }

    public function create($payload) {
        $stmt = $this->pdo->prepare("
            INSERT INTO articles (title, meta_title, slug, excerpt, content, meta_description, image, alt_image, category_id, user_id, published_at, created_at, updated_at)
            VALUES (:title, :meta_title, :slug, :excerpt, :content, :meta_description, :image, :alt_image, :category_id, :user_id, :published_at, NOW(), NOW())
            RETURNING id
        ");

        $stmt->execute([
            'title' => $payload['title'],
            'meta_title' => $payload['meta_title'],
            'slug' => $payload['slug'],
            'excerpt' => $payload['excerpt'],
            'content' => $payload['content'],
            'meta_description' => $payload['meta_description'],
            'image' => $payload['image'],
            'alt_image' => $payload['alt_image'],
            'category_id' => $payload['category_id'],
            'user_id' => $payload['user_id'],
            'published_at' => $payload['published_at'],
        ]);
        return (int)$stmt->fetchColumn();
    }

    public function update($id, $payload) {
        $stmt = $this->pdo->prepare("
            UPDATE articles
            SET title = :title,
                meta_title = :meta_title,
                slug = :slug,
                excerpt = :excerpt,
                content = :content,
                meta_description = :meta_description,
                image = :image,
                alt_image = :alt_image,
                category_id = :category_id,
                published_at = :published_at,
                updated_at = NOW()
            WHERE id = :id
        ");

        return $stmt->execute([
            'id' => $id,
            'title' => $payload['title'],
            'meta_title' => $payload['meta_title'],
            'slug' => $payload['slug'],
            'excerpt' => $payload['excerpt'],
            'content' => $payload['content'],
            'meta_description' => $payload['meta_description'],
            'image' => $payload['image'],
            'alt_image' => $payload['alt_image'],
            'category_id' => $payload['category_id'],
            'published_at' => $payload['published_at'],
        ]);
    }

    public function delete($id) {
        $stmt = $this->pdo->prepare('DELETE FROM articles WHERE id = :id');
        return $stmt->execute(['id' => $id]);
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
