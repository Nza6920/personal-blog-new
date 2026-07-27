## Why

The article create and edit pages currently constrain the entire editor card to roughly 768px, leaving substantial unused space on desktop displays and making long-form editing feel unnecessarily cramped. The editor should use more of the existing admin content area while retaining comfortable margins and responsive behavior.

## What Changes

- Increase the maximum width of the shared article editor card from the current `max-w-3xl` constraint to `max-w-5xl`.
- Apply the wider layout consistently to both article creation and article editing because they share the same view.
- Preserve the existing admin page gutters and natural shrinking on tablet and mobile viewports.
- Leave editor height, card padding, toolbar behavior, preview modes, form controls, and other admin pages unchanged.

## Capabilities

### New Capabilities
- `admin-article-editor-layout`: Defines the responsive width and scope of the article create/edit card in the admin interface.

### Modified Capabilities

None.

## Impact

- Affects the shared Blade view for article creation and editing: `resources/views/admin/create_and_edit.blade.php`.
- Requires a focused view-level regression test or equivalent rendered-markup assertion for the width classes.
- Does not change routes, controllers, validation, persistence, APIs, translations, JavaScript behavior, or dependencies.
