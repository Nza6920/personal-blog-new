# Repository Guidelines

## Project Structure & Module Organization
This is a Laravel 12 app with Vite assets.
- `app/` contains application code (controllers, models, policies).
- `routes/` defines HTTP and console routes (`web.php`, `api.php`).
- `resources/` holds Blade views, JS, and CSS sources.
- `public/` is the web root for built assets and entry points.
- `config/` stores environment-driven configuration.
- `database/` includes migrations, factories, and seeders.
- `tests/` contains `Feature/` and `Unit/` tests.
- `storage/` is for logs, compiled views, and local uploads.

## Build, Test, and Development Commands
- `composer run setup` installs PHP/JS deps, creates `.env`, generates key, runs migrations, and builds assets.
- `composer run dev` starts the app server, queue listener, log tailer, and Vite dev server via `concurrently`.
- `composer run test` clears config cache then runs the Laravel test runner.
- `npm run dev` runs the Vite dev server only.
- `npm run build` builds production assets.
- `docker compose up -d` starts the local MySQL container from `docker-compose.yml`.

## Coding Style & Naming Conventions
- Indentation: 4 spaces (see `.editorconfig`).
- Line endings: LF; final newline required.
- PHP style: follow Laravel conventions; keep class names in StudlyCase and files in PSR-4 paths (e.g., `App/Http/Controllers`).
- Blade: use kebab-case view files (e.g., `resources/views/blog/index.blade.php`).
- Formatting: use `php artisan pint` if you add/modify PHP code.

## Testing Guidelines
- Framework: PHPUnit (`phpunit.xml` defines `tests/Unit` and `tests/Feature`).
- Naming: `*Test.php` classes in matching folders, mirroring the code under `app/`.
- Default DB: in-memory SQLite for tests; keep migrations compatible with SQLite.

## Commit & Pull Request Guidelines
- Commit messages currently have no enforced convention (last seen: "upgrade success"). Prefer short, imperative summaries (e.g., "add post editor validation").
- PRs should include a concise description, test notes (commands run), and screenshots for UI changes.
- Link related issues or tasks when applicable.

## Security & Configuration Tips
- Copy `.env.example` to `.env` and set app secrets locally; never commit real credentials.
- Database defaults for Docker are in `docker-compose.yml`; align `.env` values accordingly.
