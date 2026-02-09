# AGENTS Guide

Agent-focused conventions for this repository. Keep changes small, consistent, and verifiable.

## Stack Snapshot
- Backend: Laravel 12, PHP 8.2, PHPUnit 11.
- Frontend tooling: Vite 7, Tailwind CSS 4, Alpine.js.
- UI: Blade views with Livewire 4 and Flux available.
- App autoload: `App\\` -> `app/` (PSR-4 via `composer.json`).

## Project Structure
- `app/`: controllers, models, actions, handlers, observers, requests.
- `routes/web.php`: web routes and middleware groups.
- `routes/console.php`: console routes.
- `resources/views/`: Blade templates.
- `resources/js/`, `resources/css/`: Vite entry assets.
- `database/`: migrations, factories, seeders.
- `tests/Feature`, `tests/Unit`, `tests/TestCase.php`.

## Repository-Specific Notes
- Existing app code is mostly controller + action based; preserve that split.
- Route naming is already established (`home.show`, `admin.*`, `topics.show`). Reuse names.
- This repository currently defines web routes in `routes/web.php`; avoid adding `routes/api.php` unless required.
- Ignore generated files in `storage/framework/views/` when searching or editing.
- Some legacy files and comments include non-English text; preserve user-facing wording unless asked to localize.
- Keep helper usage compatible with `bootstrap/helpers.php` (`route_class`, `make_excerpt`, `clean`).
- Model relationship examples exist in `app/Models/User.php` and `app/Models/Topic.php`; follow their style.

## Setup and Local Development
- Install and bootstrap: `composer run setup`.
  - Runs install, `.env` creation, app key generation, migration, npm install, build.
- Full dev loop: `composer run dev`.
  - Starts `php artisan serve`, queue listener, log tail (`pail`), and Vite in parallel.
- Frontend only: `npm run dev`.
- Production assets: `npm run build`.
- Optional DB container: `docker compose up -d`.

## Build / Lint / Test Commands

### Primary commands
- Run tests (preferred): `composer run test`.
- Run tests directly: `php artisan test`.
- Format PHP: `php artisan pint`.

### Run a single test (important)
- Single file: `php artisan test tests/Feature/ExampleTest.php`.
- Single class by filter: `php artisan test --filter ExampleTest`.
- Single method by filter:
  - `php artisan test --filter test_the_application_returns_a_successful_response`
  - or `php artisan test --filter "ExampleTest::test_the_application_returns_a_successful_response"`
- Specific suite from phpunit config:
  - `php artisan test --testsuite=Feature`
  - `php artisan test --testsuite=Unit`

### PHPUnit alternatives
- Direct PHPUnit file run: `vendor/bin/phpunit tests/Feature/ExampleTest.php`.
- Direct PHPUnit filter: `vendor/bin/phpunit --filter ExampleTest`.

### Test environment notes
- `phpunit.xml` sets `APP_ENV=testing`.
- Tests use in-memory SQLite (`DB_CONNECTION=sqlite`, `DB_DATABASE=:memory:`).

## Coding Style and Formatting

### Baseline formatting
- Respect `.editorconfig`:
  - 4 spaces for indentation.
  - LF line endings.
  - final newline required.
  - trim trailing whitespace (except Markdown).
- Run `php artisan pint` after PHP edits.

### PHP style
- Follow Laravel conventions and PSR-4 paths.
- Prefer explicit imports (`use ...`) over fully-qualified names in method bodies.
- Keep one class per file; class names in StudlyCase.
- Methods and variables in camelCase.
- Prefer early returns for guard clauses.

### Types and signatures
- Add return types where practical on new/modified methods.
- Keep argument and return contracts clear for service/action classes.
- Do not suppress type problems with `@ts-ignore`-like equivalents or `mixed` overuse.

### Imports ordering
- Group imports by domain with stable ordering:
  1) framework/vendor imports
  2) app imports (`App\\...`)
- Keep imports alphabetized inside groups.

### Naming conventions
- Controllers: plural resource style where fitting (`TopicsController`).
- Request objects: `*Request` and place under `app/Http/Requests`.
- Action classes: verb-first names under `app/Actions/*` (`CreateTopic`, `LoginUser`).
- Models: singular StudlyCase under `app/Models`.
- Blade views: kebab-case file names when creating new templates.
- Tests: `*Test.php` mirroring app domain structure where possible.

## Validation, Errors, and Control Flow
- Prefer Form Request classes for non-trivial validation.
- For simple controller-only cases, `$request->validate([...])` is acceptable.
- Return user-facing failures with clear flash messages.
- Do not swallow exceptions silently.
- Avoid empty catch blocks; either handle meaningfully or let Laravel report.
- Keep controllers thin; move business logic into `app/Actions/*` when complexity grows.

## Routes and HTTP Layer
- Define routes in `routes/web.php` using named routes.
- Use middleware groups (`auth`, `guest`) and prefixes for admin areas.
- Keep route definitions readable; prefer controller methods over closure-heavy routes.

## Views and Frontend
- Keep Blade mostly presentational; avoid embedding heavy logic.
- Prefer Livewire + Flux for interactive UI over ad-hoc JS.
- Use small, focused JS in `resources/js` for unavoidable client-only behavior.
- Vite inputs are `resources/css/app.css` and `resources/js/app.js`.
- For frontend changes, always evaluate i18n impact: avoid hardcoded user-facing text in views/components/JS, prefer translation keys, and update locale files (`lang/en`, `lang/zh_CN`) in the same change.

## Testing Guidelines
- Feature tests cover HTTP behavior, auth, middleware, and responses.
- Unit tests focus on isolated domain logic.
- When adding DB tests, keep SQLite compatibility in mind.
- Name tests descriptively with `test_...` methods or PHPUnit attributes if introduced.

## Git and Change Scope
- Prefer minimal patches over broad refactors for bug fixes.
- Do not rewrite unrelated files in the same change.
- Keep commits focused and imperative when asked to commit.

## Agent Workflow Expectations
- Before coding, inspect nearby patterns in `app/`, `routes/`, and `tests/`.
- After coding, run relevant tests and `php artisan pint`.
- Report exactly what was run and what passed/failed.

## Cursor / Copilot Rules
- No `.cursor/rules/` directory found.
- No `.cursorrules` file found.
- No `.github/copilot-instructions.md` file found.
- If these are added later, treat them as authoritative supplements to this guide.

## Practical Defaults for Agents
- Default test command after backend edits: `composer run test`.
- Default quick check after PHP edits: `php artisan pint`.
- For one failing test, iterate with `php artisan test --filter ...` until green.
- If conventions conflict, follow existing local file patterns first, then this guide.
