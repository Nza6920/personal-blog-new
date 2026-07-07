## MODIFIED Requirements

### Requirement: Home page article cards remain readable in dark theme and on narrow viewports
The system SHALL keep the redesigned article cards legible across the existing dark theme and smaller viewport sizes, including mobile viewports.

#### Scenario: Adapt article cards for theme and viewport constraints
- **WHEN** the home page is viewed in dark theme or on a narrow viewport
- **THEN** the article card keeps visible separation between cover and content areas
- **AND** the cover image, text content, and spacing adapt without overlap or unreadable contrast
- **AND** the dark theme page background and card background remain visually consistent across the article list and footer area

#### Scenario: Stack article card content on mobile
- **WHEN** the home page is viewed on a mobile viewport
- **THEN** each article card MUST stack its cover image above the article text
- **AND** the card content MUST fit within the viewport without horizontal scrolling
