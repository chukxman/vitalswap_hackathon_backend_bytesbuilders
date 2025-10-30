# Use official PHP image with necessary extensions
FROM php:8.2-cli

# Set working directory
WORKDIR /app

# Copy everything
COPY . .

# Install dependencies
RUN apt-get update && apt-get install -y zip unzip git curl libzip-dev && docker-php-ext-install zip pdo pdo_mysql

# Install Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Install Laravel dependencies
RUN composer install --no-dev --optimize-autoloader

# Expose port
EXPOSE 8000

# Start Laravel
CMD ["php", "artisan", "serve", "--host=0.0.0.0", "--port=8000"]
