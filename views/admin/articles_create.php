<?php
$page_title = 'Créer un article — Admin — ' . SITE_NAME;
$meta_description = 'Création d\'article.';

$categories = $data['categories'] ?? [];
$errors     = $data['errors']     ?? [];
$values     = $data['values']     ?? [];

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
    <meta name="robots" content="noindex, nofollow">
    <script src="/build/assets/tinymce/tinymce.min.js"></script>
    <?php require_once 'admin_styles.php'; ?>
    <style>
        .char-count {
            font-size: 0.78rem;
            color: var(--adm-text-muted);
            text-align: right;
            margin-top: 4px;
        }
        .char-count.warn { color: var(--adm-amber); }
        .char-count.over { color: var(--adm-red); font-weight: 700; }
        .slug-preview {
            font-size: 0.8rem;
            color: var(--adm-text-muted);
            margin-top: 5px;
            font-family: monospace;
            background: var(--adm-bg);
            padding: 4px 8px;
            border-radius: 4px;
            word-break: break-all;
        }
    </style>
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
                    <a href="<?php echo SITE_URL; ?>/admin/articles">Articles</a>
                    <span>›</span>
                    <span>Créer</span>
                </div>
                <h1 class="adm-page-title">Créer un article</h1>
            </div>
            <a href="<?php echo SITE_URL; ?>/admin/articles" class="adm-btn adm-btn-ghost">
                ← Retour à la liste
            </a>
        </div>

        <!-- SEO Notice -->
        <div class="adm-notice">
            <strong>Règles SEO :</strong> un seul H1 par page (le titre ci-dessous).
            Dans l'éditeur, structurez le contenu avec des H2 et H3 uniquement.
            Toutes les images insérées doivent avoir un texte alternatif (attribut <code>alt</code>).
        </div>

        <div class="adm-card">
            <div class="adm-card-header">
                <span class="adm-card-title">Informations de l'article</span>
            </div>
            <div class="adm-card-body">
                <form method="post"
                      action="<?php echo SITE_URL; ?>/admin/articles/create"
                      enctype="multipart/form-data"
                      id="article-form">

                    <!-- Titre -->
                    <div class="adm-field">
                        <label class="adm-label" for="title">Titre (H1) <span style="color:var(--adm-red)">*</span></label>
                        <input class="adm-input" id="title" name="title"
                               value="<?php echo field($values, 'title'); ?>" required
                               placeholder="Titre principal de l'article">
                        <?php if (!empty($errors['title'])): ?>
                            <div class="adm-error"><?php echo htmlspecialchars($errors['title']); ?></div>
                        <?php endif; ?>
                    </div>

                    <!-- SEO Title + Slug -->
                    <div class="adm-row">
                        <div>
                            <label class="adm-label" for="meta_title">Title SEO <span class="adm-muted">(optionnel — max 70)</span></label>
                            <input class="adm-input" id="meta_title" name="meta_title"
                                   value="<?php echo field($values, 'meta_title'); ?>"
                                   maxlength="70"
                                   placeholder="Titre affiché dans Google">
                            <div class="char-count" id="meta_title_count">0 / 70</div>
                            <div class="adm-help">Si vide : "Titre — <?php echo htmlspecialchars(SITE_NAME); ?>"</div>
                        </div>
                        <div>
                            <label class="adm-label" for="slug">Slug (URL) <span style="color:var(--adm-red)">*</span></label>
                            <input class="adm-input" id="slug" name="slug"
                                   value="<?php echo field($values, 'slug'); ?>"
                                   placeholder="ex: tensions-militaires-iran">
                            <div class="slug-preview" id="slug_preview">
                                <?php echo SITE_URL; ?>/<em id="slug_preview_text">votre-slug</em>
                            </div>
                            <?php if (!empty($errors['slug'])): ?>
                                <div class="adm-error"><?php echo htmlspecialchars($errors['slug']); ?></div>
                            <?php endif; ?>
                        </div>
                    </div>

                    <!-- Meta description -->
                    <div class="adm-field">
                        <label class="adm-label" for="meta_description">Meta description <span class="adm-muted">(max 160)</span></label>
                        <textarea class="adm-textarea" id="meta_description" name="meta_description"
                                  rows="3" maxlength="160"
                                  placeholder="Résumé affiché dans les résultats Google (150–160 caractères idéaux)"><?php echo field($values, 'meta_description'); ?></textarea>
                        <div class="char-count" id="meta_desc_count">0 / 160</div>
                        <?php if (!empty($errors['meta_description'])): ?>
                            <div class="adm-error"><?php echo htmlspecialchars($errors['meta_description']); ?></div>
                        <?php endif; ?>
                    </div>

                    <!-- Extrait -->
                    <div class="adm-field">
                        <label class="adm-label" for="excerpt">Extrait <span class="adm-muted">(optionnel — affiché sur les listings)</span></label>
                        <textarea class="adm-textarea" id="excerpt" name="excerpt"
                                  rows="3"><?php echo field($values, 'excerpt'); ?></textarea>
                    </div>

                    <!-- Catégorie + Date -->
                    <div class="adm-row">
                        <div>
                            <label class="adm-label" for="category_id">Catégorie <span style="color:var(--adm-red)">*</span></label>
                            <select class="adm-select" id="category_id" name="category_id" required>
                                <option value="">— Choisir une catégorie —</option>
                                <?php foreach ($categories as $c): ?>
                                    <option value="<?php echo (int)$c['id']; ?>"
                                        <?php echo field($values, 'category_id') == (string)$c['id'] ? 'selected' : ''; ?>>
                                        <?php echo htmlspecialchars($c['name']); ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                            <?php if (!empty($errors['category_id'])): ?>
                                <div class="adm-error"><?php echo htmlspecialchars($errors['category_id']); ?></div>
                            <?php endif; ?>
                        </div>
                        <div>
                            <label class="adm-label" for="published_at">Date de publication</label>
                            <input class="adm-input" id="published_at" name="published_at"
                                   type="datetime-local"
                                   value="<?php echo field($values, 'published_at'); ?>">
                            <div class="adm-help">Laisser vide pour enregistrer en brouillon.</div>
                        </div>
                    </div>

                    <!-- Image -->
                    <div class="adm-row">
                        <div>
                            <label class="adm-label" for="image_file">Image principale</label>
                            <input class="adm-input" id="image_file" name="image_file"
                                   type="file" accept="image/*"
                                   style="padding: 7px 12px; cursor:pointer;">
                            <?php if (!empty($errors['image_file'])): ?>
                                <div class="adm-error"><?php echo htmlspecialchars($errors['image_file']); ?></div>
                            <?php endif; ?>
                        </div>
                        <div>
                            <label class="adm-label" for="alt_image">Texte alternatif (alt) <span style="color:var(--adm-red)">*</span></label>
                            <input class="adm-input" id="alt_image" name="alt_image"
                                   value="<?php echo field($values, 'alt_image'); ?>"
                                   placeholder="Description de l'image pour l'accessibilité et le SEO">
                            <?php if (!empty($errors['alt_image'])): ?>
                                <div class="adm-error"><?php echo htmlspecialchars($errors['alt_image']); ?></div>
                            <?php endif; ?>
                        </div>
                    </div>

                    <!-- Contenu TinyMCE -->
                    <div class="adm-field">
                        <label class="adm-label" for="content">Contenu de l'article <span style="color:var(--adm-red)">*</span></label>
                        <textarea id="content" name="content" rows="16"><?php echo field($values, 'content'); ?></textarea>
                        <?php if (!empty($errors['content'])): ?>
                            <div class="adm-error"><?php echo htmlspecialchars($errors['content']); ?></div>
                        <?php endif; ?>
                    </div>

                    <input type="hidden" name="content_sync" id="content_sync" value="">

                    <div class="adm-form-actions">
                        <button type="submit" class="adm-btn adm-btn-primary">Enregistrer l'article</button>
                        <a href="<?php echo SITE_URL; ?>/admin/articles" class="adm-btn adm-btn-ghost">Annuler</a>
                    </div>
                </form>
            </div>
        </div>

    </div>

    <script>
        // ── Compteurs de caractères ──────────────────────────────
        function setupCounter(inputId, counterId, max, warnAt) {
            var el = document.getElementById(inputId);
            var counter = document.getElementById(counterId);
            if (!el || !counter) return;
            function update() {
                var len = el.value.length;
                counter.textContent = len + ' / ' + max;
                counter.className = 'char-count' + (len > max ? ' over' : len > warnAt ? ' warn' : '');
            }
            el.addEventListener('input', update);
            update();
        }
        setupCounter('meta_title', 'meta_title_count', 70, 55);
        setupCounter('meta_description', 'meta_desc_count', 160, 130);

        // ── Aperçu du slug ───────────────────────────────────────
        var slugInput = document.getElementById('slug');
        var slugPreviewText = document.getElementById('slug_preview_text');
        if (slugInput && slugPreviewText) {
            slugInput.addEventListener('input', function() {
                slugPreviewText.textContent = this.value || 'votre-slug';
            });
        }

        // ── TinyMCE ──────────────────────────────────────────────
        tinymce.init({
            base_url: '/build/assets/tinymce',
            suffix: '.min',
            selector: '#content',
            height: 500,
            menubar: false,
            branding: false,
            license_key: 'gpl',
            plugins: 'lists link image code',
            toolbar: 'undo redo | blocks | bold italic | bullist numlist | link image | code',
            block_formats: 'Paragraphe=p; Titre 2=h2; Titre 3=h3; Titre 4=h4; Titre 5=h5; Titre 6=h6',
            image_title: true,
            image_description: true,
            automatic_uploads: false,
            relative_urls: false,
            convert_urls: false,
            link_title: true,
            link_default_target: '_blank',
            content_style: 'body { font-family: -apple-system, BlinkMacSystemFont, Segoe UI, Roboto, sans-serif; font-size: 16px; line-height: 1.8; }',
            setup: function(editor) {
                editor.on('change input undo redo', function() { editor.save(); });
                document.getElementById('article-form').addEventListener('submit', function() {
                    editor.save();
                });
            },
            file_picker_types: 'image',
            file_picker_callback: function(cb, value, meta) {
                if (meta.filetype === 'image') {
                    var input = document.createElement('input');
                    input.setAttribute('type', 'file');
                    input.setAttribute('accept', 'image/*');
                    input.onchange = function() {
                        var file = this.files[0];
                        var reader = new FileReader();
                        reader.onload = function () {
                            cb(reader.result, { alt: 'Description de l\'image' });
                        };
                        reader.readAsDataURL(file);
                    };
                    input.click();
                }
            }
        });
    </script>
</body>
</html>