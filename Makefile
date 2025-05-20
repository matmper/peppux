CONTAINER=peppux-php

ifeq ($(OS),Windows_NT)
	CMD_TIMEOUT=timeout
	CMD_GITHUB_HOOKS=echo "Skipping chmod on Windows"
else
	CMD_TIMEOUT=sleep
	CMD_GITHUB_HOOKS=chmod +x .github/hooks/*
endif

build-first: build up
	make composer
	make migrate

build: git-prepare kill
	docker-compose build --no-cache

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

composer:
	docker exec $(CONTAINER) composer install --no-scripts --no-plugins --no-interaction --dev
	docker cp $(CONTAINER):/var/www/composer.lock ./src/composer.lock
	docker cp $(CONTAINER):/var/www/vendor ./src/vendor

composer-update:
	docker exec -it $(CONTAINER) composer update

composer-check:
	docker exec $(CONTAINER) composer check

composer-phpcbf:
	docker exec $(CONTAINER) composer phpcbf

composer-tests:
	docker exec $(CONTAINER) composer tests

composer-tests-filter:
	docker exec $(CONTAINER) php vendor/bin/phpunit --configuration phpunit.xml --filter=$(filter)

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
	$(CMD_GITHUB_HOOKS)
