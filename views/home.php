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
<div class="hero-article">
    <img src="<?php echo SITE_URL; ?>/img/<?php echo htmlspecialchars($data['hero']['image'] ?? 'default.jpg'); ?>" 
         alt="<?php echo htmlspecialchars($data['hero']['alt_image'] ?? $data['hero']['title']); ?>" 
         class="hero-image">
    <div class="hero-content">
        <div class="category-tag"><?php echo htmlspecialchars($data['hero']['category_name']); ?></div>
        <h1 class="hero-title">
            <a href="<?php echo SITE_URL; ?>/<?php echo htmlspecialchars($data['hero']['category_slug']); ?>/<?php echo htmlspecialchars($data['hero']['slug']); ?>">
                <?php echo htmlspecialchars($data['hero']['title']); ?>
            </a>
        </h1>
        <div class="article-meta">
            Par <?php echo htmlspecialchars($data['hero']['author_name'] ?? 'Rédaction'); ?> • 
            <?php echo date('d F Y', strtotime($data['hero']['published_at'])); ?>
        </div>
        <?php if ($data['hero']['excerpt']): ?>
            <p class="article-excerpt"><?php echo htmlspecialchars($data['hero']['excerpt']); ?></p>
        <?php endif; ?>
        <a href="<?php echo SITE_URL; ?>/<?php echo htmlspecialchars($data['hero']['category_slug']); ?>/<?php echo htmlspecialchars($data['hero']['slug']); ?>" class="btn">
            Lire l'article →
        </a>
    </div>
</div>
<?php endif; ?>

<!-- Articles Grid -->
<h2 style="margin: 3rem 0 2rem 0;">Dernières actualités</h2>

<div class="grid">
    <?php foreach ($data['articles'] as $article): ?>
    <article class="article-card">
        <img src="<?php echo SITE_URL; ?>/img/<?php echo htmlspecialchars($article['image'] ?? 'default.jpg'); ?>" 
             alt="<?php echo htmlspecialchars($article['alt_image'] ?? $article['title']); ?>" 
             class="article-image">
        <div class="article-content">
            <div class="category-tag"><?php echo htmlspecialchars($article['category_name']); ?></div>
            <h3 class="article-title">
                <a href="<?php echo SITE_URL; ?>/<?php echo htmlspecialchars($article['category_slug']); ?>/<?php echo htmlspecialchars($article['slug']); ?>">
                    <?php echo htmlspecialchars($article['title']); ?>
                </a>
            </h3>
            <div class="article-meta">
                Par <?php echo htmlspecialchars($article['author_name'] ?? 'Rédaction'); ?> • 
                <?php echo date('d F Y', strtotime($article['published_at'])); ?>
            </div>
            <?php if ($article['excerpt']): ?>
                <p class="article-excerpt"><?php echo htmlspecialchars($article['excerpt']); ?></p>
            <?php endif; ?>
            <a href="<?php echo SITE_URL; ?>/<?php echo htmlspecialchars($article['category_slug']); ?>/<?php echo htmlspecialchars($article['slug']); ?>" class="btn">
                Lire la suite
            </a>
        </div>
    </article>
    <?php endforeach; ?>
</div>

<?php require_once 'footer.php'; ?>
