<?php
// Variables globales
global $pdo, $category_slug;

// Récupérer la catégorie
$stmt = $pdo->prepare("SELECT * FROM categories WHERE slug = :slug");
$stmt->execute(['slug' => $category_slug]);
$category = $stmt->fetch();

if (!$category) {
    http_response_code(404);
    require_once '404.php';
    exit;
}

// Configuration de la page
$page_title = htmlspecialchars($category['name']) . ' — ' . SITE_NAME;
$meta_description = 'Découvrez tous les articles de la catégorie ' . htmlspecialchars($category['name']) . ' sur ' . SITE_NAME . '.';
$canonical = SITE_URL . '/' . htmlspecialchars($category['slug']);

require_once 'header.php';
?>

<!-- Fil d'Ariane -->
<nav class="breadcrumb" aria-label="Fil d'Ariane">
    <a href="<?php echo SITE_URL; ?>">Accueil</a>
    <span class="breadcrumb-sep" aria-hidden="true">›</span>
    <span aria-current="page"><?php echo htmlspecialchars($category['name']); ?></span>
</nav>

<!-- Page Header -->
<div class="page-header" style="margin: 0 -24px 36px; padding-left: 24px; padding-right: 24px;">
    <div class="category-tag" style="background:rgba(255,255,255,.15); color:#fff; margin-bottom:12px;">
        Catégorie
    </div>
    <h1><?php echo htmlspecialchars($category['name']); ?></h1>
    <p>Découvrez tous les articles dans la catégorie <?php echo htmlspecialchars($category['name']); ?>.</p>
</div>

<div class="grid" role="list">
    <?php
    // Pagination
    $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
    $per_page = 12;
    $offset = ($page - 1) * $per_page;
    
    // Compter le total d'articles dans cette catégorie
    $stmt = $pdo->prepare("
        SELECT COUNT(*) as total 
        FROM articles 
        WHERE category_id = :category_id AND published_at IS NOT NULL
    ");
    $stmt->execute(['category_id' => $category['id']]);
    $total = $stmt->fetch()['total'];
    $total_pages = ceil($total / $per_page);
    
    // Récupérer les articles pour la page actuelle
    $stmt = $pdo->prepare("
        SELECT a.*, c.name as category_name, c.slug as category_slug, u.name as author_name
        FROM articles a
        LEFT JOIN categories c ON a.category_id = c.id
        LEFT JOIN users u ON a.user_id = u.id
        WHERE a.category_id = :category_id AND a.published_at IS NOT NULL
        ORDER BY a.published_at DESC
        LIMIT :limit OFFSET :offset
    ");
    $stmt->bindValue(':category_id', $category['id'], PDO::PARAM_INT);
    $stmt->bindValue(':limit', $per_page, PDO::PARAM_INT);
    $stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
    $stmt->execute();
    $articles = $stmt->fetchAll();
    
    foreach ($articles as $article):
    ?>
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
            <h2 class="article-title" itemprop="headline">
                <a href="<?php echo SITE_URL; ?>/<?php echo htmlspecialchars($article['category_slug']); ?>/<?php echo htmlspecialchars($article['slug']); ?>">
                    <?php echo htmlspecialchars($article['title']); ?>
                </a>
            </h2>
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

<!-- Pagination -->
<?php if ($total_pages > 1): ?>
<nav class="pagination" aria-label="Navigation des pages">
    <?php if ($page > 1): ?>
        <a href="?page=<?php echo $page - 1; ?>" class="btn btn-outline" rel="prev">
            <span aria-hidden="true">←</span> Précédent
        </a>
    <?php endif; ?>

    <span class="pagination-info">
        Page <?php echo $page; ?> sur <?php echo $total_pages; ?>
    </span>

    <?php if ($page < $total_pages): ?>
        <a href="?page=<?php echo $page + 1; ?>" class="btn" rel="next">
            Suivant <span aria-hidden="true">→</span>
        </a>
    <?php endif; ?>
</nav>
<?php endif; ?>

<?php require_once 'footer.php'; ?>