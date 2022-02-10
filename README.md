# Bruh
An online platform for providing easy access to insurance companies services.

## Try it
https://bruh-service.herokuapp.com/offers
(Only search capabilities for now)

## Requirements
- [Docker](https://www.docker.com/)

## Quick start
Create a config file.
```shell
cp .env.example .env
```
Start the app
```shell
docker-compose up -d
```

Run migrations
```shell
docker-compose exec app php artisan migrate:fresh
```

Seed the database
```shell
docker-compose exec app php artisan db:seed
```

Reindex elasticsearch
```shell
docker-compose exec app php artisan search:reindex
```

Go to `localhost:8000/offers` and try searching for offers.

---
**NOTE**    `Docker` memory cap might be exceeded because of `Elasticsearch`.
Can be fixed with this:

Linux
```shell
sysctl -w vm.max_map_count=262144
```

Windows
```shell
wsl -d docker-desktop
```
```shell
sysctl -w vm.max_map_count=262144
```
---

