## Context

Topics currently have a `background` field used by article detail pages and by the home page article cards. The admin create/edit form already supports multipart uploads for `background`, and topic persistence is split between `AdminController`, `TopicRequest`, and `App\Actions\Topics\CreateTopic` / `UpdateTopic`.

This change adds a separate `cover_img` field for article card cover images while preserving existing background behavior.

## Goals / Non-Goals

**Goals:**
- Store a dedicated article cover image URL/path on each topic.
- Support cover upload on both article create and edit flows.
- Enforce the requested 500 KB maximum upload size through server-side validation.
- Render home article cards from `cover_img`, falling back to `uploads/images/system/default.jpg`.
- Follow existing upload, action, Blade, and translation patterns.

**Non-Goals:**
- Replace the existing `background` field or change article detail background behavior.
- Add image cropping, deletion, remote URL entry, or async upload behavior.
- Change editor body image upload limits or profile avatar upload limits.

## Decisions

- Add a nullable `cover_img` column instead of reusing `background`.
  - Rationale: the requested behavior needs independent control over list-card imagery and article detail backgrounds.
  - Alternative considered: keep using `background` for home covers. This preserves current behavior but does not satisfy dedicated cover management.

- Persist cover uploads through the existing topic create/update actions.
  - Rationale: current code keeps controllers thin and moves persistence decisions into action classes.
  - Alternative considered: save `cover_img` directly in `AdminController`. That would be less consistent with the existing controller/action split.

- Validate `cover_img` in `TopicRequest` as nullable image with `max:500`.
  - Rationale: Laravel file `max` validation is expressed in kilobytes and cleanly enforces the security requirement.
  - Alternative considered: pass a 500 KB max only to `ImageUploadHandler`. That would resize/storage-limit the uploader path but would not give the same form validation behavior.

- Use the same admin file picker pattern as `background`, placed immediately below it.
  - Rationale: users get consistent form behavior, preview styling, and localization, with minimal new UI surface.
  - Alternative considered: build a new upload component. That adds scope without improving the requested workflow.

## Risks / Trade-offs

- Existing topics will have no `cover_img` value -> use `asset('uploads/images/system/default.jpg')` on the home page.
- Uploaded cover files may remain on disk if later replaced -> preserve current background upload behavior; cleanup is out of scope.
- The field name `cover_img` is less idiomatic than `cover_image` -> use the requested name to match the product requirement.
- Create-time upload paths may not include the final topic id because the current create action saves images before the model is persisted -> preserve the existing pattern unless implementation reveals a practical issue.
