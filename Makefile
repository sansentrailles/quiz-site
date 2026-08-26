.PHONY: help up down restart logs composer install migrate migrate-all shell db test

# Цвета для вывода
GREEN  := \033[0;32m
NC     := \033[0m # No Color

# Помощь
help: ## Показать эту справку
	@echo ""
	@echo "$(GREEN)Доступные команды:$(NC)"
	@grep -E '^[a-zA-Z_-]+:.*?## .*$$' $(MAKEFILE_LIST) | sort | awk 'BEGIN {FS = ":.*?## "}; {printf "$(GREEN)%-20s$(NC) %s\n", $$1, $$2}'
	@echo ""

# Запуск всех контейнеров
up: ## Запустить все контейнеры
	docker-compose up -d

# Остановка всех контейнеров
down: ## Остановить все контейнеры
	docker-compose down

# Перезапуск контейнеров
restart: ## Перезапустить все контейнеры
	docker-compose restart

# Просмотр логов
logs: ## Просмотр логов всех контейнеров
	docker-compose logs -f

logs-php: ## Просмотр логов PHP
	docker-compose logs -f php

logs-nginx: ## Просмотр логов Nginx
	docker-compose logs -f nginx

# Установка зависимостей Composer
composer-install: ## Установить зависимости Composer
	docker-compose run --rm php composer install

composer-update: ## Обновить зависимости Composer
	docker-compose run --rm php composer update --with-all-dependencies

# Миграции
migrate-user: ## Выполнить миграции пользователей
	docker-compose exec php php yii migrate-user --interactive=0

migrate-rbac: ## Выполнить миграции RBAC
	docker-compose exec php php yii migrate-rbac --interactive=0

migrate-settings: ## Выполнить миграции настроек
	docker-compose exec php php yii migrate-settings --interactive=0

migrate-quests: ## Выполнить миграции квестов
	docker-compose exec php php yii migrate-quests --interactive=0

migrate-quiz: ## Выполнить миграции викторин
	docker-compose exec php php yii migrate-quiz --interactive=0

migrate-seo: ## Выполнить миграции SEO
	docker-compose exec php php yii migrate-seo --interactive=0

migrate-all: ## Выполнить все миграции
	@echo "$(GREEN)Выполнение всех миграций...$(NC)"
	docker-compose exec php php yii migrate-settings --interactive=0
	docker-compose exec php php yii migrate-quests --interactive=0
	docker-compose exec php php yii migrate-quiz --interactive=0
	docker-compose exec php php yii migrate-seo --interactive=0
	docker-compose exec php php yii migrate-user --interactive=0
	docker-compose exec php php yii migrate-rbac --interactive=0
	@echo "$(GREEN)Все миграции выполнены!$(NC)"

# Установка проекта (полная инициализация)
install: ## Полная установка проекта (миграции + создание пользователя)
	@echo "$(GREEN)Запуск полной установки проекта...$(NC)"
	docker-compose exec php bash install.sh

# Подключение к контейнеру
shell: ## Подключиться к контейнеру PHP
	docker-compose exec php bash

shell-root: ## Подключиться к контейнеру PHP как root
	docker-compose exec -u root php bash

# Работа с базой данных
db-shell: ## Подключиться к MySQL
	docker-compose exec db mysql -u yii2user -pyii2password yii2db

db-show-tables: ## Показать все таблицы в базе данных
	docker-compose exec db mysql -u yii2user -pyii2password yii2db -e "SHOW TABLES;"

# Права доступа
fix-permissions: ## Исправить права на папки runtime и assets
	docker-compose exec php chown -R www-data:www-data /var/www/runtime /var/www/web/assets
	docker-compose exec php chmod -R 775 /var/www/runtime /var/www/web/assets
	@echo "$(GREEN)Права исправлены!$(NC)"

# Очистка
clear-cache: ## Очистить кэш Yii2
	docker-compose exec php php yii cache/flush-all
	@echo "$(GREEN)Кэш очищен!$(NC)"

# Сборка контейнеров
build: ## Пересобрать контейнеры
	docker-compose up -d --build

# Статус контейнеров
status: ## Показать статус контейнеров
	docker-compose ps

# Запуск тестов (если есть)
test: ## Запустить тесты
	docker-compose exec php php vendor/bin/codecept run

# Полная переустановка проекта (с нуля)
reinstall: down build up composer-install migrate-all install ## Полная переустановка проекта
	@echo "$(GREEN)Проект полностью переустановлен!$(NC)"