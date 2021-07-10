.PHONY: all test

USER_ID:=$(shell id -u)

COMMAND_COLOR := $(shell tput -Txterm setaf 2)
HELP_COLOR := $(shell tput -Txterm setaf 4)
RESET := $(shell tput -Txterm sgr0)
CYAN := $(shell tput -Txterm setaf 6)

help: ## Listar comandos disponibles en este Makefile
	@echo "╔══════════════════════════════════════════════════════════════════════════════╗"
	@echo "║                           ${CYAN}.:${RESET} AVAILABLE COMMANDS ${CYAN}:.${RESET}                           ║"
	@echo "╚══════════════════════════════════════════════════════════════════════════════╝"
	@echo ""
	@grep -E '^[a-zA-Z_0-9%-]+:.*?## .*$$' $(MAKEFILE_LIST) | sort | awk 'BEGIN {FS = ":.*?## "}; {printf "${COMMAND_COLOR}%-40s${RESET} ${HELP_COLOR}%s${RESET}\n", $$1, $$2}'
	@echo ""

up: ## Docker up
	docker-compose up
down: ## Docker down
	docker-compose down
build: ## Builds docker
	docker-compose build
nginx: ## Access nginx bash
	docker exec -it -w /app got_api_web_1 /bin/sh
php: ## Access PHP bash
	docker exec -it -w /app got_api_php_1 /bin/sh
composer-install: ## Installs composer dependencies
	docker exec -it got_api_php_1 /bin/sh -c "cd /app && composer install"
migration-run: ## Executes DB migrations
	docker exec -it got_api_php_1 /bin/sh -c "cd /app && /app/vendor/bin/phinx migrate"
migration: ## Creates a new DB migration
	docker exec -it got_api_php_1 /bin/sh -c "cd /app && /app/vendor/bin/phinx create ${NAME} && chown ${USER_ID}:${USER_ID} /app/migrations/*"
seed: ## Creates a new seeder
	docker exec -it got_api_php_1 /bin/sh -c "cd /app && /app/vendor/bin/phinx seed:create ${NAME} && chown ${USER_ID}:${USER_ID} /app/seeds/*"
seed-run: ## Executes DB seeders
	docker exec -it got_api_php_1 /bin/sh -c "cd /app && /app/vendor/bin/phinx seed:run"
