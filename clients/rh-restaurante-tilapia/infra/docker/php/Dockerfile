FROM php:7.3-fpm-buster

RUN sed -i 's/deb.debian.org/archive.debian.org/g' /etc/apt/sources.list && \
    sed -i 's/security.debian.org/archive.debian.org/g' /etc/apt/sources.list && \
    sed -i '/stretch-updates/d' /etc/apt/sources.list && \
    sed -i 's/buster-updates/buster/g' /etc/apt/sources.list

RUN apt-get update && apt-get install -y \
    libpng-dev \
    libjpeg-dev \
    libfreetype6-dev \
    libzip-dev \
    zip \
    unzip \
    && docker-php-ext-configure gd --with-freetype-dir=/usr/include/ --with-jpeg-dir=/usr/include/ \
    && docker-php-ext-install -j"$(nproc)" pdo_mysql gd mysqli bcmath calendar zip

COPY docker/php/php.ini /usr/local/etc/php/conf.d/rh-restaurante-tilapia.ini
COPY docker/php/www.conf /usr/local/etc/php-fpm.d/zz-rh-restaurante-tilapia.conf

WORKDIR /var/www/html
