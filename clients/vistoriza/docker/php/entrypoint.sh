#!/bin/sh
set -eu

: "${APACHE_DOCUMENT_ROOT:=/var/www/html/public}"
: "${APACHE_SERVER_NAME:=localhost}"
: "${APACHE_DOCS_ROOT:=/var/www/html/app/src/docs}"
: "${MYSQL_TCP_HOST:=mysql}"

mkdir -p /var/run/mysqld /var/lib/php/sessions
chown -R www-data:www-data /var/run/mysqld /var/lib/php/sessions

envsubst '${APACHE_DOCUMENT_ROOT} ${APACHE_SERVER_NAME} ${APACHE_DOCS_ROOT}' \
    < /etc/apache2/templates/vhost.conf \
    > /etc/apache2/sites-available/000-default.conf

rm -f /var/run/mysqld/mysqld.sock
socat UNIX-LISTEN:/var/run/mysqld/mysqld.sock,fork,reuseaddr,user=www-data,group=www-data,mode=0777 TCP:"${MYSQL_TCP_HOST}":3306 &

chown -R www-data:www-data \
    /var/www/html/app/src/docs \
    /var/www/html/geprosColaborador/app/src/docs \
    /var/www/html/vendor/mpdf/mpdf/tmp 2>/dev/null || true

exec docker-php-entrypoint "$@"
