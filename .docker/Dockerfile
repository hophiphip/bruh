FROM php:8.0-fpm-alpine

ARG user
ARG uid

ENV POSTGRES_DB_HOST localhost
ENV POSTGRES_DB_PORT 5432

ENV MONGO_DB_HOST localhost
ENV MONGO_DB_PORT 27017

ENV REDIS_HOST localhost
ENV REDIS_PORT 6379

ENV RABBITMQ_HOST localhost
ENV RABBITMQ_PORT 5672

ENV ELASTICSEARCH_HOSTS localhost:9200

ENV PHP_DEPS_TEMP \
    util-linux \
    gnupg \
    libpng \
    libpng-dev

ENV PHP_DEPS \
    postgresql-dev \
    libzip-dev \
    freetype-dev \
    libjpeg-turbo-dev \
    libwebp-dev \
    zlib-dev \
    libxpm-dev \
    libjpeg-turbo-dev \
    zip

# NOTE: Workaround for issue: https://github.com/docker-library/php/issues/1245
ENV CFLAGS="$CFLAGS -D_GNU_SOURCE"

# Cooler PHP extension installer
ADD https://github.com/mlocati/docker-php-extension-installer/releases/latest/download/install-php-extensions /usr/local/bin/

# Setup user/group
RUN addgroup -g $uid $user
RUN adduser -u $uid -s /bin/bash -h /home/$user -G $user -D $user

# Setup project folder
COPY --chown=$user:$user ./bruh /var/www/
RUN rm -rf /var/www/.env

# Add wait scripts
COPY --chown=$user:$user .docker/scripts/wait.sh /var/wait.sh
COPY --chown=$user:$user .docker/scripts/wait_elastic.sh /var/wait_elastic.sh
RUN chmod +x /var/wait.sh
RUN chmod +x /var/wait_elastic.sh

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
    docker-php-ext-configure gd --with-freetype=/usr/include/ --with-jpeg=/usr/include/; \
    docker-php-ext-install gd; \
    docker-php-ext-install zip; \
    docker-php-ext-install sockets; \
    docker-php-ext-install pdo pdo_pgsql; \
    # MongoDB, Redis extension
    chmod +x /usr/local/bin/install-php-extensions && sync; \
    install-php-extensions redis mongodb-stable; \
    # Install composer
    curl -sS https://getcomposer.org/installer -o composer-setup.php; \
    php composer-setup.php --install-dir=/usr/local/bin --filename=composer; \
    rm -rf composer-setup.php; \
    # Cleanup
    apk del .build-deps

RUN chown $user:$user /var/www
RUN chmod 755 /var/www

WORKDIR /var/www

USER $user

RUN composer install

# TODO: use service to start all that crap
# Generate app key -> Wait for PostgreSQL to start -> Wiat for MongoDB to start -> Wait for Redis to start -> Wait for RabbitMQ to start -> Wait for Elasticsearch to start -> Run migrations -> Seed the database -> Reindex elasticsearch -> Start FastCGI server
CMD ["sh", "-c", "php artisan key:generate && timeout 60 /var/wait.sh -h ${POSTGRES_DB_HOST} -p ${POSTGRES_DB_PORT} && timeout 60 /var/wait.sh -h ${MONGO_DB_HOST} -p ${MONGO_DB_PORT} && timeout 60 /var/wait.sh -h ${REDIS_HOST} -p ${REDIS_PORT} && timeout 60 /var/wait.sh -h ${RABBITMQ_HOST} -p ${RABBITMQ_PORT} && timeout 60 /var/wait_elastic.sh -h ${ELASTICSEARCH_HOSTS} && php artisan migrate:fresh && php artisan db:seed && php artisan search:reindex && php-fpm"]

EXPOSE 9000