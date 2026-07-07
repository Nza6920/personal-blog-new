## Why

The public article list and article detail pages are primarily styled for desktop layouts, while mobile visitors need readable navigation, article cards, and article content without horizontal overflow or cramped sidebars. This change improves mobile usability for the public reading experience without expanding scope into the admin interface.

## What Changes

- Add responsive layout requirements for the public article list on the home page so article cards, profile/sidebar content, search, and pagination fit narrow viewports.
- Add responsive layout requirements for public article detail pages so the hero/sidebar, table of contents, article body, media, code blocks, and previous/next navigation remain usable on mobile.
- Preserve existing desktop behavior and visual identity while adding mobile breakpoints and layout adjustments.
- Exclude admin pages and admin Flux controls from this change.

## Capabilities

### New Capabilities
- `public-article-mobile-layout`: Covers responsive behavior for public article list and article detail pages on mobile and narrow viewport sizes.

### Modified Capabilities
- `home-article-list-cards`: Strengthens the existing narrow viewport article card requirement with mobile-specific layout and overflow expectations.
- `article-heading-toc`: Adds mobile behavior expectations for article detail table of contents placement and usability.

## Impact

- Affected views include `resources/views/home.blade.php` and `resources/views/topics/index.blade.php`.
- Affected behavior includes public home/article list layout, public article detail layout, table of contents presentation, image/code/table overflow handling, and article navigation on mobile.
- Tests should cover public page rendering and mobile-specific markup or CSS hooks where practical; visual verification should cover common mobile widths.
- No backend API, database, route, authentication, or admin interface changes are expected.
