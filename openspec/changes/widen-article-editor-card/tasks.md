## 1. Layout Regression Coverage

- [x] 1.1 Add focused feature or rendered-view assertions covering the shared article card on both create and edit pages.
- [x] 1.2 Assert that the card uses `w-full max-w-5xl`, remains centered, and no longer uses the `max-w-3xl` constraint.

## 2. Editor Card Width

- [x] 2.1 Update the wrapper in `resources/views/admin/create_and_edit.blade.php` to use the agreed `w-full max-w-5xl` responsive width while retaining existing centering, spacing, and inner card styles.
- [x] 2.2 Confirm no EasyMDE configuration, editor height, form field order, padding, translations, or unrelated admin layouts were changed.

## 3. Verification

- [x] 3.1 Run the targeted article editor layout tests and resolve any failures.
- [x] 3.2 Run the relevant feature test suite and verify the create/edit views still render successfully.
- [x] 3.3 Inspect the create and edit pages at wide and narrow viewport sizes to confirm the wider desktop cap, preserved gutters, and absence of horizontal overflow.
