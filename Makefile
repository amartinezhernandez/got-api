.PHONY: all test

USER_ID:=$(shell id -u)

COMMAND_COLOR := $(shell tput -Txterm setaf 2)
HELP_COLOR := $(shell tput -Txterm setaf 4)
RESET := $(shell tput -Txterm sgr0)
CYAN := $(shell tput -Txterm setaf 6)

help: ## List available commands
	@echo "╔══════════════════════════════════════════════════════════════════════════════╗"
	@echo "║                           ${CYAN}.:${RESET} AVAILABLE COMMANDS ${CYAN}:.${RESET}                           ║"
	@echo "╚══════════════════════════════════════════════════════════════════════════════╝"
	@echo ""
	@grep -E '^[a-zA-Z_0-9%-]+:.*?## .*$$' $(MAKEFILE_LIST) | sort | awk 'BEGIN {FS = ":.*?## "}; {printf "${COMMAND_COLOR}%-40s${RESET} ${HELP_COLOR}%s${RESET}\n", $$1, $$2}'
	@echo ""

up: ## Docker up
	docker-compose up
up-d: ## Docker up detached
	docker-compose up -d
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
install: ## Installs the Api
	@echo "\e[32mBuilding docker images\e[39m\n"
	@make build
	@echo "\e[32mInstalling composer dependencies...\e[39m\n"
	@make composer-install
	@echo "\e[32mBuilding database...\e[39m\n"
	@make migration-run
	@echo "\e[32mSeeding data to the database...\e[39m\n"
	@make seed-run
	@echo "\e[32mRebooting containers...\e[39m\n"
	@make down
	@make up-d
	@echo "\e[32mAll done! You can now check the database of GOT Characters :)\e[39m\n"



