## ADDED Requirements

### Requirement: Home page article list renders horizontal cards with a left cover area
The system SHALL render each home page article entry as a horizontal card with a dedicated cover area on the left and the article copy on the right.

#### Scenario: Render article card with left cover
- **WHEN** a visitor opens the home page and article entries are displayed
- **THEN** each article entry shows a fixed cover region on the left side
- **AND** the article title and excerpt are rendered in a separate content region to the right of the cover

### Requirement: Home page article cards reuse article background images as cover sources
The system SHALL use the article background image as the left cover source when it exists, and fall back to a default cover image when it does not.

#### Scenario: Prefer article background image for the list cover
- **WHEN** the home page article list is rendered with the current data model
- **THEN** each article card uses the existing article background image as the cover source when available
- **AND** the card falls back to a default cover image when no article background image exists
- **AND** the previous right-side avatar presentation is not rendered

### Requirement: Home page article cards preserve current article navigation and summary content
The system SHALL preserve the current article link target, title, excerpt, and relative publish time while restyling the list card layout, without introducing new metadata sections.

#### Scenario: Keep article content usable after card restyle
- **WHEN** a visitor views the redesigned article list
- **THEN** each card still links to the same article detail route
- **AND** the card displays the article title, excerpt, and relative publish time
- **AND** the card does not render any newly added tag row or auxiliary metadata section

### Requirement: Home page article cards remain readable in dark theme and on narrow viewports
The system SHALL keep the redesigned article cards legible across the existing dark theme and smaller viewport sizes.

#### Scenario: Adapt article cards for theme and viewport constraints
- **WHEN** the home page is viewed in dark theme or on a narrow viewport
- **THEN** the article card keeps visible separation between cover and content areas
- **AND** the cover image, text content, and spacing adapt without overlap or unreadable contrast
- **AND** the dark theme page background and card background remain visually consistent across the article list and footer area
