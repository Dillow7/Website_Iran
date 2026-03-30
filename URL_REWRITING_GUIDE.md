# Guide d'URL Rewriting pour Iran News

## 🎯 Objectif
Permettre d'accéder aux articles avec des URLs SEO-friendly au lieu d'utiliser l'ID.

## 📋 Options d'URL Rewriting disponibles

### Option 1: URL avec `/articles/` (actuellement active)
```
https://votresite.com/articles/titre-de-larticle
```

**Configuration actuelle:**
- Route: `Route::get('/articles/{article}', [ArticleController::class, 'show'])`
- Modèle: `getRouteKeyName()` retourne `'slug'`

### Option 2: URL simple avec slug uniquement
```
https://votresite.com/titre-de-larticle
```

**Pour activer:**
1. Commentez la route actuelle
2. Décommentez: `Route::get('/{article}', [ArticleController::class, 'show'])`

### Option 3: URL avec catégorie + slug
```
https://votresite.com/politique/titre-de-larticle
```

**Pour activer:**
1. Commentez la route actuelle
2. Décommentez: `Route::get('/{category}/{article}', [ArticleController::class, 'show'])`

## 🔧 Implémentation technique

### 1. Modèle Articles (déjà configuré)
```php
public function getRouteKeyName()
{
    return 'slug'; // Utilise le slug au lieu de l'ID
}
```

### 2. Contrôleur ArticleController (déjà configuré)
```php
public function show(Articles $article)
{
    // Laravel résout automatiquement l'article par son slug
    return view('front.article', compact('article'));
}
```

### 3. Génération des URLs dans les vues
```php
// Génère: /articles/titre-de-larticle
route('article.show', $article)

// Génère: /titre-de-larticle (option 2)
route('article.show.simple', $article)

// Génère: /politique/titre-de-larticle (option 3)
route('article.show.category', [$article->category, $article])
```

## 📝 Exemples d'utilisation

### Dans home.blade.php:
```php
<a href="{{ route('article.show', $article) }}">
    {{ $article->title }}
</a>
```

### Dans les contrôleleurs:
```php
return redirect()->route('article.show', $article);
```

## 🚀 Avantages SEO

1. **URLs lisibles** pour les utilisateurs et les moteurs de recherche
2. **Mots-clés dans l'URL** (titre de l'article)
3. **Structure hiérarchique** (option 3 avec catégorie)
4. **Meilleur taux de clic** dans les résultats de recherche

## ⚠️ Points d'attention

1. **Unicité des slugs**: Assurez-vous que chaque article a un slug unique
2. **Migration**: Si vous changez de format d'URL, mettez en place des redirections 301
3. **Performance**: L'option 2 peut entrer en conflit avec d'autres routes

## 🔍 Comment accéder à un article spécifique

### Avec l'ID (ancienne méthode):
```
/articles/1
```

### Avec le slug (nouvelle méthode):
```
/articles/titre-de-larticle
```

### Exemple concret:
Pour un article avec:
- ID: 1
- Titre: "Tensions militaires en Iran"
- Slug: "tensions-militaires-en-iran"

**URLs possibles:**
- `/articles/tensions-militaires-en-iran` (option 1)
- `/tensions-militaires-en-iran` (option 2)
- `/militaire/tensions-militaires-en-iran` (option 3)

## 🛠️ Tests

Pour tester l'URL rewriting:

1. **Créez un article** avec un slug spécifique
2. **Accédez à l'URL** correspondante
3. **Vérifiez** que l'article s'affiche correctement

Exemple de test:
```bash
# Test avec curl
curl http://localhost:8085/articles/tensions-militaires-en-iran
```

## 📊 Monitoring

Utilisez Google Analytics ou Search Console pour surveiller:
- Le trafic sur les nouvelles URLs
- Les erreurs 404
- La performance des nouvelles URLs

---

**Note**: L'implémentation actuelle utilise l'option 1. Vous pouvez changer d'option à tout moment en modifiant le fichier `routes/web.php`.
