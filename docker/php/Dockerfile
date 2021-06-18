FROM php:8.0-fpm

# Install PDO
RUN docker-php-ext-install pdo pdo_mysql

# Install composer
COPY --from=composer /usr/bin/composer /usr/bin/composer
