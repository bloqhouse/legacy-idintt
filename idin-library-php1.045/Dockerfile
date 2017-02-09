FROM php:7-apache

RUN apt-get update && apt-get install -y \
        libmcrypt-dev \
    && docker-php-ext-install -j$(nproc) mcrypt

COPY . /var/www/html/
EXPOSE 80
