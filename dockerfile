# Use official PHP image with necessary extensions
FROM php:8.1-fpm

# Set the working directory
WORKDIR /var/www

# Install system dependencies
RUN apt-get update && apt-get install -y \
    git \
    unzip \
    curl \
    libpng-dev \
    libpq-dev \
    && docker-php-ext-install pdo pdo_mysql gd

# Install Composer
COPY --from=composer:2.2 /usr/bin/composer /usr/bin/composer

# Copy Laravel app files
COPY . .

# Install Laravel dependencies
RUN composer install --no-dev --optimize-autoloader

# Set permissions
RUN chmod -R 777 storage bootstrap/cache

# Expose the PHP-FPM port
EXPOSE 9000

CMD ["php-fpm"]
