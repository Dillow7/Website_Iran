<?php
$page_title = 'Articles — Admin — ' . SITE_NAME;
$meta_description = 'Gestion des articles.';

$articles = $data['articles'] ?? [];

?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($page_title); ?></title>
    <meta name="description" content="<?php echo htmlspecialchars($meta_description); ?>">
    <style>
        * { box-sizing: border-box; }
        body { font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif; margin: 0; background: #f5f6f8; color: #222; }
        .container { max-width: 1100px; margin: 28px auto; padding: 0 18px; }
        .topbar { display: flex; justify-content: space-between; align-items: center; gap: 12px; margin-bottom: 18px; }
        h1 { font-size: 1.5rem; margin: 0; }
        a.btn { display: inline-block; padding: 10px 12px; background: #0066cc; color: #fff; border-radius: 8px; text-decoration: none; font-weight: 700; }
        a.btn:hover { background: #0052a3; }
        a.link { color: #0066cc; text-decoration: none; }
        a.link:hover { text-decoration: underline; }
        table { width: 100%; border-collapse: collapse; background: #fff; border: 1px solid #e6e8ee; border-radius: 10px; overflow: hidden; }
        th, td { padding: 12px; border-bottom: 1px solid #eef0f5; text-align: left; vertical-align: top; }
        th { background: #fbfcff; font-size: 0.9rem; color: #444; }
        tr:last-child td { border-bottom: 0; }
        .muted { color: #666; font-size: 0.9rem; }
        .actions { display: flex; gap: 10px; align-items: center; }
        .danger { background: #ffecec; border: 1px solid #ffd0d0; color: #8a0f0f; padding: 8px 10px; border-radius: 8px; cursor: pointer; }
        .danger:hover { background: #ffdede; }
        .pill { display: inline-block; padding: 2px 8px; border-radius: 999px; font-size: 0.8rem; background: #eef6ff; color: #1b5fb6; }
    </style>
</head>
<body>
    <div class="container">
        <div class="topbar">
            <div>
                <h1>BackOffice — Articles</h1>
                <div class="muted">Connecté: <?php echo htmlspecialchars($_SESSION['admin_user_name'] ?? 'Admin'); ?> • <a class="link" href="<?php echo SITE_URL; ?>/admin/logout">Déconnexion</a></div>
            </div>
            <div>
                <a class="btn" href="<?php echo SITE_URL; ?>/admin/articles/create">Créer un article</a>
            </div>
        </div>

        <table>
            <thead>
                <tr>
                    <th>Titre</th>
                    <th>Catégorie</th>
                    <th>Slug</th>
                    <th>Publication</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php if (!$articles): ?>
                    <tr>
                        <td colspan="5" class="muted">Aucun article.</td>
                    </tr>
                <?php else: ?>
                    <?php foreach ($articles as $a): ?>
                        <tr>
                            <td>
                                <div><strong><?php echo htmlspecialchars($a['title']); ?></strong></div>
                                <?php if (!empty($a['meta_title'])): ?>
                                    <div class="muted">Title SEO: <?php echo htmlspecialchars($a['meta_title']); ?></div>
                                <?php endif; ?>
                            </td>
                            <td>
                                <?php if (!empty($a['category_name'])): ?>
                                    <span class="pill"><?php echo htmlspecialchars($a['category_name']); ?></span>
                                <?php else: ?>
                                    <span class="muted">—</span>
                                <?php endif; ?>
                            </td>
                            <td class="muted"><?php echo htmlspecialchars($a['slug']); ?></td>
                            <td class="muted">
                                <?php if (!empty($a['published_at'])): ?>
                                    Publié
                                <?php else: ?>
                                    Brouillon
                                <?php endif; ?>
                            </td>
                            <td>
                                <div class="actions">
                                    <a class="link" href="<?php echo SITE_URL; ?>/admin/articles/edit/<?php echo (int)$a['id']; ?>">Modifier</a>
                                    <form method="post" action="<?php echo SITE_URL; ?>/admin/articles/delete/<?php echo (int)$a['id']; ?>" onsubmit="return confirm('Supprimer cet article ?');">
                                        <button type="submit" class="danger">Supprimer</button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
            </tbody>
        </table>

        <div style="margin-top: 14px;">
            <a class="link" href="<?php echo SITE_URL; ?>">Retour au FrontOffice</a>
        </div>
    </div>
</body>
</html>
