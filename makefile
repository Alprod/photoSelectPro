.PHONY: help
.DEFAULT_GOAL = help

DOCKER_COMPOSE=docker-compose
SYMFONY_CONSOLE=symfony console
COMPOSER=composer
PHPUNIT=php bin/phpunit
NPM=npm
PHPSTAN_ANALYSE=vendor/bin/phpstan analyse
PHPCSFIXER=php-cs-fixer/vendor/bin/php-cs-fixer

## --- Init ------------------------------------------------------------------------------

## Initialisation du projet une fois cloner
init: vendor-i npm-i start ddc dmm

## --- Docker ----------------------------------------------------------------------------

## Lancer les containers 'start'
start:
	$(DOCKER_COMPOSE) up -d

## Arrêter les containers 'stop'
stop:
	$(DOCKER_COMPOSE) stop

## Supprimer les containers 'rm'
rm: stop
	$(DOCKER_COMPOSE) rm -f

## Restart des containers 'restart'
restart: rm start

## Status des containers 'docker-ps'
docker-ps:
	$(DOCKER_COMPOSE) ps

## --- Symfony ----------------------------------------------------------------------------

## Installation de vendor 'vendor-i'
vendor-i:
	$(COMPOSER) install

## update de vendor 'vendor-u'
vendor-u:
	$(COMPOSER) update

## Supression dur répertoire vendor et réinstallation 'clean-vendor'
clean-vendor: cc-hard
	rm -Rf vendor
	rm composer.lock
	$(COMPOSER) install

## Creation de la BDD 'ddc'
ddc:
	$(SYMFONY_CONSOLE) d:d:c

## Migration des tables avec chargement de fausse données 'dmm'
dmm:
	$(SYMFONY_CONSOLE) d:m:m
	$(SYMFONY_CONSOLE) d:f:l

## Vider le cache 'cc'
cc:
	$(SYMFONY_CONSOLE) c:c

## Vider le cache test
cc-test:
	$(SYMFONY_CONSOLE) c:c --env=test

## Suppression du répertoire cache 'cc-hard'
cc-hard:
	rm -fR var/cache/*

## Réinitialisation de la BDD 'clean-db'
clean-db:
	- $(SYMFONY_CONSOLE) d:d:d --force
	$(SYMFONY_CONSOLE) d:d:c
	$(SYMFONY_CONSOLE) d:m:m --no-interaction
	$(SYMFONY_CONSOLE) d:f:l --no-interaction

## Réinitialisation de la BDD test 'clean-db-test'
clean-db-test: cc-hard cc-test
	- $(SYMFONY_CONSOLE) d:d:d --force --env=test
	$(SYMFONY_CONSOLE) d:d:c --env=test
	$(SYMFONY_CONSOLE) d:m:m --no-interaction --env=test
	$(SYMFONY_CONSOLE) d:f:l --no-interaction --env=test

## —— Tests -------------------------------------------------------------------------------

## Lancement des tests Unitaire 'test-unit'
test-unit:
	$(PHPUNIT) --testsuite Unitaire

## Lancement des tests Intégration 'test-inte'
test-inte:
	$(PHPUNIT) --testsuite Integration

## Lancement des tests Application 'test-app'
test-app:
	$(PHPUNIT) --testsuite Application

## Lancement de tout les tests 'tests'
tests:
	$(PHPUNIT) --testsuite All

## —— NPM --------------------------------------------------------------------------------

## Installation du node modules 'npm-i'
npm-i:
	$(NPM) install

## Mise a jour du node modules 'npm-u'
npm-u:
	$(NPM) update

## Suppression du répertoire node_modules et réinstallation 'clean-node'
clean-node:
	rm -Rf node_modules
	rm package-lock.json
	$(NPM) install

## —— PhpStan -----------------------------------------------------------------------------

## Analyser le ficher src 'stan-src'
stan-src:
	$(PHPSTAN_ANALYSE) src

## Analyser le ficher tests 'stan-test'
stan-test:
	$(PHPSTAN_ANALYSE) tests

## Analyser les fichiers src et tests 'stan-all'
stan-all:
	$(PHPSTAN_ANALYSE) src tests

## —— Php-cs-fixer ------------------------------------------------------------------------

## Clean les fichiers du dossier src 'cs-src'
cs-src:
	$(PHPCSFIXER) fix src

## Clean les fichiers du dossier tests 'cs-test'
cs-test:
	$(PHPCSFIXER) fix tests
## —— Others️ ------------------------------------------------------------------------------

## Liste des commandes 'help'
help:
	@grep -E '(^[a-zA-Z0-9_-]+:.*?##.*$$)|(^##)' $(MAKEFILE_LIST) | awk 'BEGIN {FS = ":.*?## "}{printf "\033[32m%-30s\033[0m %s\n", $$1, $$2}' | sed -e 's/\[32m##/[33m/'
