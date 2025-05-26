FROM php:8.2-apache

# 1. Installer les dépendances
RUN apt-get update && apt-get install -y \
    git unzip libpng-dev libjpeg-dev libfreetype6-dev \
    libzip-dev libpq-dev libonig-dev \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install gd pdo pdo_mysql pdo_pgsql mbstring zip opcache

# 2. Installer Node.js
RUN curl -fsSL https://deb.nodesource.com/setup_20.x | bash - \
    && apt-get install -y nodejs \
    && npm install -g npm

# 3. Installer Composer
COPY --from=composer:2 /usr/bin/composer /usr/local/bin/composer

# 4. Configurer Apache
ENV APACHE_DOCUMENT_ROOT /var/www/html/public
RUN sed -ri -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/sites-available/*.conf \
    && sed -ri -e 's!/var/www/!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/apache2.conf /etc/apache2/conf-available/*.conf \
    && a2enmod rewrite

WORKDIR /var/www/html

# 5. Copier l'application
COPY . .

# 6. Installer les dépendances
RUN composer install --no-dev --optimize-autoloader --no-interaction \
    && npm install --omit=dev \
    && npm run build \
    && chown -R www-data:www-data storage bootstrap/cache \
    && chmod -R 775 storage bootstrap/cache

# 7. Migration (optionnel)
RUN if [ "$RENDER_MIGRATE_AND_SEED" = "true" ]; then \
      php artisan migrate:fresh --seed --force; \
    fi

# 8. Port et commande
EXPOSE 80
CMD ["apache2-foreground"]