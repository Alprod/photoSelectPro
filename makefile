.PHONY: help
.DEFAULT_GOAL = help

DOCKER_COMPOSE=docker-compose
SYMFONY_CONSOLE=symfony console
COMPOSER=composer

## --- Docker ---------------------------------------

## Lancer les containers
start:
	${DOCKER_COMPOSE} up -d

## Arrêter les containers
stop:
	${DOCKER_COMPOSE} stop

## Supprimer les containers
rm: stop
	${DOCKER_COMPOSE} rm -f

## Supprimer les containers
restart: rm start

## Status des containers
docker-ps:
	${DOCKER_COMPOSE} ps

## --- Symfony ---------------------------------------

## Installation de vendor
vendor-i:
	${COMPOSER} install

## update de vendor
vendor-u:
	${COMPOSER} update

## Vider le cache
cc:
	${SYMFONY_CONSOLE} c:c

cc-test:
	${SYMFONY_CONSOLE} c:c --env=test

clean-db:
	- ${SYMFONY_CONSOLE} d:d:d --force
	${SYMFONY_CONSOLE} d:d:c
	${SYMFONY_CONSOLE} d:m:m --no-interaction
	${SYMFONY_CONSOLE} d:f:l --no-interaction

clean-db-test:
	- ${SYMFONY_CONSOLE} d:d:d --force --env=test
	${SYMFONY_CONSOLE} d:d:c --env=test
	${SYMFONY_CONSOLE} d:m:m --no-interaction --env=test
	${SYMFONY_CONSOLE} d:f:l --no-interaction --env=test

## —— Others️ ------------------------------------------------------------------------------
help: ## Liste des commandes
	@grep -E '(^[a-zA-Z0-9_-]+:.*?##.*$$)|(^##)' $(MAKEFILE_LIST) | awk 'BEGIN {FS = ":.*?## "}{printf "\033[32m%-30s\033[0m %s\n", $$1, $$2}' | sed -e 's/\[32m##/[33m/'
