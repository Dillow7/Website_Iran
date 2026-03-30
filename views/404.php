<?php
// Configuration de la page
$page_title = 'Page non trouvée — ' . SITE_NAME;
$meta_description = 'La page que vous recherchez n\'existe pas ou a été déplacée.';

require_once 'header.php';
?>

<div style="text-align: center; padding: 4rem 0;">
    <h1 style="font-size: 4rem; color: #ccc; margin-bottom: 1rem;">404</h1>
    <h2 style="font-size: 2rem; margin-bottom: 1rem;">Page non trouvée</h2>
    <p style="color: #666; margin-bottom: 2rem; max-width: 500px; margin-left: auto; margin-right: auto;">
        La page que vous recherchez n'existe pas ou a été déplacée.
    </p>
    <div style="display: flex; gap: 1rem; justify-content: center;">
        <a href="<?php echo SITE_URL; ?>" class="btn">← Retour à l'accueil</a>
        <a href="<?php echo SITE_URL; ?>/articles" class="btn">Voir tous les articles</a>
    </div>
</div>

<?php require_once 'footer.php'; ?>
