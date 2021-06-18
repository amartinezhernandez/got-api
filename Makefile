.PHONY: all test

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
	docker exec -it -w /app skeleton_web_1 /bin/sh
php: ## Access PHP1 bash
	docker exec -it -w /app skeleton_php_1 /bin/sh
