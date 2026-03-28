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

    -- ============================================
-- Insertion d'articles
-- ============================================

-- Supposons que user_id = 1 existe
INSERT INTO articles (title, slug, excerpt, content, meta_description, image, alt_image, category_id, user_id, published_at, created_at, updated_at) VALUES
('Tensions militaires croissantes en Iran', 
 'tensions-militaires-iran', 
 'Un aperçu des récentes tensions militaires qui secouent l’Iran et la région.', 
 'Le pays fait face à une montée des tensions dans plusieurs zones stratégiques. Les forces armées sont en alerte maximale...', 
 'Analyse des tensions militaires en Iran et de leurs conséquences régionales.', 
 'iran-military.jpg', 
 'Soldats iraniens en formation', 
 2,  -- Militaire
 1,  -- User
 NOW(), NOW(), NOW()
),
('Diplomatie internationale autour de l’Iran', 
 'diplomatie-internationale-iran', 
 'L’Iran au centre des négociations diplomatiques mondiales.', 
 'Les négociations avec les puissances internationales s’intensifient alors que les sanctions continuent de peser...', 
 'Focus sur les efforts diplomatiques concernant l’Iran.', 
 'iran-diplomatie.jpg', 
 'Rencontre diplomatique avec l’Iran', 
 3,  -- Diplomatie
 1, 
 NOW(), NOW(), NOW()
),
('Impact économique du conflit en Iran', 
 'impact-economique-conflit-iran', 
 'Comment la guerre affecte l’économie iranienne et le marché régional.', 
 'L’économie iranienne subit de plein fouet les conséquences des tensions militaires et des sanctions internationales...', 
 'Analyse de l’impact économique du conflit en Iran.', 
 'iran-economie.jpg', 
 'Graphique économique Iran', 
 4,  -- Economie
 1, 
 NOW(), NOW(), NOW()
),
('Répercussions politiques de la guerre en Iran', 
 'repercussions-politiques-guerre-iran', 
 'Les enjeux politiques internes et internationaux face au conflit.', 
 'Le conflit en Iran provoque des débats intenses au sein du gouvernement et des partis politiques, tout en influençant les relations avec les pays voisins...', 
 'Analyse des impacts politiques de la guerre en Iran.', 
 'iran-politics.jpg', 
 'Parlement iranien en session', 
 1,  -- Politique
 1, 
 NOW(), NOW(), NOW()
);