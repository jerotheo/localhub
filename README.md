# LocalHub

Multi-vendor marketplace backend (Phase 1) built with Laravel. This repo contains the initial authentication flow, UUID-based models, and basic tables for users, vendors, and categories.

## Requirements

- Docker + Docker Compose
- Postman (optional)

## Quick Start

1) Copy env template:

```
cp localhub.env.example .env
```

2) Start containers:

```
docker compose up -d --build
```

3) Run migrations:

```
docker compose exec app php artisan migrate
```

4) (Optional) Seed categories:

```
docker compose exec app php artisan db:seed
```

## API Endpoints

- `POST /api/v1/auth/register`
- `POST /api/v1/auth/login`
- `POST /api/v1/auth/logout` (auth required)
- `GET /api/v1/user/profile` (auth required)

## Postman

Import `postman/LocalHub.postman_collection.json` and set `base_url` to:
`http://localhost:8000/api/v1`
