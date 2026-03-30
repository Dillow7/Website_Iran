<?php

// Router principal PHP pur
class Router {
    private $routes = [];
    
    public function __construct() {
        // Définir les routes
        $this->routes = [
            '' => ['controller' => 'HomeController', 'method' => 'index'],
            '/' => ['controller' => 'HomeController', 'method' => 'index'],
            '/articles' => ['controller' => 'ArticleController', 'method' => 'index'],

            // BackOffice (même stack et architecture)
            '/admin' => ['controller' => 'AdminArticleController', 'method' => 'index'],
            '/admin/articles' => ['controller' => 'AdminArticleController', 'method' => 'index'],
            '/admin/articles/create' => ['controller' => 'AdminArticleController', 'method' => 'create'],
            '/admin/login' => ['controller' => 'AdminAuthController', 'method' => 'login'],
            '/admin/logout' => ['controller' => 'AdminAuthController', 'method' => 'logout'],
        ];
    }
    
    public function dispatch($path) {
        global $category_slug, $article_slug;
        
        // Nettoyer le path
        $path = rtrim($path, '/');
        
        // Routes statiques
        if (isset($this->routes[$path])) {
            $route = $this->routes[$path];
            return $this->callController($route['controller'], $route['method']);
        }

        // BackOffice - route dynamique: /admin/articles/edit/123
        if (preg_match('#^/admin/articles/edit/(\d+)$#', $path, $matches)) {
            return $this->callController('AdminArticleController', 'edit', [(int)$matches[1]]);
        }

        // BackOffice - suppression: /admin/articles/delete/123
        if (preg_match('#^/admin/articles/delete/(\d+)$#', $path, $matches)) {
            return $this->callController('AdminArticleController', 'delete', [(int)$matches[1]]);
        }
        
        // Route dynamique pour les articles: /categorie/slug
        if (preg_match('#^/([^/]+)/([^/]+)$#', $path, $matches)) {
            $category_slug = $matches[1];
            $article_slug = $matches[2];
            return $this->callController('ArticleController', 'show', [$category_slug, $article_slug]);
        }
        
        // Route dynamique pour les catégories: /categorie
        if (preg_match('#^/([^/]+)$#', $path, $matches)) {
            $category_slug = $matches[1];
            return $this->callController('CategoryController', 'show', [$category_slug]);
        }
        
        // Route non trouvée
        return null;
    }
    
    private function callController($controllerName, $methodName, $params = []) {
        require_once __DIR__ . "/controllers/{$controllerName}.php";
        
        $controller = new $controllerName();
        
        if (method_exists($controller, $methodName)) {
            return call_user_func_array([$controller, $methodName], $params);
        }
        
        return null;
    }
}
?>
