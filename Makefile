include .env

CONTAINER=$(DOCKER_CONTAINER_NAME)-php

build: git-prepare kill
	podman compose build --no-cache
	podman compose up --no-build -d
	podman exec -it $(CONTAINER) rm -rf ./vendor/ && rm -f ./composer.lock
	make composer-install
	make migrate

up:
	podman compose up --no-build -d

down:
	podman compose down || true

kill: down
	podman compose kill || true

tty:
	podman exec -it $(CONTAINER) bash

# - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
# Composer
# - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -

composer-install:
	podman exec -it $(CONTAINER) composer install --no-scripts --no-plugins --no-interaction --dev

composer-update:
	podman exec -it $(CONTAINER) composer update

composer-check:
	podman exec -it $(CONTAINER) composer check

composer-tests:
	podman exec -it $(CONTAINER) composer tests

composer-phpcbf:
	podman exec -it $(CONTAINER) composer phpcbf

# - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
# Commands
# - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -

migrate:
	podman exec -it $(CONTAINER) php peppux migrate

migrate-rollback:
	podman exec -it $(CONTAINER) php peppux migrate:rollback

# - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
# Tools
# - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -

git-prepare:
	git config --local core.hooksPath .github/hooks
	chmod +x .github/hooks/*
