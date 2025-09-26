# Utiliser une image officielle PHP avec Apache
FROM php:8.2-apache

# Activer mod_rewrite pour Laravel
RUN a2enmod rewrite

# Définir le répertoire de travail
WORKDIR /var/www/html

# Copier le projet dans le conteneur
COPY . .

# Installer Composer
RUN apt-get update && apt-get install -y unzip git \
    && curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Installer les dépendances
RUN composer install --no-dev --optimize-autoloader

# Définir les permissions nécessaires
RUN chmod -R 775 storage bootstrap/cache

# Configurer Apache pour pointer vers le dossier public
RUN echo "<VirtualHost *:80>\n\
    DocumentRoot /var/www/html/public\n\
    <Directory /var/www/html/public>\n\
        AllowOverride All\n\
        Require all granted\n\
    </Directory>\n\
</VirtualHost>" > /etc/apache2/sites-available/000-default.conf

# Exposer le port 80
EXPOSE 80

# Lancer Apache
CMD ["apache2-foreground"]
