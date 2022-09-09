FROM php:latest

RUN curl -OL https://squizlabs.github.io/PHP_CodeSniffer/phpcs.phar /workflow/bin/
RUN curl -OL https://squizlabs.github.io/PHP_CodeSniffer/phpcbf.phar /workflow/bin/
ENV PATH /workflow/bin:${PATH}

#COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

#ENV PATH /composer/vendor/bin:${PATH}
#ENV COMPOSER_ALLOW_SUPERUSER 1
#ENV COMPOSER_NO_INTERACTION 1
#ENV COMPOSER_PROCESS_TIMEOUT 0
#ENV COMPOSER_HOME="/composer"
#RUN composer global require --dev --prefer-dist --no-progress squizlabs/php_codesniffer

WORKDIR "/app"