## Why

Home page article cards currently reuse the article background image as their thumbnail, which couples two separate presentation needs. Authors need a dedicated cover image field so list-page previews can be managed independently while still falling back to a stable default image.

## What Changes

- Add a nullable `cover_img` string field to topics for storing an article cover image URL/path.
- Add cover image upload support to the admin article create/edit form, positioned below the existing background image upload control.
- Persist uploaded cover images during article creation and update.
- Update the home article list to render `cover_img` as the article card image, falling back to `uploads/images/system/default.jpg` when no cover image exists.
- Restrict cover image uploads to image files no larger than 500 KB.

## Capabilities

### New Capabilities
- `topic-cover-image`: Covers storing, uploading, validating, and displaying dedicated article cover images.

### Modified Capabilities

## Impact

- Database: add a nullable `cover_img` column to the `topics` table.
- Backend: update `Topic`, `TopicRequest`, `AdminController`, and topic create/update actions to accept and persist cover uploads.
- Frontend/admin: update `resources/views/admin/create_and_edit.blade.php` and locale strings under `lang/en` and `lang/zh_CN`.
- Frontend/home: update `resources/views/home.blade.php` to use `cover_img` with the default image fallback.
- Tests: add or update feature coverage for create/update validation and home fallback/display behavior.
