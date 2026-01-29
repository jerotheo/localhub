## LocalHub Style Guide

This document defines naming conventions and formatting rules for LocalHub.
Follow these rules for all new code.

## General Conventions

- Use English names for all identifiers.
- Prefer clarity over cleverness.
- Keep functions small and focused.
- One class per file.
- Use strict typing with explicit return types.

## PHP / Laravel

### Classes and Files

- Classes: `PascalCase` (e.g., `AuthService`, `UserController`)
- File names match class names (e.g., `AuthService.php`)
- Interfaces: `PascalCase` with `Interface` suffix (e.g., `UserRepositoryInterface`)
- Traits: `PascalCase`

### Methods and Variables

- Methods: `camelCase` (e.g., `createToken`, `findByEmail`)
- Variables: `camelCase` (e.g., `$userId`, `$storeName`)
- Boolean methods start with `is`, `has`, `can`, `should` (e.g., `isActive`)

### Constants

- Constants: `SCREAMING_SNAKE_CASE` (e.g., `MAX_RETRY_COUNT`)

### Database Naming

- Tables: `snake_case` plural (e.g., `users`, `vendor_profiles`)
- Columns: `snake_case` (e.g., `store_name`, `is_active`)
- Foreign keys: `{table}_id` (e.g., `user_id`)
- Pivot tables: alphabetical order, `snake_case` (e.g., `category_vendor`)

### Migrations

- File name: use Laravel defaults (`YYYY_MM_DD_HHMMSS_*` or `0001_01_01_*`)
- Class name matches Laravel default (auto-generated)
- Use `create_*_table` for new tables, `add_*_to_*_table` for new columns

### API and Routes

- Versioned prefix: `/api/v1`
- Resources: plural nouns (e.g., `/users`, `/vendors`)
- Allow `/user/profile` for the current authenticated user
- Actions: use verbs only for auth or non-CRUD endpoints (e.g., `/auth/login`)
- Use `kebab-case` only if required by external API; otherwise keep plain paths

### Formatting

- Braces on new lines:
```
if ($condition) {
    // code
}
```

- Function and class format:
```
public function doSomething(string $value): bool
{
    return $value !== '';
}
```

## JavaScript / React (Phase 2)

### Files and Components

- Components: `PascalCase` (e.g., `UserCard.tsx`)
- Hooks: `useCamelCase` (e.g., `useAuth`)
- Utilities: `camelCase` file names (e.g., `formatDate.ts`)

### Variables and Functions

- Variables: `camelCase`
- Functions: `camelCase`
- Constants: `SCREAMING_SNAKE_CASE`

### API Client

- API functions: `camelCase` (e.g., `loginUser`, `fetchProfile`)
- Endpoint constants: `SCREAMING_SNAKE_CASE`

## Response and DTO Naming

- Resource classes: `PascalCase` (e.g., `UserResource`)
- Request classes: `PascalCase` with suffix `Request`
- Service classes: `PascalCase` with suffix `Service`

## Common Mistakes to Avoid

- Mixing snake_case and camelCase in PHP method names
- Using singular table names
- Putting queries inside controllers
- Returning raw models without Resources
- Adding business logic inside FormRequest or Controllers

## Summary (Quick Rules)

- **Classes**: PascalCase
- **Methods/variables**: camelCase
- **Constants**: SCREAMING_SNAKE_CASE
- **Tables/columns**: snake_case
- **Routes**: plural nouns, versioned under `/api/v1`
