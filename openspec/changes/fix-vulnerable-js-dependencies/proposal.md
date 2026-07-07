## Why

The public layout currently serves legacy JavaScript libraries at `/js/jquery.min.js` and `/js/bootstrap.min.js`; the scanner reports Bootstrap 3.3.5 with SNYK-JS-BOOTSTRAP-7444617 and a risk score of 6. This should be fixed now because those files are directly reachable from the production site and are loaded by the shared Blade layout.

## What Changes

- Replace or remove the vulnerable Bootstrap 3.3.5 static asset served from `public/js/bootstrap.min.js`.
- Replace or remove the legacy jQuery static asset served from `public/js/jquery.min.js` if the site still needs jQuery-dependent scripts.
- Update the shared layout script loading so it no longer exposes vulnerable framework files at the reported URLs.
- Verify affected pages still render and existing client-side behaviors continue to work after the dependency change.
- Add focused regression coverage or documented manual verification for the public layout asset references.

## Capabilities

### New Capabilities
- `frontend-third-party-assets`: Covers security and loading requirements for third-party JavaScript assets exposed by public Blade layouts.

### Modified Capabilities

## Impact

- Affected files include `resources/views/layouts/app.blade.php`, `public/js/bootstrap.min.js`, `public/js/jquery.min.js`, and any dependent public scripts such as `jquery.easing.1.3.js`, `jquery.waypoints.min.js`, `jquery.stellar.min.js`, and `main.js`.
- The implementation may update frontend package dependencies and generated public assets if the chosen fix uses Vite-managed libraries.
- No backend API or database changes are expected.
