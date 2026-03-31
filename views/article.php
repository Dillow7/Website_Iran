<?php
// Configuration de la page
$page_title = htmlspecialchars($data['article']['meta_title'] ?: ($data['article']['title'] . ' — ' . SITE_NAME));
$meta_description = htmlspecialchars($data['article']['meta_description'] ?? mb_substr(strip_tags($data['article']['content']), 0, 160));
$canonical = SITE_URL . '/' . htmlspecialchars($data['article']['category_slug']) . '/' . htmlspecialchars($data['article']['slug']);
$og_title = htmlspecialchars($data['article']['title']);
$og_description = htmlspecialchars($data['article']['meta_description'] ?? mb_substr(strip_tags($data['article']['content']), 0, 160));
$og_image = SITE_URL . '/img/' . htmlspecialchars($data['article']['image'] ?? 'default.jpg');

require_once 'header.php';
?>

<style>
    /* ─── ARTICLE LAYOUT ─── */
    .article-layout {
        display: grid;
        grid-template-columns: 1fr 300px;
        gap: 40px;
        align-items: start;
        max-width: 1100px;
        margin: 0 auto;
    }

    .article-main { min-width: 0; }

    /* ─── ARTICLE HEADER ─── */
    .article-header {
        margin-bottom: 28px;
    }

    .article-kicker {
        display: flex;
        align-items: center;
        gap: 12px;
        margin-bottom: 16px;
    }

    .article-h1 {
        font-family: var(--font-display);
        font-size: 2.2rem;
        line-height: 1.2;
        color: var(--text-dark);
        margin-bottom: 18px;
        font-weight: 700;
    }

    .article-byline {
        display: flex;
        align-items: center;
        gap: 14px;
        padding: 14px 0;
        border-top: 1px solid var(--border);
        border-bottom: 1px solid var(--border);
        flex-wrap: wrap;
    }

    .byline-avatar {
        width: 38px;
        height: 38px;
        border-radius: 50%;
        background: var(--blue-primary);
        color: #fff;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 0.85rem;
        font-weight: 700;
        flex-shrink: 0;
    }

    .byline-info { flex: 1; }

    .byline-name {
        font-size: 0.9rem;
        font-weight: 600;
        color: var(--text-dark);
        display: block;
    }

    .byline-date {
        font-size: 0.8rem;
        color: var(--text-light);
    }

    /* ─── ARTICLE FIGURE ─── */
    .article-figure {
        margin: 28px 0;
        border-radius: 6px;
        overflow: hidden;
    }

    .article-figure img {
        width: 100%;
        height: auto;
        display: block;
    }

    .article-figcaption {
        background: var(--bg-light);
        padding: 10px 14px;
        font-size: 0.82rem;
        color: var(--text-light);
        font-style: italic;
        border-left: 3px solid var(--blue-primary);
    }

    /* ─── ARTICLE BODY ─── */
    .article-body {
        font-size: 1.05rem;
        line-height: 1.85;
        color: var(--text-mid);
        margin-bottom: 40px;
    }

    .article-body p { margin-bottom: 1.4em; }

    .article-body h2 {
        font-family: var(--font-display);
        font-size: 1.5rem;
        color: var(--text-dark);
        margin: 2em 0 0.75em;
        padding-bottom: 8px;
        border-bottom: 2px solid var(--blue-light);
    }

    .article-body h3 {
        font-family: var(--font-display);
        font-size: 1.2rem;
        color: var(--text-dark);
        margin: 1.5em 0 0.5em;
    }

    .article-body blockquote {
        border-left: 4px solid var(--blue-primary);
        background: var(--blue-light);
        margin: 2em 0;
        padding: 16px 20px;
        border-radius: 0 4px 4px 0;
        font-family: var(--font-display);
        font-style: italic;
        font-size: 1.1rem;
        color: var(--blue-dark);
    }

    .article-body a {
        color: var(--blue-accent);
        text-decoration: underline;
        text-decoration-color: rgba(0,102,204,.35);
        transition: color .2s;
    }

    .article-body a:hover { color: var(--blue-dark); }

    .article-body ul, .article-body ol {
        padding-left: 1.5em;
        margin-bottom: 1.4em;
    }

    .article-body li { margin-bottom: 0.4em; }

    /* ─── SHARE BAR ─── */
    .share-bar {
        background: var(--bg-light);
        border: 1px solid var(--border);
        border-radius: 6px;
        padding: 20px 24px;
        margin-bottom: 32px;
        display: flex;
        align-items: center;
        gap: 16px;
        flex-wrap: wrap;
    }

    .share-label {
        font-size: 0.82rem;
        font-weight: 700;
        color: var(--text-mid);
        letter-spacing: .05em;
        text-transform: uppercase;
        white-space: nowrap;
    }

    .share-links {
        display: flex;
        gap: 10px;
        flex-wrap: wrap;
    }

    .share-btn {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        padding: 7px 14px;
        border-radius: 3px;
        font-size: 0.8rem;
        font-weight: 600;
        text-decoration: none;
        transition: opacity .2s, transform .15s;
    }

    .share-btn:hover { opacity: .85; transform: translateY(-1px); }

    .share-btn.tw { background: #000; color: #fff; }
    .share-btn.fb { background: #1877f2; color: #fff; }
    .share-btn.li { background: #0a66c2; color: #fff; }

    /* ─── ARTICLE FOOTER ─── */
    .article-footer-meta {
        border-top: 2px solid var(--blue-light);
        padding-top: 20px;
        font-size: 0.85rem;
        color: var(--text-light);
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 16px;
    }

    .meta-item strong {
        display: block;
        font-size: 0.72rem;
        letter-spacing: .07em;
        text-transform: uppercase;
        color: var(--text-light);
        margin-bottom: 4px;
    }

    .meta-item span {
        color: var(--text-dark);
        font-weight: 500;
        font-size: 0.88rem;
    }

    /* ─── SIDEBAR ─── */
    .article-sidebar {
        position: sticky;
        top: 90px;
    }

    .sidebar-widget {
        background: #fff;
        border: 1px solid var(--border);
        border-radius: 6px;
        overflow: hidden;
        margin-bottom: 24px;
    }

    .sidebar-widget-title {
        background: var(--blue-primary);
        color: #fff;
        padding: 10px 16px;
        font-size: 0.75rem;
        font-weight: 700;
        letter-spacing: .08em;
        text-transform: uppercase;
    }

    .sidebar-related-item {
        display: flex;
        gap: 12px;
        padding: 14px 16px;
        border-bottom: 1px solid var(--border);
        text-decoration: none;
        transition: background .2s;
    }

    .sidebar-related-item:last-child { border-bottom: none; }
    .sidebar-related-item:hover { background: var(--bg-light); }

    .sidebar-thumb {
        width: 64px;
        height: 48px;
        object-fit: cover;
        border-radius: 3px;
        flex-shrink: 0;
    }

    .sidebar-item-text { flex: 1; min-width: 0; }

    .sidebar-item-title {
        font-family: var(--font-display);
        font-size: 0.85rem;
        line-height: 1.35;
        color: var(--text-dark);
        font-weight: 700;
        margin-bottom: 4px;
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }

    .sidebar-item-date {
        font-size: 0.75rem;
        color: var(--text-light);
    }

    /* ─── RELATED ARTICLES ─── */
    .related-section {
        margin-top: 52px;
        padding-top: 36px;
        border-top: 3px solid var(--blue-primary);
    }

    /* ─── RESPONSIVE ─── */
    @media (max-width: 900px) {
        .article-layout { grid-template-columns: 1fr; }
        .article-sidebar { position: static; display: none; }
        .article-h1 { font-size: 1.7rem; }
        .article-footer-meta { grid-template-columns: 1fr; gap: 12px; }
    }
</style>

<!-- Fil d'Ariane -->
<nav class="breadcrumb" aria-label="Fil d'Ariane">
    <a href="<?php echo SITE_URL; ?>">Accueil</a>
    <span class="breadcrumb-sep" aria-hidden="true">›</span>
    <a href="<?php echo SITE_URL; ?>/<?php echo htmlspecialchars($data['article']['category_slug']); ?>">
        <?php echo htmlspecialchars($data['article']['category_name']); ?>
    </a>
    <span class="breadcrumb-sep" aria-hidden="true">›</span>
    <span aria-current="page"><?php echo htmlspecialchars($data['article']['title']); ?></span>
</nav>

<div class="article-layout">

    <!-- Main Content -->
    <main class="article-main">
        <article itemscope itemtype="https://schema.org/NewsArticle">
            <meta itemprop="url" content="<?php echo $canonical; ?>">
            <meta itemprop="image" content="<?php echo $og_image; ?>">

            <!-- Header -->
            <header class="article-header">
                <div class="article-kicker">
                    <div class="category-tag" itemprop="articleSection">
                        <?php echo htmlspecialchars($data['article']['category_name']); ?>
                    </div>
                </div>

                <h1 class="article-h1" itemprop="headline">
                    <?php echo htmlspecialchars($data['article']['title']); ?>
                </h1>

                <div class="article-byline">
                    <?php
                    $author = $data['article']['author_name'] ?? 'Rédaction';
                    $initials = implode('', array_map(fn($w) => strtoupper($w[0]), array_slice(explode(' ', $author), 0, 2)));
                    ?>
                    <div class="byline-avatar" aria-hidden="true"><?php echo htmlspecialchars($initials); ?></div>
                    <div class="byline-info">
                        <span class="byline-name" itemprop="author" itemscope itemtype="https://schema.org/Person">
                            <span itemprop="name"><?php echo htmlspecialchars($author); ?></span>
                        </span>
                        <time class="byline-date"
                              itemprop="datePublished"
                              datetime="<?php echo date('c', strtotime($data['article']['published_at'])); ?>">
                            Publié le <?php echo date('d F Y à H:i', strtotime($data['article']['published_at'])); ?>
                        </time>
                    </div>
                </div>
            </header>

            <!-- Image principale -->
            <?php if ($data['article']['image']): ?>
            <figure class="article-figure">
                <img src="<?php echo SITE_URL; ?>/img/<?php echo htmlspecialchars($data['article']['image']); ?>"
                     alt="<?php echo htmlspecialchars($data['article']['alt_image'] ?? $data['article']['title']); ?>"
                     width="800" height="450"
                     loading="eager"
                     itemprop="image">
                <?php if ($data['article']['alt_image']): ?>
                    <figcaption class="article-figcaption">
                        <?php echo htmlspecialchars($data['article']['alt_image']); ?>
                    </figcaption>
                <?php endif; ?>
            </figure>
            <?php endif; ?>

            <!-- Corps de l'article -->
            <div class="article-body" itemprop="articleBody">
                <?php echo $data['article']['content']; ?>
            </div>

            <!-- Barre de partage -->
            <div class="share-bar">
                <span class="share-label">Partager</span>
                <div class="share-links">
                    <a href="https://twitter.com/intent/tweet?url=<?php echo urlencode($canonical); ?>&text=<?php echo urlencode($data['article']['title']); ?>"
                       target="_blank" rel="noopener noreferrer" class="share-btn tw"
                       aria-label="Partager sur X (Twitter)">
                        ✕ Twitter
                    </a>
                    <a href="https://www.facebook.com/sharer/sharer.php?u=<?php echo urlencode($canonical); ?>"
                       target="_blank" rel="noopener noreferrer" class="share-btn fb"
                       aria-label="Partager sur Facebook">
                        f Facebook
                    </a>
                    <a href="https://www.linkedin.com/sharing/share-offsite/?url=<?php echo urlencode($canonical); ?>"
                       target="_blank" rel="noopener noreferrer" class="share-btn li"
                       aria-label="Partager sur LinkedIn">
                        in LinkedIn
                    </a>
                </div>
            </div>

            <!-- Métadonnées pied d'article -->
            <footer class="article-footer-meta">
                <div class="meta-item">
                    <strong>Auteur</strong>
                    <span><?php echo htmlspecialchars($data['article']['author_name'] ?? 'Rédaction'); ?></span>
                </div>
                <div class="meta-item">
                    <strong>Publié le</strong>
                    <time itemprop="datePublished"
                          datetime="<?php echo date('c', strtotime($data['article']['published_at'])); ?>">
                        <?php echo date('d F Y à H:i', strtotime($data['article']['published_at'])); ?>
                    </time>
                </div>
                <div class="meta-item">
                    <strong>Mis à jour le</strong>
                    <time itemprop="dateModified"
                          datetime="<?php echo date('c', strtotime($data['article']['updated_at'])); ?>">
                        <?php echo date('d F Y à H:i', strtotime($data['article']['updated_at'])); ?>
                    </time>
                </div>
            </footer>
        </article>

        <!-- Articles similaires -->
        <?php if ($data['related']): ?>
        <section class="related-section" aria-labelledby="related-heading">
            <div class="section-heading">
                <div class="section-heading-accent" aria-hidden="true"></div>
                <h2 id="related-heading">Articles similaires</h2>
            </div>

            <div class="grid" role="list">
                <?php foreach ($data['related'] as $related): ?>
                <article class="article-card" role="listitem" itemscope itemtype="https://schema.org/NewsArticle">
                    <div class="article-image-wrap">
                        <img src="<?php echo SITE_URL; ?>/img/<?php echo htmlspecialchars($related['image'] ?? 'default.jpg'); ?>"
                             alt="<?php echo htmlspecialchars($related['alt_image'] ?? $related['title']); ?>"
                             class="article-image"
                             width="400" height="225"
                             loading="lazy"
                             itemprop="image">
                    </div>
                    <div class="article-content">
                        <div class="category-tag" itemprop="articleSection">
                            <?php echo htmlspecialchars($related['category_name']); ?>
                        </div>
                        <h3 class="article-title" itemprop="headline">
                            <a href="<?php echo SITE_URL; ?>/<?php echo htmlspecialchars($related['category_slug']); ?>/<?php echo htmlspecialchars($related['slug']); ?>">
                                <?php echo htmlspecialchars($related['title']); ?>
                            </a>
                        </h3>
                        <div class="article-meta">
                            <time itemprop="datePublished"
                                  datetime="<?php echo date('c', strtotime($related['published_at'])); ?>">
                                <?php echo date('d F Y', strtotime($related['published_at'])); ?>
                            </time>
                        </div>
                    </div>
                </article>
                <?php endforeach; ?>
            </div>
        </section>
        <?php endif; ?>
    </main>

    <!-- Sidebar -->
    <aside class="article-sidebar" aria-label="Contenu complémentaire">
        <?php if ($data['related']): ?>
        <div class="sidebar-widget">
            <div class="sidebar-widget-title">À lire aussi</div>
            <?php foreach (array_slice($data['related'], 0, 4) as $related): ?>
            <a href="<?php echo SITE_URL; ?>/<?php echo htmlspecialchars($related['category_slug']); ?>/<?php echo htmlspecialchars($related['slug']); ?>"
               class="sidebar-related-item">
                <img src="<?php echo SITE_URL; ?>/img/<?php echo htmlspecialchars($related['image'] ?? 'default.jpg'); ?>"
                     alt="<?php echo htmlspecialchars($related['alt_image'] ?? $related['title']); ?>"
                     class="sidebar-thumb"
                     width="64" height="48"
                     loading="lazy">
                <div class="sidebar-item-text">
                    <div class="sidebar-item-title"><?php echo htmlspecialchars($related['title']); ?></div>
                    <div class="sidebar-item-date">
                        <?php echo date('d F Y', strtotime($related['published_at'])); ?>
                    </div>
                </div>
            </a>
            <?php endforeach; ?>
        </div>
        <?php endif; ?>

        <!-- Widget catégorie -->
        <div class="sidebar-widget">
            <div class="sidebar-widget-title">Catégorie</div>
            <div style="padding: 16px;">
                <div class="category-tag" style="font-size:.8rem; padding: 5px 12px;">
                    <?php echo htmlspecialchars($data['article']['category_name']); ?>
                </div>
                <p style="margin-top: 12px; font-size: .85rem; color: var(--text-light); line-height: 1.55;">
                    Retrouvez tous nos articles sur ce sujet.
                </p>
                <a href="<?php echo SITE_URL; ?>/<?php echo htmlspecialchars($data['article']['category_slug']); ?>"
                   class="btn" style="margin-top: 14px; font-size: .8rem;">
                    Voir la catégorie →
                </a>
            </div>
        </div>
    </aside>

</div>

<?php require_once 'footer.php'; ?>