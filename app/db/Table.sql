-- ============================================
-- Base de données : iran_news
-- PostgreSQL 15
-- ============================================

-- Table users (générée par Laravel Breeze)
CREATE TABLE users (
    id         BIGSERIAL PRIMARY KEY,
    name       VARCHAR(255)        NOT NULL,
    email      VARCHAR(255) UNIQUE NOT NULL,
    password   VARCHAR(255)        NOT NULL,
    created_at TIMESTAMP,
    updated_at TIMESTAMP
);

-- Table categories
CREATE TABLE categories (
    id         BIGSERIAL PRIMARY KEY,
    name       VARCHAR(255)        NOT NULL,
    slug       VARCHAR(255) UNIQUE NOT NULL,  -- SEO : URL lisible
    created_at TIMESTAMP,
    updated_at TIMESTAMP
);

-- Table articles
CREATE TABLE articles (
    id               BIGSERIAL PRIMARY KEY,
    title            VARCHAR(60)  NOT NULL,          -- SEO : 50-60 car.
    slug             VARCHAR(255) UNIQUE NOT NULL,   -- SEO : URL rewriting
    excerpt          TEXT,                            -- intro courte
    content          TEXT         NOT NULL,
    meta_description VARCHAR(160),                   -- SEO : balise meta
    image            VARCHAR(255),
    alt_image        VARCHAR(125),                   -- SEO : attribut alt
    category_id      BIGINT NOT NULL REFERENCES categories(id) ON DELETE CASCADE,
    user_id          BIGINT NOT NULL REFERENCES users(id)      ON DELETE CASCADE,
    published_at     TIMESTAMP,                      -- NULL = brouillon
    created_at       TIMESTAMP,
    updated_at       TIMESTAMP
);





-- Index SEO & performances
CREATE INDEX idx_articles_slug        ON articles (slug);
CREATE INDEX idx_articles_category    ON articles (category_id);
CREATE INDEX idx_articles_published   ON articles (published_at);
CREATE INDEX idx_categories_slug      ON categories (slug);

-- ============================================
-- Données initiales
-- ============================================

INSERT INTO users (name, email, password, created_at, updated_at)
VALUES (
    'Admin',
    'admin@admin.com',
    '$2y$12$HASH_BCRYPT_ICI',   -- généré par Laravel : bcrypt('password')
    NOW(), NOW()
);

INSERT INTO categories (name, slug, created_at, updated_at) VALUES
    ('Politique',   'politique',   NOW(), NOW()),
    ('Militaire',   'militaire',   NOW(), NOW()),
    ('Diplomatie',  'diplomatie',  NOW(), NOW()),
    ('Economie',    'economie',    NOW(), NOW());