# Gunakan image PHP dengan ekstensi yang dibutuhkan
FROM php:8.3-fpm

# Install dependency sistem
RUN apt-get update && apt-get install -y \
    git curl libpng-dev libonig-dev libxml2-dev zip unzip \
    && docker-php-ext-install pdo pdo_mysql mbstring exif pcntl bcmath gd

# Install Composer
COPY --from=composer:2.7 /usr/bin/composer /usr/bin/composer

# Set working directory
WORKDIR /var/www/html

# Copy semua file project
COPY . .

# Install dependency Laravel
RUN composer install --no-dev --optimize-autoloader

# Jalankan artisan command untuk cache config & route
RUN php artisan config:cache && php artisan route:cache

# Expose port
EXPOSE 8000

# Start Laravel dengan artisan serve
CMD php artisan serve --host=0.0.0.0 --port=$PORT