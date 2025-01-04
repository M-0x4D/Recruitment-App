# Use the official PHP image as the base image
FROM php:8.2-fpm

# Set working directory
WORKDIR /var/www

RUN apt-get update \
    && apt-get install -y --no-install-recommends \
    git \
    curl \
    libpng-dev \
    libjpeg-dev \
    libfreetype6-dev \
    zip \
    unzip \
    && apt-get clean \
    && rm -rf /var/lib/apt/lists/*

# Install PHP extensions
RUN docker-php-ext-install pdo_mysql

# Install Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Ensure the snippets directory exists in the container
RUN mkdir -p /etc/nginx/snippets

# Copy the Nginx configuration and the fastcgi-php.conf file
# Copy existing application directory contents
COPY . /var/www
COPY ./docker/nginx/default.conf /etc/nginx/conf.d/default.conf
COPY ./docker/nginx/snippets/fastcgi-php.conf /etc/nginx/snippets/fastcgi-php.conf

# Set the correct permissions for storage and bootstrap/cache
RUN chown -R www-data:www-data /var/www/storage /var/www/bootstrap/cache \
    && chmod -R 775 /var/www/storage /var/www/bootstrap/cache

# Expose port 80
EXPOSE 9000

# Start PHP-FPM
CMD ["php-fpm"]
