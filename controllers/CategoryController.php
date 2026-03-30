<?php

require_once __DIR__ . '/../models/ArticleModel.php';
require_once __DIR__ . '/../models/CategoryModel.php';

class CategoryController {
    private $articleModel;
    private $categoryModel;
    
    public function __construct() {
        $this->articleModel = new ArticleModel();
        $this->categoryModel = new CategoryModel();
    }
    
    // Afficher les articles d'une catégorie
    public function show($categorySlug) {
        // Récupérer la catégorie
        $category = $this->categoryModel->getBySlug($categorySlug);
        
        if (!$category) {
            return null; // 404
        }
        
        // Pagination
        $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
        $per_page = 12;
        $offset = ($page - 1) * $per_page;
        
        $articles = $this->articleModel->getByCategory($category['id'], $per_page, $offset);
        $total = $this->articleModel->countByCategory($category['id']);
        $total_pages = ceil($total / $per_page);
        
        return [
            'category' => $category,
            'articles' => $articles,
            'pagination' => [
                'current_page' => $page,
                'total_pages' => $total_pages,
                'total_items' => $total,
                'per_page' => $per_page
            ]
        ];
    }
}
?>
