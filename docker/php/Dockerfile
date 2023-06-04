FROM php:8.1.18-fpm-alpine

# WORKDIR
WORKDIR /var/www/html/jinsei_mentor

# Composer
RUN curl -sS https://getcomposer.org/installer | php
RUN mv composer.phar /usr/local/bin/composer

# Update
RUN apk update

# Packages
RUN apk add zip unzip git

# PHP extentions
RUN docker-php-ext-install pdo pdo_mysql


# build後にdocker-compose exec app chmod -R 777 storage bootstrap/cacheした
