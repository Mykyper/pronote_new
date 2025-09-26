# Étape 1 : choisir une image PHP avec les extensions nécessaires
FROM php:8.2-apache

# Étape 2 : installer les dépendances système
RUN apt-get update && apt-get install -y \
    git \
    unzip \
    libzip-dev \
    zip \
    && docker-php-ext-install pdo pdo_mysql zip

# Étape 3 : activer le module Apache pour Laravel
RUN a2enmod rewrite

# Étape 4 : copier les fichiers du projet dans le conteneur
COPY . /var/www/html

# Étape 5 : définir le dossier de travail
WORKDIR /var/www/html

# Étape 6 : installer Composer
COPY --from=composer:2.6 /usr/bin/composer /usr/bin/composer
RUN composer install --no-dev --optimize-autoloader

# Étape 7 : donner les bons droits
RUN chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache

# Étape 8 : exposer le port 80
EXPOSE 80

# Étape 9 : lancer Apache
CMD ["apache2-foreground"]
