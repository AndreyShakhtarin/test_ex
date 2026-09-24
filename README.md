# Laravel Backend API

REST API с CRUD-операциями, связями между сущностями, WebSockets и административной панелью.

## Стек

- **PHP 8.3** + **Laravel 13**
- **PostgreSQL** — основная БД
- **Redis** — кэш и сессии
- **RabbitMQ** — очереди
- **Laravel Reverb** — WebSocket сервер
- **Laravel Echo** + **Pusher JS** — клиент WebSockets
- **FilamentPHP** — административная панель
- **spatie/laravel-data** — DTO объекты
- **spatie/laravel-route-attributes** — маршруты через PHP-атрибуты
- **laravel-request-docs** — документация API

## Архитектура

```
app/
├── Data/           # DTO (spatie/laravel-data)
├── Enums/          # Перечисления
├── Events/         # События для WebSocket broadcasting
├── Filament/       # Ресурсы админ-панели
├── Http/
│   └── Controllers/
│       ├── Api/    # Single-action API контроллеры
│       └── Web/    # Web контроллеры
├── Models/         # Eloquent модели
├── Repositories/   # Слой доступа к данным
└── Services/       # Бизнес-логика
```

## Связи между сущностями

| Связь | Описание |
|-------|----------|
| User → Profile | Один к одному (1:1) |
| Category → Products | Один ко многим (1:M) |
| Product → Category | Многие к одному (M:1) |
| Product ↔ Tags | Многие ко многим (M:M) |

---

## Локальный запуск (Laravel Sail)

### Требования

- Docker Desktop

### Установка

```bash
# 1. Клонировать репозиторий
git clone git@github.com:AndreyShakhtarin/test_ex.git
cd test_ex

# 2. Создать .env
cp .env.example .env

# 3. Установить зависимости через Sail
docker run --rm -u "$(id -u):$(id -g)" \
    -v "$(pwd):/var/www/html" \
    -w /var/www/html \
    laravelsail/php83-composer:latest \
    composer install --ignore-platform-reqs

# 4. Поднять контейнеры
./vendor/bin/sail up -d

# 5. Сгенерировать ключ приложения
./vendor/bin/sail artisan key:generate

# 6. Запустить миграции и сидеры
./vendor/bin/sail artisan migrate --seed

# 7. Установить npm зависимости и собрать фронтенд
./vendor/bin/sail npm install
./vendor/bin/sail npm run build

# 8. Запустить Reverb WebSocket сервер (в отдельном терминале)
./vendor/bin/sail artisan reverb:start

# 9. Запустить обработчик очередей (в отдельном терминале)
./vendor/bin/sail artisan queue:work
```

### Доступ

| Сервис | URL |
|--------|-----|
| Приложение | http://localhost |
| Демо-страница | http://localhost/demo |
| Админ-панель | http://localhost/admin |
| API Документация | http://localhost/request-docs |
| RabbitMQ Management | http://localhost:15672 |

**Данные для входа в админ-панель:**
- Email: `admin@example.com`
- Password: `password`

---

## Тесты

```bash
# Все тесты (внутри Sail)
./vendor/bin/sail artisan test

# Unit тесты (без БД, запускаются локально)
php artisan test --testsuite=Unit

# С детальным выводом
./vendor/bin/sail artisan test --verbose
```

---

## API Endpoints

Полная документация доступна на `/request-docs`.

### Users
| Метод | URL | Описание |
|-------|-----|----------|
| GET | `/api/users` | Список пользователей |
| POST | `/api/users` | Создать пользователя |
| GET | `/api/users/{id}` | Получить пользователя |
| PUT | `/api/users/{id}` | Обновить пользователя |
| DELETE | `/api/users/{id}` | Удалить пользователя |

### Categories
| Метод | URL | Описание |
|-------|-----|----------|
| GET | `/api/categories` | Список категорий |
| POST | `/api/categories` | Создать категорию |
| GET | `/api/categories/{id}` | Получить категорию |
| PUT | `/api/categories/{id}` | Обновить категорию |
| DELETE | `/api/categories/{id}` | Удалить категорию |

### Products
| Метод | URL | Описание |
|-------|-----|----------|
| GET | `/api/products` | Список товаров |
| POST | `/api/products` | Создать товар |
| GET | `/api/products/{id}` | Получить товар |
| PUT | `/api/products/{id}` | Обновить товар |
| DELETE | `/api/products/{id}` | Удалить товар |

### Tags
| Метод | URL | Описание |
|-------|-----|----------|
| GET | `/api/tags` | Список тегов |
| POST | `/api/tags` | Создать тег |
| GET | `/api/tags/{id}` | Получить тег |
| PUT | `/api/tags/{id}` | Обновить тег |
| DELETE | `/api/tags/{id}` | Удалить тег |

---

## WebSockets

При любой CRUD-операции автоматически отправляется событие в канал `entities`.

| Событие | Описание |
|---------|----------|
| `entity.created` | Сущность создана |
| `entity.updated` | Сущность обновлена |
| `entity.deleted` | Сущность удалена |

Демонстрация в реальном времени — на странице `/demo`.

---

## Деплой на Railway

### Шаги

1. Создать новый проект → **GitHub Repository** → `AndreyShakhtarin/test_ex`
2. **+ New → Database → PostgreSQL**
3. **+ New → Database → Redis**
4. **+ New → Docker Image → `rabbitmq:3-management-alpine`**
5. В сервисе приложения добавить переменные окружения:

```env
APP_KEY=               # php artisan key:generate --show
APP_ENV=production
APP_DEBUG=false
APP_URL=               # URL выданный Railway

DB_CONNECTION=pgsql
DB_HOST=               # из Railway PostgreSQL переменных
DB_PORT=5432
DB_DATABASE=           # из Railway PostgreSQL переменных
DB_USERNAME=           # из Railway PostgreSQL переменных
DB_PASSWORD=           # из Railway PostgreSQL переменных

REDIS_HOST=            # из Railway Redis
REDIS_PORT=6379

RABBITMQ_HOST=         # из Railway RabbitMQ
RABBITMQ_PORT=5672
RABBITMQ_USER=guest
RABBITMQ_PASSWORD=guest
RABBITMQ_VHOST=/

BROADCAST_CONNECTION=reverb
QUEUE_CONNECTION=rabbitmq
CACHE_STORE=redis
SESSION_DRIVER=database

REVERB_APP_ID=755289
REVERB_APP_KEY=cxlqav5hmkaaibztf1pe
REVERB_APP_SECRET=2adje3pw1ddgitofxthv
REVERB_HOST=           # ваш домен на Railway
REVERB_PORT=8080
REVERB_SCHEME=https

VITE_REVERB_APP_KEY=cxlqav5hmkaaibztf1pe
VITE_REVERB_HOST=      # ваш домен на Railway
VITE_REVERB_PORT=8080
VITE_REVERB_SCHEME=https
```

Railway автоматически запустит деплой из `Dockerfile`.

---

## Административная панель

FilamentPHP доступна по адресу `/admin`.

Управление сущностями: **Users · Categories · Products · Tags**

Администратор создаётся автоматически при первом `db:seed`:
- Email: `admin@example.com`
- Password: `password`
