FROM php:8.2-fpm

RUN apt-get update && apt-get install -y \
    git curl libpq-dev libpng-dev libonig-dev \
    zip unzip libzip-dev

RUN docker-php-ext-install pdo pdo_pgsql mbstring zip exif pcntl

COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

WORKDIR /var/www

COPY ./app .

RUN composer install --optimize-autoloader --no-dev

RUN chown -R www-data:www-data /var/www/storage /var/www/bootstrap/cache

EXPOSE 9000
CMD ["php-fpm"]
