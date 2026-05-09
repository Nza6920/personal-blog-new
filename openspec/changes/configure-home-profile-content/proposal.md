## Why

The home page left profile panel still has key copy hardcoded in translation files, so changing the headline, tag labels, or about-section body requires a code change. Making these fields configurable from the admin profile page lets the site owner keep the public homepage current without editing Blade or locale files.

## What Changes

- Add admin-editable fields for the home profile title, profile tags, and profile section body.
- Persist the configured values with the existing portal settings data, using existing translated copy as defaults when no setting exists.
- Render the home page left profile panel from saved settings for the title, tag list, and about body.
- Validate configured text so empty or malformed profile content cannot break the home page layout.

## Capabilities

### New Capabilities
- None

### Modified Capabilities
- `home-left-profile-panel`: Home page left panel content becomes configurable for the title, about body, and technology/profile tags while preserving current fallback behavior.

## Impact

- Database: extend `portal_settings` with fields for home profile title, section body, and tags.
- Backend: update portal/profile settings actions, validation, and home-page data loading.
- Admin UI: add controls to the admin profile page for editing the configurable home profile content.
- Frontend: render saved profile title, section body, and tag labels in `resources/views/home.blade.php`.
- Tests: add or update feature coverage for saving settings and rendering configured homepage content.
