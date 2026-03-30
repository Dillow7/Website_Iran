# Architecture PHP Pur - Iran News

## 🏗️ Structure complète en PHP pur sans framework

```
Website_Iran/
├── .htaccess                    # Configuration Apache pour URL rewriting
├── index.php                    # Point d'entrée principal
├── routes.php                   # Router manuel
├── config/                      # Configuration
│   └── database.php           # Connexion base de données
├── models/                      # Modèles de données
│   ├── ArticleModel.php       # Gestion des articles
│   └── CategoryModel.php      # Gestion des catégories
├── controllers/                 # Contrôleurs
│   ├── HomeController.php      # Page d'accueil
│   ├── ArticleController.php   # Gestion des articles
│   └── CategoryController.php  # Gestion des catégories
├── views/                       # Vues HTML/PHP
│   ├── header.php            # En-tête commun
│   ├── footer.php            # Pied de page commun
│   ├── home.php             # Page d'accueil
│   ├── article.php          # Page article
│   ├── articles.php         # Liste articles
│   ├── category.php         # Page catégorie
│   └── 404.php              # Page 404
└── img/                          # Images
```

## 🔄 Flow de fonctionnement

### 1. URL Rewriting (.htaccess)
```apache
RewriteEngine On
RewriteCond %{REQUEST_FILENAME} !-f
RewriteCond %{REQUEST_FILENAME} !-d
RewriteRule ^(.*)$ index.php [QSA,L]
```

### 2. Router (routes.php)
```php
class Router {
    // Routes statiques
    '' => ['controller' => 'HomeController', 'method' => 'index']
    '/articles' => ['controller' => 'ArticleController', 'method' => 'index']
    
    // Routes dynamiques
    // /categorie/slug -> ArticleController@show
    // /categorie -> CategoryController@show
}
```

### 3. Point d'entrée (index.php)
```php
// Analyse l'URL
$path = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

// Dispatch vers le bon contrôleur
$result = $router->dispatch($path);

// Charge la vue appropriée
require_once 'views/...');
```

### 4. Modèles (Models)
```php
class ArticleModel {
    // Connexion PDO sécurisée
    // Requêtes préparées
    // Méthodes CRUD
}
```

### 5. Contrôleurs (Controllers)
```php
class ArticleController {
    // Logique métier
    // Appel des modèles
    // Préparation des données
}
```

### 6. Vues (Views)
```php
// HTML + PHP
// Variables des contrôleurs
// Inclusion header/footer
```

## 🎯 URLs implémentées

### Routes statiques:
- `GET /` → HomeController@index
- `GET /articles` → ArticleController@index

### Routes dynamiques:
- `GET /militaire/tensions-militaires-iran` → ArticleController@show
- `GET /politique` → CategoryController@show

## 🔧 Sécurité

### Protection XSS:
```php
$output = htmlspecialchars($input, ENT_QUOTES, 'UTF-8');
```

### Protection SQL Injection:
```php
$stmt = $pdo->prepare("SELECT * FROM articles WHERE slug = :slug");
$stmt->execute(['slug' => $slug]);
```

### Validation:
- Vérification des slugs
- Contrôle des paramètres
- Gestion des erreurs 404

## 📊 Avantages de cette architecture

### ✅ Points forts:
1. **Performance**: Pas d'overhead de framework
2. **Contrôle total**: Architecture 100% personnalisée
3. **Pédagogique**: Compréhension complète du fonctionnement
4. **Léger**: Minimaliste et rapide
5. **Flexible**: Facile à modifier et étendre

### 🎯 Objectifs atteints:
1. **URL Rewriting SEO**: `/categorie/slug-de-larticle`
2. **Architecture MVC**: Séparation des responsabilités
3. **Code pur**: Aucune dépendance de framework
4. **Sécurité**: Protection contre XSS et SQLi
5. **Maintenabilité**: Code organisé et modulaire

## 🚀 Utilisation

1. **Configuration**: Adapter `config/database.php`
2. **Déploiement**: Placer sur serveur Apache
3. **Activation**: Activer mod_rewrite
4. **Accès**: `http://localhost:8085/`

Cette architecture démontre une maîtrise complète du PHP pur avec des patterns modernes d'architecture!
