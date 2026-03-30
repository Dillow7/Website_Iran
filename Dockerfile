FROM php:8.2-apache

# Installer les extensions PHP nécessaires
RUN apt-get update && apt-get install -y \
    libpq-dev \
    && docker-php-ext-install pdo_pgsql pdo

# Activer les modules Apache nécessaires
RUN a2enmod rewrite

# Créer une configuration Apache simple
RUN printf '<VirtualHost *:80>\n    ServerName localhost\n    DocumentRoot /var/www\n    <Directory /var/www>\n        AllowOverride All\n        Require all granted\n    </Directory>\n</VirtualHost>' > /etc/apache2/sites-available/000-default.conf

# Définir le répertoire de travail
WORKDIR /var/www

# Copier les fichiers de l'application
COPY . .

# Donner les permissions à Apache
RUN chown -R www-data:www-data /var/www

# Exposer le port 80
EXPOSE 80

# Démarrer Apache
CMD ["apache2-foreground"]
