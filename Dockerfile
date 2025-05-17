FROM php:8.4-cli

# Dépendances système
RUN apt-get update && apt-get install -y \
    libpng-dev libjpeg-dev libfreetype6-dev zlib1g-dev git unzip curl libzip-dev \
    && docker-php-ext-install zip pdo pdo_mysql gd

# Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Node.js + npm
RUN curl -fsSL https://deb.nodesource.com/setup_18.x | bash - && \
    apt-get install -y nodejs

WORKDIR /var/www

# Copie les fichiers
COPY . .

# Installe les dépendances
RUN composer install --no-dev --optimize-autoloader \
    && npm install && npm run build

# Génère une clé si elle n'existe pas
RUN php artisan key:generate || true

# Expose le port 8000 (utilisé par artisan serve)
EXPOSE 8000

# Commande de démarrage
CMD ["php", "artisan", "serve", "--host=0.0.0.0", "--port=8000"]
