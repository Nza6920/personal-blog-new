# Migration Plan (Laravel 12.11.1)

## Goals
- Move the current Laravel 5.5 codebase into the Laravel 12.11.1 skeleton in `personal-blog-new`.
- Keep behavior consistent while updating deprecated APIs and packages.
- Establish a stable, repeatable local dev environment.

## Phases
1. Use the existing Laravel 12.11.1 scaffold in `personal-blog-new/`.
2. Port core PHP code: routes, controllers, models, requests, observers, helpers.
3. Migrate database layer: migrations, seeders, factories (class-based).
4. Update dependencies: replace/remove deprecated packages, align with PHP 8.2+.
5. Migrate views and assets; decide on Vite vs. keeping Mix.
6. Validate features: manual checks + tests.

## Key Files to Update
- `routes/web.php`
- `app/Http/Controllers/*`
- `app/Models/*`, `app/Models/Traits/*`
- `app/Observers/*`
- `app/Handlers/*`
- `bootstrap/helpers.php`
- `database/migrations/*`, `database/seeders/*`, `database/factories/*`
- `resources/views/*`, `resources/assets/*`

## Known API Changes
- `str_limit()` -> `Str::limit()`
- `str_random()` -> `Str::random()`
- `$dates` -> `$casts`
- `fideloper/proxy` removed (Laravel 12 has built-in proxies)

## Dependencies to Review
- `mews/purifier`
- `overtrue/laravel-lang`
- `vinkla/hashids`

## Environment Notes
- PHP 8.2+ required for Laravel 12.
- MySQL and Docker compose are available for local dev.
