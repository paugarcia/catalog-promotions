DOCKER_COMPOSE := docker compose
PHP_SERVICE := php-fpm

.DEFAULT_GOAL := help

.PHONY: help
help: ## Show the available commands
	@echo Available commands:
	@echo   make up     - Build and start the project
	@echo   make down   - Stop the project
	@echo   make test   - Run the test suite

.PHONY: up down test
up: ## Build and start the project
	@$(DOCKER_COMPOSE) up -d --build --remove-orphans

down: ## Stop the project
	@$(DOCKER_COMPOSE) down

test: ## Run the test suite
	@$(DOCKER_COMPOSE) exec $(PHP_SERVICE) vendor/bin/phpunit --testdox
