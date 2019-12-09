FROM php:7.2-fpm

RUN apt-get update
RUN apt-get install -y libmcrypt-dev mcrypt git curl gnupg
RUN curl -sL https://deb.nodesource.com/setup_8.x | bash
RUN docker-php-ext-install pdo_mysql
RUN apt-get install -y vim
RUN curl -sS https://getcomposer.org/installer | php
RUN mv composer.phar /usr/local/bin/composer

COPY php.ini /usr/local/etc/php/