FROM php:8.4-cli

# Étape 1: Installer les dépendances système
RUN apt-get update && apt-get install -y \
    git \
    unzip \
    libpng-dev \
    libjpeg-dev \
    libfreetype6-dev \
    libzip-dev \
    libpq-dev \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install gd zip pdo pdo_mysql pdo_pgsql


# Étape 2: Installer Node.js et npm
RUN curl -fsSL https://deb.nodesource.com/setup_20.x | bash - \
    && apt-get install -y nodejs \
    && npm install -g npm


# Étape 3: Installer Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer



WORKDIR /var/www

# Étape 4: Copier les fichiers
COPY . .

# Étape 5: Installer les dépendances
RUN composer install --no-dev --optimize-autoloader --no-interaction \
    && npm install --omit=dev \  # Changement de --production à --omit=dev
    && npm install vite \  # Installation explicite de Vite
    && npm run build \
    && apt-get clean \
    && rm -rf /var/lib/apt/lists/* /tmp/* /var/tmp/*

# Étape 6: Configurer les permissions
RUN chown -R www-data:www-data storage bootstrap/cache \
    && chmod -R 775 storage bootstrap/cache

RUN if [ "$RENDER_MIGRATE_AND_SEED" = "true" ]; then \
      php artisan migrate:fresh --seed --force; \
    fi

EXPOSE 8000

CMD ["php", "artisan", "serve", "--host=0.0.0.0", "--port=8000"]