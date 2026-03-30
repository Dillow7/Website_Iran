<?php

require_once __DIR__ . '/../models/ArticleModel.php';
require_once __DIR__ . '/../models/CategoryModel.php';

class AdminArticleController {
    private $articleModel;
    private $categoryModel;

    public function __construct() {
        $this->articleModel = new ArticleModel();
        $this->categoryModel = new CategoryModel();
    }

    private function requireAuth() {
        if (!isset($_SESSION['admin_user_id'])) {
            header('Location: ' . SITE_URL . '/admin/login');
            exit;
        }
    }

    private function downloadImageFromUrl($url, $alt = '') {
        if (empty($url)) return '';
        
        // Validation de l'URL
        if (!filter_var($url, FILTER_VALIDATE_URL)) {
            return false;
        }
        
        // Téléchargement avec cURL
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
        curl_setopt($ch, CURLOPT_MAXREDIRS, 3);
        curl_setopt($ch, CURLOPT_TIMEOUT, 30);
        curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (compatible; IranNews/1.0)');
        
        $imageData = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);
        
        if ($httpCode !== 200 || !$imageData) {
            return false;
        }
        
        // Vérifier que c'est bien une image
        $finfo = finfo_open(FILEINFO_MIME_TYPE);
        $mimeType = finfo_buffer($finfo, $imageData);
        finfo_close($finfo);
        
        if (!in_array($mimeType, ['image/jpeg', 'image/png', 'image/gif', 'image/webp'])) {
            return false;
        }
        
        // Déterminer l'extension
        $extension = '';
        switch ($mimeType) {
            case 'image/jpeg': $extension = 'jpg'; break;
            case 'image/png': $extension = 'png'; break;
            case 'image/gif': $extension = 'gif'; break;
            case 'image/webp': $extension = 'webp'; break;
        }
        
        // Générer un nom de fichier unique
        $filename = uniqid('img_', true) . '.' . $extension;
        $dir = __DIR__ . '/../img/';
        if (!is_dir($dir)) {
            @mkdir($dir, 0775, true);
        }
        $filepath = $dir . $filename;
        
        // Sauvegarder
        if (file_put_contents($filepath, $imageData) === false) {
            return false;
        }
        
        return $filename;
    }

    private function uploadImageFromFile(array $file) {
        if (empty($file) || !isset($file['error'])) {
            return false;
        }

        if ($file['error'] === UPLOAD_ERR_NO_FILE) {
            return '';
        }

        if ($file['error'] !== UPLOAD_ERR_OK) {
            return false;
        }

        if (empty($file['tmp_name']) || !is_uploaded_file($file['tmp_name'])) {
            return false;
        }

        $maxBytes = 5 * 1024 * 1024;
        if (!empty($file['size']) && (int)$file['size'] > $maxBytes) {
            return false;
        }

        $finfo = finfo_open(FILEINFO_MIME_TYPE);
        $mimeType = finfo_file($finfo, $file['tmp_name']);
        finfo_close($finfo);

        $allowed = [
            'image/jpeg' => 'jpg',
            'image/png' => 'png',
            'image/gif' => 'gif',
            'image/webp' => 'webp',
        ];

        if (!isset($allowed[$mimeType])) {
            return false;
        }

        $extension = $allowed[$mimeType];
        $filename = uniqid('img_', true) . '.' . $extension;
        $dir = __DIR__ . '/../img/';
        if (!is_dir($dir)) {
            @mkdir($dir, 0775, true);
        }
        $filepath = $dir . $filename;

        if (!move_uploaded_file($file['tmp_name'], $filepath)) {
            return false;
        }

        return $filename;
    }

    private function slugify($value) {
        $value = trim((string)$value);
        $value = mb_strtolower($value, 'UTF-8');
        $value = iconv('UTF-8', 'ASCII//TRANSLIT//IGNORE', $value);
        $value = preg_replace('/[^a-z0-9]+/i', '-', $value);
        $value = trim($value, '-');
        return $value === '' ? 'article' : $value;
    }

    private function sanitizeTinyMceHtml($html) {
        $html = (string)$html;
        $html = preg_replace('/<\/?script\b[^>]*>/i', '', $html);
        $html = preg_replace('/\son\w+\s*=\s*("[^"]*"|\'[^\']*\'|[^\s>]+)/i', '', $html);

        $html = preg_replace_callback('/<\s*h1\b([^>]*)>(.*?)<\s*\/\s*h1\s*>/is', function ($m) {
            return '<h2' . $m[1] . '>' . $m[2] . '</h2>';
        }, $html);

        return $html;
    }

    private function contentHasMissingImageAlt($html) {
        $html = (string)$html;

        if (stripos($html, '<img') === false) {
            return false;
        }

        libxml_use_internal_errors(true);
        $dom = new DOMDocument();
        $dom->loadHTML('<?xml encoding="utf-8" ?>' . $html, LIBXML_HTML_NOIMPLIED | LIBXML_HTML_NODEFDTD);
        $imgs = $dom->getElementsByTagName('img');
        foreach ($imgs as $img) {
            $alt = $img->getAttribute('alt');
            if (trim((string)$alt) === '') {
                return true;
            }
        }
        return false;
    }

    public function index() {
        $this->requireAuth();

        $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
        $per_page = 20;
        $offset = ($page - 1) * $per_page;

        $articles = $this->articleModel->getAll($per_page, $offset);

        return [
            'articles' => $articles,
            'pagination' => [
                'current_page' => $page,
                'per_page' => $per_page,
            ],
        ];
    }

    public function create() {
        $this->requireAuth();

        $categories = $this->categoryModel->getAll();
        $errors = [];

        $values = [
            'title' => '',
            'meta_title' => '',
            'slug' => '',
            'excerpt' => '',
            'meta_description' => '',
            'content' => '',
            'image' => '',
            'alt_image' => '',
            'category_id' => '',
            'published_at' => '',
        ];

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            foreach ($values as $k => $_) {
                $values[$k] = trim((string)($_POST[$k] ?? ''));
            }

            $values['slug'] = $this->slugify($values['slug'] !== '' ? $values['slug'] : $values['title']);
            $values['content'] = $this->sanitizeTinyMceHtml($_POST['content'] ?? '');

            if ($values['title'] === '') {
                $errors['title'] = 'Le titre est obligatoire.';
            }

            if ($values['slug'] === '') {
                $errors['slug'] = 'Le slug est obligatoire.';
            } elseif ($this->articleModel->slugExists($values['slug'])) {
                $errors['slug'] = 'Ce slug existe déjà.';
            }

            if ($values['meta_description'] !== '' && mb_strlen($values['meta_description']) > 160) {
                $errors['meta_description'] = 'La meta description doit faire 160 caractères maximum.';
            }

            if ($values['content'] === '' || trim(strip_tags($values['content'])) === '') {
                $errors['content'] = 'Le contenu est obligatoire.';
            } elseif ($this->contentHasMissingImageAlt($values['content'])) {
                $errors['content'] = 'Toutes les images dans le contenu doivent avoir un alt non vide.';
            }

            if ($values['category_id'] === '' || !ctype_digit($values['category_id'])) {
                $errors['category_id'] = 'La catégorie est obligatoire.';
            }

            $hasUpload = isset($_FILES['image_file']) && ($_FILES['image_file']['error'] ?? UPLOAD_ERR_NO_FILE) !== UPLOAD_ERR_NO_FILE;
            if ($hasUpload && $values['alt_image'] === '') {
                $errors['alt_image'] = 'Le alt de l\'image principale est obligatoire.';
            }

            $publishedAt = null;
            if ($values['published_at'] !== '') {
                $publishedAt = $values['published_at'];
            }

            if (!$errors) {
                if (isset($_FILES['image_file'])) {
                    $uploaded = $this->uploadImageFromFile($_FILES['image_file']);
                    if ($uploaded === false) {
                        $errors['image_file'] = 'Upload impossible. Formats acceptés: jpg, png, gif, webp (max 5MB).';
                    } elseif ($uploaded !== '') {
                        $values['image'] = $uploaded;
                    }
                }
            }

            if (!$errors) {
                $payload = [
                    'title' => $values['title'],
                    'meta_title' => $values['meta_title'] !== '' ? $values['meta_title'] : null,
                    'slug' => $values['slug'],
                    'excerpt' => $values['excerpt'] !== '' ? $values['excerpt'] : null,
                    'content' => $values['content'],
                    'meta_description' => $values['meta_description'] !== '' ? $values['meta_description'] : null,
                    'image' => $values['image'] !== '' ? $values['image'] : null,
                    'alt_image' => $values['alt_image'] !== '' ? $values['alt_image'] : null,
                    'category_id' => (int)$values['category_id'],
                    'user_id' => (int)($_SESSION['admin_user_id'] ?? 1),
                    'published_at' => $publishedAt,
                ];

                $id = $this->articleModel->create($payload);
                header('Location: ' . SITE_URL . '/admin/articles/edit/' . $id);
                exit;
            }
        }

        return [
            'categories' => $categories,
            'errors' => $errors,
            'values' => $values,
        ];
    }

    public function edit($id) {
        $this->requireAuth();

        $id = (int)$id;
        $article = $this->articleModel->getById($id);
        if (!$article) {
            return null;
        }

        $categories = $this->categoryModel->getAll();
        $errors = [];

        $values = [
            'title' => (string)($article['title'] ?? ''),
            'meta_title' => (string)($article['meta_title'] ?? ''),
            'slug' => (string)($article['slug'] ?? ''),
            'excerpt' => (string)($article['excerpt'] ?? ''),
            'meta_description' => (string)($article['meta_description'] ?? ''),
            'content' => (string)($article['content'] ?? ''),
            'image' => (string)($article['image'] ?? ''),
            'alt_image' => (string)($article['alt_image'] ?? ''),
            'category_id' => (string)($article['category_id'] ?? ''),
            'published_at' => $article['published_at'] ? date('Y-m-d\TH:i', strtotime($article['published_at'])) : '',
        ];

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            foreach ($values as $k => $_) {
                $values[$k] = trim((string)($_POST[$k] ?? ''));
            }

            $values['slug'] = $this->slugify($values['slug'] !== '' ? $values['slug'] : $values['title']);
            $values['content'] = $this->sanitizeTinyMceHtml($_POST['content'] ?? '');

            if ($values['title'] === '') {
                $errors['title'] = 'Le titre est obligatoire.';
            }

            if ($values['slug'] === '') {
                $errors['slug'] = 'Le slug est obligatoire.';
            } elseif ($this->articleModel->slugExists($values['slug'], $id)) {
                $errors['slug'] = 'Ce slug existe déjà.';
            }

            if ($values['meta_description'] !== '' && mb_strlen($values['meta_description']) > 160) {
                $errors['meta_description'] = 'La meta description doit faire 160 caractères maximum.';
            }

            if ($values['content'] === '' || trim(strip_tags($values['content'])) === '') {
                $errors['content'] = 'Le contenu est obligatoire.';
            } elseif ($this->contentHasMissingImageAlt($values['content'])) {
                $errors['content'] = 'Toutes les images dans le contenu doivent avoir un alt non vide.';
            }

            if ($values['category_id'] === '' || !ctype_digit($values['category_id'])) {
                $errors['category_id'] = 'La catégorie est obligatoire.';
            }

            // Image principale: uniquement upload fichier (si aucun upload, on garde l'image existante)
            $hasUpload = isset($_FILES['image_file']) && ($_FILES['image_file']['error'] ?? UPLOAD_ERR_NO_FILE) !== UPLOAD_ERR_NO_FILE;
            $hasExistingImage = ($article['image'] ?? '') !== '';
            if (($hasUpload || $hasExistingImage) && $values['alt_image'] === '') {
                $errors['alt_image'] = 'Le alt de l\'image principale est obligatoire.';
            }

            if (!$errors) {
                if (isset($_FILES['image_file'])) {
                    $uploaded = $this->uploadImageFromFile($_FILES['image_file']);
                    if ($uploaded === false) {
                        $errors['image_file'] = 'Upload impossible. Formats acceptés: jpg, png, gif, webp (max 5MB).';
                    } elseif ($uploaded !== '') {
                        $values['image'] = $uploaded;
                    } else {
                        $values['image'] = (string)($article['image'] ?? '');
                    }
                }
            }

            if (!$errors && !$hasUpload) {
                $values['image'] = (string)($article['image'] ?? '');
            }

            $publishedAt = null;
            if ($values['published_at'] !== '') {
                $publishedAt = $values['published_at'];
            }

            if (!$errors) {
                $payload = [
                    'title' => $values['title'],
                    'meta_title' => $values['meta_title'] !== '' ? $values['meta_title'] : null,
                    'slug' => $values['slug'],
                    'excerpt' => $values['excerpt'] !== '' ? $values['excerpt'] : null,
                    'content' => $values['content'],
                    'meta_description' => $values['meta_description'] !== '' ? $values['meta_description'] : null,
                    'image' => $values['image'] !== '' ? $values['image'] : null,
                    'alt_image' => $values['alt_image'] !== '' ? $values['alt_image'] : null,
                    'category_id' => (int)$values['category_id'],
                    'published_at' => $publishedAt,
                ];

                $this->articleModel->update($id, $payload);
                header('Location: ' . SITE_URL . '/admin/articles/edit/' . $id);
                exit;
            }
        }

        return [
            'article' => $article,
            'categories' => $categories,
            'errors' => $errors,
            'values' => $values,
        ];
    }

    public function delete($id) {
        $this->requireAuth();

        $id = (int)$id;
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $this->articleModel->delete($id);
            header('Location: ' . SITE_URL . '/admin/articles');
            exit;
        }

        header('Location: ' . SITE_URL . '/admin/articles');
        exit;
    }
}

?>
