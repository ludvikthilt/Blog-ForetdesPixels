FROM php:8.2-fpm

# Arguments définis dans docker-compose.yml
ARG user
ARG uid

# Installation des dépendances système
RUN apt-get update && apt-get install -y \
    git \
    curl \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    libzip-dev \
    zip \
    unzip \
    nodejs \
    npm \
    libsqlite3-dev \
    && rm -rf /var/lib/apt/lists/*

# Installation des extensions PHP
RUN docker-php-ext-install mbstring exif pcntl bcmath gd zip
RUN docker-php-ext-install pdo_sqlite

# Installation de Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Création du répertoire de l'application
WORKDIR /var/www

# Création d'un utilisateur système pour exécuter les commandes Composer et Artisan
RUN useradd -G www-data,root -u $uid -d /home/$user $user
RUN mkdir -p /home/$user/.composer && \
    chown -R $user:$user /home/$user

# Copier les fichiers de configuration personnalisés, si nécessaire
COPY docker/php/local.ini /usr/local/etc/php/conf.d/local.ini

# Copier le répertoire du projet
COPY . /var/www

# Définir le propriétaire du répertoire
RUN chown -R $user:$user /var/www

# Exécuter Composer Install avec les bonnes permissions
USER $user
RUN composer install --no-interaction --no-scripts

# Nettoyer le cache et optimiser
RUN php artisan optimize:clear
RUN php artisan cache:clear
RUN php artisan config:clear

# Exposer le port 9000 pour PHP-FPM
EXPOSE 9000

# Démarrer PHP-FPM
CMD ["php-fpm"]
