FROM php:8.2-fpm

RUN apt-get update && apt-get install -y \
    curl \
    zip unzip \
    git \
    libzip-dev \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    && docker-php-ext-install pdo_mysql zip

COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

WORKDIR /var/www/html

# Copy all app files including vite.config.js and resources before building assets
COPY . .

# Install Node.js and npm
RUN curl -fsSL https://deb.nodesource.com/setup_18.x | bash - && apt-get install -y nodejs

# Install npm dependencies and build assets
RUN npm install
RUN npm run build

# Fix permissions for storage and cache
RUN chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache \
    && chmod -R 775 /var/www/html/storage /var/www/html/bootstrap/cache

# Install PHP dependencies
RUN composer install --no-dev --optimize-autoloader

RUN php artisan config:clear && \
    php artisan route:clear && \
    php artisan cache:clear && \
    php artisan view:clear && \
    php artisan optimize && \
    composer dump-autoload



RUN php artisan storage:link

EXPOSE 8000

CMD ["php", "artisan", "serve", "--host=0.0.0.0", "--port=8000"]
