<?php
// Configuration de la page
$page_title = 'Page non trouvée — ' . SITE_NAME;
$meta_description = 'La page que vous recherchez n\'existe pas ou a été déplacée.';

require_once 'header.php';
?>

<style>
    .error-page {
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        text-align: center;
        padding: 64px 24px 80px;
        max-width: 560px;
        margin: 0 auto;
    }

    .error-code {
        font-family: var(--font-display);
        font-size: 7rem;
        font-weight: 700;
        line-height: 1;
        color: var(--blue-light);
        letter-spacing: -.04em;
        position: relative;
        margin-bottom: 8px;
    }

    .error-code::after {
        content: '404';
        position: absolute;
        inset: 0;
        display: flex;
        align-items: center;
        justify-content: center;
        color: var(--blue-primary);
        font-size: 7rem;
        clip-path: inset(0 0 50% 0);
    }

    .error-divider {
        width: 60px;
        height: 4px;
        background: var(--blue-primary);
        border-radius: 2px;
        margin: 20px auto 28px;
    }

    .error-title {
        font-family: var(--font-display);
        font-size: 1.75rem;
        color: var(--text-dark);
        margin-bottom: 14px;
        font-weight: 700;
    }

    .error-desc {
        color: var(--text-light);
        font-size: 1rem;
        line-height: 1.65;
        margin-bottom: 36px;
    }

    .error-actions {
        display: flex;
        gap: 12px;
        flex-wrap: wrap;
        justify-content: center;
    }
</style>

<div class="error-page" role="main">
    <div class="error-code" aria-label="Erreur 404">404</div>
    <div class="error-divider" aria-hidden="true"></div>

    <h1 class="error-title">Page non trouvée</h1>
    <p class="error-desc">
        La page que vous recherchez n'existe pas ou a été déplacée.<br>
        Elle a peut-être été supprimée ou l'adresse a changé.
    </p>

    <div class="error-actions">
        <a href="<?php echo SITE_URL; ?>" class="btn">
            ← Retour à l'accueil
        </a>
        <a href="<?php echo SITE_URL; ?>/articles" class="btn btn-outline">
            Voir tous les articles
        </a>
    </div>
</div>

<?php require_once 'footer.php'; ?>