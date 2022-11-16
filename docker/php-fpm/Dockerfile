FROM php:8.1.12-fpm

RUN export DEBIAN_FRONTEND=noninteractive DEBCONF_NONINTERACTIVE_SEEN=true && apt-get -q update && \
  apt-get -q install -y \
  libfreetype6-dev \
  libjpeg62-turbo-dev \
  libpng-dev \
  && apt-get clean \
  && rm -rf /var/lib/apt/lists/* \
  && docker-php-ext-configure gd --with-freetype --with-jpeg \
  && docker-php-ext-configure mysqli --with-mysqli=mysqlnd \
  && docker-php-ext-configure pdo_mysql --with-pdo-mysql=mysqlnd \
  && docker-php-ext-install -j$(nproc) gd \
  && docker-php-ext-install -j$(nproc) iconv \
  && docker-php-ext-install -j$(nproc) mysqli \
  && docker-php-ext-install -j$(nproc) pdo_mysql