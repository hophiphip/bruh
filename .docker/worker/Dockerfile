FROM php:8.0-alpine

ARG user
ARG uid

ENV RABBITMQ_HOST localhost
ENV RABBITMQ_PORT 5672

ENV PHP_DEPS_TEMP \
    util-linux \
    gnupg

ENV PHP_DEPS \
    postgresql-dev \
    libzip-dev \
    libpng-dev \
    libpng \
    zip

# NOTE: Workaround for issue: https://github.com/docker-library/php/issues/1245
ENV CFLAGS="$CFLAGS -D_GNU_SOURCE"

# Setup user/group
RUN addgroup -g $uid $user
RUN adduser -u $uid -s /bin/bash -h /home/$user -G $user -D $user

# Project folder is mounter to `app` container project folder

# Add wait script
COPY --chown=$user:$user .docker/scripts/wait.sh /var/wait.sh
RUN chmod +x /var/wait.sh

RUN set -xe; \
    # Install temporary dependencies
    apk add --update --no-cache --virtual .build-deps ${PHP_DEPS_TEMP}; \
    # Install persistent dependencies
    apk add --no-cache ${PHP_DEPS}; \
    # Ensure that channel definitions are up-to-date
    pecl channel-update pecl.php.net; \
    # PHP extensions
    docker-php-ext-configure sockets; \
    docker-php-ext-configure zip; \
    docker-php-ext-configure gd; \
    docker-php-ext-install gd zip sockets pdo pdo_pgsql; \
    # Cleanup
    apk del .build-deps

WORKDIR /var/www

# As `app` container project folder is mounted, no need to install dependencies second time

USER $user

# Setup project folder contetns -> Wait for RabbitMQ to start -> Start listening for the queue
CMD ["/bin/sh", "-c", "timeout 60 /var/wait.sh -h ${RABBITMQ_HOST} -p ${RABBITMQ_PORT} && php artisan queue:work"]