# Bruh

## Requirements
- [PHP](https://www.php.net/)
- [Composer](https://getcomposer.org/download/)
- [Laravel](https://laravel.com/)
- [MongoDB](https://www.mongodb.com/)
- [PostgreSQL](https://www.postgresql.org/)
- [NodeJS](https://nodejs.org/en/)
- [Redis](https://redis.io/)
## Optional
- [Elasticsearch](https://www.elastic.co/)
- [RabbitMQ](https://www.rabbitmq.com/)
## Testing
- [MailHog](https://github.com/mailhog/MailHog)

## ~~Slow~~ Quick start
Instructions for running the app locally.

### Install Laravel MongoDB Package
```shell
sudo pecl install mongodb
```

Ensure that the mongodb extension is enabled in `php.ini` file.
Add the following line to `php.init` file.
```shell
extension="mongodb.so"
```

You can find `php.ini` file location by running
```shell
php --ini
```

### Install app dependencies
```shell
composer install
```

### Install web dependencies
```shell
npm install
```

### Compile Vue components
```shell
npm run dev
```

### Create application `.env` file and generate the app key
Create app `.env` file
```shell
cp .env.example.local .env
```

Generate the app key
```shell
php artisan key:generate
```

### Change `.env` file if necessary and run migrations
```shell
php artisan migrate
```

### Start the app
```shell
php artisan serve --host=0.0.0.0 --port=8080
```


# NOTES

## Setup local MongoDB with `Docker`
```shell
docker run -d --name bruh-mongo-db-local -p 27017:27017 -e MONGO_INITDB_ROOT_USERNAME=${MONGO_DB_USERNAME} -e MONGO_INITDB_ROOT_PASSWORD=${MONGO_DB_PASSWORD} -e MONGO_INITDB_DATABASE=${MONGO_DB_AUTHENTICATION_DATABASE} mongo
```

## Setup local PostgreSQL with `Docker`
```shell
docker run -d --name bruh-pgsql-local -p 5432:5432 -e POSTGRES_PASSWORD=${POSTGRES_DB_PASSWORD} -e POSTGRES_USER=${POSTGRES_DB_USERNAME} -e POSTGRES_DB=${POSTGRES_DB_DATABASE} postgres:alpine
```

## Setup local Elasticsearch with `Docker`
```shell
docker run -d --name bruh-elastic-local -e "discovery.type=single-node" -e "bootstrap.memory_lock=true" -e "network.bind_host=0.0.0.0" -e "ES_JAVA_OPTS=-Xms512m -Xmx512m" -p 9200:9200 -p 9300:9300 elasticsearch:7.17.0
```

## Setup local RabbitMQ with `Docker`
````shell
docker run -d --name bruh-rabbitmq-local -e RABBITMQ_DEFAULT_USER=${RABBITMQ_USER} -e RABBITMQ_DEFAULT_PASS=${RABBITMQ_PASSWORD} -p 5672:5672 -p 15672:15672 rabbitmq:3.9.13-management-alpine
````

## Setup local MailHog (for email testing) with `Docker`
```shell
docker run -d --name bruh-mailhog-local -p 8025:8025 -p 1025:1025 mailhog/mailhog
```

## Setup local queue consumer with `Docker` (execute this command in current directory)
```shell
docker run -d --name bruh-worker-local --network host -v `pwd`:/var/www/ -w /var/www/ php:8.0-alpine php artisan queue:work
```

## Setup local Redis with `Docker`
```shell
docker run -d --name bruh-redis-local -p 6379:6379 -e REDIS_PASSWORD=777Passw0rd777 redis:7.0-rc1-alpine /bin/sh -c 'redis-server --maxmemory 100mb --appendonly yes --requirepass ${REDIS_PASSWORD}'
```

## Error: Install or enable PHP's sockets extension.
In `php.ini` change this line
```text
;extension=sockets
```
To this
```text
extension=sockets
```

## Docker compose helpful commands
Rerun migrations
```shell
docker-compose exec app php artisan migrate:fresh
```

Seed the database
```shell
docker-compose exec app php artisan db:seed
```

Reindex Elasticsearch
```shell
docker-compose exec app php artisan search:reindex
```

## Creating index in prod Elasticsearch(Bonsai) (Future reference)
```shell
curl -X PUT "https://<ELASTICSEARCH_URL>/<ELASTICSEARCH_INDEX/MODEL_NAME>"
```
In our case index/model(ELASTICSEARCH_INDEX/MODEL_NAME) name is `offers`. (Can be accessed like that: `$model->getSearchIndex()` or `Offer::find(1)->getSearchIndex()`)

And `ELASTICSEARCH_HOSTS` is set to `ELASTICSEARCH_URL`.

## Installing php-redis
 - [php-redis-repo](https://github.com/phpredis/phpredis/blob/develop/INSTALL.markdown)

Personal note: Compiling some C code just so PHP could serve some text over HTTP...
