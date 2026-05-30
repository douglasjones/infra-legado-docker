# Dockerfile para PHP 5.6
FROM php:5.6-apache

# Instalar extensões PHP necessárias (exemplo)
RUN docker-php-ext-install pdo_mysql mbstring

# Habilitar mod_rewrite
RUN a2enmod rewrite

# Copiar arquivo php.ini
COPY php.ini /usr/local/etc/php/