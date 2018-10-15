FROM php:7.2-apache

WORKDIR /var/www/html
RUN apt-get update
RUN apt-get upgrade -y
RUN docker-php-ext-install mysqli
RUN docker-php-ext-install pdo_mysql
RUN a2enmod rewrite