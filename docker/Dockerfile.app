FROM php:8.1-fpm-alpine

# # Install system dependencies for PHP extensions
# RUN apt-get update && apt-get install -y \
#     git \
#     curl \
#     libpng-dev \
#     libonig-dev \
#     libxml2-dev \
#     zip \
#     unzip \
#     && apt-get clean && rm -rf /var/lib/apt/lists/*

RUN apk update && apk add --no-cache git \
    curl \
    libpng-dev \
    oniguruma-dev \
    libxml2-dev \
    zip \
    unzip \
    linux-headers \
    $PHPIZE_DEPS \
    bash

# Install PHP extensions your app needs
RUN docker-php-ext-install pdo_mysql mbstring exif pcntl bcmath gd

# NO COMPOSER INSTALLED HERE

#Xdebug
RUN pecl install xdebug && docker-php-ext-enable xdebug

COPY ./xdebug.ini "${PHP_INI_DIR}/conf.d"

WORKDIR /var/www

RUN apk del $PHPIZE_DEPS