FROM php:8.2-fpm-alpine

RUN set -ex \
  && apk --no-cache add \
    postgresql-dev

RUN docker-php-ext-install pdo pdo_pgsql intl

ADD --chown=82:82 ./ /var/www/symfony/

WORKDIR /var/www/symfony/