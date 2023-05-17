FROM php:8.0-fpm

COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

RUN apt-get update \
  && apt-get install -y wget git zip unzip libpq-dev libfreetype6-dev libjpeg62-turbo-dev libpng-dev libicu-dev libzip-dev \
  && docker-php-ext-install pdo pdo_mysql pgsql pdo_pgsql intl \
  && docker-php-ext-configure gd --with-freetype --with-jpeg \
  && docker-php-ext-install -j$(nproc) gd \
  && docker-php-ext-configure zip \
  && docker-php-ext-install zip
