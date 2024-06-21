# Use an official PHP image as base
FROM php:apache

# Enable the rewrite module
RUN apt-get update
RUN apt-get upgrade -y

RUN a2enmod rewrite
RUN service apache2 restart

COPY ./site /var/www/html

WORKDIR /var/www/html

EXPOSE 80