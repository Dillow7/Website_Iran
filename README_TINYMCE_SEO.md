# Iran News - Site d'informations sur la guerre en Iran

## Architecture complète FO + BO avec TinyMCE et SEO

### Stack technique
- **Backend**: PHP 8.2 pur (pas de framework)
- **Base de données**: PostgreSQL 15
- **FrontOffice**: Templates PHP pur avec CSS moderne
- **BackOffice**: Même architecture PHP pur avec TinyMCE
- **URL Rewriting**: .htaccess Apache
- **Docker**: Docker + docker-compose

### Structure des dossiers
```
Website_Iran/
├── .htaccess                    # URL rewriting Apache
├── index.php                    # Point d'entrée principal
├── routes.php                   # Router manuel PHP pur
├── docker-compose.yml           # Configuration Docker
├── Dockerfile                   # Image PHP + Apache
├── config/
│   └── database.php           # Connexion PostgreSQL
├── controllers/
│   ├── HomeController.php      # FO: Page d'accueil
│   ├── ArticleController.php   # FO: Articles
│   ├── CategoryController.php  # FO: Catégories
│   ├── AdminArticleController.php # BO: CRUD articles
│   └── AdminAuthController.php   # BO: Authentification
├── models/
│   ├── ArticleModel.php       # Modèle Article (CRUD + SEO)
│   └── CategoryModel.php      # Modèle Catégorie
├── views/
│   ├── header.php            # Header commun FO
│   ├── footer.php            # Footer commun FO
│   ├── home.php             # FO: Accueil
│   ├── article.php          # FO: Article (affiche HTML TinyMCE)
│   ├── articles.php         # FO: Liste articles
│   ├── category.php         # FO: Catégorie
│   └── admin/               # Vues BackOffice
│       ├── login.php       # BO: Connexion
│       ├── articles_index.php # BO: Listing articles
│       ├── articles_create.php # BO: Formulaire création
│       └── articles_edit.php   # BO: Formulaire édition
├── build/assets/tinymce/    # TinyMCE editor
├── img/                     # Images uploadées
└── db/
    ├── init.sql            # Structure DB + données
    └── Table.sql           # Schéma détaillé
```

## Fonctionnalités SEO implémentées

### 1. URL Rewriting optimisé
- Format: `/categorie/slug-de-larticle`
- Slug unique et normalisé automatiquement
- Gestion des collisions de slug

### 2. Balises meta éditables depuis le BO
- `<title>`: Champ `meta_title` (fallback vers titre + nom site)
- `<meta description>`: Champ `meta_description` (max 160 caractères)
- Open Graph: title, description, image, url
- URL canonique automatique

### 3. Structure Hn respectée
- **H1 unique**: Le titre de l'article (hors TinyMCE)
- **H2-H6**: Disponibles dans TinyMCE pour structurer le contenu
- **Conversion automatique**: H1 dans TinyMCE → H2

### 4. Images SEO optimisées
- **Alt obligatoire**: Validation côté serveur
- **TinyMCE**: Champ alt obligatoire à l'insertion
- **Téléchargement URL**: Import d'images avec alt
- **Stockage local**: Images sauvegardées dans `/img`

### 5. TinyMCE configuré SEO
```javascript
tinymce.init({
    selector: '#content',
    plugins: ['lists', 'link', 'image', 'code'],
    toolbar: 'undo redo | blocks | bold italic | bullist numlist | link image | code',
    block_formats: 'Paragraphe=p; Titre 2=h2; Titre 3=h3; Titre 4=h4; Titre 5=h5; Titre 6=h6',
    // Pas de H1 pour garantir l'unicité
    // Alt obligatoire pour les images
    // Liens ouverts dans nouvel onglet par défaut
});
```

## Utilisation

### Démarrage avec Docker
```bash
docker-compose up -d
```

### Accès
- **FrontOffice**: http://localhost:8089
- **BackOffice**: http://localhost:8089/admin/login
  - Identifiants: `admin@irannews.com` / `admin123`

### Flux de création d'article
1. Se connecter à l'administration
2. Cliquer sur "Créer un article"
3. Remplir les champs SEO:
   - Titre (devient H1 unique)
   - Meta title (optionnel, pour la balise `<title>`)
   - Slug (URL, généré automatiquement)
   - Meta description (max 160 caractères)
4. Ajouter une image:
   - Soit nom de fichier dans `/img`
   - Soit URL (téléchargement automatique)
   - Alt obligatoire pour le SEO
5. Rédiger le contenu avec TinyMCE:
   - Utiliser H2-H6 pour la structure
   - Insérer des images avec alt obligatoire
   - Ajouter des liens (ouverts dans nouvel onglet)
6. Choisir la catégorie et la date de publication
7. Enregistrer

### Affichage FrontOffice
La page `article.php` affiche:
- Balises `<title>` et `<meta description>` personnalisées
- H1 unique avec le titre
- Contenu HTML TinyMCE avec sémantique préservée
- Images avec attributs alt
- URL canonique correcte

## Score Lighthouse ≥ 90
- HTML sémantique correct
- Images optimisées avec alt
- Meta tags complets
- URL canoniques
- Structure Hn respectée
- Pas de JavaScript lourd côté FO

## Contraintes respectées
✅ **Même stack FO/BO**: PHP pur, mêmes dossiers, mêmes conventions  
✅ **TinyMCE intégré**: Headings, images+alt, liens, listes, code  
✅ **SEO complet**: Slugs, meta tags, Hn unique, alt obligatoire  
✅ **URL rewriting**: `/categorie/slug` automatique  
✅ **Docker**: Dockerfile + docker-compose.yml  
✅ **Score Lighthouse**: Structure optimisée pour performance  

Le projet est prêt pour le mini-projet de web design (Mars 2026) !
