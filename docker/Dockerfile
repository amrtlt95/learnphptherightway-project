FROM php:8.0.2-fpm

# Fix for old Debian mirrors
RUN sed -i 's/deb.debian.org/archive.debian.org/g' /etc/apt/sources.list && \
    sed -i 's|security.debian.org/debian-security|archive.debian.org/debian-security|g' /etc/apt/sources.list && \
    sed -i '/stretch-updates/d' /etc/apt/sources.list

RUN apt-get update && apt-get install -y \
    git \
    curl \
    zip \
    unzip \
    # Adding mysql-client and dev headers just in case
    default-mysql-client \
    && docker-php-ext-install pdo pdo_mysql

WORKDIR /var/www