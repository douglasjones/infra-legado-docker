FROM php:5.6-apache

RUN docker-php-ext-install mysqli mysql

RUN a2enmod rewrite
RUN echo "ServerName localhost" > /etc/apache2/conf-available/servername.conf && a2enconf servername

COPY docker/php/php.ini /usr/local/etc/php/conf.d/hemil.ini
COPY docker/php/apache.conf /etc/apache2/sites-available/000-default.conf

WORKDIR /var/www/html
