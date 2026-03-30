<?php

// Configuration du site
define('SITE_URL', 'http://localhost:8089');
define('SITE_NAME', 'Iran News');
define('SITE_DESCRIPTION', 'Actualités sur la guerre en Iran : politique, militaire, diplomatie, économie.');

// Inclure les fichiers nécessaires
require_once 'config/database.php';
require_once 'routes.php';

// Récupération de l'URL demandée
$request_uri = $_SERVER['REQUEST_URI'];
$request_uri = rtrim($request_uri, '/');
$path = parse_url($request_uri, PHP_URL_PATH);

// Router
$router = new Router();
$result = $router->dispatch($path);

// Gestion des routes
if ($result === null) {
    // Page 404
    http_response_code(404);
    require_once 'views/404.php';
} elseif (is_array($result)) {
    // Extraire les variables globales pour les vues
    global $category_slug, $article_slug;
    
    // Déterminer quelle vue charger
    $current_path = rtrim($path, '/');
    
    switch ($current_path) {
        case '':
        case '/':
            // Page d'accueil
            $data = $result;
            require_once 'views/home.php';
            break;
            
        case '/articles':
            // Liste des articles
            $data = $result;
            require_once 'views/articles.php';
            break;
            
        default:
            // Route dynamique (article ou catégorie)
            if (preg_match('#^/([^/]+)/([^/]+)$#', $path)) {
                // Page article
                $data = $result;
                if ($data === null) {
                    http_response_code(404);
                    require_once 'views/404.php';
                } else {
                    require_once 'views/article.php';
                }
            } elseif (preg_match('#^/([^/]+)$#', $path)) {
                // Page catégorie
                $data = $result;
                if ($data === null) {
                    http_response_code(404);
                    require_once 'views/404.php';
                } else {
                    require_once 'views/category.php';
                }
            } else {
                http_response_code(404);
                require_once 'views/404.php';
            }
            break;
    }
} else {
    // Erreur
    http_response_code(500);
    echo '<h1>Erreur interne du serveur</h1>';
}

?>
