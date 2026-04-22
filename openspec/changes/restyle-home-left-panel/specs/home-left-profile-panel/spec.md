## ADDED Requirements

### Requirement: Home page left panel renders a structured profile hero
The system SHALL render the home page left panel as a structured profile hero area with a prominent avatar, a primary headline, supporting description, and grouped content sections.

#### Scenario: Render profile hero content on the home page
- **WHEN** a visitor opens the home page
- **THEN** the left panel displays a prominent avatar, headline text, supporting description, and at least one grouped content section below the hero copy

### Requirement: Home page left panel exposes quick action links
The system SHALL present quick action links in the left panel for primary destinations or profiles using icon-based controls that remain visually distinct from the article list.

#### Scenario: Render quick action links below the hero copy
- **WHEN** the home page left panel is rendered
- **THEN** the page shows a set of quick action links below the main copy area using icon-based controls

### Requirement: Home page left panel includes about and technology sections
The system SHALL provide dedicated left-panel sections for personal introduction content and technology stack labels.

#### Scenario: Render grouped about and technology content
- **WHEN** the home page is displayed
- **THEN** the left panel shows an "about" style section with descriptive text and a separate section containing multiple technology labels

### Requirement: Home page left panel preserves existing homepage behavior
The system SHALL preserve the existing homepage article feed, search interaction, and theme toggle behavior while restyling the left panel.

#### Scenario: Keep homepage actions available after restyling
- **WHEN** the redesigned home page is rendered
- **THEN** the home link and theme toggle remain available in the left panel
- **AND** the article list, search panel, and pagination continue to render on the home page

### Requirement: Home page left panel remains readable across viewport sizes
The system SHALL keep the redesigned left panel readable on both desktop and mobile viewports through responsive spacing and content wrapping.

#### Scenario: Adapt profile panel layout on small screens
- **WHEN** the home page is viewed on a narrow viewport
- **THEN** the left panel content stacks without overlapping
- **AND** quick action links and technology labels wrap within the available width
