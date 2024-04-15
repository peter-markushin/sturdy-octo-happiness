docker = docker compose run workspace

.PHONY: help
help: # List commands
	@grep '^[^#(?!.PHONY)[:space:]].*:' Makefile

.PHONY: composer-install
composer-install: # Run composer install
	$(docker) composer install

.PHONY: migrate
migrate: # Run migrations
	$(docker) php artisan migrate

.PHONY: routes
routes: # See application routes
	$(docker) php artisan route:list

.PHONY: cache-clear
cache-clear: # Clear cache
	$(docker) php artisan optimize:clear

.PHONY: ssh
ssh: # SSH into container
	$(docker) /bin/bash

.PHONY: tests
tests: # Run phpunit tests
	$(docker) ./vendor/bin/phpunit -d memory_limit=512M tests

.PHONY: test
test: # make test filter=test_name
	$(docker) ./vendor/bin/phpunit -d memory_limit=512M tests --filter $(filter)

.PHONY: unit
unit: # Run unit tests
	$(docker) ./vendor/bin/phpunit -d memory_limit=512M --testsuite unit

.PHONY: integration
integration: # Run integration tests
	$(docker) ./vendor/bin/phpunit -d memory_limit=512M --testsuite integration

.PHONY: functional
functional: # Run functional tests
	$(docker) ./vendor/bin/phpunit -d memory_limit=512M --testsuite functional

.PHONY: style
style: # Check code style
	$(docker) ./vendor/bin/pint

.PHONY: stan
stan: # Run phpstan
	$(docker) php -dmemory_limit=1024M ./vendor/bin/phpstan analyse

.PHONY: stan-fix
stan-fix: # Run phpstan and generate baseline
	$(docker) php -dmemory_limit=1024M ./vendor/bin/phpstan analyse --generate-baseline
