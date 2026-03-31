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
    <meta property="og:type" content="website">
    <meta property="og:locale" content="fr_FR">
    
    <!-- Twitter Card -->
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="<?php echo $og_title ?? $page_title ?? SITE_NAME; ?>">
    <meta name="twitter:description" content="<?php echo $og_description ?? $meta_description ?? SITE_DESCRIPTION; ?>">
    <meta name="twitter:image" content="<?php echo $og_image ?? SITE_URL . '/img/og-default.jpg'; ?>">

    <!-- Canonical URL -->
    <link rel="canonical" href="<?php echo $canonical ?? SITE_URL . $_SERVER['REQUEST_URI']; ?>">
    
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Libre+Baskerville:ital,wght@0,400;0,700;1,400&family=Source+Sans+3:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <style>
        :root {
            --blue-primary: #003f8a;
            --blue-dark: #00265c;
            --blue-accent: #0066cc;
            --blue-light: #e8f1fb;
            --blue-mid: #1a73c8;
            --red-breaking: #d0021b;
            --gold: #c8a04a;
            --text-dark: #1a1a2e;
            --text-mid: #444;
            --text-light: #777;
            --border: #dde3ed;
            --bg-light: #f4f7fc;
            --white: #fff;
            --shadow-sm: 0 1px 4px rgba(0,63,138,.08);
            --shadow-md: 0 4px 16px rgba(0,63,138,.12);
            --shadow-lg: 0 8px 32px rgba(0,63,138,.16);
            --font-display: 'Libre Baskerville', Georgia, serif;
            --font-body: 'Source Sans 3', sans-serif;
        }

        *, *::before, *::after {
            margin: 0; padding: 0;
            box-sizing: border-box;
        }

        html { scroll-behavior: smooth; }

        body {
            font-family: var(--font-body);
            color: var(--text-dark);
            background: var(--bg-light);
            line-height: 1.6;
            font-size: 16px;
            -webkit-font-smoothing: antialiased;
        }

        .container {
            max-width: 1240px;
            margin: 0 auto;
            padding: 0 24px;
        }

        /* ─── TOP BAR ─── */
        .top-bar {
            background: var(--blue-dark);
            padding: 6px 0;
            font-size: 0.75rem;
            color: rgba(255,255,255,.65);
            border-bottom: 1px solid rgba(255,255,255,.08);
        }

        .top-bar .container {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .top-bar time {
            letter-spacing: .04em;
            text-transform: uppercase;
            font-weight: 500;
        }

        .top-bar-links {
            display: flex;
            gap: 1.25rem;
            list-style: none;
        }

        .top-bar-links a {
            color: rgba(255,255,255,.65);
            text-decoration: none;
            transition: color .2s;
        }

        .top-bar-links a:hover { color: #fff; }

        /* ─── BREAKING TICKER ─── */
        .breaking-bar {
            background: var(--red-breaking);
            padding: 7px 0;
            overflow: hidden;
            display: flex;
            align-items: center;
        }

        .breaking-label {
            background: #fff;
            color: var(--red-breaking);
            font-weight: 700;
            font-size: 0.7rem;
            letter-spacing: .08em;
            text-transform: uppercase;
            padding: 3px 12px;
            white-space: nowrap;
            margin-right: 16px;
            flex-shrink: 0;
            margin-left: 24px;
        }

        .ticker-wrapper {
            overflow: hidden;
            flex: 1;
        }

        .ticker-track {
            display: flex;
            gap: 0;
            animation: ticker 35s linear infinite;
            white-space: nowrap;
        }

        .ticker-track:hover { animation-play-state: paused; }

        .ticker-item {
            color: #fff;
            font-size: 0.82rem;
            font-weight: 500;
            padding-right: 60px;
            flex-shrink: 0;
        }

        .ticker-item::before {
            content: '•';
            margin-right: 10px;
            opacity: .6;
        }

        @keyframes ticker {
            0%   { transform: translateX(0); }
            100% { transform: translateX(-50%); }
        }

        /* ─── HEADER ─── */
        header {
            background: var(--blue-primary);
            position: sticky;
            top: 0;
            z-index: 100;
            box-shadow: 0 2px 12px rgba(0,0,0,.25);
        }

        .header-inner {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 14px 0;
        }

        .logo {
            display: flex;
            align-items: center;
            gap: 10px;
            text-decoration: none;
        }

        .logo-icon {
            width: 38px;
            height: 38px;
            background: var(--gold);
            border-radius: 4px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 700;
            font-size: 1.1rem;
            color: var(--blue-dark);
            font-family: var(--font-display);
            flex-shrink: 0;
        }

        .logo-text {
            color: #fff;
            font-family: var(--font-display);
            font-size: 1.5rem;
            font-weight: 700;
            letter-spacing: -.01em;
            line-height: 1;
        }

        .logo-tagline {
            color: rgba(255,255,255,.55);
            font-size: 0.65rem;
            letter-spacing: .06em;
            text-transform: uppercase;
            font-weight: 400;
            display: block;
            margin-top: 2px;
        }

        /* ─── NAV ─── */
        .main-nav {
            background: var(--blue-dark);
            border-top: 1px solid rgba(255,255,255,.1);
        }

        .nav-list {
            display: flex;
            list-style: none;
            gap: 0;
        }

        .nav-list a {
            display: block;
            padding: 12px 20px;
            color: rgba(255,255,255,.8);
            text-decoration: none;
            font-size: 0.82rem;
            font-weight: 600;
            letter-spacing: .06em;
            text-transform: uppercase;
            transition: background .2s, color .2s;
            position: relative;
        }

        .nav-list a:hover,
        .nav-list a.active {
            color: #fff;
            background: rgba(255,255,255,.1);
        }

        .nav-list a.active::after {
            content: '';
            position: absolute;
            bottom: 0; left: 0; right: 0;
            height: 3px;
            background: var(--gold);
        }

        /* ─── SEARCH ─── */
        .header-search {
            display: flex;
            align-items: center;
            background: rgba(255,255,255,.12);
            border: 1px solid rgba(255,255,255,.2);
            border-radius: 4px;
            overflow: hidden;
            transition: background .2s;
        }

        .header-search:focus-within {
            background: rgba(255,255,255,.18);
        }

        .header-search input {
            background: none;
            border: none;
            outline: none;
            color: #fff;
            font-size: 0.85rem;
            padding: 7px 12px;
            width: 180px;
            font-family: var(--font-body);
        }

        .header-search input::placeholder { color: rgba(255,255,255,.5); }

        .header-search button {
            background: none;
            border: none;
            color: rgba(255,255,255,.7);
            padding: 7px 10px;
            cursor: pointer;
            transition: color .2s;
            font-size: 1rem;
        }

        .header-search button:hover { color: #fff; }

        /* ─── MAIN ─── */
        main {
            min-height: calc(100vh - 220px);
            padding: 32px 0 64px;
        }

        /* ─── HERO ARTICLE ─── */
        .hero-article {
            background: #fff;
            border-radius: 6px;
            overflow: hidden;
            margin-bottom: 40px;
            box-shadow: var(--shadow-md);
            display: grid;
            grid-template-columns: 1fr 420px;
            min-height: 420px;
        }

        .hero-image-wrap {
            position: relative;
            overflow: hidden;
        }

        .hero-image {
            width: 100%;
            height: 100%;
            object-fit: cover;
            display: block;
            transition: transform .6s ease;
        }

        .hero-article:hover .hero-image {
            transform: scale(1.03);
        }

        .hero-image-overlay {
            position: absolute;
            inset: 0;
            background: linear-gradient(to right, rgba(0,38,92,.35) 0%, transparent 60%);
        }

        .hero-content {
            padding: 36px 40px;
            display: flex;
            flex-direction: column;
            justify-content: center;
            border-left: 4px solid var(--blue-primary);
        }

        .hero-title {
            font-family: var(--font-display);
            font-size: 1.75rem;
            line-height: 1.25;
            margin-bottom: 14px;
            color: var(--text-dark);
        }

        .hero-title a {
            color: inherit;
            text-decoration: none;
            transition: color .2s;
        }

        .hero-title a:hover { color: var(--blue-accent); }

        .hero-excerpt {
            color: var(--text-mid);
            font-size: 1rem;
            line-height: 1.65;
            margin-bottom: 24px;
            flex: 1;
        }

        /* ─── SECTION HEADING ─── */
        .section-heading {
            display: flex;
            align-items: center;
            gap: 14px;
            margin: 40px 0 24px;
        }

        .section-heading h2 {
            font-family: var(--font-display);
            font-size: 1.35rem;
            color: var(--text-dark);
            font-weight: 700;
        }

        .section-heading::after {
            content: '';
            flex: 1;
            height: 1px;
            background: var(--border);
        }

        .section-heading-accent {
            width: 4px;
            height: 24px;
            background: var(--blue-primary);
            border-radius: 2px;
            flex-shrink: 0;
        }

        /* ─── ARTICLE GRID ─── */
        .grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(340px, 1fr));
            gap: 24px;
        }

        .article-card {
            background: #fff;
            border-radius: 6px;
            overflow: hidden;
            box-shadow: var(--shadow-sm);
            border: 1px solid var(--border);
            display: flex;
            flex-direction: column;
            transition: transform .25s ease, box-shadow .25s ease;
        }

        .article-card:hover {
            transform: translateY(-4px);
            box-shadow: var(--shadow-md);
        }

        .article-image-wrap {
            position: relative;
            overflow: hidden;
            aspect-ratio: 16/9;
        }

        .article-image {
            width: 100%;
            height: 100%;
            object-fit: cover;
            display: block;
            transition: transform .5s ease;
        }

        .article-card:hover .article-image {
            transform: scale(1.05);
        }

        .article-content {
            padding: 20px;
            display: flex;
            flex-direction: column;
            flex: 1;
        }

        .article-title {
            font-family: var(--font-display);
            font-size: 1.05rem;
            line-height: 1.35;
            margin-bottom: 10px;
            font-weight: 700;
        }

        .article-title a {
            color: var(--text-dark);
            text-decoration: none;
            transition: color .2s;
        }

        .article-title a:hover { color: var(--blue-accent); }

        .article-meta {
            color: var(--text-light);
            font-size: 0.78rem;
            margin-bottom: 10px;
            display: flex;
            align-items: center;
            gap: 6px;
            letter-spacing: .01em;
        }

        .meta-dot {
            width: 3px; height: 3px;
            background: var(--text-light);
            border-radius: 50%;
        }

        .article-excerpt {
            color: var(--text-mid);
            font-size: 0.9rem;
            line-height: 1.6;
            margin-bottom: 16px;
            flex: 1;
            display: -webkit-box;
            -webkit-line-clamp: 3;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }

        /* ─── CATEGORY TAG ─── */
        .category-tag {
            display: inline-flex;
            align-items: center;
            background: var(--blue-light);
            color: var(--blue-primary);
            padding: 3px 10px;
            border-radius: 2px;
            font-size: 0.7rem;
            font-weight: 700;
            letter-spacing: .08em;
            text-transform: uppercase;
            margin-bottom: 12px;
        }

        /* ─── BUTTONS ─── */
        .btn {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 9px 18px;
            background: var(--blue-primary);
            color: #fff;
            text-decoration: none;
            border-radius: 3px;
            font-size: 0.82rem;
            font-weight: 600;
            letter-spacing: .04em;
            transition: background .2s, transform .15s;
            border: none;
            cursor: pointer;
            align-self: flex-start;
        }

        .btn:hover {
            background: var(--blue-dark);
            transform: translateY(-1px);
        }

        .btn-outline {
            background: transparent;
            color: var(--blue-primary);
            border: 2px solid var(--blue-primary);
        }

        .btn-outline:hover {
            background: var(--blue-primary);
            color: #fff;
        }

        /* ─── BREADCRUMB ─── */
        .breadcrumb {
            display: flex;
            align-items: center;
            gap: 8px;
            font-size: 0.82rem;
            color: var(--text-light);
            margin-bottom: 28px;
            flex-wrap: wrap;
        }

        .breadcrumb a {
            color: var(--blue-accent);
            text-decoration: none;
            transition: color .2s;
        }

        .breadcrumb a:hover { color: var(--blue-dark); text-decoration: underline; }

        .breadcrumb-sep {
            color: var(--border);
            font-size: 1rem;
        }

        /* ─── PAGE HEADER ─── */
        .page-header {
            background: linear-gradient(135deg, var(--blue-primary) 0%, var(--blue-dark) 100%);
            color: #fff;
            padding: 40px 0 36px;
            margin-bottom: 36px;
            position: relative;
            overflow: hidden;
        }

        .page-header::before {
            content: '';
            position: absolute;
            top: -40px; right: -40px;
            width: 280px; height: 280px;
            border: 40px solid rgba(255,255,255,.04);
            border-radius: 50%;
        }

        .page-header h1 {
            font-family: var(--font-display);
            font-size: 2.2rem;
            line-height: 1.2;
            margin-bottom: 10px;
        }

        .page-header p {
            color: rgba(255,255,255,.75);
            font-size: 1rem;
            max-width: 580px;
        }

        /* ─── PAGINATION ─── */
        .pagination {
            display: flex;
            justify-content: center;
            align-items: center;
            gap: 12px;
            margin: 48px 0 16px;
            flex-wrap: wrap;
        }

        .pagination-info {
            color: var(--text-light);
            font-size: 0.88rem;
            background: #fff;
            padding: 9px 18px;
            border-radius: 3px;
            border: 1px solid var(--border);
        }

        /* ─── FOOTER ─── */
        footer {
            background: var(--blue-dark);
            color: rgba(255,255,255,.75);
            margin-top: 0;
        }

        .footer-top {
            padding: 48px 0 36px;
            display: grid;
            grid-template-columns: 2fr 1fr 1fr;
            gap: 48px;
            border-bottom: 1px solid rgba(255,255,255,.1);
        }

        .footer-brand .logo-text {
            font-size: 1.3rem;
            margin-bottom: 10px;
            display: block;
        }

        .footer-brand p {
            font-size: 0.88rem;
            line-height: 1.65;
            color: rgba(255,255,255,.55);
        }

        .footer-col h3 {
            color: #fff;
            font-size: 0.75rem;
            letter-spacing: .1em;
            text-transform: uppercase;
            font-weight: 700;
            margin-bottom: 14px;
        }

        .footer-col ul {
            list-style: none;
            display: flex;
            flex-direction: column;
            gap: 8px;
        }

        .footer-col a {
            color: rgba(255,255,255,.55);
            text-decoration: none;
            font-size: 0.88rem;
            transition: color .2s;
        }

        .footer-col a:hover { color: #fff; }

        .footer-bottom {
            padding: 18px 0;
            display: flex;
            justify-content: space-between;
            align-items: center;
            font-size: 0.78rem;
            color: rgba(255,255,255,.4);
            gap: 16px;
            flex-wrap: wrap;
        }

        /* ─── RESPONSIVE ─── */
        @media (max-width: 900px) {
            .hero-article {
                grid-template-columns: 1fr;
                min-height: auto;
            }
            .hero-image-wrap { aspect-ratio: 16/9; }
            .hero-content { padding: 24px; border-left: none; border-top: 4px solid var(--blue-primary); }
            .hero-title { font-size: 1.4rem; }
            .footer-top { grid-template-columns: 1fr; gap: 28px; }
            .header-search { display: none; }
        }

        @media (max-width: 600px) {
            .grid { grid-template-columns: 1fr; }
            .top-bar-links { display: none; }
            .nav-list a { padding: 10px 12px; font-size: 0.75rem; }
            .page-header h1 { font-size: 1.6rem; }
        }
    </style>
</head>
<body>
    <!-- Top Bar -->
    <div class="top-bar">
        <div class="container">
            <time id="live-date"></time>
            <ul class="top-bar-links">
                <li><a href="#">À propos</a></li>
                <li><a href="#">Contact</a></li>
                <li><a href="#">Newsletter</a></li>
            </ul>
        </div>
    </div>

    <!-- Breaking News Ticker -->
    <div class="breaking-bar">
        <span class="breaking-label">En direct</span>
        <div class="ticker-wrapper">
            <div class="ticker-track" aria-label="Fil d'actualité en direct">
                <span class="ticker-item">Dernières informations sur la situation en Iran disponibles</span>
                <span class="ticker-item">Suivez nos reporters sur le terrain 24h/24</span>
                <span class="ticker-item">Analyses et décryptages des événements géopolitiques</span>
                <span class="ticker-item">Retrouvez tous nos articles et dossiers spéciaux</span>
                <!-- Duplication for seamless loop -->
                <span class="ticker-item">Dernières informations sur la situation en Iran disponibles</span>
                <span class="ticker-item">Suivez nos reporters sur le terrain 24h/24</span>
                <span class="ticker-item">Analyses et décryptages des événements géopolitiques</span>
                <span class="ticker-item">Retrouvez tous nos articles et dossiers spéciaux</span>
            </div>
        </div>
    </div>

    <!-- Header -->
    <header>
        <div class="container">
            <div class="header-inner">
                <a href="<?php echo SITE_URL; ?>" class="logo" aria-label="<?php echo SITE_NAME; ?> — Accueil">
                    <div class="logo-icon"><?php echo strtoupper(substr(SITE_NAME, 0, 1)); ?></div>
                    <div>
                        <span class="logo-text"><?php echo SITE_NAME; ?></span>
                        <span class="logo-tagline">L'info internationale en continu</span>
                    </div>
                </a>

                <form class="header-search" role="search" action="<?php echo SITE_URL; ?>/recherche" method="get">
                    <input type="search" name="q" placeholder="Rechercher…" aria-label="Rechercher un article">
                    <button type="submit" aria-label="Lancer la recherche">&#9906;</button>
                </form>
            </div>
        </div>

        <!-- Main Navigation -->
        <nav class="main-nav" aria-label="Navigation principale">
            <div class="container">
                <ul class="nav-list" role="list">
                    <li>
                        <a href="<?php echo SITE_URL; ?>"
                           <?php echo ($path ?? '') === '' ? 'class="active" aria-current="page"' : ''; ?>>
                            Accueil
                        </a>
                    </li>
                    <li>
                        <a href="<?php echo SITE_URL; ?>/articles"
                           <?php echo ($path ?? '') === '/articles' ? 'class="active" aria-current="page"' : ''; ?>>
                            Articles
                        </a>
                    </li>
                </ul>
            </div>
        </nav>
    </header>

    <main id="main-content">
        <div class="container">

    <script>
        (function() {
            var d = new Date();
            var options = { weekday:'long', year:'numeric', month:'long', day:'numeric' };
            var el = document.getElementById('live-date');
            if (el) el.textContent = d.toLocaleDateString('fr-FR', options);
        })();
    </script>