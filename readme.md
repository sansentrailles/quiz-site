# Quiz сайт - платформа для барных интеллектуальных викторин | 

Проект на базе фреймворка Yii2, упакованный в Docker-окружение для удобной разработки и развертывания.


## 📋 Содержание

- [Требования](#-требования)
- [Быстрый запуск](#-быстрый-запуск)
- [Пошаговый запуск](#-пошаговый-запуск)
- [Команды Makefile](#-команды-makefile)
- [Структура проекта](#-структура-проекта)
- [Доступ к приложению](#-доступ-к-приложению)
- [Решение типичных проблем](#-решение-типичных-проблем)
- [Обновление проекта](#-обновление-проекта)

---

## 🔧 Требования

Перед началом убедитесь, что у вас установлены:

| Компонент | Минимальная версия | Проверка |
|-----------|-------------------|----------|
| Docker | 20.10+ | `docker --version` |
| Docker Compose | 2.0+ | `docker-compose --version` |
| Git | 2.0+ | `git --version` |
| Make | любая | `make --version` |

> 💡 **Для Windows:** если у вас не установлен `make`, вы можете использовать [Chocolatey](https://chocolatey.org/install): `choco install make`, либо выполнять команды вручную (см. раздел "Пошаговый запуск").

---

## 🚀 Быстрый запуск

Самый простой способ запустить проект — выполнить одну команду:

```bash
# 1. Клонируйте репозиторий
git clone https://github.com/your-username/your-project.git
cd your-project

# 2. Запустите полную установку
make reinstall
```

Команда `make reinstall` автоматически выполнит:
- ✅ Остановку старых контейнеров (если есть)
- ✅ Сборку Docker-образов
- ✅ Запуск контейнеров
- ✅ Копирование конфигурационных файлов из примеров
- ✅ Очистку базы данных
- ✅ Установку зависимостей Composer
- ✅ Выполнение всех миграций
- ✅ Инициализацию RBAC и создание пользователя
- ✅ Исправление прав доступа

После завершения откройте в браузере: **[http://localhost:8080](http://localhost:8080)**

---

## 📝 Пошаговый запуск

Если вы предпочитаете выполнять команды вручную или у вас не установлен `make`:

### 1. Клонируйте репозиторий

```bash
git clone https://github.com/your-username/your-project.git
cd your-project
```

### 2. Скопируйте конфигурационные файлы

```bash
cp config/db.example.php config/db.php
cp config/params.example.php config/params.php
cp public_html/index.example.php public_html/index.php
```

> ⚠️ При необходимости отредактируйте `config/db.php` — данные для подключения к БД уже настроены под Docker.

### 3. Запустите контейнеры

```bash
docker-compose up -d --build
```

### 4. Установите зависимости Composer

```bash
docker-compose run --rm php composer install
```

### 5. Выполните миграции

```bash
# Миграции модулей
docker-compose exec php php yii migrate-settings --interactive=0
docker-compose exec php php yii migrate-quests --interactive=0
docker-compose exec php php yii migrate-quiz --interactive=0
docker-compose exec php php yii migrate-seo --interactive=0
```

### 6. Инициализируйте проект

```bash
# Запустите скрипт установки (создание пользователя, инициализация RBAC)
docker-compose exec php bash install.sh

# Исправьте права на папки
docker-compose exec php chown -R www-data:www-data runtime public_html/assets
docker-compose exec php chmod -R 775 runtime public_html/assets
```

### 7. Откройте приложение

Перейдите в браузере: **[http://localhost:8080](http://localhost:8080)**

---

## 🛠 Команды Makefile

Получить список всех доступных команд:

```bash
make help
```

### Основные команды

| Команда | Описание |
|---------|----------|
| `make up` | Запустить контейнеры |
| `make down` | Остановить контейнеры |
| `make restart` | Перезапустить контейнеры |
| `make build` | Пересобрать контейнеры |
| `make status` | Показать статус контейнеров |
| `make reinstall` | Полная переустановка проекта (с нуля) |

### Работа с зависимостями

| Команда | Описание |
|---------|----------|
| `make composer-install` | Установить зависимости Composer |
| `make composer-update` | Обновить зависимости Composer |
| `make init-config` | Скопировать конфигурационные файлы из примеров |

### Работа с миграциями

| Команда | Описание |
|---------|----------|
| `make migrate-all` | Выполнить все миграции |
| `make migrate-settings` | Миграции настроек |
| `make migrate-quests` | Миграции квестов |
| `make migrate-quiz` | Миграции викторин |
| `make migrate-seo` | Миграции SEO |
| `make migrate-user` | Миграции пользователей |
| `make migrate-rbac` | Миграции RBAC |

### Работа с базой данных

| Команда | Описание |
|---------|----------|
| `make db-shell` | Подключиться к MySQL |
| `make db-show-tables` | Показать все таблицы |
| `make drop-tables` | Удалить все таблицы из БД |

### Утилиты

| Команда | Описание |
|---------|----------|
| `make logs` | Просмотр логов всех контейнеров |
| `make logs-php` | Просмотр логов PHP |
| `make logs-nginx` | Просмотр логов Nginx |
| `make shell` | Подключиться к контейнеру PHP |
| `make shell-root` | Подключиться к контейнеру PHP как root |
| `make fix-permissions` | Исправить права на `runtime` и `public_html/assets` |
| `make clear-cache` | Очистить кэш Yii2 |

---

## 📁 Структура проекта

```
your-project/
├── config/
│   ├── db.example.php          # Пример конфигурации БД
│   ├── params.example.php      # Пример параметров
│   └── ...
├── docker/
│   ├── mysql/
│   │   └── drop-all-tables.sql # SQL для очистки БД
│   ├── nginx/
│   │   └── default.conf        # Конфигурация Nginx
│   └── php/
│       └── Dockerfile          # Конфигурация PHP 8.2
├── public_html/
│   ├── index.example.php       # Пример точки входа
│   └── assets/                 # Публичные ассеты
├── runtime/                    # Логи и кэш Yii2
├── docker-compose.yml          # Оркестрация контейнеров
├── Makefile                    # Команды для быстрого запуска
├── install.sh                  # Скрипт установки
├── composer.json               # Зависимости проекта
└── README.md                   # Эта инструкция
```

---

## 🌐 Доступ к приложению

| Сервис | URL / Адрес | Данные |
|--------|-------------|--------|
| **Веб-интерфейс** | http://localhost:8080 | — |
| **База данных** | localhost:3306 | Хост: `db` (внутри Docker) |
| | | Пользователь: `yii2user` |
| | | Пароль: `yii2password` |
| | | База данных: `yii2db` |

---

## ⚠️ Решение типичных проблем

### 1. Ошибка "Port 8080 is already in use"

Порт 8080 занят другим процессом. Измените порт в `docker-compose.yml`:

```yaml
ports:
  - "8081:80"  # Замените 8080 на любой свободный порт
```

Затем перезапустите:
```bash
docker-compose down && docker-compose up -d
```

### 2. Ошибка "500 Internal Server Error" или белая страница

Проблема с правами доступа. Выполните:
```bash
make fix-permissions
```

Или вручную:
```bash
docker-compose exec php chown -R www-data:www-data runtime public_html/assets
docker-compose exec php chmod -R 775 runtime public_html/assets
```

### 3. Ошибка подключения к базе данных (PDOException)

Убедитесь, что в `config/db.php` указан хост `db` (не `localhost` или `127.0.0.1`):

```php
'dsn' => 'mysql:host=db;dbname=yii2db',
```

### 4. Ошибка "composer.lock does not contain a compatible set of packages"

Обновите зависимости:
```bash
make composer-update
```

### 5. Ошибка безопасности Composer (tinymce, dompdf)

Если Composer блокирует установку пакетов из-за уязвимостей, обновите версии в `composer.json`:

```json
"tinymce/tinymce": "^5.10",
"dompdf/dompdf": "^3.0"
```

Затем выполните:
```bash
make composer-update
```

### 6. Ошибка "/bin/bash^M: bad interpreter"

Проблема с окончаниями строк в `install.sh` (если файл редактировался в Windows). Исправьте:

```bash
sed -i -e 's/\r$//' install.sh
```

Или откройте файл в VS Code, переключите окончания строк с **CRLF** на **LF** и сохраните.

### 7. Ошибка при удалении таблиц с внешними ключами

Убедитесь, что существует файл `docker/mysql/drop-all-tables.sql` со следующим содержимым:

```sql
SET FOREIGN_KEY_CHECKS = 0;

SET @tables = NULL;
SELECT GROUP_CONCAT('`', table_schema, '`.`', table_name, '`') INTO @tables
FROM information_schema.tables
WHERE table_schema = 'yii2db';

SELECT IF(@tables IS NOT NULL, 
    CONCAT('DROP TABLE IF EXISTS ', @tables), 
    'SELECT 1'
) INTO @tables;

PREPARE stmt FROM @tables;
EXECUTE stmt;
DEALLOCATE PREPARE stmt;

SET FOREIGN_KEY_CHECKS = 1;
```

### 8. Контейнер не запускается

Посмотрите логи для диагностики:
```bash
make logs
```

Или логи конкретного сервиса:
```bash
make logs-php
make logs-nginx
```

---

## 🔄 Обновление проекта

Если вы обновили код из репозитория:

```bash
# Получите последние изменения
git pull origin main

# Обновите зависимости (если composer.json изменился)
make composer-install

# Выполните новые миграции (если появились)
docker-compose exec php php yii migrate

# Перезапустите контейнеры
make restart
```

---

## 📊 Технические детали

| Компонент | Версия |
|-----------|--------|
| PHP | 8.2 (FPM) |
| MySQL | 8.0 |
| Nginx | Alpine (последняя стабильная) |
| Фреймворк | Yii2 ^2.0 |
| Composer | 2.x |

### Установленные PHP-расширения

- `pdo_mysql` — подключение к MySQL
- `mbstring` — работа с многобайтовыми строками
- `gd` — обработка изображений
- `zip` — работа с ZIP-архивами
- `xml` — обработка XML
- `curl` — HTTP-запросы
- `bcmath` — точные математические вычисления
- `intl` — интернационализация
- `opcache` — кеширование PHP-кода
- `exif` — чтение метаданных изображений

---

## 📚 Полезные ссылки

- [Документация Yii2](https://www.yiiframework.com/doc/guide/2.0/ru)
- [Документация Docker](https://docs.docker.com/)
- [Документация Docker Compose](https://docs.docker.com/compose/)
- [Документация Make](https://www.gnu.org/software/make/manual/)

---

## 🤝 Поддержка

При возникновении проблем:

1. Проверьте логи контейнеров: `make logs`
2. Убедитесь, что все контейнеры запущены: `make status`
3. Проверьте раздел [Решение типичных проблем](#-решение-типичных-проблем)
4. Попробуйте полную переустановку: `make reinstall`

---

## 📄 Лицензия

Проект распространяется под лицензией, указанной в файле `LICENSE`.

---
