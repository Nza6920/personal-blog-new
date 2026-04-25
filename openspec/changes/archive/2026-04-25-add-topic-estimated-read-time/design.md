## Context

Topics are persisted through `App\Actions\Topics\CreateTopic` and `UpdateTopic`, while `App\Observers\TopicObserver` already normalizes body-derived data during `saving` by cleaning the body and generating the excerpt. The home page renders article card metadata in `resources/views/home.blade.php`, where the publish date currently appears as a single inline element above the title.

This change adds a nullable, derived `estimated_read_time` value to the `topics` table and exposes it on the home card. Because the value is derived from body content rather than manual editor input, the implementation should recalculate it automatically wherever a topic is saved. The same home page update also reduces the article list page size to 6 items so the denser card presentation remains easier to scan.

## Goals / Non-Goals

**Goals:**
- Persist a nullable `estimated_read_time` integer on topics.
- Recalculate the value automatically on topic create and update based on the current topic body content.
- Keep the calculation logic centralized so all save paths remain consistent.
- Extend the home article card metadata row to show estimated read time to the right of the date with matching styling.
- Reduce the home page topic list pagination size from 10 items to 6 items.

**Non-Goals:**
- Add a manual admin form field for editing read time.
- Display estimated read time on the topic detail page, feeds, sitemap output, or admin topic list.
- Introduce user-configurable reading-speed preferences or locale-specific pluralization rules beyond the existing translation approach.

## Decisions

- Add a nullable `estimated_read_time` column to `topics`.
  - Rationale: the field needs to be queryable and renderable without recalculating in every read path, while remaining optional for legacy rows and exceptional content.
  - Alternative considered: compute read time on the fly in Blade or controllers. That would duplicate logic and make consistency dependent on every render path.

- Calculate read time in `TopicObserver::saving`.
  - Rationale: this observer already owns body-derived normalization (`clean` and `make_excerpt`), so read-time derivation fits the existing lifecycle and automatically covers both create and update flows.
  - Alternative considered: calculate separately inside `CreateTopic` and `UpdateTopic`. That would duplicate the logic and make future save paths easier to miss.

- Derive minutes from cleaned topic body content using a shared helper-style method and round up to at least one minute when readable content exists.
  - Rationale: using cleaned content avoids counting markup noise, and rounding up matches common reading-time expectations for partial-minute articles.
  - Alternative considered: base the value on raw HTML or excerpt length. Raw HTML overcounts markup, while excerpt length undercounts long posts.

- Render date and read time in a single metadata row on the home article card.
  - Rationale: the request is specific about placement to the right of the date and calls for consistent styling, so the UI should extend the existing metadata treatment instead of adding a visually separate badge block.
  - Alternative considered: place read time below the title or as a detached pill. That would change the information hierarchy more than necessary.

- Reduce the home page paginator size directly in `HomeController` from 10 to 6.
  - Rationale: the page-size change is simple, request-specific behavior and belongs with the existing home query rather than a new abstraction.
  - Alternative considered: make page size configurable. That adds configuration surface without a stated requirement.

## Risks / Trade-offs

- Word-count-based read time is only an estimate -> choose a clear, deterministic formula and cover it with tests.
- Existing topics will retain `null` until they are saved again unless the migration backfills them -> include a migration-time backfill strategy or an explicit one-off update in the migration.
- Counting cleaned body text may still be imprecise for code-heavy or mixed-language posts -> accept that limitation because the requirement is for an estimate, not an exact duration.
- Adding another home-card metadata item can tighten horizontal space on narrow screens -> keep the metadata row flexible and verify the mobile layout.
- Reducing page size changes pagination cadence for existing visitors -> keep the change explicit in spec coverage so the smaller page length is intentional and stable.

## Migration Plan

- Add a nullable integer column for `estimated_read_time` to the `topics` table.
- Backfill existing rows from current topic bodies during the migration or in a deterministic migration-time update step so legacy content can display read times without manual edits.
- Rollback by dropping the column if the change is reverted.

## Open Questions

- None at proposal time; the request is specific enough to proceed with the outlined formula and placement.
