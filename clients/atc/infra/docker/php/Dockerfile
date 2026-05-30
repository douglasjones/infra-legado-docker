FROM php:7.3-fpm-buster

RUN docker-php-ext-install -j"$(nproc)" pdo_mysql calendar

WORKDIR /var/www/html
