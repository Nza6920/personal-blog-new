## ADDED Requirements

### Requirement: Table of contents remains usable on mobile
The topic detail table of contents SHALL remain usable on mobile viewports without preserving the desktop sticky sidebar behavior.

#### Scenario: Render table of contents in page flow on mobile
- **WHEN** a topic detail page with a table of contents is viewed on a mobile viewport
- **THEN** the table of contents MUST render within the normal article flow before the article body
- **AND** it MUST NOT overlap the article content or require horizontal page scrolling

#### Scenario: Keep table of contents links tappable on mobile
- **WHEN** a reader taps a table of contents entry on a mobile viewport
- **THEN** the link target MUST remain reachable and the entry text MUST remain readable within the viewport
