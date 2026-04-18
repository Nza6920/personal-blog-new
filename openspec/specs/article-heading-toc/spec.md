## ADDED Requirements

### Requirement: Article detail page generates a table of contents from supported headings
The system SHALL inspect the rendered article body on the topic detail page and generate a table of contents from all supported headings in document order. Supported headings MUST include level-one and level-two headings.

#### Scenario: Render table of contents when supported headings exist
- **WHEN** a published topic detail page contains one or more `h1` or `h2` elements in the rendered body
- **THEN** the page displays a table of contents with one entry for each supported heading in the same order as the article body

#### Scenario: Omit table of contents when no supported headings exist
- **WHEN** a topic detail page contains no `h1` or `h2` elements in the rendered body
- **THEN** the page does not render a visible table of contents container

### Requirement: Table of contents reflects heading hierarchy
The system SHALL preserve heading level information in the table of contents so that level-two headings are visually distinguishable from level-one headings.

#### Scenario: Render nested visual treatment for level-two headings
- **WHEN** a topic detail page contains both `h1` and `h2` elements
- **THEN** table of contents entries for `h2` headings are rendered with a distinct indented style from `h1` entries

### Requirement: Table of contents entries link to unique heading anchors
The system SHALL ensure each supported heading referenced by the table of contents has a unique anchor target that can be navigated through a URL hash.

#### Scenario: Navigate to a heading from the table of contents
- **WHEN** a reader clicks a table of contents entry
- **THEN** the browser navigates to the corresponding heading anchor within the article

#### Scenario: Preserve uniqueness for repeated heading text
- **WHEN** multiple supported headings have identical text content
- **THEN** the system assigns distinct anchor identifiers so each table of contents entry targets the correct heading

### Requirement: Table of contents highlights the current reading section
The system SHALL update the active table of contents entry as the reader scrolls so that the entry matching the current supported heading is visually highlighted.

#### Scenario: Highlight the visible section while scrolling downward
- **WHEN** the reader scrolls through the article and a new supported heading becomes the current section in view
- **THEN** the matching table of contents entry becomes active and the previously active entry is cleared

#### Scenario: Keep active state aligned after direct anchor navigation
- **WHEN** the reader reaches a section by clicking a table of contents entry or opening a URL with a matching hash
- **THEN** the corresponding table of contents entry is shown as active
