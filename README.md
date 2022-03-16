# Bruh
A sample platform implementation for publishing and accessing insurance services.  

## Try it
https://bruh-service.herokuapp.com/

## Requirements
- [Docker](https://www.docker.com/)

## Quick start
Create a config file.
```shell
cp .env.example .env
```
Start the app in background
```shell
docker-compose -f docker-compose.yml up -d
```

## Recommendations
Delete volumes between runs (e.g. update webapp files/configs)
```shell
docker-compose down -v
```

## Tests
### Unit/Feature tests
```shell
docker-compose -f docker-compose-unit.yml up --exit-code-from app
```

## Possible issues

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

