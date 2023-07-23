COMPOSE=docker-compose -p test -f ./docker/docker-compose.yml

up:
	$(COMPOSE) up -d

down:
	$(COMPOSE) down

enter-php:
	$(COMPOSE) exec php bash

csfixer:
	$(COMPOSE) exec php vendor/bin/php-cs-fixer fix src

phpstan:
	$(COMPOSE) exec php php -d memory_limit=-1 vendor/bin/phpstan analyse src -l 6
