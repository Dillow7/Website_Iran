<?php
$page_title = 'Connexion — Admin — ' . SITE_NAME;
$meta_description = 'Connexion administrateur.';

$error = $data['error'] ?? null;
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
        .container { max-width: 520px; margin: 8vh auto; padding: 0 18px; }
        .card { background: #fff; border: 1px solid #e6e8ee; border-radius: 10px; padding: 22px; box-shadow: 0 8px 24px rgba(0,0,0,0.06); }
        h1 { font-size: 1.4rem; margin: 0 0 16px; }
        label { display: block; font-weight: 600; margin: 12px 0 6px; }
        input { width: 100%; padding: 10px 12px; border: 1px solid #cfd6e4; border-radius: 8px; font-size: 1rem; }
        button { margin-top: 16px; width: 100%; padding: 10px 12px; border: 0; border-radius: 8px; background: #0066cc; color: #fff; font-weight: 700; font-size: 1rem; cursor: pointer; }
        button:hover { background: #0052a3; }
        .error { margin-top: 12px; padding: 10px 12px; border-radius: 8px; background: #ffecec; border: 1px solid #ffd0d0; color: #8a0f0f; }
        .back { display: inline-block; margin-top: 12px; color: #0066cc; text-decoration: none; }
    </style>
</head>
<body>
    <div class="container">
        <div class="card">
            <h1>Connexion administrateur</h1>
            <form method="post" action="<?php echo SITE_URL; ?>/admin/login" autocomplete="on">
                <label for="email">Email</label>
                <input id="email" name="email" type="email" required>

                <label for="password">Mot de passe</label>
                <input id="password" name="password" type="password" required>

                <button type="submit">Se connecter</button>
            </form>
            <?php if ($error): ?>
                <div class="error"><?php echo htmlspecialchars($error); ?></div>
            <?php endif; ?>

            <a class="back" href="<?php echo SITE_URL; ?>">Retour au site</a>
        </div>
    </div>
</body>
</html>
