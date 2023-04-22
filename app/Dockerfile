FROM php:8.2-apache

RUN apt update \
    && docker-php-ext-install mysqli \
    && docker-php-ext-install pdo_mysql
