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
Start the app
```shell
docker-compose up -d
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

