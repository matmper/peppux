# Peppux Framework

Github: [matmper/peppux](https://github.com/matmper/peppux)

Peppux is a web framework developed in PHP for personal studies.

## Requeriments for development

- Docker
- Docker Compose
- GNU make
- PHP ^8.3 (Optional, you can use it within Docker)

## Installation for development

Clone repository, copy env and configure it:
```bash
$ cp .env.example .env
```

Start docker and run these commands:
```bash
$ make build
$ make up
```

Use `$ make up` to start or `$ make down` to stop.

The API will be available at `http://localhost:80` by default.
To change the port set the variable `DOCKER_CONTAINER_PORT` in your `.env` file.
