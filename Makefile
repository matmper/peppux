include .env

CONTAINER=$(DOCKER_CONTAINER_NAME)-php

build: kill
	docker-compose build --no-cache
	docker-compose up --no-build -d
	docker exec -it $(CONTAINER) rm -rf ./vendor/ && rm -f ./composer.lock
	make composer-install

up:
	docker-compose up --no-build -d

down:
	docker-compose down || true

kill: down
	docker-compose kill || true

tty:
	docker exec -it ${CONTAINER} bash

composer-install:
	docker exec -it ${CONTAINER} composer install

composer-update:
	docker exec -it ${CONTAINER} composer update

composer-check:
	docker exec -it ${CONTAINER} composer check

composer-tests:
	docker exec -it ${CONTAINER} composer tests

composer-phpstan:
	docker exec -it ${CONTAINER} composer phpstan

composer-phpcs:
	docker exec -it ${CONTAINER} composer phpcs

composer-phpcbf:
	docker exec -it ${CONTAINER} composer phpcbf
