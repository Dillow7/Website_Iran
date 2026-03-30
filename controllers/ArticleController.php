<?php

require_once __DIR__ . '/../models/ArticleModel.php';
require_once __DIR__ . '/../models/CategoryModel.php';

class ArticleController {
    private $articleModel;
    private $categoryModel;
    
    public function __construct() {
        $this->articleModel = new ArticleModel();
        $this->categoryModel = new CategoryModel();
    }
    
    // Liste de tous les articles avec pagination
    public function index() {
        $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
        $per_page = 12;
        $offset = ($page - 1) * $per_page;
        
        $articles = $this->articleModel->getAllPublished($per_page, $offset);
        $total = $this->articleModel->countPublished();
        $total_pages = ceil($total / $per_page);
        
        return [
            'articles' => $articles,
            'pagination' => [
                'current_page' => $page,
                'total_pages' => $total_pages,
                'total_items' => $total,
                'per_page' => $per_page
            ]
        ];
    }
    
    // Afficher un article individuel
    public function show($categorySlug, $articleSlug) {
        // Récupérer l'article
        $article = $this->articleModel->getBySlug($articleSlug);
        
        // Vérifier que l'article existe et que la catégorie correspond
        if (!$article || $article['category_slug'] !== $categorySlug) {
            return null; // 404
        }
        
        // Récupérer les articles similaires
        $related = $this->articleModel->getRelated($article['category_id'], $article['id']);
        
        return [
            'article' => $article,
            'related' => $related
        ];
    }
}
?>
