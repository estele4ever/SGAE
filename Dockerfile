# Utilisez une image officielle PHP avec Apache
FROM php:8.2-apache

# Installer les dépendances système
RUN apt-get update && apt-get install -y \
    git \
    unzip \
    libpng-dev \
    libjpeg-dev \
    libfreetype6-dev \
    libzip-dev \
    libpq-dev \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install -j$(nproc) gd zip pdo pdo_mysql pdo_pgsql opcache

# Installer Composer
COPY --from=composer:2 /usr/bin/composer /usr/local/bin/composer

# Installer Node.js
RUN curl -fsSL https://deb.nodesource.com/setup_18.x | bash - \
    && apt-get install -y nodejs \
    && npm install -g npm

# Configurer Apache
COPY . /var/www/html/
RUN chown -R www-data:www-data /var/www/html/storage \
    && chmod -R 775 /var/www/html/storage \
    && a2enmod rewrite

# Installer les dépendances
RUN composer install --no-dev --optimize-autoloader --no-interaction \
    && npm install --omit=dev \
    && npm run build \
    && php artisan optimize:clear

# Configurer le virtualhost
COPY docker/apache.conf /etc/apache2/sites-available/000-default.conf

# Port exposé
EXPOSE 80

# Commande de démarrage
CMD ["apache2-foreground"]