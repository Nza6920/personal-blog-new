## Context

The shared Blade layout `resources/views/layouts/app.blade.php` loads `/js/jquery.min.js` and `/js/bootstrap.min.js` from the public directory on every page using that layout. The scanner identified `public/js/bootstrap.min.js` as Bootstrap 3.3.5 and reported SNYK-JS-BOOTSTRAP-7444617 with risk value 6; the scan also counted the jQuery asset as part of the affected JavaScript framework surface.

The current application already uses Vite, Tailwind CSS, Alpine.js, and bundled assets for newer frontend code. The legacy public scripts appear to support older page interactions and animation plugins, so the fix needs to remove the vulnerable public framework files without breaking existing public pages.

## Goals / Non-Goals

**Goals:**
- Stop serving the vulnerable Bootstrap 3.3.5 file from `/js/bootstrap.min.js`.
- Stop loading vulnerable or unnecessary legacy framework assets from the shared public layout.
- Preserve existing page rendering and required client-side interactions.
- Keep the change small and compatible with the Laravel 12 and Vite setup.
- Provide verification that the reported URLs no longer expose vulnerable framework versions.

**Non-Goals:**
- Redesign the public UI or migrate all legacy CSS.
- Replace all existing jQuery plugins unless they are proven unnecessary or insecure for this fix.
- Introduce a new frontend framework.
- Change backend routes, database schema, or admin workflows.

## Decisions

1. Prefer removing Bootstrap JS from the shared layout over upgrading to another Bootstrap major version.

   Rationale: Bootstrap 3 JavaScript depends on jQuery and is loaded globally. The project now has Tailwind/Alpine available, and the public layout does not show an explicit need for Bootstrap JS at the load site. Removing it eliminates the reported vulnerable URL and avoids the behavior differences of jumping to Bootstrap 5.

   Alternative considered: upgrade Bootstrap 3.3.5 to 3.4.1 or Bootstrap 5. Bootstrap 3.4.1 reduces known Bootstrap 3 vulnerabilities but keeps an old jQuery-based framework in the public surface; Bootstrap 5 changes markup and plugin APIs and is likely broader than this security fix.

2. Keep jQuery only if dependent legacy scripts still require it, and use a non-vulnerable maintained version when it remains necessary.

   Rationale: `jquery.easing.1.3.js`, `jquery.waypoints.min.js`, `jquery.stellar.min.js`, and `main.js` may depend on `window.jQuery`. Removing jQuery without checking those scripts risks breaking page behavior. If jQuery is still required, the asset should be replaced with an up-to-date compatible release and loaded before plugins.

   Alternative considered: rewrite all jQuery-dependent scripts to vanilla JS or Alpine. That may be the best long-term direction, but it is larger than the immediate vulnerability remediation.

3. Verify both source references and generated public assets.

   Rationale: The scanner checks public URLs, while the application behavior is controlled by Blade templates and public files. The implementation must ensure the layout no longer references vulnerable files and that the public files are removed, replaced, or made non-vulnerable.

   Alternative considered: only updating `public/js/bootstrap.min.js`. That could satisfy the detected version string but would leave unnecessary legacy framework loading and may miss jQuery exposure.

## Risks / Trade-offs

- Legacy page behavior depends on Bootstrap plugins -> Test interactive UI that might use dropdowns, modals, tabs, collapse, or tooltips; if any are required, replace with local Alpine/Blade behavior or a safe dependency.
- Existing scripts require a specific jQuery API shape -> Use a maintained jQuery version compatible with the plugins in use, then run page smoke tests.
- Static scanner still finds old version strings in bundled or unused files -> Search public and source assets for Bootstrap 3.3.5 and vulnerable jQuery versions, and remove stale files when they are no longer served.
- Dependency updates can alter built assets -> Run `npm run build` and relevant Laravel tests after implementation.

## Migration Plan

1. Audit usage of Bootstrap JS and global jQuery in Blade views and public scripts.
2. Remove the Bootstrap script tag from the shared layout if no required behavior depends on it.
3. Replace or remove `public/js/bootstrap.min.js` so `/js/bootstrap.min.js` no longer serves Bootstrap 3.3.5.
4. Replace `public/js/jquery.min.js` with a maintained compatible jQuery version only if legacy plugins still require jQuery; otherwise remove the layout reference and stale file.
5. Verify public pages render and client-side scripts initialize without console errors.
6. Run formatting/build/tests appropriate to the touched files.

Rollback is to restore the previous public assets and layout script tags from version control if a production-only behavior regression is found.
