# Stage 1 - Build Frontend (Vite)
FROM node:18 AS frontend
WORKDIR /app
COPY package*.json ./
RUN npm install
COPY . .
RUN npm run build

# Stage 2 - Backend (Laravel + PHP + Composer + Nginx)
FROM php:8.2-fpm AS backend

# Install system dependencies
RUN apt-get update && apt-get install -y \
    git curl unzip libpq-dev libonig-dev libzip-dev zip nginx \
    && docker-php-ext-install pdo pdo_mysql mbstring zip

# Install Composer
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

WORKDIR /var/www

# Copy Laravel app files
COPY . .

# Copy Vite build output into public/build
COPY --from=frontend /app/public/build ./public/build

# Install PHP dependencies
RUN composer install --no-dev --optimize-autoloader

# Laravel cache clear
RUN php artisan config:clear && \
    php artisan route:clear && \
    php artisan view:clear

# Copy Nginx config
COPY ./nginx.conf /etc/nginx/conf.d/default.conf

# Expose port 8080 (Render expects a web service here)
EXPOSE 8080

# Start PHP-FPM + Nginx
CMD service php-fpm start && nginx -g "daemon off;"

