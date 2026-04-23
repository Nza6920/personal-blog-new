## 1. Data Model

- [x] 1.1 Add a migration that adds nullable string column `cover_img` to the `topics` table and drops it on rollback.
- [x] 1.2 Add `cover_img` to `App\Models\Topic` fillable attributes.
- [x] 1.3 Update topic factory or seeded topic defaults only if tests need explicit cover image data.

## 2. Upload Persistence

- [x] 2.1 Update `TopicRequest` validation to accept nullable `cover_img` image uploads with a maximum size of 500 KB.
- [x] 2.2 Update `AdminController::store` and `AdminController::update` to pass the cover upload into topic actions.
- [x] 2.3 Update `CreateTopic` to save a valid cover image upload and store the uploaded path in `cover_img`.
- [x] 2.4 Update `UpdateTopic` to save a valid cover image upload and update `cover_img`.

## 3. Admin UI

- [x] 3.1 Add localized cover image labels, button text, hint text, no-file text, and preview alt text to `lang/en/admin_ui.php`.
- [x] 3.2 Add matching localized cover image strings to `lang/zh_CN/admin_ui.php`.
- [x] 3.3 Add a cover image file picker to `resources/views/admin/create_and_edit.blade.php` directly below the background upload field.
- [x] 3.4 Show the current cover image preview on edit when `cover_img` exists.

## 4. Home Rendering

- [x] 4.1 Update `resources/views/home.blade.php` to use `$topic->cover_img` for article card images.
- [x] 4.2 Keep `asset('uploads/images/system/default.jpg')` as the fallback when `cover_img` is empty.

## 5. Tests and Verification

- [x] 5.1 Add or update feature tests for creating a topic with a valid cover image.
- [x] 5.2 Add or update feature tests for rejecting cover images larger than 500 KB.
- [x] 5.3 Add or update feature tests for updating a topic cover image.
- [x] 5.4 Add or update home page coverage showing `cover_img` is used and the default image is shown when missing.
- [x] 5.5 Run `composer run format`.
- [x] 5.6 Run relevant tests, preferably `composer run test` unless a narrower iteration is needed first.
