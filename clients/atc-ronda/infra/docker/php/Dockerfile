FROM php:7.3-fpm-buster

RUN docker-php-ext-install -j"$(nproc)" mysqli pdo_mysql calendar

RUN { \
        echo "short_open_tag=On"; \
        echo "display_errors=Off"; \
        echo "log_errors=On"; \
        echo "date.timezone=America/Sao_Paulo"; \
    } > /usr/local/etc/php/conf.d/legacy.ini

WORKDIR /var/www/html
