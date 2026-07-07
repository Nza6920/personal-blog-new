## ADDED Requirements

### Requirement: Public article list adapts to mobile viewports
The public article list page SHALL adapt its profile panel, article list, search control, and pagination for mobile viewports without horizontal page overflow.

#### Scenario: Home page stacks public content on mobile
- **WHEN** a visitor opens the public home page on a narrow viewport
- **THEN** the profile area and article list MUST fit within the viewport width
- **AND** article cards MUST stack their cover and text regions vertically when there is not enough horizontal space

#### Scenario: Home page controls remain usable on mobile
- **WHEN** a visitor uses search or pagination on the public home page on a narrow viewport
- **THEN** the controls MUST remain visible, tappable, and contained within the viewport

### Requirement: Public article detail adapts to mobile viewports
The public article detail page SHALL adapt its title area, article content, table of contents, media, code blocks, tables, and article navigation for mobile viewports without horizontal page overflow.

#### Scenario: Article detail content remains readable on mobile
- **WHEN** a visitor opens a public article detail page on a narrow viewport
- **THEN** the article title, metadata, body text, images, code blocks, and tables MUST fit or scroll within their content area without causing full-page horizontal overflow

#### Scenario: Article detail navigation stacks on mobile
- **WHEN** a visitor reaches previous or next article navigation on a narrow viewport
- **THEN** the navigation items MUST remain readable and tappable without overlapping each other

### Requirement: Mobile layout scope excludes admin pages
The mobile layout change SHALL apply to public reader-facing article list and detail pages without requiring admin page layout changes.

#### Scenario: Admin routes are not part of the mobile layout requirement
- **WHEN** the public mobile layout is implemented
- **THEN** admin views and admin Flux controls MUST NOT be redesigned as part of this change
