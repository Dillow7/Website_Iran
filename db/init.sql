-- Création des tables pour Iran News

-- Table des catégories
CREATE TABLE IF NOT EXISTS categories (
    id SERIAL PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    slug VARCHAR(255) NOT NULL UNIQUE,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Table des articles
CREATE TABLE IF NOT EXISTS articles (
    id SERIAL PRIMARY KEY,
    title VARCHAR(255) NOT NULL,
    meta_title VARCHAR(70),
    slug VARCHAR(255) NOT NULL UNIQUE,
    excerpt TEXT,
    content TEXT NOT NULL,
    meta_description VARCHAR(160),
    image VARCHAR(255),
    alt_image VARCHAR(125),
    category_id BIGINT REFERENCES categories(id) ON DELETE CASCADE,
    user_id BIGINT NOT NULL DEFAULT 1,
    published_at TIMESTAMP,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Compat: si la base existait avant l'ajout de meta_title
ALTER TABLE articles ADD COLUMN IF NOT EXISTS meta_title VARCHAR(70);

-- Table des utilisateurs
CREATE TABLE IF NOT EXISTS users (
    id SERIAL PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    email VARCHAR(255) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Index pour les performances
CREATE INDEX IF NOT EXISTS idx_articles_slug ON articles(slug);
CREATE INDEX IF NOT EXISTS idx_articles_category ON articles(category_id);
CREATE INDEX IF NOT EXISTS idx_articles_published ON articles(published_at);
CREATE INDEX IF NOT EXISTS idx_categories_slug ON categories(slug);

-- Insertion des données de base
INSERT INTO categories (name, slug) VALUES
    ('Politique', 'politique'),
    ('Militaire', 'militaire'),
    ('Diplomatie', 'diplomatie'),
    ('Economie', 'economie')
ON CONFLICT (slug) DO NOTHING;

INSERT INTO users (name, email, password) VALUES
    ('Admin', 'admin@irannews.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi')
ON CONFLICT (email) DO NOTHING;

INSERT INTO articles (title, meta_title, slug, excerpt, content, meta_description, image, alt_image, category_id, user_id, published_at, created_at, updated_at) VALUES
('Tensions militaires croissantes en Iran', 
 NULL,
 'tensions-militaires-iran',
 'Un aperçu des récentes tensions militaires qui secouent l''Iran et la région.',
 'Le pays fait face à une montée des tensions dans plusieurs zones stratégiques. Les forces armées sont en alerte maximale...',
 'Analyse des tensions militaires en Iran et de leurs conséquences régionales.',
 'iran-military.jpg',
 'Soldats iraniens en formation',
 2, 1, NOW(), NOW(), NOW()),

('Diplomatie internationale autour de l''Iran', 
 NULL,
 'diplomatie-internationale-iran',
 'L''Iran au centre des négociations diplomatiques mondiales.',
 'Les négociations avec les puissances internationales s''intensifient alors que les sanctions continuent de peser...',
 'Focus sur les efforts diplomatiques concernant l''Iran.',
 'iran-diplomatie.jpg',
 'Rencontre diplomatique avec l''Iran',
 3, 1, NOW(), NOW(), NOW()),

('Impact économique du conflit en Iran', 
 NULL,
 'impact-economique-conflit-iran',
 'Analyse des répercussions économiques du conflit iranien.',
 'Le conflit a des conséquences majeures sur l''économie locale et internationale...',
 'Conséquences économiques du conflit en Iran.',
 'iran-economy.jpg',
 'Graphique économique',
 4, 1, NOW(), NOW(), NOW())
ON CONFLICT (slug) DO NOTHING;
