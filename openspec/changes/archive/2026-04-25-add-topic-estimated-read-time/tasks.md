## 1. Data model and derivation

- [x] 1.1 Add a migration that introduces nullable `estimated_read_time` on `topics` and backfills existing rows from topic body content.
- [x] 1.2 Update topic persistence support so `estimated_read_time` is available on the model and is derived from cleaned topic body content in a single shared save path.

## 2. Home page rendering

- [x] 2.1 Update the home article card markup to render estimated read time to the right of the publish date when the value exists.
- [x] 2.2 Adjust the home article card styles so the date and read-time metadata row stays visually consistent across dark theme and narrow viewports.
- [x] 2.3 Reduce the home topic list page size from 10 items to 6 items in the home query flow.

## 3. Verification

- [x] 3.1 Add backend coverage for automatic estimated read time calculation on topic create and update flows.
- [x] 3.2 Add home page feature coverage for rendering estimated read time when present and omitting it safely when absent.
- [x] 3.3 Keep home pagination behavior aligned with the new six-items-per-page requirement.
