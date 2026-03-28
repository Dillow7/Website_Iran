# 🗺️ Guide complet — Mini-projet Web Design (Mars 2026)

> **Site d'informations sur la guerre en Iran**  
> Stack : PHP Laravel · PostgreSQL · Docker  
> Deadline : **Mardi 31 mars à 14h00**  
> Travail en binôme

---

## 📋 Sommaire

1. [Structure du projet](#1-structure-du-projet)
2. [Étape 1 — Docker & environnement](#2-étape-1--docker--environnement)
3. [Étape 2 — Base de données PostgreSQL](#3-étape-2--base-de-données-postgresql)
4. [Étape 3 — Back-Office (BO)](#4-étape-3--back-office-bo)
5. [Étape 4 — Front-Office (FO)](#5-étape-4--front-office-fo)
6. [Étape 5 — Optimisation SEO](#6-étape-5--optimisation-seo)
7. [Étape 6 — Tests Lighthouse](#7-étape-6--tests-lighthouse)
8. [Étape 7 — Git & Livraison](#8-étape-7--git--livraison)
9. [Checklist finale](#9-checklist-finale)

---

## 1. Structure du projet

```
Website_Iran/
├── docker-compose.yml
├── Dockerfile
├── nginx/
│   └── default.conf
├── app/                   ← projet Laravel
│   ├── app/
│   │   ├── Http/
│   │   │   └── Controllers/
│   │   │       ├── Admin/
│   │   │       │   ├── ArticleController.php
│   │   │       │   └── CategoryController.php
│   │   │       └── Front/
│   │   │           ├── HomeController.php
│   │   │           ├── ArticleController.php
│   │   │           └── SitemapController.php
│   │   └── Models/
│   │       ├── Article.php
│   │       ├── Category.php
│   │       └── User.php
│   ├── database/
│   │   ├── migrations/
│   │   └── seeders/
│   ├── resources/
│   │   └── views/
│   │       ├── layouts/
│   │       │   └── app.blade.php   ← balises SEO ici
│   │       ├── front/
│   │       │   ├── home.blade.php
│   │       │   ├── article.blade.php
│   │       │   └── category.blade.php
│   │       └── admin/
│   │           ├── articles/
│   │           └── categories/
│   ├── routes/
│   │   └── web.php
│   └── public/
│       └── robots.txt
└── doc-technique.pdf
```

---

## 2. Étape 1 — Docker & environnement

### 2.1 `docker-compose.yml`

```yaml
version: '3.8'

services:
  app:
    build:
      context: .
      dockerfile: Dockerfile
    container_name: laravel_app
    restart: unless-stopped
    working_dir: /var/www
    volumes:
      - ./app:/var/www
    networks:
      - app-network
    depends_on:
      - db

  db:
    image: postgres:15-alpine
    container_name: postgres_db
    restart: unless-stopped
    environment:
      POSTGRES_DB: iran_news
      POSTGRES_USER: laravel
      POSTGRES_PASSWORD: secret
    volumes:
      - pgdata:/var/lib/postgresql/data
    networks:
      - app-network

  nginx:
    image: nginx:alpine
    container_name: nginx_server
    restart: unless-stopped
    ports:
      - "8080:80"
    volumes:
      - ./app:/var/www
      - ./nginx/default.conf:/etc/nginx/conf.d/default.conf
    networks:
      - app-network
    depends_on:
      - app

networks:
  app-network:
    driver: bridge

volumes:
  pgdata:
```

### 2.2 `Dockerfile`

```dockerfile
FROM php:8.2-fpm

# Dépendances système
RUN apt-get update && apt-get install -y \
    git curl libpq-dev libpng-dev libonig-dev \
    zip unzip libzip-dev

# Extensions PHP
RUN docker-php-ext-install pdo pdo_pgsql mbstring zip exif pcntl

# Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

WORKDIR /var/www

COPY ./app .

RUN composer install --optimize-autoloader --no-dev

RUN chown -R www-data:www-data /var/www/storage /var/www/bootstrap/cache

EXPOSE 9000
CMD ["php-fpm"]
```

### 2.3 `nginx/default.conf`

```nginx
server {
    listen 80;
    server_name localhost;
    root /var/www/public;
    index index.php;

    location / {
        try_files $uri $uri/ /index.php?$query_string;
    }

    location ~ \.php$ {
        fastcgi_pass app:9000;
        fastcgi_index index.php;
        fastcgi_param SCRIPT_FILENAME $realpath_root$fastcgi_script_name;
        include fastcgi_params;
    }

    location ~ /\.ht {
        deny all;
    }
}
```

### 2.4 Création du projet Laravel

```bash
# Depuis la racine du projet (hors du conteneur)
composer create-project laravel/laravel app

# Lancer les conteneurs
docker-compose up -d --build

# Vérifier que tout tourne
docker-compose ps
```

### 2.5 `.env` — configuration PostgreSQL

```env
APP_NAME="Iran News"
APP_ENV=local
APP_DEBUG=true
APP_URL=http://localhost:8080

DB_CONNECTION=pgsql
DB_HOST=db
DB_PORT=5432
DB_DATABASE=iran_news
DB_USERNAME=laravel
DB_PASSWORD=secret

# Langue et timezone
APP_LOCALE=fr
APP_TIMEZONE=Indian/Antananarivo
```

---

## 3. Étape 2 — Base de données PostgreSQL

### 3.1 Modélisation (ERD simplifié)

```
users
├── id (PK)
├── name
├── email (unique)
└── password

categories
├── id (PK)
├── name
├── slug (unique)
└── timestamps

articles
├── id (PK)
├── title
├── slug (unique)            ← URL rewriting SEO
├── excerpt                  ← intro courte
├── content (text)
├── meta_description         ← balise <meta description>
├── image (nullable)
├── alt_image                ← texte alt SEO de l'image
├── category_id (FK)
├── user_id (FK)
├── published_at (nullable)
└── timestamps
```

### 3.2 Migrations

**Migration `categories`**

```php
// database/migrations/xxxx_create_categories_table.php
Schema::create('categories', function (Blueprint $table) {
    $table->id();
    $table->string('name');
    $table->string('slug')->unique();
    $table->timestamps();
});
```

**Migration `articles`**

```php
// database/migrations/xxxx_create_articles_table.php
Schema::create('articles', function (Blueprint $table) {
    $table->id();
    $table->string('title');
    $table->string('slug')->unique();
    $table->text('excerpt')->nullable();
    $table->longText('content');
    $table->string('meta_description', 160)->nullable();
    $table->string('image')->nullable();
    $table->string('alt_image')->nullable();
    $table->foreignId('category_id')->constrained()->onDelete('cascade');
    $table->foreignId('user_id')->constrained()->onDelete('cascade');
    $table->timestamp('published_at')->nullable();
    $table->timestamps();
});
```

### 3.3 Modèles Eloquent

**`app/Models/Article.php`**

```php
<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Article extends Model
{
    protected $fillable = [
        'title', 'slug', 'excerpt', 'content',
        'meta_description', 'image', 'alt_image',
        'category_id', 'user_id', 'published_at',
    ];

    protected $casts = [
        'published_at' => 'datetime',
    ];

    // Génération automatique du slug
    protected static function boot()
    {
        parent::boot();
        static::creating(function ($article) {
            $article->slug = Str::slug($article->title);
        });
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Scope articles publiés uniquement
    public function scopePublished($query)
    {
        return $query->whereNotNull('published_at')
                     ->where('published_at', '<=', now());
    }
}
```

**`app/Models/Category.php`**

```php
<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Category extends Model
{
    protected $fillable = ['name', 'slug'];

    protected static function boot()
    {
        parent::boot();
        static::creating(function ($category) {
            $category->slug = Str::slug($category->name);
        });
    }

    public function articles()
    {
        return $this->hasMany(Article::class);
    }
}
```

### 3.4 Seeder — données de test

```php
// database/seeders/DatabaseSeeder.php
public function run(): void
{
    User::factory()->create([
        'name'     => 'Admin',
        'email'    => 'admin@admin.com',
        'password' => bcrypt('password'),
    ]);

    $categories = ['Politique', 'Militaire', 'Diplomatie', 'Économie'];
    foreach ($categories as $name) {
        Category::create(['name' => $name]);
    }

    Article::create([
        'title'            => 'Tensions croissantes au Moyen-Orient',
        'excerpt'          => 'Analyse de la situation diplomatique actuelle en Iran.',
        'content'          => 'Contenu complet de l\'article...',
        'meta_description' => 'Analyse des tensions diplomatiques en Iran en 2026.',
        'alt_image'        => 'Carte du Moyen-Orient montrant l\'Iran',
        'category_id'      => 1,
        'user_id'          => 1,
        'published_at'     => now(),
    ]);
}
```

```bash
# Exécuter dans le conteneur
docker exec -it laravel_app php artisan migrate --seed
```

---

## 4. Étape 3 — Back-Office (BO)

### 4.1 Installation de l'authentification

```bash
docker exec -it laravel_app composer require laravel/breeze --dev
docker exec -it laravel_app php artisan breeze:install blade
docker exec -it laravel_app php artisan migrate
```

### 4.2 Routes du BO

```php
// routes/web.php

// Routes publiques (FO)
Route::get('/', [Front\HomeController::class, 'index'])->name('home');
Route::get('/sitemap.xml', [SitemapController::class, 'index']);
Route::get('/{category:slug}', [Front\CategoryController::class, 'show'])->name('category.show');
Route::get('/{category:slug}/{article:slug}', [Front\ArticleController::class, 'show'])->name('article.show');

// Routes Back-Office (protégées)
Route::middleware(['auth'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/', fn() => redirect()->route('admin.articles.index'));
    Route::resource('articles', Admin\ArticleController::class);
    Route::resource('categories', Admin\CategoryController::class);
});
```

> ⚠️ L'URL de connexion au BO est `/login` — identifiants par défaut à mentionner dans le document technique : `admin@admin.com` / `password`

### 4.3 `Admin\ArticleController`

```php
<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Article;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ArticleController extends Controller
{
    public function index()
    {
        $articles = Article::with('category')->latest()->paginate(15);
        return view('admin.articles.index', compact('articles'));
    }

    public function create()
    {
        $categories = Category::all();
        return view('admin.articles.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'title'            => 'required|max:60',
            'excerpt'          => 'nullable|max:200',
            'content'          => 'required',
            'meta_description' => 'nullable|max:160',
            'category_id'      => 'required|exists:categories,id',
            'image'            => 'nullable|image|max:2048',
            'alt_image'        => 'nullable|max:125',
            'published_at'     => 'nullable|date',
        ]);

        $data['slug'] = Str::slug($data['title']);
        $data['user_id'] = auth()->id();

        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('articles', 'public');
        }

        Article::create($data);

        return redirect()->route('admin.articles.index')
                         ->with('success', 'Article créé avec succès.');
    }

    public function edit(Article $article)
    {
        $categories = Category::all();
        return view('admin.articles.edit', compact('article', 'categories'));
    }

    public function update(Request $request, Article $article)
    {
        $data = $request->validate([
            'title'            => 'required|max:60',
            'excerpt'          => 'nullable|max:200',
            'content'          => 'required',
            'meta_description' => 'nullable|max:160',
            'category_id'      => 'required|exists:categories,id',
            'image'            => 'nullable|image|max:2048',
            'alt_image'        => 'nullable|max:125',
            'published_at'     => 'nullable|date',
        ]);

        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('articles', 'public');
        }

        $article->update($data);

        return redirect()->route('admin.articles.index')
                         ->with('success', 'Article mis à jour.');
    }

    public function destroy(Article $article)
    {
        $article->delete();
        return redirect()->route('admin.articles.index')
                         ->with('success', 'Article supprimé.');
    }
}
```

---

## 5. Étape 4 — Front-Office (FO)

### 5.1 Contrôleurs FO

**`Front\HomeController`**

```php
<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\Article;
use App\Models\Category;

class HomeController extends Controller
{
    public function index()
    {
        $articles   = Article::published()->with('category')->latest('published_at')->paginate(10);
        $categories = Category::withCount('articles')->get();

        return view('front.home', compact('articles', 'categories'));
    }
}
```

**`Front\ArticleController`**

```php
<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\Article;
use App\Models\Category;

class ArticleController extends Controller
{
    public function show(Category $category, Article $article)
    {
        abort_if($article->category_id !== $category->id, 404);
        abort_if(! $article->published_at, 404);

        $related = Article::published()
            ->where('category_id', $category->id)
            ->where('id', '!=', $article->id)
            ->limit(3)
            ->get();

        return view('front.article', compact('article', 'category', 'related'));
    }
}
```

### 5.2 Layout Blade principal avec SEO

```blade
{{-- resources/views/layouts/app.blade.php --}}
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    {{-- ✅ TITLE SEO : unique par page, mot-clé en premier --}}
    <title>@yield('title', 'Iran News — Actualités sur la guerre en Iran')</title>

    {{-- ✅ META DESCRIPTION SEO --}}
    <meta name="description" content="@yield('meta_description', 'Suivez toute l\'actualité sur le conflit en Iran : politique, militaire, diplomatique.')">

    {{-- ✅ META ROBOTS --}}
    <meta name="robots" content="@yield('robots', 'index, follow')">

    {{-- ✅ CANONICAL --}}
    <link rel="canonical" href="@yield('canonical', url()->current())">

    {{-- ✅ OPEN GRAPH (partage réseaux sociaux) --}}
    <meta property="og:type"        content="@yield('og_type', 'website')">
    <meta property="og:title"       content="@yield('og_title', 'Iran News')">
    <meta property="og:description" content="@yield('og_description', 'Actualités sur la guerre en Iran.')">
    <meta property="og:url"         content="{{ url()->current() }}">
    <meta property="og:image"       content="@yield('og_image', asset('images/default-og.jpg'))">

    {{-- ✅ TWITTER CARD --}}
    <meta name="twitter:card"        content="summary_large_image">
    <meta name="twitter:title"       content="@yield('og_title', 'Iran News')">
    <meta name="twitter:description" content="@yield('og_description', 'Actualités sur la guerre en Iran.')">
    <meta name="twitter:image"       content="@yield('og_image', asset('images/default-og.jpg'))">

    {{-- ✅ SCHEMA.ORG JSON-LD (injecté par les vues enfants) --}}
    @stack('schema')

    {{-- Sitemap dans le head --}}
    <link rel="sitemap" type="application/xml" href="{{ url('/sitemap.xml') }}">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body>

<header>
    {{-- Navigation principale --}}
    <nav aria-label="Navigation principale">
        <a href="{{ route('home') }}">Iran News</a>
        @foreach(\App\Models\Category::all() as $cat)
            <a href="{{ route('category.show', $cat) }}">{{ $cat->name }}</a>
        @endforeach
    </nav>
</header>

<main>
    @yield('content')
</main>

<footer>
    <p>&copy; {{ date('Y') }} Iran News</p>
</footer>

</body>
</html>
```

### 5.3 Vue article avec SEO complet

```blade
{{-- resources/views/front/article.blade.php --}}
@extends('layouts.app')

@section('title', $article->title . ' | Iran News')
@section('meta_description', $article->meta_description ?? $article->excerpt)
@section('canonical', route('article.show', [$category, $article]))
@section('og_type', 'article')
@section('og_title', $article->title)
@section('og_description', $article->excerpt)
@section('og_image', $article->image ? asset('storage/' . $article->image) : '')

{{-- ✅ SCHEMA.ORG Article --}}
@push('schema')
<script type="application/ld+json">
{
    "@context": "https://schema.org",
    "@type": "NewsArticle",
    "headline": "{{ $article->title }}",
    "description": "{{ $article->meta_description ?? $article->excerpt }}",
    "datePublished": "{{ $article->published_at->toIso8601String() }}",
    "dateModified": "{{ $article->updated_at->toIso8601String() }}",
    "author": {
        "@type": "Person",
        "name": "{{ $article->user->name }}"
    },
    "publisher": {
        "@type": "Organization",
        "name": "Iran News",
        "logo": {
            "@type": "ImageObject",
            "url": "{{ asset('images/logo.png') }}"
        }
    }
    @if($article->image)
    ,"image": "{{ asset('storage/' . $article->image) }}"
    @endif
}
</script>
@endpush

@section('content')

{{-- ✅ BREADCRUMB --}}
<nav aria-label="Fil d'Ariane">
    <ol>
        <li><a href="{{ route('home') }}">Accueil</a></li>
        <li><a href="{{ route('category.show', $category) }}">{{ $category->name }}</a></li>
        <li aria-current="page">{{ $article->title }}</li>
    </ol>
</nav>

<article>
    {{-- ✅ H1 unique avec le mot-clé principal --}}
    <h1>{{ $article->title }}</h1>

    <p>
        Publié le {{ $article->published_at->format('d/m/Y') }}
        dans <a href="{{ route('category.show', $category) }}">{{ $category->name }}</a>
    </p>

    {{-- ✅ IMAGE avec ALT obligatoire --}}
    @if($article->image)
    <figure>
        <img
            src="{{ asset('storage/' . $article->image) }}"
            alt="{{ $article->alt_image ?? $article->title }}"
            width="800"
            height="450"
            loading="lazy"
        >
    </figure>
    @endif

    {{-- ✅ CONTENU avec structure H2/H3 --}}
    <div class="article-content">
        {!! $article->content !!}
    </div>
</article>

{{-- Articles liés --}}
@if($related->count())
<section>
    {{-- ✅ H2 pour les sections secondaires --}}
    <h2>Articles liés</h2>
    <div>
        @foreach($related as $item)
        <article>
            <h3>
                <a href="{{ route('article.show', [$item->category, $item]) }}">
                    {{ $item->title }}
                </a>
            </h3>
            <p>{{ $item->excerpt }}</p>
        </article>
        @endforeach
    </div>
</section>
@endif

@endsection
```

---

## 6. Étape 5 — Optimisation SEO

### 6.1 URL Rewriting — récapitulatif

Le **slug** est généré automatiquement par le modèle (voir étape 2). Les URLs finales ont la forme :

```
/                                    → page d'accueil
/politique                           → catégorie "Politique"
/politique/tensions-au-moyen-orient  → article
/sitemap.xml                         → sitemap dynamique
```

Pas de `/articles/123` avec des IDs numériques — uniquement des slugs lisibles et descriptifs.

### 6.2 `public/robots.txt`

```
User-agent: *
Allow: /
Disallow: /admin
Disallow: /login
Disallow: /register

Sitemap: http://localhost:8080/sitemap.xml
```

### 6.3 Sitemap dynamique

```php
// app/Http/Controllers/SitemapController.php
<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\Category;

class SitemapController extends Controller
{
    public function index()
    {
        $articles   = Article::published()->with('category')->get();
        $categories = Category::all();

        return response()->view('sitemap', compact('articles', 'categories'))
                         ->header('Content-Type', 'application/xml');
    }
}
```

```blade
{{-- resources/views/sitemap.blade.php --}}
<?xml version="1.0" encoding="UTF-8"?>
<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">

    {{-- Page d'accueil --}}
    <url>
        <loc>{{ url('/') }}</loc>
        <changefreq>daily</changefreq>
        <priority>1.0</priority>
    </url>

    {{-- Catégories --}}
    @foreach($categories as $category)
    <url>
        <loc>{{ route('category.show', $category) }}</loc>
        <changefreq>weekly</changefreq>
        <priority>0.8</priority>
    </url>
    @endforeach

    {{-- Articles --}}
    @foreach($articles as $article)
    <url>
        <loc>{{ route('article.show', [$article->category, $article]) }}</loc>
        <lastmod>{{ $article->updated_at->toAtomString() }}</lastmod>
        <changefreq>monthly</changefreq>
        <priority>0.7</priority>
    </url>
    @endforeach

</urlset>
```

### 6.4 Récapitulatif des critères SEO à valider

| Critère | Implémentation | Fichier |
|---|---|---|
| `<title>` unique 50-60 car. | `@section('title', ...)` | `layouts/app.blade.php` |
| `<meta description>` 150-160 car. | `@section('meta_description', ...)` | `layouts/app.blade.php` |
| Un seul `<h1>` par page | `<h1>{{ $article->title }}</h1>` | `front/article.blade.php` |
| Structure H2, H3… logique | Dans le contenu de l'article | Éditeur BO |
| Alt sur les images | `alt="{{ $article->alt_image }}"` | `front/article.blade.php` |
| URL lisible (slug) | Route model binding + `Str::slug()` | `routes/web.php` + modèles |
| `robots.txt` | Fichier statique | `public/robots.txt` |
| `sitemap.xml` | Contrôleur dynamique | `SitemapController.php` |
| Lien canonical | `<link rel="canonical">` | `layouts/app.blade.php` |
| Open Graph | Balises `og:*` | `layouts/app.blade.php` |
| Schema.org JSON-LD | `<script type="application/ld+json">` | `front/article.blade.php` |
| HTTPS | Nginx + `APP_URL=https://...` | `docker-compose.yml` |
| Mobile responsive | Meta viewport + CSS responsive | `layouts/app.blade.php` |

---

## 7. Étape 6 — Tests Lighthouse

### 7.1 Lancer le test

1. Ouvrir Chrome et aller sur `http://localhost:8080`
2. Ouvrir les DevTools (`F12`)
3. Onglet **Lighthouse**
4. Cocher : **Performance, Accessibility, SEO**
5. Tester en **Mobile** puis **Desktop**
6. Faire une capture d'écran du rapport pour le document technique

### 7.2 Objectifs minimums

| Catégorie | Cible |
|---|---|
| Performance | ≥ 70 |
| Accessibilité | ≥ 85 |
| SEO | ≥ 90 |
| Bonnes pratiques | ≥ 80 |

### 7.3 Corrections fréquentes

**Images trop lourdes** → ajouter `loading="lazy"` et définir `width` + `height`

```html
<img src="..." alt="..." width="800" height="450" loading="lazy">
```

**Pas de meta viewport** → déjà dans le layout, vérifier qu'elle est bien présente :

```html
<meta name="viewport" content="width=device-width, initial-scale=1.0">
```

**Liens sans texte descriptif** → éviter `<a href="#">Cliquez ici</a>`, préférer `<a href="/article">Lire l'article complet</a>`

**Contraste insuffisant** → utiliser des couleurs avec ratio ≥ 4.5:1

---

## 8. Étape 7 — Git & Livraison

### 8.1 Initialisation du dépôt

```bash
cd mon-projet
git init
git add .
git commit -m "Initial commit — mini-projet SEO Laravel"

# Créer un repo public sur GitHub ou GitLab, puis :
git remote add origin https://github.com/ton-compte/iran-news.git
git push -u origin main
```

### 8.2 `.gitignore` (vérifier que ces fichiers sont exclus)

```
app/.env
app/vendor/
app/node_modules/
app/storage/
pgdata/
*.zip
```

### 8.3 `README.md` du dépôt

```markdown
# Iran News — Mini-projet SEO Laravel

## Lancer le projet

```bash
git clone https://github.com/ton-compte/iran-news.git
cd iran-news
docker-compose up -d --build
docker exec -it laravel_app php artisan migrate --seed
docker exec -it laravel_app php artisan storage:link
```

Accéder au site : http://localhost:8080

## Accès Back-Office

URL : http://localhost:8080/login
Email : admin@admin.com
Mot de passe : password

## Stack technique
- PHP 8.2 / Laravel 11
- PostgreSQL 15
- Nginx
- Docker / Docker Compose
```

### 8.4 Contenu du document technique (PDF/Word)

Le document technique doit contenir :

1. **Page de garde** : titre, noms, numéros étudiants, date
2. **Captures d'écran FO** : accueil, listing catégorie, page article
3. **Captures d'écran BO** : login, liste articles, formulaire de création
4. **Modélisation de la base de données** : schéma ERD avec les tables et relations
5. **Identifiants BO par défaut** : email + mot de passe clairement indiqués
6. **Rapport Lighthouse** : captures mobile et desktop
7. **Lien du dépôt Git public**

---

## 9. Checklist finale

### Avant de livrer, vérifier point par point :

**Docker & déploiement**
- [ ] `docker-compose up -d --build` fonctionne sans erreur
- [ ] `php artisan migrate --seed` peuple la base
- [ ] `php artisan storage:link` est exécuté (pour les images)
- [ ] Le site est accessible sur `http://localhost:8080`

**Front-Office**
- [ ] Page d'accueil affiche les articles publiés
- [ ] Page catégorie filtre par catégorie
- [ ] Page article affiche le contenu complet
- [ ] Les images s'affichent correctement

**Back-Office**
- [ ] Login accessible sur `/login`
- [ ] CRUD articles fonctionnel (créer, modifier, supprimer)
- [ ] Upload d'image fonctionnel
- [ ] Identifiants par défaut : `admin@admin.com` / `password`

**SEO — critères du sujet**
- [ ] URL avec slugs lisibles (ex: `/politique/tensions-iran`)
- [ ] Un seul `<h1>` par page contenant le mot-clé
- [ ] Structure H2, H3 logique dans les articles
- [ ] `<title>` unique par page (50-60 caractères)
- [ ] `<meta name="description">` (150-160 caractères)
- [ ] `alt` renseigné sur toutes les images
- [ ] `robots.txt` présent et configuré
- [ ] `sitemap.xml` accessible et valide
- [ ] Lighthouse SEO ≥ 90 en mobile et desktop

**Livraison**
- [ ] ZIP contenant le projet complet (avec docker-compose)
- [ ] Dépôt Git public accessible
- [ ] Document technique complet (captures FO+BO, ERD, identifiants, numéros étudiants)
- [ ] Livré avant le **mardi 31 mars à 14h00**

---

> 💡 **Conseil** : commencer par faire tourner Docker + les migrations, puis construire le BO (CRUD articles), puis le FO, et finir par affiner le SEO. Le Lighthouse en dernier pour corriger les derniers points.
