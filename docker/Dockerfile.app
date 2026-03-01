FROM php:8.1-fpm

# Install system dependencies for PHP extensions
RUN apt-get update && apt-get install -y \
    git \
    curl \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    zip \
    unzip \
    && apt-get clean && rm -rf /var/lib/apt/lists/*

# Install PHP extensions your app needs
RUN docker-php-ext-install pdo_mysql mbstring exif pcntl bcmath gd

# NO COMPOSER INSTALLED HERE

#Xdebug
RUN pecl install xdebug && docker-php-ext-enable xdebug

COPY ./xdebug.ini "${PHP_INI_DIR}/conf.d"

WORKDIR /var/www