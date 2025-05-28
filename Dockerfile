# Build stage
FROM composer:2.7 AS composer

WORKDIR /app
COPY composer.json composer.lock ./
RUN composer install --no-scripts --no-autoloader --prefer-dist

COPY . .
RUN composer dump-autoload --optimize

# Node stage for frontend assets
FROM node:20-alpine AS node

WORKDIR /app
COPY package.json vite.config.js ./
COPY resources /app/resources
RUN npm i && npm run build

# Production stage
FROM php:8.2-fpm-alpine AS production

# Install system dependencies with MySQL support
RUN apk add --no-cache \
    mysql-dev \
    libpng-dev \
    libjpeg-turbo-dev \
    libwebp-dev \
    freetype-dev \
    zip \
    unzip \
    git \
    curl \
    libzip-dev \
    oniguruma-dev \
    supervisor

# Install PHP extensions with MySQL support
RUN docker-php-ext-configure gd --with-freetype --with-jpeg --with-webp && \
    docker-php-ext-install pdo pdo_mysql mysqli gd zip bcmath opcache mbstring exif pcntl

# Configure opcache
COPY docker/php/opcache.ini /usr/local/etc/php/conf.d/opcache.ini

# Set working directory
WORKDIR /var/www

# Create necessary directories with proper permissions
RUN mkdir -p /var/log/supervisor /var/log/php-fpm && \
    chown -R www-data:www-data /var/log/supervisor /var/log/php-fpm

# Copy application files
COPY --chown=www-data:www-data . /var/www
COPY --from=composer --chown=www-data:www-data /app/vendor /var/www/vendor
COPY --from=node --chown=www-data:www-data /app/public/build /var/www/public/build

# Set up supervisor
COPY docker/supervisor/supervisord.conf /etc/supervisor/conf.d/supervisord.conf

# Set proper permissions
RUN chown -R www-data:www-data /var/www/storage /var/www/bootstrap/cache && \
    chmod -R 775 /var/www/storage /var/www/bootstrap/cache

# Expose port 9000
EXPOSE 9000

# Start PHP-FPM and supervisor
CMD ["/usr/bin/supervisord", "-c", "/etc/supervisor/conf.d/supervisord.conf"]
