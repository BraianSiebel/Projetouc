# Stage 1: Install PHP dependencies with Composer
# We use the official composer image to get our /vendor directory
FROM composer:2 as vendor

WORKDIR /app
COPY database/ database/
COPY composer.json composer.json
COPY composer.lock composer.lock
RUN composer install --no-interaction --no-dev --no-scripts --prefer-dist --optimize-autoloader

# Stage 2: Build frontend assets with Node
# We use a node image to run `npm run build`
FROM node:18-alpine as assets

WORKDIR /app
COPY package.json package.json
COPY package-lock.json package-lock.json
# If you have vite.config.js or others, copy them too
COPY vite.config.js vite.config.js
COPY postcss.config.js postcss.config.js
COPY tailwind.config.js tailwind.config.js
COPY resources/ resources/
RUN npm install
RUN npm run build

# Stage 3: Create the final production image
# We use a lean php-fpm-alpine image for a small footprint
FROM php:8.2-fpm-alpine

# Set working directory
WORKDIR /var/www/html

# Install system dependencies
# - Nginx for the web server
# - Supervisor to run multiple processes (php-fpm and nginx)
# - Common PHP extensions for Laravel
RUN apk update && apk add --no-cache \
    nginx \
    supervisor \
    libzip-dev \
    zip \
    && docker-php-ext-install pdo pdo_mysql zip

# Copy Nginx and Supervisor configuration files into the container
# We will create these files next
COPY docker/nginx.conf /etc/nginx/nginx.conf
COPY docker/supervisord.conf /etc/supervisor/conf.d/supervisord.conf

# Copy application code from the current directory
COPY . .

# Copy vendor dependencies and built assets from previous stages
COPY --from=vendor /app/vendor/ /var/www/html/vendor/
COPY --from=assets /app/public/build/ /var/www/html/public/build/

# Set correct permissions for storage and bootstrap/cache directories
# This is CRITICAL for Laravel to run properly
RUN chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache
RUN chmod -R 775 /var/www/html/storage /var/www/html/bootstrap/cache

# Expose port 80 to the outside world
EXPOSE 80

# The command that will be run when the container starts
# Supervisor will manage running both Nginx and PHP-FPM
CMD ["/usr/bin/supervisord", "-c", "/etc/supervisor/conf.d/supervisord.conf"]