## ADDED Requirements

### Requirement: Admin profile page manages home profile content
The system SHALL allow an authenticated admin to configure the home profile title, profile tags, and profile section body from the admin profile page.

#### Scenario: Render configurable home profile fields on admin profile page
- **WHEN** an authenticated admin opens the admin profile page
- **THEN** the page shows editable controls for the home profile title, home profile tags, and home profile section body
- **AND** each control is prefilled with the saved value or the system default when no saved value exists

#### Scenario: Save configured home profile content
- **WHEN** an authenticated admin submits valid home profile title, tag, and section body values from the admin profile page
- **THEN** the system persists the submitted values
- **AND** the admin is returned to the profile page with a success message

#### Scenario: Reject invalid home profile content
- **WHEN** an authenticated admin submits missing, overlong, or otherwise invalid home profile content
- **THEN** the system rejects the update with validation errors
- **AND** the previously saved home profile content remains unchanged

### Requirement: Home page left panel renders a structured profile hero
The system SHALL render the home page left panel as a structured profile hero area with a prominent avatar, a configurable primary headline, and grouped content sections below the hero area.

#### Scenario: Render profile hero content on the home page
- **WHEN** a visitor opens the home page
- **THEN** the left panel displays a prominent avatar, configured headline text, and at least one grouped content section below the hero area

#### Scenario: Render default profile hero content without saved settings
- **WHEN** a visitor opens the home page and no profile headline has been configured
- **THEN** the left panel displays the default translated headline text

### Requirement: Home page left panel exposes quick action links
The system SHALL present quick action links in the left panel for primary destinations or profiles using icon-based controls that remain visually distinct from the article list.

#### Scenario: Render quick action links below the hero copy
- **WHEN** the home page left panel is rendered
- **THEN** the page shows a set of quick action links below the main copy area using icon-based controls

### Requirement: Home page left panel includes about and technology sections
The system SHALL provide dedicated left-panel sections for configurable personal introduction content and configurable technology stack labels.

#### Scenario: Render configured grouped about and technology content
- **WHEN** the home page is displayed after profile panel content has been configured
- **THEN** the left panel shows an about section with the configured section body
- **AND** the technology stack section contains the configured technology labels

#### Scenario: Render default grouped content without saved settings
- **WHEN** the home page is displayed and profile panel content has not been configured
- **THEN** the left panel shows the default translated about text
- **AND** the technology stack section contains the default translated technology labels

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
