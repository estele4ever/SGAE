FROM php:8.4-cli

# Dépendances système
RUN apt-get update && apt-get install -y \
    git unzip libpng-dev libjpeg-dev libfreetype6-dev \
    libzip-dev libpq-dev curl \
    libonig-dev libxml2-dev \
    zip nano gnupg \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install gd zip pdo pdo_mysql pdo_pgsql

# Installer Node.js + npm (version LTS recommandée)
RUN curl -fsSL https://deb.nodesource.com/setup_20.x | bash - && \
    apt-get install -y nodejs && \
    npm install -g npm

# Installer Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Définir le dossier de travail
WORKDIR /var/www

# Copier les fichiers (en excluant node_modules pour une meilleure performance)
COPY . .

# Installer les dépendances PHP et Node
RUN composer install --no-dev --optimize-autoloader && \
    npm install && \
    npm run build && \
    php artisan optimize:clear && \
    php artisan optimize

# Permissions
RUN chown -R www-data:www-data storage bootstrap/cache public/build && \
    chmod -R 775 storage bootstrap/cache public/build

# Créer le lien symbolique pour le stockage
RUN php artisan storage:link

# Port exposé
EXPOSE 8000

# Lancer le serveur Laravel
CMD php artisan serve --host=0.0.0.0 --port=8000