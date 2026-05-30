FROM php:7.3-apache

RUN set -eux; \
    apt-get update; \
    apt-get install -y --no-install-recommends \
        default-mysql-client \
        gettext-base \
        libfreetype6-dev \
        libicu-dev \
        libjpeg62-turbo-dev \
        libpng-dev \
        libzip-dev \
        qpdf \
        socat \
        unzip \
        zlib1g-dev; \
    docker-php-ext-configure gd --with-freetype-dir=/usr/include/ --with-jpeg-dir=/usr/include/; \
    docker-php-ext-install -j"$(nproc)" bcmath calendar gd intl mbstring mysqli pdo_mysql zip; \
    a2enmod rewrite headers expires; \
    rm -rf /var/lib/apt/lists/*

COPY docker/php/entrypoint.sh /usr/local/bin/vistoriza-entrypoint
RUN chmod +x /usr/local/bin/vistoriza-entrypoint

ENTRYPOINT ["vistoriza-entrypoint"]
CMD ["apache2-foreground"]
