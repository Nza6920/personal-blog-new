## 1. Audit Current Usage

- [x] 1.1 Search Blade views and public scripts for Bootstrap plugin usage, including `modal`, `dropdown`, `collapse`, `tab`, `tooltip`, `popover`, and `data-toggle` patterns.
- [x] 1.2 Search public and source assets for vulnerable Bootstrap and jQuery version signatures, including Bootstrap 3.3.5.
- [x] 1.3 Confirm whether `jquery.easing.1.3.js`, `jquery.waypoints.min.js`, `jquery.stellar.min.js`, or `main.js` still require global jQuery.

## 2. Remediate Public Assets

- [x] 2.1 Remove the `/js/bootstrap.min.js` script tag from `resources/views/layouts/app.blade.php` unless required Bootstrap behavior is found.
- [x] 2.2 Remove, replace, or neutralize `public/js/bootstrap.min.js` so the public URL no longer serves Bootstrap 3.3.5.
- [x] 2.3 Replace `public/js/jquery.min.js` with a maintained non-vulnerable compatible jQuery version if jQuery is still required.
- [x] 2.4 Remove the `/js/jquery.min.js` script tag and stale jQuery asset if no required legacy script depends on jQuery.
- [x] 2.5 Preserve valid script load order for any remaining jQuery-dependent plugins and page scripts.

## 3. Verification

- [x] 3.1 Add or update a focused feature test that verifies the shared public layout does not include vulnerable Bootstrap 3.3.5.
- [x] 3.2 Run `rg` checks to confirm vulnerable Bootstrap 3.3.5 is no longer present in served public assets.
- [x] 3.3 Run `npm run build` after frontend asset changes.
- [x] 3.4 Run `composer run format` after PHP or Blade-related changes.
- [x] 3.5 Run `composer run test` or a narrower relevant test command and record the result.
