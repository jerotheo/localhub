## LocalHub Phase 1

### Overview

Phase 1 delivers the minimum viable backend:
- Laravel project setup
- Authentication for buyer/vendor/admin (register, login, logout)
- Core tables: users, vendors, categories
- Protected user profile endpoint
- Consistent JSON response envelope and error handling
- Docker + MySQL + Postman collection + tests

### Tech Stack

- Laravel + PHP
- MySQL 8.0
- Laravel Sanctum (token auth)
- PHPUnit (tests)
- Docker + Docker Compose
- Postman (manual checks)

### Architecture (Clean Structure)

**Layers**
- `Controller` -> HTTP input/output only
- `Service` -> business rules
- `Repository` -> database access
- `Model` -> data representation
- `Request` -> validation rules
- `Resource` -> response shape

**Flow (Auth Example)**
```
HTTP Request
└── routes/api.php
    └── Controllers/Auth/AuthController.php
        └── Services/Auth/AuthService.php
            ├── Repositories/UserRepository.php
            │   └── Models/User.php
            ├── Repositories/VendorRepository.php
            │   └── Models/Vendor.php
            └── Token (Sanctum)
                └── Resources/UserResource.php
                    └── JSON Response
```

**Design Rules**
- Controllers stay thin.
- Services hold business logic.
- Repositories are the only place with query logic.
- Validation is always handled by FormRequest classes.
- UUIDs are used for primary keys.

### Auth Flow

1) Register (buyer/vendor) -> create user and vendor if needed -> return token.
2) Login -> validate credentials -> return token.
3) Profile -> requires `Authorization: Bearer {token}`.
4) Logout -> revoke current token.

### API Response Shape

Success:
```json
{
  "success": true,
  "data": {},
  "message": "..."
}
```

Error:
```json
{
  "success": false,
  "message": "Validation failed",
  "errors": {}
}
```

### Project Structure (Phase 1)

- `app/Models` (User, Vendor, Category)
- `app/Repositories` (data access)
- `app/Services` (business logic)
- `app/Http/Controllers` (HTTP layer)
- `app/Http/Requests` (validation)
- `app/Http/Resources` (response shaping)
- `database/migrations` (tables)
- `routes/api.php` (API endpoints)
- `tests/Feature` and `tests/Unit` (tests)
- `postman/LocalHub.postman_collection.json` (Postman)

Structure view:
```
localhub/
├── app/
│   ├── Exceptions/
│   ├── Http/
│   │   ├── Controllers/
│   │   ├── Middleware/
│   │   ├── Requests/
│   │   └── Resources/
│   ├── Models/
│   ├── Providers/
│   ├── Repositories/
│   └── Services/
├── bootstrap/
├── config/
├── database/
│   ├── factories/
│   ├── migrations/
│   └── seeders/
├── docs/
├── postman/
├── routes/
├── storage/
├── tests/
└── docker-compose.yml
```

### Setup (Clean Steps)

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

### API Endpoints

- `POST /api/v1/auth/register`
- `POST /api/v1/auth/login`
- `POST /api/v1/auth/logout` (auth required)
- `GET /api/v1/user/profile` (auth required)

API tree:
```
/api/v1
├── /auth
│   ├── POST /register
│   ├── POST /login
│   └── POST /logout   (auth)
└── /user
    └── GET /profile   (auth)
```

### Database Tables (Phase 1)

```
users
├── id (uuid, pk)
├── name
├── email (unique)
├── password
├── role (buyer|vendor|admin)
├── is_active
└── timestamps

vendors
├── id (uuid, pk)
├── user_id (fk -> users.id)
├── store_name
├── description
├── is_approved
├── status (pending|active|inactive)
└── timestamps

categories
├── id (uuid, pk)
├── name (unique)
├── slug (unique)
├── description
└── timestamps
```

### Postman (Quick Check)

Import `postman/LocalHub.postman_collection.json` and set `base_url` to:
`http://localhost:8000/api/v1`

Suggested sequence:
1) Register -> copy `data.token`
2) Login -> update env `token`
3) Profile -> verify user data
4) Logout

### MySQL Workbench

Connection details (Docker):
- Host: `127.0.0.1`
- Port: `3306`
- Username: `localhub`
- Password: `secret`
- Schema: `localhub`

If `3306` is already in use, change the port mapping in `docker-compose.yml`.

### Testing

Run all tests:
```
docker compose exec app php artisan test
```

### Quick Health Checks

- Browser: `http://localhost:8000/`
- Health: `http://localhost:8000/up`
- API profile: `GET /api/v1/user/profile` (with token)

### Local-Only Rules (Isolation)

Everything is scoped to the `localhub` folder:
- Git repo is initialized only in this folder.
- Docker services are defined only in `localhub/docker-compose.yml`.
- Database and ports are limited to this project.
- Other company projects and Bitbucket repos are not affected.
