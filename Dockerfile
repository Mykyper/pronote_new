# Étape 1 : image PHP avec Apache
FROM php:8.2-apache

# Étape 2 : dépendances
RUN apt-get update && apt-get install -y \
    git unzip libzip-dev zip \
    && docker-php-ext-install pdo pdo_mysql zip

# Étape 3 : activer mod_rewrite
RUN a2enmod rewrite

# Étape 4 : définir la config Apache
RUN echo '<VirtualHost *:80>\n\
    DocumentRoot /var/www/html/public\n\
    <Directory /var/www/html/public>\n\
        AllowOverride All\n\
        Require all granted\n\
    </Directory>\n\
</VirtualHost>' > /etc/apache2/sites-available/000-default.conf

# Étape 5 : copier les fichiers du projet
COPY . /var/www/html
WORKDIR /var/www/html

# Étape 6 : installer composer
COPY --from=composer:2.6 /usr/bin/composer /usr/bin/composer
RUN composer install --no-dev --optimize-autoloader

# Étape 7 : donner les permissions
RUN chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache

# Étape 8 : exposer le port
EXPOSE 80

# Étape 9 : lancer Apache
CMD ["apache2-foreground"]
