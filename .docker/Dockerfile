FROM laradock/php-fpm:latest-8.0

# TODO: Need a multistage container build -> run (for NodeJS)

ARG user
ARG uid

# TODO: I just noticed, but it is actually a fucking Ubuntu image
RUN set -xe; \
    apt-get update -yqq && \
    pecl channel-update pecl.php.net && \
    apt-get install -yqq \
      apt-utils \
      gnupg2 \
      git \
      libzip-dev zip unzip && \
      docker-php-ext-configure zip && \
      docker-php-ext-install zip && \
      php -m | grep -q 'zip' && \
      docker-php-ext-install sockets

COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

RUN groupadd -g $uid $user
RUN useradd -u $uid -ms /bin/bash -g $user $user

COPY --chown=$user:$user ./bruh /var/www
RUN rm -rf /var/www/.env
COPY --chown=$user:$user .env /var/www/.env

WORKDIR /var/www

USER $user

CMD ["sh", "-c", "composer install && php artisan key:generate && php-fpm"]

EXPOSE 9000