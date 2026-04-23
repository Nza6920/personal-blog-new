## ADDED Requirements

### Requirement: Topic cover image storage
The system SHALL store an optional dedicated cover image path for each topic in a `cover_img` field.

#### Scenario: Topic has no cover image
- **WHEN** a topic is created or loaded without a cover image
- **THEN** the topic remains valid with an empty `cover_img` value

#### Scenario: Topic has a cover image
- **WHEN** a valid cover image is saved for a topic
- **THEN** the topic stores the uploaded image path in `cover_img`

### Requirement: Admin cover image upload
The admin article create and edit form SHALL allow authenticated admins to upload a cover image below the existing background image upload control.

#### Scenario: Create topic with cover image
- **WHEN** an admin creates a topic with a valid cover image upload
- **THEN** the new topic stores the uploaded cover image path in `cover_img`

#### Scenario: Update topic with cover image
- **WHEN** an admin edits a topic with a valid cover image upload
- **THEN** the topic updates `cover_img` to the uploaded image path

### Requirement: Cover image upload validation
The system SHALL reject cover image uploads that are not images or exceed 500 KB.

#### Scenario: Oversized cover image upload
- **WHEN** an admin submits a cover image larger than 500 KB
- **THEN** validation fails and the topic is not saved with that file

#### Scenario: Non-image cover upload
- **WHEN** an admin submits a non-image file as the cover image
- **THEN** validation fails and the topic is not saved with that file

### Requirement: Home article card cover rendering
The home page SHALL render each article card image from `cover_img` when it exists and from `uploads/images/system/default.jpg` when it does not.

#### Scenario: Home card uses cover image
- **WHEN** a listed topic has a `cover_img` value
- **THEN** the home article card image uses that cover image

#### Scenario: Home card uses default fallback
- **WHEN** a listed topic has no `cover_img` value
- **THEN** the home article card image uses `uploads/images/system/default.jpg`
