## Context

The admin layout already provides a centered content region capped at `max-w-6xl` with horizontal padding. Inside it, the shared article create/edit view adds a second centered `max-w-3xl` constraint around the complete editor card. That inner constraint is the source of the excessive desktop whitespace; EasyMDE itself fills its available parent width.

The desired result is a modest increase rather than consuming the full admin content width. Both create and edit states must remain identical because they are rendered by the same Blade view.

## Goals / Non-Goals

**Goals:**

- Give the full article editor card more horizontal room on desktop displays.
- Cap the card at Tailwind's `max-w-5xl` size while retaining centering and responsive shrinking.
- Preserve the existing outer admin gutters on every viewport.
- Keep the change small and directly verifiable in the rendered view.

**Non-Goals:**

- Changing editor height, EasyMDE configuration, toolbar, fullscreen, or preview behavior.
- Rearranging fields, changing card padding, or redesigning upload controls.
- Changing the width of other admin pages or the global admin layout.
- Adding or changing user-facing copy or translations.

## Decisions

1. **Change the shared card wrapper, not EasyMDE-specific CSS.** The parent `max-w-3xl` constraint controls the width of the whole form and editor. Updating that wrapper keeps all fields aligned and automatically applies to both create and edit states. Targeting `.EasyMDEContainer` instead would either remain bounded by its parent or require a brittle breakout layout.

2. **Use `w-full max-w-5xl` on the centered wrapper.** `max-w-5xl` provides the agreed conservative cap of approximately 1024px, below the outer layout's 1152px cap. `w-full` makes the intended use of available width explicit, while `mx-auto` retains centering and the outer layout retains its existing gutters.

3. **Verify the layout contract with a focused automated assertion.** A view or feature test should confirm that the shared editor wrapper carries `w-full max-w-5xl` and no longer carries `max-w-3xl`, covering both create and edit routes where practical. Manual responsive inspection can supplement the automated check but should not replace it.

## Risks / Trade-offs

- **[Risk] Longer title and metadata controls also become wider than before.** → This is intentional because the agreed scope is the entire card; consistent alignment is preferable to a one-off editor breakout.
- **[Risk] A class-only assertion could be coupled to implementation details.** → Keep the assertion focused on the user-visible layout contract and avoid snapshotting unrelated markup.
- **[Trade-off] The card will not use the final 128px available under the outer `max-w-6xl` cap.** → This preserves comfortable desktop margins in accordance with the conservative-width decision.
