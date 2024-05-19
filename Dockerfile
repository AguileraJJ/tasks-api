# Use an official PHP image as base
FROM php:apache

# Set working directory
WORKDIR /app

# Install system dependencies
RUN apt-get update && apt-get install -y \
    git \
    unzip

# Install Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Copy composer files and install dependencies
COPY composer.json composer.lock ./
RUN composer install --no-scripts --no-autoloader

# Copy project files
COPY . .

# Generate autoload files
RUN composer dump-autoload --optimize

# Command to run the application
CMD ["php", "index.php"]