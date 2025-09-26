# Étape 1 : Image PHP avec extensions nécessaires
FROM php:8.2-fpm

# Installer dépendances système et extensions PHP
RUN apt-get update && apt-get install -y \
    git unzip libzip-dev zip libpng-dev libonig-dev \
    && docker-php-ext-install pdo_mysql mbstring zip exif pcntl bcmath

# Installer Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Définir le répertoire de travail
WORKDIR /var/www/html

# Copier uniquement composer.json et composer.lock pour optimiser le cache Docker
COPY composer.json composer.lock ./

# Installer les dépendances PHP
RUN composer install --no-dev --optimize-autoloader

# Copier le reste du projet
COPY . .

# Permissions
RUN chown -R www-data:www-data storage bootstrap/cache \
    && chmod -R 775 storage bootstrap/cache

# Exposer le port que Render utilisera
EXPOSE 10000

# Commande pour démarrer Laravel avec PHP-FPM
CMD ["php-fpm"]
