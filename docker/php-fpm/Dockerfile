FROM php:8.1.10-fpm

RUN apt-get update && apt-get install -y \
  libfreetype6-dev \
  libjpeg62-turbo-dev \
  libpng-dev \
  && apt-get clean \
  && rm -rf /var/lib/apt/lists/* \
  && docker-php-ext-configure gd --with-freetype --with-jpeg \
  && docker-php-ext-configure mysqli --with-mysqli=mysqlnd \
  && docker-php-ext-install -j$(nproc) gd \
  && docker-php-ext-install -j$(nproc) iconv \
  && docker-php-ext-install -j$(nproc) mysqli