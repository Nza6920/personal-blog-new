## 1. Audit Public Mobile Layout

- [x] 1.1 Inspect current home page layout at desktop, tablet, and mobile widths and identify horizontal overflow or overlap in profile, search, article cards, pagination, and footer.
- [x] 1.2 Inspect current topic detail layout at desktop, tablet, and mobile widths and identify overflow or overlap in hero/title, table of contents, article body, media, code blocks, tables, and previous/next navigation.
- [x] 1.3 Confirm admin views are not part of the implementation scope.

## 2. Home Article List Mobile Layout

- [x] 2.1 Update `resources/views/home.blade.php` responsive styles so the public profile panel and main article list fit narrow viewports without page-level horizontal scrolling.
- [x] 2.2 Ensure home article cards stack cover image above article text on mobile while preserving desktop horizontal card layout.
- [x] 2.3 Ensure search and pagination controls remain contained, readable, and tappable on mobile.
- [x] 2.4 Verify dark theme article cards remain readable after mobile layout changes.

## 3. Topic Detail Mobile Layout

- [x] 3.1 Update `resources/views/topics/index.blade.php` responsive styles so the public topic hero/title and article content fit narrow viewports.
- [x] 3.2 Render the topic table of contents as an in-flow mobile section without sticky sidebar overlap or horizontal overflow.
- [x] 3.3 Add overflow containment for topic body tables, code blocks, images, and other wide content without changing article rendering semantics.
- [x] 3.4 Ensure previous/next topic navigation stacks or resizes cleanly on mobile and remains tappable.

## 4. Verification

- [x] 4.1 Add or update focused feature tests for public mobile layout hooks or regression markers where practical.
- [x] 4.2 Run `php artisan test --filter ShowHomeTest` and `php artisan test --filter ShowTopicTest`.
- [x] 4.3 Run `npm run build` after frontend style changes.
- [x] 4.4 Run `composer run format` after Blade or PHP test changes.
- [x] 4.5 Capture or manually verify representative desktop and mobile viewports for home and topic detail pages.
