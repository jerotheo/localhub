# LocalHub

Multi-vendor marketplace backend (Phase 1) built with Laravel. This repo contains the initial authentication flow, UUID-based models, and basic tables for users, vendors, and categories.

## Docs

- `docs/phase-1.md` (backend scope, architecture, setup, testing)
- `docs/phase-2.md` (frontend scope outline)

## Tech Stack (Phase 1)

- Laravel (framework) + PHP (runtime in Docker)
- MySQL 8.0
- Laravel Sanctum (token auth)
- PHPUnit (tests)
- Docker + Docker Compose
- Postman (manual API checks)

## Phase 1 Summary

Backend MVP with UUID models, token auth, migrations, tests, Docker, and Postman collection. See `docs/phase-1.md` for full details.

## Requirements

- Docker + Docker Compose
- Postman (optional)
- MySQL Workbench (optional)

## Quick Start

1) Copy env template (local folder only):

```
cp localhub.env.example .env
```

2) Start containers:

```
docker compose up -d --build
```

3) Generate app key:

```
docker compose exec app php artisan key:generate
```

4) Run migrations:

```
docker compose exec app php artisan migrate
```

5) (Optional) Seed categories:

```
docker compose exec app php artisan db:seed
```

## API Endpoints

- `POST /api/v1/auth/register`
- `POST /api/v1/auth/login`
- `POST /api/v1/auth/logout` (auth required)
- `GET /api/v1/user/profile` (auth required)

## Quick Checks

- Browser: `http://localhost:8000/`
- Health: `http://localhost:8000/up`
- Tests: `docker compose exec app php artisan test`
