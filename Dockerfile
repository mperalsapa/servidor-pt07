FROM php:8.0-apache
WORKDIR /var/www/html
ADD . .
RUN a2enmod rewrite
RUN docker-php-ext-install mysqli pdo pdo_mysql
EXPOSE 80

