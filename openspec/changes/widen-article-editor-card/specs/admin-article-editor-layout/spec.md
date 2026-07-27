## ADDED Requirements

### Requirement: Wider article editor card
The admin interface SHALL render the complete article editor card with a maximum width equivalent to Tailwind's `max-w-5xl` container and SHALL allow it to fill the available width up to that maximum.

#### Scenario: Create article on a wide viewport
- **WHEN** an authenticated administrator opens the article creation page on a viewport wider than the card maximum
- **THEN** the complete article editor card is centered and capped at `max-w-5xl`

#### Scenario: Edit article on a wide viewport
- **WHEN** an authenticated administrator opens an existing article for editing on a viewport wider than the card maximum
- **THEN** the complete article editor card is centered and capped at the same `max-w-5xl` width as the creation page

### Requirement: Responsive editor card containment
The article editor card MUST remain within the existing padded admin content area and MUST shrink to the available width on viewports narrower than its maximum.

#### Scenario: Article editor on a narrow viewport
- **WHEN** the article create or edit page is displayed on a viewport narrower than the `max-w-5xl` card maximum
- **THEN** the card uses the available content width without causing horizontal overflow or removing the admin layout gutters

### Requirement: Editor layout scope remains unchanged
The width change SHALL NOT alter editor height, card padding, EasyMDE toolbar behavior, preview modes, field ordering, or the layout of other admin pages.

#### Scenario: Existing editor behavior after widening
- **WHEN** an administrator uses the widened article create or edit card
- **THEN** all editor controls and behaviors other than the card's maximum width remain unchanged
