FROM php:8.4-fpm

RUN apt-get update && apt-get install -y \
    git curl libpq-dev libpng-dev libonig-dev \
    zip unzip libzip-dev

RUN docker-php-ext-install pdo pdo_pgsql mbstring zip exif pcntl

# Install Node.js and npm
RUN curl -fsSL https://deb.nodesource.com/setup_20.x | bash - \
    && apt-get install -y nodejs

COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

WORKDIR /var/www

COPY ./app .

RUN composer install --optimize-autoloader --no-dev

RUN chown -R www-data:www-data /var/www/storage /var/www/bootstrap/cache

# Create proper temp directory and set permissions
RUN mkdir -p /var/www/tmp && chmod 777 /var/www/tmp

# Ensure PHP uses a writable temp dir for uploads (avoid volume permission issues)
RUN mkdir -p /tmp \
     && chmod 1777 /tmp \
     && { \
         echo 'sys_temp_dir=/tmp'; \
         echo 'upload_tmp_dir=/tmp'; \
       } > /usr/local/etc/php/conf.d/99-temp.ini

# Set temp directory for PHP
ENV TMPDIR=/tmp

EXPOSE 9000
CMD ["php-fpm"]
