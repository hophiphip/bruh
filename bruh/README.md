# Bruh

## Requirements
- [PHP](https://www.php.net/)
- [Composer](https://getcomposer.org/download/)
- [Laravel](https://laravel.com/)
- [MongoDB](https://www.mongodb.com/)
- [PostgreSQL](https://www.postgresql.org/)
- [NodeJS](https://nodejs.org/en/)

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
docker run -d --name bruh-mongo-db -p 27017:27017 -e MONGO_INITDB_ROOT_USERNAME=${MONGO_DB_USERNAME} -e MONGO_INITDB_ROOT_PASSWORD=${MONGO_DB_PASSWORD} -e MONGO_INITDB_DATABASE=${MONGO_DB_AUTHENTICATION_DATABASE} mongo
```

## Setup local PostgreSQL with 'Docker'
```shell
docker run -d --name bruh-pgsql-db -p 5432:5432 -e POSTGRES_PASSWORD=${POSTGRES_DB_PASSWORD} -e POSTGRES_USER=${POSTGRES_DB_USERNAME} -e POSTGRES_DB=${POSTGRES_DB_DATABASE} postgres:alpine
```

