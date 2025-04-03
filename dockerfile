FROM php:8.2-fpm

# Arguments définis dans docker-compose.yml
ARG user
ARG uid

# Installer les dépendances système
RUN apt-get update && apt-get install -y \
    git \
    curl \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    zip \
    unzip \
    libzip-dev \
    sqlite3 \
    libsqlite3-dev

# Nettoyer le cache
RUN apt-get clean && rm -rf /var/lib/apt/lists/*

# Installer les extensions PHP
RUN docker-php-ext-install pdo_sqlite mbstring exif pcntl bcmath gd zip

# Obtenir Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Créer un utilisateur système pour exécuter les commandes Composer et Artisan
RUN useradd -G www-data,root -u $uid -d /home/$user $user
RUN mkdir -p /home/$user/.composer && \
    chown -R $user:$user /home/$user

# Définir le répertoire de travail
WORKDIR /var/www

# Copier les fichiers d'autorisation personnalisés
COPY docker/php/custom.ini /usr/local/etc/php/conf.d/custom.ini

# Copier et rendre exécutable le script d'initialisation
COPY docker/init.sh /usr/local/bin/init-laravel
RUN chmod +x /usr/local/bin/init-laravel

USER $user

# Exposer le port 9000 pour PHP-FPM
EXPOSE 9000

CMD ["php-fpm"]