FROM php:8.0-fpm-alpine

ARG user
ARG uid

ENV POSTGRES_DB_HOST localhost
ENV POSTGRES_DB_PORT 5432

ENV RABBITMQ_HOST localhost
ENV RABBITMQ_PORT 5672

# TODO: Remove unnecessay deps.
ENV PHP_DEPS_TEMP \
    util-linux \
    gnupg

ENV PHP_DEPS \
    postgresql-dev \
    libzip-dev \
    zip

# NOTE: Workaround for issue: https://github.com/docker-library/php/issues/1245
ENV CFLAGS="$CFLAGS -D_GNU_SOURCE"

# ADD https://github.com/mlocati/docker-php-extension-installer/releases/latest/download/install-php-extensions /usr/local/bin/

RUN set -xe; \
    # Install temporary dependencies
    apk add --update --no-cache --virtual .build-deps ${PHP_DEPS_TEMP}; \
    # Install persistent dependencies
    apk add --no-cache ${PHP_DEPS}; \
    # Ensure that channel definitions are up-to-date
    pecl channel-update pecl.php.net; \
    # Install composer
    curl -sS https://getcomposer.org/installer -o composer-setup.php; \
    php composer-setup.php --install-dir=/usr/local/bin --filename=composer; \
    rm -rf composer-setup.php; \
    # PHP extensions
    docker-php-ext-configure sockets; \
    docker-php-ext-configure zip; \
    docker-php-ext-install zip; \
    docker-php-ext-install sockets; \
    docker-php-ext-install pdo pdo_pgsql; \
    # MongoDB extension
    # chmod +x /usr/local/bin/install-php-extensions && sync && \
    # install-php-extensions mongodb-stable
    # Cleanup
    apk del .build-deps

RUN addgroup -g $uid $user
RUN adduser -u $uid -s /bin/bash -h /home/$user -G $user -D $user

COPY --chown=$user:$user ./bruh /var/www
RUN rm -rf /var/www/.env
COPY --chown=$user:$user .env /var/www/.env

COPY --chown=$user:$user .docker/scripts/wait.sh /var/www/wait.sh
RUN chmod +x /var/www/wait.sh

WORKDIR /var/www

USER $user

# Install dependenices with composer -> Generate app key -> Wait for PostgreSQL to start -> Wait for RabbitMQ to start -> Start FastCGI server
CMD ["sh", "-c", "composer install && php artisan key:generate && timeout 60 ./wait.sh -h ${POSTGRES_DB_HOST} -p ${POSTGRES_DB_PORT} && timeout 60 ./wait.sh -h ${RABBITMQ_HOST} -p ${RABBITMQ_PORT} && php-fpm"]

EXPOSE 9000