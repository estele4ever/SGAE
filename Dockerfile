FROM php:8.4-cli


# Dépendances système
RUN apt-get update && apt-get install -y \
    git unzip libpng-dev libjpeg-dev libfreetype6-dev \
    libzip-dev libpq-dev curl \
    libonig-dev libxml2-dev \
    zip nano gnupg \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install gd zip pdo pdo_mysql pdo_pgsql

# Installer Node.js + npm
RUN curl -fsSL https://deb.nodesource.com/setup_20.x | bash - && \
    apt-get install -y nodejs && \
    npm install -g npm

# Installer Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Définir le dossier de travail
WORKDIR /var/www

# Copier les fichiers
COPY . .

# Installer les dépendances Laravel et builder Vite
RUN composer install --no-dev --optimize-autoloader && \
    npm install && \
    npm run build

# Permissions
RUN chown -R www-data:www-data storage bootstrap/cache && \
    chmod -R 775 storage bootstrap/cache


RUN php artisan storage:link 
# Port exposé
EXPOSE 8000

# Lancer migration + seeder + serveur Laravel
CMD php artisan migrate --seed && \
php artisan serve --host=0.0.0.0 --port=8000
