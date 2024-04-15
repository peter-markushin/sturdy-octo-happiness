docker = docker compose run workspace

.PHONY: help
help: # List commands
	@grep '^[^#(?!.PHONY)[:space:]].*:' Makefile


.PHONY: setup-db
setup-db: # Creates database, runs migrations and migrates data
	bin/console doctrine:database:create -e catalog
	bin/console doctrine:database:create -e test

	php bin/console doctrine:migrations:migrate --no-interaction
	php bin/console doctrine:migrations:migrate -e test --no-interaction

	php bin/console app:migrate-data brands
	php bin/console app:migrate-data print_providers
	php bin/console app:migrate-data categories
	php bin/console app:migrate-data blueprints

.PHONY: composer-install
composer-install: # Run composer install
	$(docker) composer install

.PHONY: routes
routes: # See application routes
	$(docker) php bin/console debug:router

.PHONY: cache-clear
cache-clear: # Clear cache
	$(docker) php bin/console cache:clear

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
	$(docker) php ./vendor/bin/phpcs --standard=phpcs.xml --parallel=8 --report=checkstyle

.PHONY: stan
stan: # Run phpstan
    $(docker) php -dmemory_limit=1024M ./vendor/bin/phpstan analyse

.PHONY: stan-fix
stan-fix: # Run phpstan and generate baseline
	$(docker) php -dmemory_limit=1024M ./vendor/bin/phpstan analyse --generate-baseline
