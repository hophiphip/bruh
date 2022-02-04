# Bruh

## Requirements
- [PHP](https://www.php.net/)
- [Composer](https://getcomposer.org/download/)
- [Laravel](https://laravel.com/)
- [MongoDB](https://www.mongodb.com/)
- [PostgreSQL](https://www.postgresql.org/)

## Setup local MongoDB with `Docker`
```shell
docker run -d --name bruh-mongo-db -p 27017:27017 -e MONGO_INITDB_ROOT_USERNAME=${MONGO_DB_USERNAME} -e MONGO_INITDB_ROOT_PASSWORD=${MONGO_DB_PASSWORD} -e MONGO_INITDB_DATABASE=${MONGO_DB_AUTHENTICATION_DATABASE} mongo
```

## Setup local PostgreSQL with 'Docker'
```shell
docker run -d --name bruh-pgsql-db -p 5432:5432 -e POSTGRES_PASSWORD=${POSTGRES_DB_PASSWORD} -e POSTGRES_USER=${POSTGRES_DB_USERNAME} -e POSTGRES_DB=${POSTGRES_DB_DATABASE} postgres:alpine
```

