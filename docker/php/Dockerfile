FROM php:8.0-fpm

# Install PDO
RUN docker-php-ext-install pdo pdo_mysql

# Install composer
COPY --from=composer /usr/bin/composer /usr/bin/composer

# Install git
RUN apt-get update -y
RUN apt-get install -y --no-install-recommends git

# Install PHP Zip
RUN apt-get install -y \
        libzip-dev \
        zip \
  && docker-php-ext-install zip
