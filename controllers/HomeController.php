<?php

require_once __DIR__ . '/../models/ArticleModel.php';
require_once __DIR__ . '/../models/CategoryModel.php';

class HomeController {
    private $articleModel;
    private $categoryModel;
    
    public function __construct() {
        $this->articleModel = new ArticleModel();
        $this->categoryModel = new CategoryModel();
    }
    
    // Page d'accueil
    public function index() {
        // Récupérer l'article principal (hero)
        $hero = $this->articleModel->getFirstPublished();
        
        // Récupérer les autres articles
        $articles = $this->articleModel->getAllPublished(6, 1); // 6 articles, offset 1 (pour éviter le hero)
        
        // Récupérer les catégories pour le sidebar
        $categories = $this->categoryModel->getAllWithCount();
        
        return [
            'hero' => $hero,
            'articles' => $articles,
            'categories' => $categories
        ];
    }
}
?>
