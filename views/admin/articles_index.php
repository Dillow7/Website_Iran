<?php
$page_title = 'Articles — Admin — ' . SITE_NAME;
$meta_description = 'Gestion des articles.';

$articles = $data['articles'] ?? [];
$total = count($articles);
$published = count(array_filter($articles, fn($a) => !empty($a['published_at'])));
$drafts = $total - $published;
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($page_title); ?></title>
    <meta name="robots" content="noindex, nofollow">
    <?php require_once 'admin_styles.php'; ?>
    
</head>

<body>

    <!-- Top Nav -->
    <nav class="adm-topnav" aria-label="Navigation administration">
        <a href="<?php echo SITE_URL; ?>/admin/articles" class="adm-logo">
            <div class="adm-logo-icon"><?php echo strtoupper(substr(SITE_NAME, 0, 1)); ?></div>
            <span class="adm-logo-text"><?php echo htmlspecialchars(SITE_NAME); ?></span>
            <span class="adm-logo-badge">Admin</span>
        </a>
        <div class="adm-topnav-right">
            <div class="adm-user">
                <div class="adm-user-avatar">
                    <?php echo strtoupper(substr($_SESSION['admin_user_name'] ?? 'A', 0, 1)); ?>
                </div>
                <span><?php echo htmlspecialchars($_SESSION['admin_user_name'] ?? 'Admin'); ?></span>
            </div>
            <a href="<?php echo SITE_URL; ?>" class="adm-logout" target="_blank">↗ Voir le site</a>
            <a href="<?php echo SITE_URL; ?>/admin/logout" class="adm-logout">Déconnexion</a>
        </div>
    </nav>

    <div class="adm-wrap">

        <!-- Page Header -->
        <div class="adm-page-header">
            <div>
                <div class="adm-breadcrumb">
                    <span>Administration</span>
                    <span>›</span>
                    <span>Articles</span>
                </div>
                <h1 class="adm-page-title">Gestion des articles</h1>
            </div>
            <a href="<?php echo SITE_URL; ?>/admin/articles/create" class="adm-btn adm-btn-primary">
                + Créer un article
            </a>
        </div>

        <!-- Stats -->
        <div class="adm-stats">
            <div class="adm-stat-card">
                <div class="adm-stat-label">Total articles</div>
                <div class="adm-stat-value"><?php echo $total; ?></div>
            </div>
            <div class="adm-stat-card">
                <div class="adm-stat-label">Publiés</div>
                <div class="adm-stat-value" style="color:var(--adm-green)"><?php echo $published; ?></div>
            </div>
            <div class="adm-stat-card">
                <div class="adm-stat-label">Brouillons</div>
                <div class="adm-stat-value" style="color:var(--adm-amber)"><?php echo $drafts; ?></div>
            </div>
        </div>

        <!-- Table -->
        <div class="adm-card">
            <div class="adm-card-header">
                <span class="adm-card-title">Tous les articles</span>
            </div>
            <div class="adm-table-wrap">
                <table class="adm-table">
                    <thead>
                        <tr>
                            <th>Titre</th>
                            <th>Catégorie</th>
                            <th>Slug</th>
                            <th>Statut</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (!$articles): ?>
                            <tr>
                                <td colspan="5" style="text-align:center; padding:32px; color:var(--adm-text-muted);">
                                    Aucun article pour l'instant.
                                </td>
                            </tr>
                        <?php else: ?>
                            <?php foreach ($articles as $a): ?>
                                <tr>
                                    <td>
                                        <div style="font-weight:600; color:var(--adm-text); margin-bottom:3px;">
                                            <?php echo htmlspecialchars($a['title']); ?>
                                        </div>
                                        <?php if (!empty($a['meta_title'])): ?>
                                            <div class="adm-muted">SEO: <?php echo htmlspecialchars($a['meta_title']); ?></div>
                                        <?php endif; ?>
                                    </td>
                                    <td>
                                        <?php if (!empty($a['category_name'])): ?>
                                            <span class="adm-pill adm-pill-blue"><?php echo htmlspecialchars($a['category_name']); ?></span>
                                        <?php else: ?>
                                            <span class="adm-muted">—</span>
                                        <?php endif; ?>
                                    </td>
                                    <td>
                                        <code style="font-size:.82rem; color:var(--adm-text-muted); background:var(--adm-bg); padding:2px 6px; border-radius:3px;">
                                            <?php echo htmlspecialchars($a['slug']); ?>
                                        </code>
                                    </td>
                                    <td>
                                        <?php if (!empty($a['published_at'])): ?>
                                            <span class="adm-pill adm-pill-green">Publié</span>
                                        <?php else: ?>
                                            <span class="adm-pill adm-pill-amber">Brouillon</span>
                                        <?php endif; ?>
                                    </td>
                                    <td>
                                        <div class="adm-table-actions">
                                            <a href="<?php echo SITE_URL; ?>/admin/articles/edit/<?php echo (int)$a['id']; ?>"
                                               class="adm-btn adm-btn-ghost" style="padding:6px 12px; font-size:.82rem;">
                                                Modifier
                                            </a>
                                            <?php if (!empty($a['category_slug']) && !empty($a['slug'])): ?>
                                                <a href="<?php echo SITE_URL; ?>/<?php echo htmlspecialchars($a['category_slug']); ?>/<?php echo htmlspecialchars($a['slug']); ?>"
                                                   target="_blank"
                                                   class="adm-btn adm-btn-ghost" style="padding:6px 10px; font-size:.82rem;"
                                                   title="Voir sur le site">↗</a>
                                            <?php endif; ?>
                                            <form method="post"
                                                  action="<?php echo SITE_URL; ?>/admin/articles/delete/<?php echo (int)$a['id']; ?>"
                                                  onsubmit="return confirm('Supprimer définitivement cet article ?');"
                                                  style="display:inline;">
                                                <button type="submit" class="adm-btn adm-btn-danger" style="padding:6px 12px; font-size:.82rem;">
                                                    Supprimer
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>

    </div>
</body>
</html>