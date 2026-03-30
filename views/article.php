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

<!-- Fil d'Ariane -->
<nav class="breadcrumb">
    <a href="<?php echo SITE_URL; ?>">Accueil</a> → 
    <a href="<?php echo SITE_URL; ?>/<?php echo htmlspecialchars($data['article']['category_slug']); ?>">
        <?php echo htmlspecialchars($data['article']['category_name']); ?>
    </a> → 
    <span><?php echo htmlspecialchars($data['article']['title']); ?></span>
</nav>

<!-- Article -->
<article class="article-detail" style="max-width: 800px; margin: 0 auto;">
    <header>
        <div class="category-tag"><?php echo htmlspecialchars($data['article']['category_name']); ?></div>
        <h1 style="font-size: 2.5rem; margin: 1rem 0; line-height: 1.2;"><?php echo htmlspecialchars($data['article']['title']); ?></h1>
        <div class="article-meta" style="margin-bottom: 2rem; color: #666;">
            Par <?php echo htmlspecialchars($data['article']['author_name'] ?? 'Rédaction'); ?> • 
            <time datetime="<?php echo date('c', strtotime($data['article']['published_at'])); ?>">
                <?php echo date('d F Y à H:i', strtotime($data['article']['published_at'])); ?>
            </time>
        </div>
    </header>

    <?php if ($data['article']['image']): ?>
    <div style="margin: 2rem 0;">
        <img src="<?php echo SITE_URL; ?>/img/<?php echo htmlspecialchars($data['article']['image']); ?>" 
             alt="<?php echo htmlspecialchars($data['article']['alt_image'] ?? $data['article']['title']); ?>" 
             style="width: 100%; height: auto; border-radius: 8px;">
        <?php if ($data['article']['alt_image']): ?>
            <p style="text-align: center; color: #666; font-style: italic; margin-top: 0.5rem;">
                <?php echo htmlspecialchars($data['article']['alt_image']); ?>
            </p>
        <?php endif; ?>
    </div>
    <?php endif; ?>

    <div class="article-content" style="font-size: 1.1rem; line-height: 1.8; margin-bottom: 3rem;">
        <?php echo $data['article']['content']; ?>
    </div>

    <footer style="border-top: 1px solid #e5e5e5; padding-top: 2rem;">
        <div style="margin-bottom: 2rem;">
            <h3 style="margin-bottom: 1rem;">Partager l'article</h3>
            <div style="display: flex; gap: 1rem;">
                <a href="https://twitter.com/intent/tweet?url=<?php echo urlencode($canonical); ?>&text=<?php echo urlencode($data['article']['title']); ?>" 
                   target="_blank" class="btn">Twitter</a>
                <a href="https://www.facebook.com/sharer/sharer.php?u=<?php echo urlencode($canonical); ?>" 
                   target="_blank" class="btn">Facebook</a>
                <a href="https://www.linkedin.com/sharing/share-offsite/?url=<?php echo urlencode($canonical); ?>" 
                   target="_blank" class="btn">LinkedIn</a>
            </div>
        </div>
        
        <div style="font-size: 0.9rem; color: #666;">
            <p><strong>Auteur :</strong> <?php echo htmlspecialchars($data['article']['author_name'] ?? 'Rédaction'); ?></p>
            <p><strong>Publié le :</strong> <?php echo date('d F Y à H:i', strtotime($data['article']['published_at'])); ?></p>
            <p><strong>Modifié le :</strong> <?php echo date('d F Y à H:i', strtotime($data['article']['updated_at'])); ?></p>
        </div>
    </footer>
</article>

<!-- Articles similaires -->
<?php if ($data['related']): ?>
<section style="margin-top: 4rem;">
    <h2 style="margin-bottom: 2rem;">Articles similaires</h2>
    <div class="grid">
        <?php foreach ($data['related'] as $related): ?>
        <article class="article-card">
            <img src="<?php echo SITE_URL; ?>/img/<?php echo htmlspecialchars($related['image'] ?? 'default.jpg'); ?>" 
                 alt="<?php echo htmlspecialchars($related['alt_image'] ?? $related['title']); ?>" 
                 class="article-image">
            <div class="article-content">
                <div class="category-tag"><?php echo htmlspecialchars($related['category_name']); ?></div>
                <h3 class="article-title">
                    <a href="<?php echo SITE_URL; ?>/<?php echo htmlspecialchars($related['category_slug']); ?>/<?php echo htmlspecialchars($related['slug']); ?>">
                        <?php echo htmlspecialchars($related['title']); ?>
                    </a>
                </h3>
                <div class="article-meta">
                    <?php echo date('d F Y', strtotime($related['published_at'])); ?>
                </div>
            </div>
        </article>
        <?php endforeach; ?>
    </div>
</section>
<?php endif; ?>

<?php require_once 'footer.php'; ?>
