<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $page_title ?? SITE_NAME; ?></title>
    <meta name="description" content="<?php echo $meta_description ?? SITE_DESCRIPTION; ?>">
    
    <!-- Open Graph -->
    <meta property="og:title" content="<?php echo $og_title ?? $page_title ?? SITE_NAME; ?>">
    <meta property="og:description" content="<?php echo $og_description ?? $meta_description ?? SITE_DESCRIPTION; ?>">
    <meta property="og:image" content="<?php echo $og_image ?? SITE_URL . '/img/og-default.jpg'; ?>">
    <meta property="og:url" content="<?php echo $canonical ?? SITE_URL . $_SERVER['REQUEST_URI']; ?>">
    
    <!-- Canonical URL -->
    <link rel="canonical" href="<?php echo $canonical ?? SITE_URL . $_SERVER['REQUEST_URI']; ?>">
    
    <!-- CSS -->
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
            line-height: 1.6;
            color: #333;
        }
        
        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 20px;
        }
        
        header {
            background: #fff;
            border-bottom: 1px solid #e5e5e5;
            padding: 1rem 0;
        }
        
        .nav {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        
        .logo {
            font-size: 1.5rem;
            font-weight: bold;
            color: #333;
            text-decoration: none;
        }
        
        .nav-links {
            display: flex;
            gap: 2rem;
            list-style: none;
        }
        
        .nav-links a {
            color: #666;
            text-decoration: none;
            transition: color 0.3s;
        }
        
        .nav-links a:hover {
            color: #333;
        }
        
        .nav-links a.active {
            color: #333;
            font-weight: 600;
        }
        
        main {
            min-height: calc(100vh - 200px);
            padding: 2rem 0;
        }
        
        footer {
            background: #f8f9fa;
            padding: 2rem 0;
            text-align: center;
            color: #666;
            margin-top: 4rem;
        }
        
        .article-card {
            background: #fff;
            border: 1px solid #e5e5e5;
            border-radius: 8px;
            overflow: hidden;
            margin-bottom: 2rem;
            transition: transform 0.2s, box-shadow 0.2s;
        }
        
        .article-card:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(0,0,0,0.1);
        }
        
        .article-image {
            width: 100%;
            height: 200px;
            object-fit: cover;
        }
        
        .article-content {
            padding: 1.5rem;
        }
        
        .article-title {
            font-size: 1.25rem;
            margin-bottom: 0.5rem;
        }
        
        .article-title a {
            color: #333;
            text-decoration: none;
        }
        
        .article-title a:hover {
            color: #0066cc;
        }
        
        .article-meta {
            color: #666;
            font-size: 0.9rem;
            margin-bottom: 1rem;
        }
        
        .article-excerpt {
            color: #555;
            line-height: 1.6;
            margin-bottom: 1rem;
        }
        
        .btn {
            display: inline-block;
            padding: 0.5rem 1rem;
            background: #0066cc;
            color: #fff;
            text-decoration: none;
            border-radius: 4px;
            transition: background 0.3s;
        }
        
        .btn:hover {
            background: #0052a3;
        }
        
        .grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(350px, 1fr));
            gap: 2rem;
        }
        
        .hero-article {
            background: #fff;
            border-radius: 12px;
            overflow: hidden;
            margin-bottom: 3rem;
            box-shadow: 0 4px 20px rgba(0,0,0,0.1);
        }
        
        .hero-image {
            width: 100%;
            height: 400px;
            object-fit: cover;
        }
        
        .hero-content {
            padding: 2rem;
        }
        
        .hero-title {
            font-size: 2rem;
            margin-bottom: 1rem;
            line-height: 1.2;
        }
        
        .category-tag {
            display: inline-block;
            background: #e3f2fd;
            color: #1976d2;
            padding: 0.25rem 0.75rem;
            border-radius: 20px;
            font-size: 0.8rem;
            font-weight: 600;
            margin-bottom: 1rem;
        }
        
        .breadcrumb {
            color: #666;
            font-size: 0.9rem;
            margin-bottom: 2rem;
        }
        
        .breadcrumb a {
            color: #666;
            text-decoration: none;
        }
        
        .breadcrumb a:hover {
            color: #333;
        }
    </style>
</head>
<body>
    <header>
        <div class="container">
            <nav class="nav">
                <a href="<?php echo SITE_URL; ?>" class="logo"><?php echo SITE_NAME; ?></a>
                <ul class="nav-links">
                    <li><a href="<?php echo SITE_URL; ?>" <?php echo ($path ?? '') === '' ? 'class="active"' : ''; ?>>Accueil</a></li>
                    <li><a href="<?php echo SITE_URL; ?>/articles" <?php echo ($path ?? '') === '/articles' ? 'class="active"' : ''; ?>>Articles</a></li>
                </ul>
            </nav>
        </div>
    </header>
    
    <main>
        <div class="container">
