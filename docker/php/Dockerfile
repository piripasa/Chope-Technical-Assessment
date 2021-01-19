FROM php:7.4-fpm-alpine

WORKDIR /var/www/html

RUN docker-php-ext-install pdo pdo_mysql

RUN apk add --update --no-cache autoconf g++ make \
    && pecl install redis \
    && docker-php-ext-enable redis
