include .env

CONTAINER=$(DOCKER_CONTAINER_NAME)-php

build: git-prepare kill
	docker-compose build --no-cache
	docker-compose up --no-build -d
	docker exec -it $(CONTAINER) rm -rf ./vendor/ && rm -f ./composer.lock
	make composer-install
	make migrate

up:
	docker-compose up --no-build -d

down:
	docker-compose down || true

kill: down
	docker-compose kill || true

tty:
	docker exec -it $(CONTAINER) bash

# - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
# Composer
# - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -

composer-install:
	docker exec -it $(CONTAINER) composer install --no-scripts --no-plugins --no-interaction --dev

composer-update:
	docker exec -it $(CONTAINER) composer update

composer-check:
	docker exec -it $(CONTAINER) composer check

composer-tests:
	docker exec -it $(CONTAINER) composer tests

composer-phpcbf:
	docker exec -it $(CONTAINER) composer phpcbf

# - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
# Commands
# - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -

migrate:
	docker exec -it $(CONTAINER) php peppux migrate

migrate-rollback:
	docker exec -it $(CONTAINER) php peppux migrate:rollback

# - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
# Tools
# - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -

git-prepare:
	git config --local core.hooksPath .github/hooks
	chmod +x .github/hooks/*
