FROM php:5.6-apache

RUN docker-php-ext-install mysql mysqli pdo_mysql mbstring

RUN a2enmod rewrite

COPY docker/php/php.ini /usr/local/etc/php/php.ini
