## Why

Topics currently do not expose an estimated reading time, so readers cannot quickly gauge article length from the home list and editors must manage that expectation manually. Adding a stored, auto-maintained read time keeps the value consistent with article content and surfaces a small but useful piece of metadata in a prominent location.

## What Changes

- Add a nullable `estimated_read_time` field to topics, stored in minutes.
- Automatically calculate and persist `estimated_read_time` whenever a topic is created or updated so editors do not need to enter it manually.
- Show the estimated read time on the home article card to the right of the publish date using the same visual treatment as the surrounding metadata.
- Reduce the home topic list page size from 10 items to 6 items so the updated card layout keeps a lighter scan length per page.
- Keep the field nullable so existing topics and exceptional content can remain valid when a read time cannot be derived.

## Capabilities

### New Capabilities
- `topic-estimated-read-time`: Topics store an automatically derived estimated reading time and expose it on the home article card.

### Modified Capabilities

## Impact

- Affected data model: `topics` table schema and `App\Models\Topic`
- Affected write flows: topic create/update paths and any action/controller code that persists topic content
- Affected UI: home article card metadata rendering and home list pagination behavior
- Affected controller: `App\Http\Controllers\HomeController`
- Testing impact: feature coverage for topic persistence, home page rendering of read time, and home pagination behavior
