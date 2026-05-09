## 1. Data Model

- [x] 1.1 Add a migration for nullable `home_profile_title`, `home_profile_section`, and JSON `home_profile_tags` columns on `portal_settings`.
- [x] 1.2 Update `PortalSetting` fillable fields, casts, and default helper methods for the profile title, section body, and tags.

## 2. Backend Flow

- [x] 2.1 Add an action to validate-ready normalized home profile content into the singleton `PortalSetting` record.
- [x] 2.2 Update `AdminController::profile` to load the portal setting defaults and saved values for the profile page.
- [x] 2.3 Add an authenticated admin route and controller method for saving home profile content from `/admin/profile`.
- [x] 2.4 Update `HomeController::show` to pass configured profile title, section body, and tags to the home view with default fallbacks.

## 3. Views and Translations

- [x] 3.1 Add a separated home profile content form to `resources/views/admin/profile.blade.php`.
- [x] 3.2 Update `resources/views/home.blade.php` to render configured profile title, section body, and tags instead of hardcoded translation values.
- [x] 3.3 Add admin UI translation keys in `lang/en/admin_ui.php` and `lang/zh_CN/admin_ui.php` for the new profile form labels, hints, modal text, and success message.

## 4. Verification

- [x] 4.1 Add feature tests for rendering the admin profile form with defaults and saved values.
- [x] 4.2 Add feature tests for saving valid home profile content and rejecting invalid submissions without overwriting saved values.
- [x] 4.3 Add feature tests that the home page renders configured content and falls back to translated defaults when settings are empty.
- [x] 4.4 Run `composer run format` after PHP edits.
- [x] 4.5 Run `composer run test`.
