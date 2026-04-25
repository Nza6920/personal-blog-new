## ADDED Requirements

### Requirement: Topic stores a nullable estimated read time
The system SHALL store an optional `estimated_read_time` value for each topic as a minute-based estimate.

#### Scenario: Topic remains valid without a stored read time
- **WHEN** a topic record has no `estimated_read_time` value
- **THEN** the topic remains valid
- **AND** the missing value does not prevent the topic from being created, updated, or rendered

#### Scenario: Topic stores a derived minute estimate
- **WHEN** the system derives a read time for a topic with readable body content
- **THEN** it persists the result in `estimated_read_time`
- **AND** the stored value is expressed in whole minutes

### Requirement: Estimated read time is recalculated on topic create and update
The system SHALL automatically calculate `estimated_read_time` from the topic body whenever a topic is created or updated.

#### Scenario: Create topic calculates read time
- **WHEN** a new topic is saved with readable body content
- **THEN** the system calculates `estimated_read_time` without requiring manual input
- **AND** the saved topic includes the derived minute estimate

#### Scenario: Update topic recalculates read time
- **WHEN** an existing topic body is changed and the topic is saved
- **THEN** the system recalculates `estimated_read_time` from the updated body
- **AND** the saved topic reflects the new derived minute estimate

### Requirement: Existing topics can expose estimated read time after the schema change
The system SHALL support legacy topics after the `estimated_read_time` field is introduced.

#### Scenario: Existing topic receives a backfilled estimate
- **WHEN** the schema change is applied to topics that already contain body content
- **THEN** the system can populate `estimated_read_time` for those existing topics using the same body-derived approach

#### Scenario: Existing topic with no derived estimate remains safe to render
- **WHEN** a legacy topic still has a null `estimated_read_time`
- **THEN** home page rendering continues without failure
- **AND** the topic may omit the read-time display until a value is available

### Requirement: Home article card shows estimated read time beside the publish date
The home page SHALL render estimated read time to the right of the existing publish date using consistent metadata styling.

#### Scenario: Home card renders read time after date
- **WHEN** a listed topic has an `estimated_read_time` value
- **THEN** the home article card displays the publish date first
- **AND** the card displays the estimated read time immediately to the right of the date
- **AND** both metadata items share consistent visual styling

#### Scenario: Home card omits read time when unavailable
- **WHEN** a listed topic does not have an `estimated_read_time` value
- **THEN** the home article card still displays the publish date
- **AND** the card does not render a broken or placeholder read-time value

### Requirement: Home topic list paginates six items per page
The home page SHALL paginate the topic list with 6 topics per page.

#### Scenario: First page shows at most six topics
- **WHEN** a visitor opens the home page and more than 6 published topics exist
- **THEN** the first page renders 6 topics
- **AND** the remaining topics are available through pagination links

#### Scenario: Search results keep six-item pagination
- **WHEN** a visitor filters the home page topic list with a search query
- **THEN** the filtered result set paginates with 6 topics per page
- **AND** pagination links preserve the active search query
