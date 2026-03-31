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
    <meta name="robots" content="noindex, nofollow">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Source+Sans+3:wght@400;600;700&display=swap" rel="stylesheet">
    <style>
        :root {
            --adm-blue: #003f8a;
            --adm-blue-hover: #00265c;
            --adm-gold: #c8a04a;
            --adm-red: #c0392b;
            --adm-red-lt: #fdf0ef;
            --adm-red-border: #f5c6c2;
            --adm-border: #dde3ee;
            --adm-border-2: #c8d0e0;
            --adm-text: #1a1d2e;
            --adm-text-mid: #4a5068;
            --adm-text-muted: #7a839a;
        }
        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }
        body {
            font-family: 'Source Sans 3', -apple-system, sans-serif;
            background: linear-gradient(135deg, var(--adm-blue) 0%, var(--adm-blue-hover) 100%);
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            padding: 24px;
            -webkit-font-smoothing: antialiased;
        }

        .login-card {
            background: #fff;
            border-radius: 10px;
            box-shadow: 0 20px 60px rgba(0,0,0,.25);
            width: 100%;
            max-width: 420px;
            overflow: hidden;
        }

        .login-header {
            background: var(--adm-blue);
            padding: 28px 32px;
            text-align: center;
            border-bottom: 3px solid var(--adm-gold);
        }

        .login-logo {
            display: inline-flex;
            align-items: center;
            gap: 10px;
            margin-bottom: 10px;
        }

        .login-logo-icon {
            width: 36px; height: 36px;
            background: var(--adm-gold);
            border-radius: 5px;
            display: flex; align-items: center; justify-content: center;
            font-weight: 700; font-size: 15px;
            color: var(--adm-blue-hover);
        }

        .login-logo-text {
            color: #fff;
            font-size: 1.25rem;
            font-weight: 700;
        }

        .login-badge {
            display: inline-block;
            background: rgba(255,255,255,.15);
            color: rgba(255,255,255,.8);
            font-size: 0.68rem;
            font-weight: 700;
            letter-spacing: .1em;
            text-transform: uppercase;
            padding: 3px 10px;
            border-radius: 20px;
        }

        .login-body { padding: 28px 32px 32px; }

        .login-title {
            font-size: 1rem;
            font-weight: 700;
            color: var(--adm-text);
            margin-bottom: 22px;
        }

        .field { margin-bottom: 18px; }

        label {
            display: block;
            font-size: 0.78rem;
            font-weight: 700;
            color: var(--adm-text-mid);
            letter-spacing: .04em;
            text-transform: uppercase;
            margin-bottom: 6px;
        }

        input {
            width: 100%;
            padding: 10px 13px;
            border: 1px solid var(--adm-border-2);
            border-radius: 6px;
            font-size: 0.95rem;
            font-family: inherit;
            color: var(--adm-text);
            outline: none;
            transition: border-color .2s, box-shadow .2s;
        }

        input:focus {
            border-color: var(--adm-blue);
            box-shadow: 0 0 0 3px rgba(0,63,138,.1);
        }

        .submit-btn {
            width: 100%;
            padding: 11px;
            background: var(--adm-blue);
            color: #fff;
            border: none;
            border-radius: 6px;
            font-size: 0.95rem;
            font-weight: 700;
            font-family: inherit;
            cursor: pointer;
            margin-top: 22px;
            letter-spacing: .02em;
            transition: background .2s;
        }

        .submit-btn:hover { background: var(--adm-blue-hover); }

        .error-box {
            margin-top: 16px;
            padding: 11px 14px;
            background: var(--adm-red-lt);
            border: 1px solid var(--adm-red-border);
            border-left: 4px solid var(--adm-red);
            border-radius: 6px;
            color: var(--adm-red);
            font-size: 0.88rem;
        }

        .login-footer {
            text-align: center;
            padding-top: 20px;
            border-top: 1px solid var(--adm-border);
            margin-top: 20px;
        }

        .login-footer a {
            color: var(--adm-text-muted);
            text-decoration: none;
            font-size: 0.85rem;
            transition: color .2s;
        }
        .login-footer a:hover { color: var(--adm-blue); }

        .site-link {
            color: rgba(255,255,255,.45);
            font-size: 0.78rem;
            margin-top: 20px;
            text-align: center;
        }

        .site-link a { color: rgba(255,255,255,.6); text-decoration: none; }
        .site-link a:hover { color: #fff; }
    </style>
</head>
<body>
    <div class="login-card">
        <div class="login-header">
            <div class="login-logo">
                <div class="login-logo-icon"><?php echo strtoupper(substr(SITE_NAME, 0, 1)); ?></div>
                <span class="login-logo-text"><?php echo htmlspecialchars(SITE_NAME); ?></span>
            </div>
            <br>
            <span class="login-badge">Administration</span>
        </div>

        <div class="login-body">
            <div class="login-title">Connexion à l'espace admin</div>

            <form method="post" action="<?php echo SITE_URL; ?>/admin/login" autocomplete="on">
                <div class="field">
                    <label for="email">Adresse e-mail</label>
                    <input id="email" name="email" type="email" autocomplete="email" required
                           placeholder="admin@exemple.com">
                </div>

                <div class="field">
                    <label for="password">Mot de passe</label>
                    <input id="password" name="password" type="password" autocomplete="current-password" required
                           placeholder="••••••••">
                </div>

                <button type="submit" class="submit-btn">Se connecter →</button>
            </form>

            <?php if ($error): ?>
                <div class="error-box" role="alert">
                    <?php echo htmlspecialchars($error); ?>
                </div>
            <?php endif; ?>

            <div class="login-footer">
                <a href="<?php echo SITE_URL; ?>">← Retour au site</a>
            </div>
        </div>
    </div>

    <p class="site-link">
        <a href="<?php echo SITE_URL; ?>"><?php echo htmlspecialchars(SITE_NAME); ?></a>
        &nbsp;—&nbsp;Accès réservé aux administrateurs
    </p>
</body>
</html>