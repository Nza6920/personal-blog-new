## Context

The home page left profile panel is rendered by `resources/views/home.blade.php`. It currently reads the avatar and bio from `PortalSetting`, but the profile title, about-section body, and technology tag labels come from `lang/*/home.php`. The admin profile page at `/admin/profile` already manages account profile details, while `/admin/portal` manages the short homepage bio.

This change specifically needs the public home panel content to be configurable from the admin profile page. The implementation should preserve existing default text so fresh installs and existing databases keep rendering the same home page until settings are saved.

## Goals / Non-Goals

**Goals:**
- Let an authenticated admin configure the home profile title, profile tags, and profile section body from `/admin/profile`.
- Store the configured content in the existing portal settings record.
- Render saved values on the home page with translated defaults when values are missing.
- Keep the implementation compatible with in-memory SQLite tests and existing Laravel controller/action patterns.

**Non-Goals:**
- Redesign the home page left panel layout.
- Change profile quick action links, theme toggle, RSS/search behavior, or article feed behavior.
- Add multi-profile support or per-locale database values.
- Remove the existing `/admin/portal` bio settings page.

## Decisions

1. Store configurable content on `portal_settings`.

   The existing model already owns home-facing profile fields (`home_bio`, `home_avatar`). Add nullable columns for `home_profile_title`, `home_profile_section`, and `home_profile_tags`. `home_profile_tags` should be stored as JSON via an Eloquent cast so controllers and views handle it as an array. Alternative considered: create a separate table for home profile content. That adds unnecessary relationship and migration complexity for one singleton settings record.

2. Add defaults on `PortalSetting`.

   Keep default methods on the model for the title, section body, and tags, mirroring `defaultBio()` and `defaultAvatar()`. The defaults can read from existing translation keys, so the current English and Chinese fallback text remains centralized. Alternative considered: hardcode defaults in `HomeController`, but that would scatter fallback behavior.

3. Add a dedicated home profile content form to `/admin/profile`.

   The user-facing request names the admin profile page, so add a separate form and route such as `admin.profile.home-profile` or similar rather than overloading the existing account update form. This keeps account validation, password changes, and homepage content validation independent. Alternative considered: adding these controls to `/admin/portal`, but that misses the requested page.

4. Normalize tags server-side.

   Accept tags from a textarea or repeatable input as newline/comma-separated text, trim each tag, discard empty entries, de-duplicate exact matches, and cap both count and per-tag length. This keeps the Blade UI simple and prevents malformed settings from creating an oversized tag section. Alternative considered: storing raw text and splitting in the view, but that pushes data cleanup into presentation code.

## Risks / Trade-offs

- Existing saved settings have null new columns -> use model/controller fallbacks so the home page remains unchanged.
- Tags can overflow the left panel if too many are saved -> validate a maximum count and rely on existing wrapping styles.
- Adding this to `/admin/profile` makes that page manage both account and public homepage content -> use a clearly separated form section and route to avoid mixed validation failures.
- Locale defaults are only fallbacks, not per-locale saved content -> document by preserving one configured value set for the site.

## Migration Plan

Add a nullable-column migration for the three settings fields. Deploying forward is non-breaking because null values fall back to existing translated copy. Rolling back drops only the new fields and restores the current hardcoded behavior.
