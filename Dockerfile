FROM php:7.4-apache

RUN docker-php-ext-install mysqli && \
    docker-php-ext-enable mysqli

COPY init.sql /docker-entrypoint-initdb.d/

COPY index.php /var/www/html/
COPY login.php /var/www/html/
COPY manage.php /var/www/html/

EXPOSE 80
