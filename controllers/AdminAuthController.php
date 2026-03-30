<?php

require_once __DIR__ . '/../config/database.php';

class AdminAuthController {
    private $pdo;

    public function __construct() {
        $this->pdo = Database::getConnection();
    }

    public function login() {
        if (isset($_SESSION['admin_user_id'])) {
            header('Location: ' . SITE_URL . '/admin/articles');
            exit;
        }

        $error = null;

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $email = trim($_POST['email'] ?? '');
            $password = (string)($_POST['password'] ?? '');

            if ($email === '' || $password === '') {
                $error = 'Email et mot de passe requis.';
            } else {
                $stmt = $this->pdo->prepare('SELECT id, email, password, name FROM users WHERE email = :email LIMIT 1');
                $stmt->execute(['email' => $email]);
                $user = $stmt->fetch();

                if (!$user || !password_verify($password, $user['password'])) {
                    $error = 'Identifiants invalides.';
                } else {
                    $_SESSION['admin_user_id'] = (int)$user['id'];
                    $_SESSION['admin_user_name'] = (string)($user['name'] ?? 'Admin');
                    header('Location: ' . SITE_URL . '/admin/articles');
                    exit;
                }
            }
        }

        return [
            'error' => $error,
        ];
    }

    public function logout() {
        unset($_SESSION['admin_user_id']);
        unset($_SESSION['admin_user_name']);
        header('Location: ' . SITE_URL . '/admin/login');
        exit;
    }
}

?>
