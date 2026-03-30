# Iran News - PHP Pur sans Framework

## 🎯 Architecture complète en PHP pur

Cette application utilise du PHP pur sans framework pour implémenter un site d'actualités avec URL rewriting SEO-friendly.

## 📁 Structure des fichiers

```
Website_Iran/
├── .htaccess              # Configuration Apache pour URL rewriting
├── index.php              # Router principal et configuration
├── views/                 # Dossier des vues
│   ├── header.php         # En-tête HTML commun
│   ├── footer.php         # Pied de page HTML commun
│   ├── home.php          # Page d'accueil
│   ├── article.php       # Page article individuel
│   ├── articles.php      # Liste de tous les articles
│   ├── category.php      # Page catégorie
│   └── 404.php           # Page d'erreur 404
└── img/                   # Images des articles
```

## 🔄 URL Rewriting SEO-friendly

### Routes implémentées:

1. **Page d'accueil**: `http://localhost:8085/`
2. **Liste articles**: `http://localhost:8085/articles`
3. **Article individuel**: `http://localhost:8085/categorie/slug-de-larticle`
4. **Catégorie**: `http://localhost:8085/categorie`
5. **Erreur 404**: Pages inexistantes

### Exemples d'URLs:

- `http://localhost:8085/militaire/tensions-militaires-iran`
- `http://localhost:8085/diplomatie/diplomatie-internationale-iran`
- `http://localhost:8085/economie/impact-economique-conflit-iran`

## 🔧 Configuration technique

### Base de données
- **SGBD**: PostgreSQL
- **Connexion**: PDO avec gestion d'erreurs
- **Sécurité**: Requêtes préparées

### URL Rewriting
- **.htaccess**: Active le rewriting d'URL
- **index.php**: Router manuel avec expressions régulières
- **Pattern**: `/categorie/slug` pour les articles

### Sécurité
- **XSS**: `htmlspecialchars()` sur toutes les sorties
- **SQL Injection**: Requêtes préparées PDO
- **Validation**: Vérification des slugs de catégorie

## 🎨 Fonctionnalités

### Pages principales
1. **Accueil**: Hero article + grille d'articles récents
2. **Article**: Article complet avec métadonnées SEO
3. **Liste**: Tous les articles avec pagination
4. **Catégorie**: Articles filtrés par catégorie
5. **404**: Page d'erreur personnalisée

### SEO intégré
- **Balises meta**: title, description, canonical
- **Open Graph**: Facebook, Twitter partage
- **Fil d'Ariane**: Navigation hiérarchique
- **URLs propres**: Format `/categorie/slug`

### Design responsive
- **CSS intégré**: Styles modernes
- **Grille flexible**: Adaptatif mobile/desktop
- **Animations**: Transitions subtiles

## 🚀 Installation

1. **Configurer la base de données** dans `index.php`
2. **Placer les fichiers** sur un serveur Apache
3. **Activer mod_rewrite** sur Apache
4. **Importer les données** SQL existantes

## 📊 Avantages vs Framework

### ✅ Avantages PHP pur:
- **Performance**: Pas d'overhead de framework
- **Contrôle total**: Code 100% personnalisé
- **Apprentissage**: Compréhension complète du fonctionnement
- **Léger**: Minimaliste et rapide

### ⚠️ Limitations:
- **Moins de fonctionnalités**: Pas d'helpers intégrés
- **Sécurité manuelle**: Gestion manuelle des vulnérabilités
- **Maintenance**: Plus de code à maintenir

## 🎯 Objectifs pédagogiques

Ce projet démontre:
- **URL rewriting** avec .htaccess
- **Routing manuel** en PHP
- **Connexion PDO** sécurisée
- **Architecture MVC** simplifiée
- **SEO technique** avancé
- **Design responsive** moderne

## 🔄 Utilisation

1. **Accès**: `http://localhost:8085/`
2. **Navigation**: Cliquez sur les articles
3. **URLs**: Format `/categorie/slug-de-larticle`
4. **Pagination**: Navigation page par page

L'application est entièrement fonctionnelle et prête à l'emploi !
