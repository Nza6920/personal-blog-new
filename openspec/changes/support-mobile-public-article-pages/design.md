## Context

The public home page combines a fixed-width left profile panel with article cards in `resources/views/home.blade.php`. The topic detail page uses a hero/sidebar area, article content, a table of contents, and previous/next navigation in `resources/views/topics/index.blade.php`. Both templates already include inline CSS and some responsive rules, but the mobile behavior is incomplete as a user-facing requirement and needs targeted layout hardening for narrow screens.

## Goals / Non-Goals

**Goals:**
- Make the public article list readable and navigable on mobile widths without horizontal scrolling or overlapping content.
- Make the public article detail page readable on mobile widths, including title area, table of contents, article body, media, code blocks, tables, and previous/next navigation.
- Preserve current desktop layouts and public visual identity where possible.
- Keep the change scoped to public reader-facing pages.

**Non-Goals:**
- Do not redesign or restyle the admin area.
- Do not replace the existing Blade templates with a new frontend framework.
- Do not change article routes, persistence, search behavior, authentication, or admin workflows.
- Do not rewrite the article content rendering pipeline.

## Decisions

1. Use responsive CSS in the existing Blade templates instead of introducing a new layout system.

   Rationale: The affected pages already keep page-specific styles near the Blade markup. Extending those media queries is the smallest change and avoids moving unrelated styling into a new architecture.

   Alternative considered: Move all public page CSS into `resources/css/app.css`. That may be cleaner long term, but it broadens the change and risks unrelated regressions.

2. Treat `768px` and below as the primary mobile target, with tablet adjustments around existing intermediate breakpoints.

   Rationale: The home template already has `1024px` and `768px` breakpoints, while the topic template uses desktop-specific behavior at `min-width: 992px`. Building on those thresholds keeps implementation aligned with current CSS.

   Alternative considered: Add many device-specific breakpoints. That would make the styles harder to maintain and is unnecessary for the stated requirement.

3. Stack complex desktop regions on mobile rather than shrinking them in place.

   Rationale: The article list cards, topic table of contents, and previous/next navigation need enough horizontal space for text. Stacking avoids cramped content and prevents overflow from images, code blocks, and tables.

   Alternative considered: Keep desktop two-column structures and reduce spacing. That is more likely to cause unreadable text and overflow on phones.

## Risks / Trade-offs

- Mobile CSS changes can regress desktop spacing -> Scope new rules inside mobile media queries and verify desktop tests still pass.
- Article content may include wide tables or long code lines -> Add overflow containment for content blocks rather than altering rendered article HTML.
- Sticky table of contents can consume too much vertical space on mobile -> Disable desktop sticky treatment on mobile and render it as an in-flow section.
- Existing inline styles are large -> Keep edits localized to the current public templates and avoid admin views.

## Migration Plan

1. Add or adjust mobile media queries in the public home template.
2. Add or adjust mobile media queries in the public topic detail template.
3. Add focused feature assertions for mobile layout hooks where practical.
4. Run existing public page feature tests and frontend build.
5. Roll back by reverting the template CSS and tests if mobile changes cause production layout regressions.
