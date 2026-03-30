# Docker pour Architecture PHP Pur

## 🐳 Configuration Docker complète

### Services:

1. **app**: Container PHP + Apache pour l'application
2. **db**: Container PostgreSQL pour la base de données

## 🚀 Lancement

```bash
# Démarrer les containers
docker-compose up -d

# Voir les logs
docker-compose logs -f

# Arrêter les containers
docker-compose down
```

## 🔧 Configuration

### Base de données:
- **Hôte**: `db` (nom du service)
- **Port**: `5432`
- **Base**: `iran_news`
- **Utilisateur**: `root`
- **Mot de passe**: `root`

### Application:
- **URL**: `http://localhost:8085`
- **Volume**: Montage du code local
- **Rewriting**: Activé via Apache

## 📁 Fichiers Docker

### docker-compose.yml:
```yaml
version: '3.8'
services:
  app:
    build: .
    ports:
      - "8085:80"
    volumes:
      - .:/var/www
    depends_on:
      - db
  
  db:
    image: postgres:15-alpine
    environment:
      POSTGRES_DB: iran_news
      POSTGRES_USER: root
      POSTGRES_PASSWORD: root
```

### Dockerfile:
```dockerfile
FROM php:8.2-apache
RUN apt-get update && apt-get install -y libpq-dev
RUN docker-php-ext-install pdo_pgsql pdo
RUN a2enmod rewrite
COPY .docker/apache.conf /etc/apache2/sites-available/000-default.conf
WORKDIR /var/www
COPY . .
RUN chown -R www-data:www-data /var/www
EXPOSE 80
CMD ["apache2-foreground"]
```

### .docker/apache.conf:
```apache
<VirtualHost *:80>
    ServerName localhost
    DocumentRoot /var/www
    RewriteEngine On
    RewriteCond %{REQUEST_FILENAME} !-f
    RewriteCond %{REQUEST_FILENAME} !-d
    RewriteRule ^(.*)$ index.php [QSA,L]
</VirtualHost>
```

## 🎯 Avantages

### ✅ PHP Pur:
- **Léger**: Pas de framework
- **Performance**: Directement sur Apache
- **Contrôle**: Configuration manuelle

### ✅ Docker:
- **Isolation**: Environnement propre
- **Reproductibilité**: Identique partout
- **Déploiement**: Simple et rapide

## 🚀 Utilisation

1. **Lancer**: `docker-compose up -d`
2. **Accéder**: `http://localhost:8085`
3. **Développer**: Code local synchronisé
4. **Logs**: `docker-compose logs -f app`

L'application PHP pur fonctionne parfaitement dans Docker !
