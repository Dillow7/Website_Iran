<?php
// Configuration de la page
$page_title = SITE_NAME . ' — Actualités sur la guerre en Iran';
$meta_description = 'Suivez toute l\'actualité sur la guerre en Iran : analyses politiques, opérations militaires, diplomatie internationale et impact économique.';
$canonical = SITE_URL;
$path = '';

require_once 'header.php';
?>

<!-- Hero Article -->
<?php if ($data['hero']): ?>
<article class="hero-article" itemscope itemtype="https://schema.org/NewsArticle">
    <div class="hero-image-wrap">
        <img src="<?php echo SITE_URL; ?>/img/<?php echo htmlspecialchars($data['hero']['image'] ?? 'default.jpg'); ?>"
             alt="<?php echo htmlspecialchars($data['hero']['alt_image'] ?? $data['hero']['title']); ?>"
             class="hero-image"
             width="800" height="450"
             loading="eager"
             itemprop="image">
        <div class="hero-image-overlay" aria-hidden="true"></div>
    </div>
    <div class="hero-content">
        <div class="category-tag" itemprop="articleSection">
            <?php echo htmlspecialchars($data['hero']['category_name']); ?>
        </div>
        <h1 class="hero-title" itemprop="headline">
            <a href="<?php echo SITE_URL; ?>/<?php echo htmlspecialchars($data['hero']['category_slug']); ?>/<?php echo htmlspecialchars($data['hero']['slug']); ?>">
                <?php echo htmlspecialchars($data['hero']['title']); ?>
            </a>
        </h1>
        <div class="article-meta">
            <span itemprop="author" itemscope itemtype="https://schema.org/Person">
                <span itemprop="name">Par <?php echo htmlspecialchars($data['hero']['author_name'] ?? 'Rédaction'); ?></span>
            </span>
            <span class="meta-dot" aria-hidden="true"></span>
            <time itemprop="datePublished" datetime="<?php echo date('c', strtotime($data['hero']['published_at'])); ?>">
                <?php echo date('d F Y', strtotime($data['hero']['published_at'])); ?>
            </time>
        </div>
        <?php if ($data['hero']['excerpt']): ?>
            <p class="hero-excerpt" itemprop="description">
                <?php echo htmlspecialchars($data['hero']['excerpt']); ?>
            </p>
        <?php endif; ?>
        <a href="<?php echo SITE_URL; ?>/<?php echo htmlspecialchars($data['hero']['category_slug']); ?>/<?php echo htmlspecialchars($data['hero']['slug']); ?>"
           class="btn" aria-label="Lire l'article complet : <?php echo htmlspecialchars($data['hero']['title']); ?>">
            Lire l'article <span aria-hidden="true">→</span>
        </a>
    </div>
</article>
<?php endif; ?>

<!-- Dernières actualités -->
<div class="section-heading">
    <div class="section-heading-accent" aria-hidden="true"></div>
    <h2>Dernières actualités</h2>
</div>

<div class="grid" role="list">
    <?php foreach ($data['articles'] as $article): ?>
    <article class="article-card" role="listitem" itemscope itemtype="https://schema.org/NewsArticle">
        <div class="article-image-wrap">
            <img src="<?php echo SITE_URL; ?>/img/<?php echo htmlspecialchars($article['image'] ?? 'default.jpg'); ?>"
                 alt="<?php echo htmlspecialchars($article['alt_image'] ?? $article['title']); ?>"
                 class="article-image"
                 width="400" height="225"
                 loading="lazy"
                 itemprop="image">
        </div>
        <div class="article-content">
            <div class="category-tag" itemprop="articleSection">
                <?php echo htmlspecialchars($article['category_name']); ?>
            </div>
            <h3 class="article-title" itemprop="headline">
                <a href="<?php echo SITE_URL; ?>/<?php echo htmlspecialchars($article['category_slug']); ?>/<?php echo htmlspecialchars($article['slug']); ?>">
                    <?php echo htmlspecialchars($article['title']); ?>
                </a>
            </h3>
            <div class="article-meta">
                <span itemprop="author">Par <?php echo htmlspecialchars($article['author_name'] ?? 'Rédaction'); ?></span>
                <span class="meta-dot" aria-hidden="true"></span>
                <time itemprop="datePublished" datetime="<?php echo date('c', strtotime($article['published_at'])); ?>">
                    <?php echo date('d F Y', strtotime($article['published_at'])); ?>
                </time>
            </div>
            <?php if ($article['excerpt']): ?>
                <p class="article-excerpt" itemprop="description">
                    <?php echo htmlspecialchars($article['excerpt']); ?>
                </p>
            <?php endif; ?>
            <a href="<?php echo SITE_URL; ?>/<?php echo htmlspecialchars($article['category_slug']); ?>/<?php echo htmlspecialchars($article['slug']); ?>"
               class="btn"
               aria-label="Lire la suite : <?php echo htmlspecialchars($article['title']); ?>">
                Lire la suite
            </a>
        </div>
    </article>
    <?php endforeach; ?>
</div>

<?php require_once 'footer.php'; ?>