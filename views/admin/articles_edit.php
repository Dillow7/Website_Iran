<?php
$page_title = 'Modifier un article — Admin — ' . SITE_NAME;
$meta_description = 'Modification d\'article.';

$categories = $data['categories'] ?? [];
$errors = $data['errors'] ?? [];
$values = $data['values'] ?? [];
$article = $data['article'] ?? [];

function field($values, $key) {
    return htmlspecialchars((string)($values[$key] ?? ''));
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($page_title); ?></title>
    <meta name="description" content="<?php echo htmlspecialchars($meta_description); ?>">

    <script src="https://cdn.tiny.cloud/1/no-api-key/tinymce/6/tinymce.min.js" referrerpolicy="origin"></script>
    <style>
        * { box-sizing: border-box; }
        body { font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif; margin: 0; background: #f5f6f8; color: #222; }
        .container { max-width: 1100px; margin: 28px auto; padding: 0 18px; }
        .topbar { display: flex; justify-content: space-between; align-items: center; gap: 12px; margin-bottom: 18px; }
        h1 { font-size: 1.5rem; margin: 0; }
        a.link { color: #0066cc; text-decoration: none; }
        a.link:hover { text-decoration: underline; }
        .card { background: #fff; border: 1px solid #e6e8ee; border-radius: 10px; padding: 18px; box-shadow: 0 8px 24px rgba(0,0,0,0.06); }
        label { display: block; font-weight: 700; margin: 12px 0 6px; }
        input, select, textarea { width: 100%; padding: 10px 12px; border: 1px solid #cfd6e4; border-radius: 8px; font-size: 1rem; }
        .row { display: grid; grid-template-columns: 1fr 1fr; gap: 14px; }
        .help { font-size: 0.9rem; color: #666; margin-top: 6px; }
        .error { margin-top: 6px; color: #8a0f0f; font-size: 0.92rem; }
        .actions { display: flex; gap: 12px; margin-top: 16px; align-items: center; }
        button { padding: 10px 12px; border: 0; border-radius: 8px; background: #0066cc; color: #fff; font-weight: 800; cursor: pointer; }
        button:hover { background: #0052a3; }
        .note { background: #fbfcff; border: 1px dashed #cfd6e4; padding: 12px; border-radius: 10px; color: #444; margin-bottom: 14px; }
        .meta { font-size: 0.9rem; color: #666; margin-top: 6px; }
    </style>
</head>
<body>
    <div class="container">
        <div class="topbar">
            <div>
                <h1>Modifier un article</h1>
                <div class="help">Connecté: <?php echo htmlspecialchars($_SESSION['admin_user_name'] ?? 'Admin'); ?> • <a class="link" href="<?php echo SITE_URL; ?>/admin/logout">Déconnexion</a></div>
                <?php if (!empty($article['id'])): ?>
                    <div class="meta">ID: <?php echo (int)$article['id']; ?> • Créé: <?php echo htmlspecialchars((string)($article['created_at'] ?? '')); ?></div>
                <?php endif; ?>
            </div>
            <div><a class="link" href="<?php echo SITE_URL; ?>/admin/articles">← Retour</a></div>
        </div>

        <div class="card">
            <div class="note">
                Règles SEO: un seul H1 par page (le titre). Dans l'éditeur, utilise des H2/H3 pour structurer. Les images insérées doivent avoir un attribut alt.
            </div>

            <form method="post">
                <label for="title">Titre (H1)</label>
                <input id="title" name="title" value="<?php echo field($values, 'title'); ?>" required>
                <?php if (!empty($errors['title'])): ?><div class="error"><?php echo htmlspecialchars($errors['title']); ?></div><?php endif; ?>

                <div class="row">
                    <div>
                        <label for="meta_title">Title SEO (&lt;title&gt;) (optionnel)</label>
                        <input id="meta_title" name="meta_title" value="<?php echo field($values, 'meta_title'); ?>" maxlength="70">
                    </div>
                    <div>
                        <label for="slug">Slug (URL)</label>
                        <input id="slug" name="slug" value="<?php echo field($values, 'slug'); ?>">
                        <?php if (!empty($errors['slug'])): ?><div class="error"><?php echo htmlspecialchars($errors['slug']); ?></div><?php endif; ?>
                    </div>
                </div>

                <label for="meta_description">Meta description (max 160)</label>
                <textarea id="meta_description" name="meta_description" rows="3" maxlength="160"><?php echo field($values, 'meta_description'); ?></textarea>
                <?php if (!empty($errors['meta_description'])): ?><div class="error"><?php echo htmlspecialchars($errors['meta_description']); ?></div><?php endif; ?>

                <label for="excerpt">Extrait (optionnel)</label>
                <textarea id="excerpt" name="excerpt" rows="3"><?php echo field($values, 'excerpt'); ?></textarea>

                <div class="row">
                    <div>
                        <label for="category_id">Catégorie</label>
                        <select id="category_id" name="category_id" required>
                            <option value="">— Choisir —</option>
                            <?php foreach ($categories as $c): ?>
                                <option value="<?php echo (int)$c['id']; ?>" <?php echo field($values, 'category_id') == (string)$c['id'] ? 'selected' : ''; ?>>
                                    <?php echo htmlspecialchars($c['name']); ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                        <?php if (!empty($errors['category_id'])): ?><div class="error"><?php echo htmlspecialchars($errors['category_id']); ?></div><?php endif; ?>
                    </div>
                    <div>
                        <label for="published_at">Date de publication (optionnel)</label>
                        <input id="published_at" name="published_at" type="datetime-local" value="<?php echo field($values, 'published_at'); ?>">
                        <div class="help">Vide = brouillon</div>
                    </div>
                </div>

                <div class="row">
                    <div>
                        <label for="image">Image principale (nom de fichier dans /img)</label>
                        <input id="image" name="image" value="<?php echo field($values, 'image'); ?>" placeholder="ex: iran-military.jpg">
                    </div>
                    <div>
                        <label for="alt_image">Alt image principale</label>
                        <input id="alt_image" name="alt_image" value="<?php echo field($values, 'alt_image'); ?>" placeholder="Description de l'image">
                        <?php if (!empty($errors['alt_image'])): ?><div class="error"><?php echo htmlspecialchars($errors['alt_image']); ?></div><?php endif; ?>
                    </div>
                </div>

                <label for="content">Contenu</label>
                <textarea id="content" name="content" rows="16"><?php echo field($values, 'content'); ?></textarea>
                <?php if (!empty($errors['content'])): ?><div class="error"><?php echo htmlspecialchars($errors['content']); ?></div><?php endif; ?>

                <div class="actions">
                    <button type="submit">Enregistrer</button>
                    <a class="link" href="<?php echo SITE_URL; ?>/admin/articles">Retour</a>
                </div>
            </form>
        </div>
    </div>

    <script>
        tinymce.init({
            selector: '#content',
            height: 520,
            menubar: false,
            branding: false,
            plugins: [
                'lists',
                'link',
                'image',
                'code'
            ],
            toolbar: [
                'undo redo | blocks | bold italic | bullist numlist | link image | code'
            ],
            block_formats: 'Paragraphe=p; Titre 2=h2; Titre 3=h3; Titre 4=h4; Titre 5=h5; Titre 6=h6',
            image_title: true,
            image_advtab: true,
            image_description: true,
            automatic_uploads: false,
            relative_urls: false,
            convert_urls: false,
            link_title: true,
            link_default_target: '_blank',
            content_style: 'body { font-family: -apple-system, BlinkMacSystemFont, Segoe UI, Roboto, sans-serif; font-size: 16px; line-height: 1.8; }',
            setup: (editor) => {
                editor.on('NodeChange', () => {
                    const imgs = editor.getBody().querySelectorAll('img');
                    imgs.forEach(img => {
                        if (!img.getAttribute('alt')) {
                            img.setAttribute('alt', '');
                        }
                    });
                });
            },
            file_picker_types: 'image',
            file_picker_callback: (cb, value, meta) => {
                if (meta.filetype === 'image') {
                    const editor = tinymce.activeEditor;
                    editor.windowManager.open({
                        title: 'Insérer une image',
                        body: {
                            type: 'panel',
                            items: [
                                { type: 'input', name: 'src', label: 'Source (URL ou /img/...)' },
                                { type: 'input', name: 'alt', label: 'Alt (obligatoire)' }
                            ]
                        },
                        buttons: [
                            { type: 'cancel', text: 'Annuler' },
                            { type: 'submit', text: 'Insérer', primary: true }
                        ],
                        onSubmit: (api) => {
                            const data = api.getData();
                            const src = (data.src || '').trim();
                            const alt = (data.alt || '').trim();
                            if (!src) {
                                api.close();
                                return;
                            }
                            if (!alt) {
                                alert('Alt obligatoire pour le SEO.');
                                return;
                            }
                            cb(src, { alt: alt });
                            api.close();
                        }
                    });
                }
            }
        });
    </script>
</body>
</html>
