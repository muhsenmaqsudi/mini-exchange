# Docker service names for Laravel, Redis, and Postgres
APP_CONTAINER=app
REDIS_CONTAINER=redis
POSTGRES_CONTAINER=postgres

# Default target
.DEFAULT_GOAL := help

# -------------------------
# 🍃 Laravel Commands
# -------------------------

art: ## Run Laravel Artisan command
	@docker compose exec $(APP_CONTAINER) php artisan

migrate: ## Run Laravel migrations
	@docker compose exec $(APP_CONTAINER) php artisan migrate

seed: ## Run database seeders
	@docker compose exec $(APP_CONTAINER) php artisan db:seed

tinker: ## Open Laravel Tinker
	@docker compose exec $(APP_CONTAINER) php artisan tinker

queue: ## Start Laravel queue worker
	@docker compose exec $(APP_CONTAINER) php artisan queue:work

optimize: ## Optimize Laravel
	@docker compose exec $(APP_CONTAINER) php artisan optimize

cache-clear: ## Clear config, route, view, cache
	@docker compose exec $(APP_CONTAINER) php artisan config:clear
	@docker compose exec $(APP_CONTAINER) php artisan route:clear
	@docker compose exec $(APP_CONTAINER) php artisan view:clear
	@docker compose exec $(APP_CONTAINER) php artisan cache:clear

# -------------------------
# 🐘 PHP Commands
# -------------------------

php: ## Run a PHP script inside container
	@docker compose exec $(APP_CONTAINER) php $(ARGS)

composer: ## Run composer in app container
	@docker compose exec $(APP_CONTAINER) composer $(ARGS)

dump-autoload: ## Run composer dump-autoload
	@docker compose exec $(APP_CONTAINER) composer dump-autoload

bash: ## Bash into the app container
	@docker compose exec $(APP_CONTAINER) bash

logs: ## Show container logs
	@docker compose logs -f $(APP_CONTAINER)

# -------------------------
# 🧑‍💻 Redis Commands
# -------------------------

redis-cli: ## Connect to Redis using redis-cli
	@docker compose exec $(REDIS_CONTAINER) redis-cli

# -------------------------
# 🍇 Postgres Commands
# -------------------------

psql: ## Connect to Postgres using psql
	@docker compose exec $(POSTGRES_CONTAINER) psql -U laravel

# -------------------------
# 🛠️ Dev Helpers
# -------------------------

up: ## Start containers
	@docker compose up -d

down: ## Stop containers
	@docker compose down

restart: ## Restart app container
	@docker compose restart $(APP_CONTAINER)

build: ## Build Docker containers
	@docker compose build

# -------------------------
# 📘 Help
# -------------------------

help: ## Show this help message
	@echo "Available commands:"
	@grep -E '^[a-zA-Z_-]+:.*?## .*$$' $(MAKEFILE_LIST) | awk 'BEGIN {FS = ":.*?## "}; {printf "  \033[36m%-18s\033[0m %s\n", $$1, $$2}'