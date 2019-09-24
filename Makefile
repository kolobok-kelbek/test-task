.ONESHELL:
SHELL = /bin/bash

default: start

.PHONY: help
help: ## Show this help message
	@grep -E '^[a-zA-Z_-]+:.*?## .*$$' $(MAKEFILE_LIST) | sort | awk 'BEGIN {FS = ":.*?## "}; {printf "\033[36m%-30s\033[0m %s\n", $$1, $$2}'

.PHONY: start
start:  ## Start docker containers
	@docker-compose up -d --remove-orphans
	@sleep 5s
	@docker-compose exec php composer install

.PHONY: stop
stop:  ## Stop docker containers
	@docker-compose down -v

.PHONY: test
test:  ## Run tests
	@docker-compose exec php ./vendor/bin/phpunit

.PHONY: run
run:  ## Run search command
	@docker-compose exec php ./app/console search /app/resources/${filename} ${searchText}
